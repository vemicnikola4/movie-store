<?php
namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\QueryException;

class MovieRepository implements MovieRepositoryInterface{

    public function __construct(
        protected Movie $model
    ){}


    public function create(array $data) : void 
    {
        $prices= [700,900,950,1000,1200,1500,1700];
        $movieExists = Movie::where('api_id',$data['id'])->first();
        if ( !$movieExists ){
            try {
                $dbMovie = new Movie;
                $dbMovie->title = $data['title'];
                $dbMovie->overview = $data['overview'];
                $dbMovie->original_language = $data['original_language'];
                $dbMovie->release_date = $data['release_date'];
                $dbMovie->api_id = $data['id'];
                $dbMovie->media_id = $data['media_id'];
                $dbMovie->price = $prices[mt_rand(0,6)];
                $dbMovie->save();
            } catch (QueryException $e) {
                // Handle database-related exceptions
                throw new MovieException('Database error while creating movie: ' . $e->getMessage());
            } catch (\Exception $e) {
                // Handle any other exceptions
                throw new MovieException('An unexpected error occurred: ' . $e->getMessage());
            } 
           
        }
       

    }
    public function deleteAll():void
    {
        Movie::query()->delete();

    }

}
