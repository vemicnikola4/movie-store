<?php
namespace App\Repositories;

use App\Interfaces\PersonRepositoryInterface;
use App\Models\Person;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PersonRepository implements PersonRepositoryInterface{
    public function __construct(
        protected Person $model
    ){}

    public function create(array $data)
    {
        try {
            $dbPerson = Person::create([
                'id'=>$data['id'],
                'name'=>$data['name'],
                'gender'=>$data['gender'],
                'birthday_date'=>$data['birthday'],
                'biography'=>$data['biography'],
                'place_of_birth'=>$data['place_of_birth'],
                'known_for_department'=>$data['known_for_department'],
                'media_id'=>$data['media_id'],
            ]);
            
            $this->attachMovie($data['id'],$data['movie_id']);
           
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
    public function getOne($id)
    {
        try {
            // Create a new person record
       
            
            return Person::find($id);
           
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
    }
    public function attachMovie($personId, $movieId){
        try{
            $person = Person::find($personId);
            if ( $person ){
                $person->movies()->attach($movieId);
            }
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
        
    }
    public function moviePersonExists($movieId,$personId){
        return DB::table('movie_people')
        ->where([
            ['movie_id', '=', $movieId],
            ['person_id', '=', $personId],
        ])
        ->first();
    }


}