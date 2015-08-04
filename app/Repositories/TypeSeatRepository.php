<?php
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 22/06/2015
 * Time: 10:42 PM
 */

namespace AccountHon\Repositories;


use AccountHon\Entities\TypeSeat;
use Illuminate\Support\Facades\Response;

class TypeSeatRepository extends BaseRepository {

    /**
     * @return mixed
     */
    public function getModel()
    {
        return new TypeSeat();
    }

    public function whereDuoData($id){
        return $this->newQuery()->where('abbreviation', $id)->where('school_id', userSchool()->id)->get();
    }

    public function updateWhere($id){
        $alumno = $this->whereDuoData($id);
        $num = $alumno[0]->quatity+1;
        $cambio= $this->newQuery()->where('abbreviation', $id)->where('school_id', userSchool()->id)->update(['quatity'=>$num]);
        return $cambio;
    }
}