<?php

namespace AccountHon\Repositories;

    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

/**
 * Description of BaseRepository
 *
 * @author Anwar Sarmiento
 */
abstract class BaseRepository {


    /**
     * @return mixed
     */
    abstract public function getModel();

    public function __construct(){

    }

    public function token($token) {
        $consults = $this->newQuery()->where('token', $token)->get();
        if ($consults):
            foreach ($consults as $consult):
                return $consult;
            endforeach;
        endif;

        return false;
    }

    public function newQuery() {
        return $this->getModel()->newQuery();
    }

    public function whereId($data, $id,$order){
        return $this->newQuery()->where($data, $id)->orderBy($order,'DESC')->get();
    }

    public function whereDuo($dataOne,$id,$dataTwo, $idTwo,$data,$style){
        return $this->newQuery()->where($dataOne, $id)->where($dataTwo, $idTwo)->orderBy($data,$style)->get();
    }

    public function findOrFail($id) {
        return $this->newQuery()->findOrFail($id);
    }

    public function withTrashedOrderBy($data, $type) {
        return $this->newQuery()->withTrashed()->orderBy($data, $type)->get();
    }

    public function onlyTrashedFind($id) {
        return $this->newQuery()->onlyTrashed()->find($id);
    }

    public function withTrashedFind($id) {
        return $this->newQuery()->withTrashed()->find($id);
    }

    public function destroy($id) {
        return $this->getModel()->destroy($id);
    }

    public function find($id) {
        return $this->newQuery()->find($id);
    }

    public function orderBy($data, $type){
        return $this->newQuery()->orderBy($data, $type)->get();
    }

    public function all() {
        return $this->newQuery()->get();
    }

    public function detach(){
        return $this->detach();
    }

    public function attach($id, $array){
        return $this->attach($id, $array);
    }

    public function lists($keyList){
        return $this->newQuery()->where('school_id', userSchool()->id)->lists($keyList);
    }

    public function listsWhere($column, $filter, $keyList){
        return $this->newQuery()->where('school_id', userSchool()->id)->where($column, $filter)->lists($keyList);
    }

    public function listsRange($array, $filter, $keyList){
        return $this->newQuery()->where('school_id', userSchool()->id)
            ->whereBetween($filter, array($array[0], $array[1]))
            ->lists($keyList);
    }

    public function whereIn($column1, $filter, $column2, $array){
        return $this->newQuery()->where($column1, $filter)->whereIn($column2, $array)->get();
    }
    
    public function whereDuoIn($column1, $filter1, $column2, $filter2, $column3, $array){
        return $this->newQuery()->where($column1, $filter1)->where($column2, $filter2)->whereIn($column3, $array)->get();
    }

    public function whereInList($column1, $array, $keyList){
        return $this->newQuery()->whereIn($column1, $array)->lists($keyList);
    }

    public function whereDuoInListDistinct($colum1, $filter1, $column2, $filter2, $column3, $array, $keyList){
        return $this->newQuery()->where($colum1, $filter1)->where($column2, $filter2)->whereIn($column3, $array)->distinct()->lists($keyList);
    }

    public function first(){
        return $this->newQuery()->first();
    }

    public function last(){
        return $this->newQuery()->orderBy('id', 'desc')->first();
    }

    public function sumInSchool($column1, $filter1){
        return $this->newQuery()->where('school_id', userSchool()->id)->whereIn($column1, $filter1)->sum('amount');
    }

    public function whereNot($column1, $filter1){
        return $this->newQuery()->where($column1, '<>', $filter1)->get();
    }

}