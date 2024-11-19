<?php


namespace App\Interfaces;

interface MovieRepositoryInterface extends BaseInterface{
    
    public function deleteAll();
    public function getAll();
    public function getOne($id);

}