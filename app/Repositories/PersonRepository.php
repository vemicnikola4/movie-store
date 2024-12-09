<?php
namespace App\Repositories;

use App\Interfaces\PersonRepositoryInterface;
use App\Models\Person;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;


class PersonRepository implements PersonRepositoryInterface{
    public function __construct(
        protected Person $model
    ){}

    public function create(array $data) : Person
    {
        try {
            return $dbPerson = Person::create([
                'id'=>$data['id'],
                'name'=>$data['name'],
                'gender'=>$data['gender'],
                'birthday_date'=>$data['birthday'],
                'biography'=>$data['biography'],
                'place_of_birth'=>$data['place_of_birth'],
                'known_for_department'=>$data['known_for_department'],
                'media_id'=>$data['media_id'],
            ]);
            
           
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
       
    }
    public function deleteAll():void
    {
        try {
            // Create a new person record
            Person::query()->delete();
           
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getOne(int $id) : ?Person
    {
        try {
            // Create a new person record
       
            
            return Person::find($id);
           
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
    }
    public function getAll() : Collection
    {

    }
    public function update(int $id, array $data) : void
    {
        
    }
    // 
    //*** */


}