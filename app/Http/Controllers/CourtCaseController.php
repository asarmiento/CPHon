<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Repositories\AuxiliarySeatRepository;
use AccountHon\Repositories\SeatingPartRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\SettingRepository;
use AccountHon\Repositories\TypeSeatRepository;
use AccountHon\Repositories\CatalogRepository;
use AccountHon\Repositories\CourtCaseRepository;
use AccountHon\Repositories\ReceiptRepository;
use AccountHon\Repositories\StudentRepository;
use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\DepositRepository;
use AccountHon\Repositories\CashRepository;
use AccountHon\Repositories\TypeFormRepository;
use Illuminate\Http\Request;
use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use AccountHon\Repositories\AuxiliaryReceiptRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourtCaseController extends Controller {

    /**
     * @var AuxiliaryReceiptRepository
     */
    private $auxiliaryReceiptRepository;

    /**
     * @var CatalogRepository
     */
    private $catalogRepository;

    /**
     * @var ReceitpRepository
     */
    private $receiptRepository;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var FinancialRecordsRepository
     */
    private $financialRecordsRepository;

    /**
     * @var CourtCaseRepository
     */
    private $courtCaseRepository;

    /**
     * @var DepositRepository
     */
    private $depositRecordsRepository;

    /**
     * @var CashRepository
     */
    private $cashRepository;

    /**
     * @var AuxiliarySeatRepository
     */
    private $auxiliarySeatRepository;

    /**
     * @var TypeSeatRepository
     */
    private $typeSeatRepository;

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var TypeFormRepository
     */
    private $typeFormRepository;

    /**
     * @var SeatingPartRepository
     */
    private $seatingPartRepository;

    /**
     * @var SeatingRepository
     */
    private $seatingRepository;

    /**
     * @param AuxiliaryReceiptRepository $auxiliaryReceiptRepository
     * @param CatalogRepository $catalogRepository
     * @param ReceitpRepository|ReceiptRepository $receiptRepository
     * @param StudentRepository $studentRepository
     * @param FinancialRecordsRepository $financialRecordsRepository
     * @param CourtCaseRepository $courtCaseRepository
     * @param DepositRepository $depositRepository
     * @param CashRepository $cashRepository
     * @param AuxiliarySeatRepository $auxiliarySeatRepository
     * @param TypeSeatRepository $typeSeatRepository
     */
    public function __construct(
    AuxiliaryReceiptRepository $auxiliaryReceiptRepository, CatalogRepository $catalogRepository, ReceiptRepository $receiptRepository, StudentRepository $studentRepository, FinancialRecordsRepository $financialRecordsRepository, CourtCaseRepository $courtCaseRepository, DepositRepository $depositRepository, CashRepository $cashRepository, AuxiliarySeatRepository $auxiliarySeatRepository, TypeSeatRepository $typeSeatRepository, SettingRepository $settingRepository, TypeFormRepository $typeFormRepository, SeatingPartRepository $seatingPartRepository, SeatingRepository $seatingRepository
    ) {
        $this->middleware('auth');
        $this->auxiliaryReceiptRepository = $auxiliaryReceiptRepository;
        $this->catalogRepository = $catalogRepository;
        $this->receiptRepository = $receiptRepository;
        $this->studentRepository = $studentRepository;
        $this->financialRecordsRepository = $financialRecordsRepository;
        $this->courtCaseRepository = $courtCaseRepository;
        $this->depositRepository = $depositRepository;
        $this->cashRepository = $cashRepository;

        $this->auxiliarySeatRepository = $auxiliarySeatRepository;
        $this->typeSeatRepository = $typeSeatRepository;
        $this->settingRepository = $settingRepository;
        $this->typeFormRepository = $typeFormRepository;
        $this->seatingPartRepository = $seatingPartRepository;
        $this->seatingRepository = $seatingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $courtCases = $this->courtCaseRepository->CourtCaseAll();
        return view('courtCases.index', compact('courtCases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $catalogs = $this->catalogRepository->listsWhere('style', 'detalle', 'id');
        $receipts = $this->receiptRepository->whereDuoIn('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs);
        $numbers_receipts = $this->receiptRepository->whereDuoInListDistinct('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs, 'receipt_number');
        $sum_deposits_receipts = $this->depositRepository->sumInSchool('codeReceipt', $numbers_receipts);
        $sum_cashes_receipts = $this->cashRepository->sumInSchool('receipt', $numbers_receipts);

        $schools_ids = $this->studentRepository->lists('id');
        $financialRecords_ids = $this->financialRecordsRepository->whereInList('student_id', $schools_ids, 'id');
        $auxiliaryReceipts = $this->auxiliaryReceiptRepository->whereDuoIn('court_case_id', null, 'status', 'aplicado', 'financial_record_id', $financialRecords_ids);
        $numbers_auxiliaryReceipts = $this->auxiliaryReceiptRepository->whereDuoInListDistinct('court_case_id', null, 'status', 'aplicado', 'financial_record_id', $financialRecords_ids, 'receipt_number');
        $sum_deposits_auxiliaryReceipts = $this->depositRepository->sumInSchool('codeReceipt', $numbers_auxiliaryReceipts);
        $sum_cashes_auxiliaryReceipts = $this->cashRepository->sumInSchool('receipt', $numbers_auxiliaryReceipts);

        $sum_deposits = $sum_deposits_receipts + $sum_deposits_auxiliaryReceipts;
        $sum_cashes = $sum_cashes_receipts + $sum_cashes_auxiliaryReceipts;

        $sum_total = $sum_deposits + $sum_cashes;

        return view('courtCases.create', compact('receipts', 'auxiliaryReceipts', 'sum_deposits', 'sum_cashes', 'sum_total'));
    }

    /**
     * Store a newly created resource in storage.
     * Pasos 1 al 8 para generar el corte de caja.
     * 1. Primero creamos el corte en la tabla de cortes de caja
     * 2. creamos el asiento del corte de caja en la tabla seatings para los recibos de contabilidad
     * 3. buscamos todos los recibos que seran parte del corte de caja tanto auxiliar y contabilidad
     * 4. actualizamos los recibos de contabilidad con el id del corte de caja que se creo.
     * 5. buscamos todos los recibos del auxiliar que seran parte del corte de caja
     * 6. creamos el asiento en la tabla auxiliarySeat el asiento de los alumnos segun los recibos
     * 7. actualizamos los recibos del auxiliar con el id del corte de caja que creamos.
     * 8. enviamos el token del corte de caja a la vista para que se genere los tres reportes a imprimir del corte.
     * @return Response
     */
    public function store() {
        try {
            # Paso 1
            $typeSeat = $this->typeSeatRepository->whereDuoData('CorCa');
            $CourtCases = ['date' => dateShort(), 'type_seat_id' => $typeSeat[0]->id, 'token' => Crypt::encrypt($typeSeat[0]->abbreviation()), 'abbreviation' => $typeSeat[0]->abbreviation()];
            \DB::beginTransaction();
            $courtCase = $this->courtCaseRepository->getModel();
            # Paso 2
            if ($courtCase->isValid($CourtCases)):
                $courtCase->fill($CourtCases);
                if ($courtCase->save()):

                    $token = Crypt::encrypt($courtCase->abbreviation);
                    # Paso 3
                    $catalogs = $this->catalogRepository->listsWhere('style', 'detalle', 'id');
                    $receipts = $this->receiptRepository->whereDuoIn('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs);
                    $first = $this->receiptRepository->whereDuoFisrt('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs);
                    $last = $this->receiptRepository->whereDuoInLast('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs);
                    $amount = $this->receiptRepository->whereDuoInSum('court_case_id', null, 'status', 'aplicado', 'catalog_id', $catalogs);
                    $seatingCourtCase = $this->accountingSeating($courtCase, $receipts, $first, $last, $amount, $token);
                    if ($seatingCourtCase):
                        # Paso 4
                        foreach ($receipts AS $receipt):
                            $this->receiptRepository->updateDataWhere('receipt_number', $receipt->receipt_number, 'court_case_id', $courtCase->id, $receipt->type_seat_id);
                        endforeach;
                    else:
                        return $this->errores($seatingCourtCase);
                    endif;

                    # Paso 5
                    $schools_ids = $this->studentRepository->lists('id');
                    $financialRecords_ids = $this->financialRecordsRepository->whereInList('student_id', $schools_ids, 'id');
                    $auxiliaryReceipts = $this->auxiliaryReceiptRepository->whereDuoIn('court_case_id', null, 'status', 'aplicado', 'financial_record_id', $financialRecords_ids);
                    $firts = $this->auxiliaryReceiptRepository->whereDuoFirst('court_case_id', null, 'status', 'aplicado', 'financial_record_id', $financialRecords_ids);
                    $last = $this->auxiliaryReceiptRepository->whereDuoLast('court_case_id', null, 'status', 'aplicado', 'financial_record_id', $financialRecords_ids);
                    # Paso 6
                    $auxiliarSeatingCourtCase = $this->auxiliarSeat($courtCase, $auxiliaryReceipts, $firts, $last, $token);
                    if ($auxiliarSeatingCourtCase):
                        # Paso 7
                        foreach ($auxiliaryReceipts AS $auxiliaryReceipt):
                            $this->auxiliaryReceiptRepository->updateDataWhere('receipt_number', $auxiliaryReceipt->receipt_number, 'court_case_id', $courtCase->id, $auxiliaryReceipt->type_seat_id);
                        endforeach;
                    else:
                        \DB::rollback();
                        return $this->errores($auxiliarSeatingCourtCase);
                    endif;

                endif;
                # Paso 8
                $this->typeSeatRepository->updateWhere('CorCa');
                \DB::commit();
                return $this->exito($courtCase->token);
            endif;
            return $this->errores(['save' => 'Se genero un error']);
        } catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('CourtCase Save' => 'Verificar la información del Corte de Caja, sino contactarse con soporte de la applicación'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function report($token, $type) {
        $courtCase = $this->courtCaseRepository->token($token);
        $receipts = $this->receiptRepository->whereId('court_case_id', $courtCase->id, 'receipt_number');
        $auxiliaryReceipts = $this->auxiliaryReceiptRepository->whereId('court_case_id', $courtCase->id, 'receipt_number');
        $depositsRC;
        $sumDepositsRC = 0;
        $sumCashesRC = 0;
        $depositsRCA;
        $sumDepositsRCA = 0;
        $sumCashesRCA = 0;
        $cashesRC;
        $cashesRCA;
        $arrReceipt = array();
        $arrAuxilaryReceipt = array();
        if (!$receipts->isEmpty()) {
            $listsReceipts = $this->receiptRepository->newQuery()
                    ->where('type_seat_id', $receipts[0]->type_seat_id)
                    ->where('court_case_id', $courtCase->id)
                    ->distinct()
                    ->lists('receipt_number');
            $depositsRC = $this->depositRepository->whereIn('school_id', userSchool()->id, 'codeReceipt', $listsReceipts);
            if (!$depositsRC->isEmpty()) {
                $sumDepositsRC = $this->depositRepository->sumInSchool('codeReceipt', $listsReceipts);
            }
            $sumCashesRC = $this->cashRepository->sumInSchool('receipt', $listsReceipts);
        }
        if (!$auxiliaryReceipts->isEmpty()) {
            $listsAuxiliaryReceipts = $this->auxiliaryReceiptRepository->newQuery()
                    ->where('type_seat_id', $auxiliaryReceipts[0]->type_seat_id)
                    ->where('court_case_id', $courtCase->id)
                    ->distinct()
                    ->lists('receipt_number'); 
            $depositsRCA = $this->depositRepository->whereIn('school_id', userSchool()->id, 'codeReceipt', $listsAuxiliaryReceipts); 
            if (!$depositsRCA->isEmpty()) {
                $sumDepositsRCA = $this->depositRepository->newQuery()->where('school_id', userSchool()->id)->whereIn('codeReceipt', $listsAuxiliaryReceipts)->sum('amount');
            }
            $sumCashesRCA = $this->cashRepository->sumTypeSchool('receipt', $listsAuxiliaryReceipts);
        }
        if (isset($listsReceipts)) {
            foreach ($listsReceipts as $value) {
                $sumList = $this->receiptRepository->newQuery()->where('receipt_number', $value)->sum('amount');
                $arrReceipt[$value] = $sumList;
            }
            $cashesRC = $this->cashRepository->whereIn('school_id', userSchool()->id, 'receipt', $listsReceipts);
        }
        if (isset($listsAuxiliaryReceipts)) {
            foreach ($listsAuxiliaryReceipts as $value) {
                $sumList = $this->auxiliaryReceiptRepository->newQuery()->where('receipt_number', $value)->sum('amount');
                $arrAuxilaryReceipt[$value] = $sumList;
            }
            $cashesRCA = $this->cashRepository->whereIn('school_id', userSchool()->id, 'receipt', $listsAuxiliaryReceipts);
        }
        if ($type == 1) {
            //return view('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'sumDepositsRC', 'sumDepositsRCA', 'sumCashesRC', 'sumCashesRCA', 'type'));
            $pdf = \PDF::loadView('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'sumDepositsRC', 'sumDepositsRCA', 'sumCashesRC', 'sumCashesRCA', 'type'));
            return $pdf->stream("Impresion - $courtCase->abbreviation.pdf");
        } else if ($type == 2) {
            //return view('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'type', 'arrReceipt', 'arrAuxilaryReceipt'));
            $pdf = \PDF::loadView('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'type', 'arrReceipt', 'arrAuxilaryReceipt'));
            return $pdf->stream("Impresion - $courtCase->abbreviation.pdf");
        } else if ($type == 3) {
            //return view('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'depositsRC', 'depositsRCA', 'cashesRC', 'cashesRCA', 'type', 'arrReceipt', 'arrAuxilaryReceipt'));
            $pdf = \PDF::loadView('courtCases.report', compact('courtCase', 'receipts', 'auxiliaryReceipts', 'depositsRC', 'depositsRCA', 'cashesRC', 'cashesRCA', 'type', 'arrReceipt', 'arrAuxilaryReceipt'));
            return $pdf->stream("Impresion - $courtCase->abbreviation.pdf");
        } else {
            return abort(404);
        }
    }

    /**
     * @param $courtCase
     * @return mixed
     */
    private function accountingSeating($courtCase, $receipts, $firts, $last, $amount, $token) {

        $setting = $this->settingRepository->whereDuoData($courtCase->type_seat_id);

        if ($setting->isEmpty()):
            return $this->errores(['courtCase save' => 'Debe elegir configurar la cuenta para el Corte de Caja']);
        endif;

        if (!$receipts->isEmpty()):
            $seatings = ['date' => dateShort(),
                'code' => $courtCase->abbreviation,
                'detail' => 'Corte de Caja del recibo ' . $firts->receipt_number . ' Al ' . $last->receipt_number . ' del mes ' . changeLetterMonth(periodSchool()->month),
                'amount' => $amount,
                'catalog_id' => $setting[0]->catalog_id,
                'type_seat_id' => $courtCase->type_seat_id,
                'accounting_period_id' => $receipts[0]->accounting_period_id,
                'type_id' => $this->typeFormRepository->nameType('DEBITO'),
                'token' => $token,
                'status' => 'aplicado',
                'typeCollection' => 'otro',
                'user_created' => Auth::user()->id
            ];
            $Seating = $this->seatingRepository->getModel();
            if ($Seating->isValid($seatings)):
                $Seating->fill($seatings);
                if ($Seating->save()):
                    foreach ($receipts AS $seat):
                        $accountingSeats = [
                            'date' => dateShort(),
                            'code' => $courtCase->abbreviation,
                            'detail' => 'Corte de Caja del recibo ' . $firts->receipt_number . ' Al ' . $last->receipt_number . ' del mes ' . changeLetterMonth(periodSchool()->month),
                            'amount' => $seat->amount,
                            'seating_id' => $courtCase->id,
                            'catalog_id' => $seat->catalog_id,
                            'type_seat_id' => $courtCase->type_seat_id,
                            'accounting_period_id' => $seat->accounting_period_id,
                            'type_id' => $this->typeFormRepository->nameType('CREDITO'),
                            'token' => $token,
                            'status' => 'aplicado',
                            'typeCollection' => 'otro',
                            'user_created' => Auth::user()->id
                        ];

                        $SeatingPart = $this->seatingPartRepository->getModel();
                        if ($SeatingPart->isValid($accountingSeats)):
                            $SeatingPart->fill($accountingSeats);
                            $SeatingPart->save();

                        endif;
                    endforeach;

                endif;

            endif;
            return true;
        endif;
        return $this->errores($receipts);
    }

    /**
     * @param $courtCase
     * @return mixed
     */
    private function auxiliarSeat($courtCase, $auxiliaryReceipts, $firts, $last, $token) {

        if (!$auxiliaryReceipts->isEmpty()):
            foreach ($auxiliaryReceipts AS $seat):
                $auxiliarSeatCourt = ['date' => dateShort(),
                    'code' => $courtCase->abbreviation,
                    'detail' => $auxiliaryReceipts->detail.' # Recibo ' . $auxiliaryReceipts->receipt_number.' del mes ' . changeLetterMonth(periodSchool()->month),
                    'amount' => $seat->amount,
                    'financial_records_id' => $seat->financial_record_id,
                    'type_seat_id' => $courtCase->type_seat_id,
                    'accounting_period_id' => $seat->accounting_period_id,
                    'type_id' => $this->typeFormRepository->nameType('CREDITO'),
                    'token' => $token,
                    'status' => 'aplicado',
                    'typeCollection' => 'otro',
                    'user_created' => Auth::user()->id
                ];
                $auxiliarySeat = $this->auxiliarySeatRepository->getModel();
                if ($auxiliarySeat->isValid($auxiliarSeatCourt)):
                    $auxiliarySeat->fill($auxiliarSeatCourt);
                    $auxiliarySeat->save();
                endif;
                if (count($auxiliarySeat->errors) > 0):
                    \DB::rollback();
                    return $this->errores($auxiliarySeat->errors);
                endif;
            endforeach;
            return true;
        endif;
        return $this->errores($auxiliaryReceipts);
    }

}
