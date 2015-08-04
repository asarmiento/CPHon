<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 10:43 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\BalancePeriod;
use AccountHon\Repositories\SeatingPartRepository;

/**
 * @property  seatingRepository
 */
class BalancePeriodRepository extends BaseRepository{
    protected $seatingRepository;
    /**
     * @var TypeFormRepository
     */
    private $typeFormRepository;

    private $seatingPartRepository;
    public function __construct(
            SeatingRepository $seatingRepository,
            TypeFormRepository $typeFormRepository,
            SeatingPartRepository $seatingPartRepository
            ){
        $this->seatingPartRepository = $seatingPartRepository;
        $this->seatingRepository = $seatingRepository;
        $this->typeFormRepository = $typeFormRepository;
    }
    /**
     * @return mixed
     */
    public function getModel()
    {
        return new BalancePeriod();
    }


    public function saldoIncial($data, $filter,$catalog){

        return $this->newQuery()
            ->where('school_id',userSchool()->id)
            ->where('catalog_id',$catalog)
            ->where($filter,'<' ,$data)->sum('amount');
    }

    public function saldoTotalPeriod($catalog,$period){
        $debito =   $this->saldoPeriod($catalog,$period,'DEBITO');
        $credito =   $this->saldoPeriod($catalog,$period,'CREDITO');


        if(($debito > 0 ) && ($credito > 0)):
            $saldo = $debito-$credito;
        elseif(($debito > 0 ) && ( $credito == 0)): 
            $saldo = $debito;

        elseif(($debito == 0) && ($credito > 0)):
            $saldo = 0-$credito;
        elseif(($debito == 0) && ($credito == 0)):
            $saldo = 0;
        endif;
        
        return $saldo;
    }

    public function saldoPeriod($catalog,$period,$type){

        $saldo = $this->saldoPeriodCatalog($catalog,$period,$type);
        $saldoPart =$this->saldoPeriodCatalogPart($catalog,$period,$type);
        $total = $saldo+$saldoPart;
        return $total;
    }

    private function saldoPeriodCatalog($catalog,$periods,$type){
        $type = $this->typeFormRepository->nameType($type);
        $saldo = 0;
        foreach($periods AS $key => $period):
            $saldo += $this->seatingRepository->catalogPeriod($catalog,$period,$type);
        endforeach;
        return $saldo;
    }

    private function saldoPeriodCatalogPart($catalog,$periods,$type){
        $type = $this->typeFormRepository->nameType($type);
        $saldo = 0;
        foreach($periods AS $key => $period):
            $saldo += $this->seatingPartRepository->catalogPeriod($catalog,$period,$type);
        endforeach;
        return $saldo;
    }
}