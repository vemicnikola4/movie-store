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
    public function attachMovie(object $person,int  $movieId) : void
    {
        try{
            $person->movies()->attach($movieId);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
        
    }
    public function moviePersonExists(int $movieId,int $personId) : ?object
    {
        
        try{
            return DB::table('movie_people')
            ->where([
                ['movie_id', '=', $movieId],
                ['person_id', '=', $personId],
            ])
            ->first();
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
       
    }

    public function addCharacterToPivotTable(object $person,int $movieId, string $character ) : void
    {
        
        try{
            DB::table('movie_people')
              ->where('movie_id', $movieId)->where('person_id',$person->id)
              ->update(['character' => $character]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
       
    }
    public function addJobToPivotTable(object $person,int $movieId, string $job ) : void
    {
        
        try{
            DB::table('movie_people')
              ->where('movie_id', $movieId)->where('person_id',$person->id)
              ->update(['job' => $job]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
       
    }
    public function movieCastExists(int $movieId, int $personId ) : ?object
    {
        try{
            return DB::table('cast')
            ->where([
                ['movie_id', '=', $movieId],
                ['person_id', '=', $personId],
            ])
            ->first();
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }

    }
   
    public function movieCastCharacterExists(int $movieId, int $personId, string $character ): ?object
    {
        try{
            return DB::table('cast')
            ->where([
                ['movie_id', '=', $movieId],
                ['person_id', '=', $personId],
                ['character', '=', $character],
            ])
            ->first();
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function createMovieCast(int $movieId, int $personId, string $character) : void 
    {
        try{
            DB::table('cast')->insert([
                'movie_id' => $movieId,
                'person_id' => $personId,
                'character' => $character,
            ]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        

    }


    //***crew check */
    public function movieCrewExists(int $movieId, int $personId ) : ?object
    {
        try{
            return DB::table('crew')
            ->where([
                ['movie_id', '=', $movieId],
                ['person_id', '=', $personId],
            ])
            ->first();
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }

    }

    public function movieCrewJobExists(int $movieId, int $personId, string $job ): ?object
    {
        try{
            return DB::table('crew')
            ->where([
                ['movie_id', '=', $movieId],
                ['person_id', '=', $personId],
                ['job', '=', $job],
            ])
            ->first();
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function createMovieCrew(int $movieId, int $personId, string $job) : void 
    {
        try{
            DB::table('crew')->insert([
                'movie_id' => $movieId,
                'person_id' => $personId,
                'job' => $job,
            ]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        

    }


}