<?php


namespace App\Interfaces;

interface MediaRepositoryInterface{
    
    public function create(array $data);
    public function getOne($id);
    public function getOneWithPath(string $path);

}