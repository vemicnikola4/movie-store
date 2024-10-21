<?php
namespace App\Repositories;

use App\Interfaces\PersonRepositoryInterface;
use App\Models\Person;
use Illuminate\Database\QueryException;

class PersonRepository implements PersonRepositoryInterface{
    public function __construct(
        protected Person $model
    ){}

    public function create(array $person)
    {
        
        try {
            // Create a new person record
            $dbPerson = new Person;
            $dbPerson->name = $person['name'];
            $dbPerson->gender = $person['gender'];
            $dbPerson->birthday_date = $person['birthday'];
            $dbPerson->biography = $person['biography'];
            $dbPerson->place_of_birth = $person['place_of_birth'];
            $dbPerson->known_for_department = $person['known_for_department'];
            $dbPerson->media_id = $person['media_id'];
            $dbPerson->save();
            $dbPerson->movies()->attach($person['movie_id']);
           
        } catch (QueryException $e) {
            // Handle database-related exceptions
            throw new PersonException('Database error while creating Person: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new PersonException('An unexpected error occurred: ' . $e->getMessage());
        } 
       
    }
    public function deleteAll():void
    {
        try {
            // Create a new person record
            Person::query()->delete();
           
        } catch (QueryException $e) {
            // Handle database-related exceptions
            throw new PersonException('Database error while creating Person: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new PersonException('An unexpected error occurred: ' . $e->getMessage());
        } 

    }


}