<?php

/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 13/07/2015
 * Time: 01:56 AM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\CourtCase;
use AccountHon\Repositories\TypeSeatRepository;
use AccountHon\Repositories\SeatingRepository;
use AccountHon\Repositories\AuxiliarySeatRepository;

class CourtCaseRepository extends BaseRepository{

	private $typeSeatRepository;
	private $seatingRepository;
	private $auxiliarySeatRepository;

	public function __construct(
		TypeSeatRepository $typeSeatRepository,
		SeatingRepository $seatingRepository,
		AuxiliarySeatRepository $auxiliarySeatRepository
		){

		$this->typeSeatRepository = $typeSeatRepository;
		$this->seatingRepository = $seatingRepository;
		$this->auxiliarySeatRepository = $auxiliarySeatRepository;

	}
    /**
     * @return mixed
     */
    public function getModel()
    {
        return new CourtCase();
    }

    public function CourtCaseAll(){
    	$corCar = $this->typeSeatRepository->whereDuoData('CorCa');
    	return $this->newQuery()->where('type_seat_id',$corCar[0]->id)->get();
    	
    }

    public function amountCourtCase(){
    	
    }

}