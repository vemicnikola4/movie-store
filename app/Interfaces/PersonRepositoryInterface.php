<?php
namespace App\Interfaces;

interface PersonRepositoryInterface{
    
    public function create(array $person);
    public function deleteAll();

}