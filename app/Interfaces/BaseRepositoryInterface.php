<?php


namespace App\Interfaces;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryInterface {
    public function create(array $data);
    public function getAll() : Collection ;
    public function getOne(int $id);
    public function update(int $id, array $data ): void;
    

}