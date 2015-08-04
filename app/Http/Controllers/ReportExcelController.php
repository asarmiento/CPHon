<?php

namespace AccountHon\Http\Controllers;

use AccountHon\Entities\AccountingPeriod;
use AccountHon\Repositories\AccountingPeriodRepository;
use AccountHon\Repositories\AuxiliarySeatRepository;
use AccountHon\Repositories\BalancePeriodRepository;
use AccountHon\Repositories\CatalogRepository;
use AccountHon\Repositories\DegreesRepository;
use AccountHon\Repositories\FinancialRecordsRepository;
use AccountHon\Repositories\SchoolsRepository;
use AccountHon\Repositories\SeatingPartRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\StudentRepository;
use AccountHon\Repositories\TypeFormRepository;
use Illuminate\Http\Request;

use AccountHon\Http\Requests;
use AccountHon\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class ReportExcelController extends Controller
{
   /**
     * @var SchoolsRepository
     */
    protected $schoolsRepository;
    /**
     * @var CatalogRepository
     */
    protected $catalogRepository;
    /**
     * @var SeatingRepository
     */
    protected $seatingRepository;
    /**
     * @var TypeFormRepository
     */
    protected $typeFormRepository;
    /**
     * @var FinancialRecordsRepository
     */
    protected $financialRecordsRepository;
    /**
     * @var StudentRepository
     */
    protected $studentRepository;
    /**
     * @var AuxiliarySeatRepository
     */
    protected $auxiliarySeatRepository;
    /**
     * @var AccountingPeriodRepository
     */
    protected $accountingPeriodRepository;
    /**
     * @var DegreesRepository
     */
    protected $degreesRepository;
    /**
     * @var BalancePeriodRepository
     */
    protected $balancePeriodRepository;
    /**
     * @var SeatingPartRepository
     */
    protected $seatingPartRepository;

    /**
     * @param SchoolsRepository $schoolsRepository
     * @param CatalogRepository $catalogRepository
     * @param SeatingRepository $seatingRepository
     * @param TypeFormRepository $typeFormRepository
     * @param FinancialRecordsRepository $financialRecordsRepository
     * @param StudentRepository $studentRepository
     * @param AuxiliarySeatRepository $auxiliarySeatRepository
     * @param AccountingPeriodRepository $accountingPeriodRepository
     * @param DegreesRepository $degreesRepository
     * @param BalancePeriodRepository $balancePeriodRepository
     * @internal param AccountingPeriod $accountingPeriod
     */
    public function __construct(
        SchoolsRepository $schoolsRepository,
    CatalogRepository $catalogRepository,
    SeatingRepository $seatingRepository,
    TypeFormRepository $typeFormRepository,
    FinancialRecordsRepository $financialRecordsRepository,
    StudentRepository $studentRepository,
    AuxiliarySeatRepository $auxiliarySeatRepository,
    AccountingPeriodRepository $accountingPeriodRepository,
    DegreesRepository $degreesRepository,
    BalancePeriodRepository $balancePeriodRepository,
    SeatingPartRepository $seatingPartRepository
    ){

        $this->middleware('auth');
        $this->schoolsRepository = $schoolsRepository;
        $this->catalogRepository = $catalogRepository;
        $this->seatingRepository = $seatingRepository;
        $this->typeFormRepository = $typeFormRepository;
        $this->financialRecordsRepository = $financialRecordsRepository;
        $this->studentRepository = $studentRepository;
        $this->auxiliarySeatRepository = $auxiliarySeatRepository;
        $this->accountingPeriodRepository = $accountingPeriodRepository;
        $this->degreesRepository = $degreesRepository;
        $this->balancePeriodRepository = $balancePeriodRepository;
        $this->seatingPartRepository = $seatingPartRepository;
    }



    /**
     * @param $name
     * @return mixed
     */
    protected function nameType($name){
        $type= $this->typeFormRepository->whereId('name',$name,'name');

        return $type[0];
    }



}
