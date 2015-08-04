<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 06/07/2015
 * Time: 12:10 AM
 */

namespace AccountHon\Http\Controllers\ReportExcel;


use AccountHon\Entities\Degree;
use AccountHon\Entities\School;
use AccountHon\Http\Controllers\ReportExcelController;
use Maatwebsite\Excel\Facades\Excel;

class StudentsBalance extends ReportExcelController {

    public function index(){ set_time_limit(0);
        $student = $this->studentRepository->whereId('school_id',userSchool()->id,'sex');

        $content=array(
            array(userSchool()->name),
            array('LISTA DE SALDOS DE ESTUDIANTES'),
            array('')
        );
        $countTotal =array();
        $countGrado=array();
        $countHeader = count($content);
        $school = $this->schoolsRepository->getModel()->find(userSchool()->id);
            foreach($school->degrees AS $degree):
        $content[]=  array('GRADO: '.$degree->name);
                $countGrado[] = count($content);
                $content[]=  array('CARNET','NOMBRE ALUMNO','SALDO');
                $students = $this->financialRecordsRepository->whereId('year',periodSchool()->year,'updated_at');
                $total=0;
                foreach($students AS $student):
                    if($degree->id == $student->degreeDatos()->id ):
                    $content[]=  array($student->students->book,$student->students->nameComplete(),$student->balance);
                        $total +=$student->balance;

                    endif;
                endforeach;
                $content[]=array('','TOTAL',$total);
                $countTotal[]=count($content);
                $content[]=array('','','');
            endforeach;



        Excel::create(date('d-m-Y').'- Todos los Grados', function($excel) use ($content,$countTotal,$countGrado) {
            $excel->sheet('Saldos de todos los Alumnos', function($sheet)  use ($content,$countTotal,$countGrado) {
                $sheet->mergeCells('A1:C1');
                $sheet->mergeCells('A2:C2');
                $sheet->mergeCells('A3:C3');
                foreach($countGrado AS $grado):
                    $sheet->mergeCells('A'.$grado.':C'.$grado);
                    $sheet->cells('A'.$grado.':D'.$grado, function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                    $grado= $grado+1;
                    $sheet->cells('A'.$grado.':D'.$grado, function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });
                endforeach;
                foreach($countTotal AS $total):
                    $sheet->cells('A'.$total.':D'.$total, function($cells) {
                        $cells->setFontSize(12);
                        $cells->setFontWeight('bold');
                        $cells->setAlignment('center');
                    });

                endforeach;
                $sheet->cell('A1', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cell('A2', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });
                $sheet->cell('A3', function($cell) {
                    $cell->setFontSize(16);
                    $cell->setFontWeight('bold');
                    $cell->setAlignment('center');
                });



                $sheet->fromArray($content, null, 'A1', true,false);
            });
        })->export('xlsx');

    }
}