<?php

namespace AccountHon\Http\Controllers;



use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Input;
class TestController extends Controller {
    

 
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index()
    {
        return view('test.index');
    }

    public function post(){
       set_time_limit(0);
       $file = Input::file('file');
      // dd($file);
       $excel = $this->uploadExcel($file,'CICLO1.xlsx');



             
    }

     public  function uploadExcel($file,  $fileName) {

         $MaatExcel = App::make('excel');

        $path = 'files';

        if (strtoupper($file->getClientOriginalExtension()) == 'XLSX' || strtoupper($file->getClientOriginalExtension()) == 'XLS'):

            $file->move($path, $fileName);

            $files = $path . '/' . $fileName;

            $excel = $MaatExcel->load($files, function ($reader) {

                        $reader->formatDates(true, 'Y-m-d');

                    })->all();



            return $excel;

        endif;

        return false;

    }

  /*  public function catalogSaldo($catalog,$period,$type){

        return Seating::where('type_id',$type)
            ->where('accounting_period_id',$period)
            ->where('catalog_id',$catalog)->sum('amount');
    }

   public function catalogPartSaldo($catalog,$period,$type){

        return Seating::where('type_id' ,$type)
            ->where('accounting_period_id',$period)
            ->where('catalogPart_id',$catalog)->sum('amount');
    }*/


}
