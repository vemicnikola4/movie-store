<?php


namespace App\Interfaces;
use Illuminate\Http\Request;

interface BaseInterface {
    
    public function index();
    public function create(array $data);
    public function store(Request  $data);
    public function show(object $data);
    public function edit(object $id);
    public function update($data);
    public function destroy(object $data);

}