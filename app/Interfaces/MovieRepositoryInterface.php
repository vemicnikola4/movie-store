<?php


namespace App\Interfaces;

interface MovieRepositoryInterface{
    
    public function create(array $data);
    public function deleteAll();
    public function getAll();

}