<?php
namespace App\Repositories;

use App\Interfaces\PersonRepositoryInterface;
use App\Models\Person;
use Illuminate\Database\QueryException;

class PersonRepository implements PersonRepositoryInterface{
    public function __construct(
        protected Person $model
    ){}

    public function create(array $data)
    {
        
        try {
            $dbPerson = Person::create([
                'name'=>$data['name'],
                'gender'=>$data['gender'],
                'birthday_date'=>$data['birthday'],
                'biography'=>$data['biography'],
                'place_of_birth'=>$data['place_of_birth'],
                'known_for_department'=>$data['known_for_department'],
                'media_id'=>$data['media_id'],
            ]);
            
            $dbPerson->movies()->attach($data['movie_id']);
           
        } catch (QueryException $e) {
            // Handle database-related exceptions
            throw new QueryException('Database error while creating Person: ' . $e->getMessage());
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
           
        }catch (QueryException $e) {
            // Handle database-related exceptions
            throw new QueryException('Database error while deleting Person: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }


}