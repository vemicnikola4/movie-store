<?php
namespace App\Repositories;

use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class MovieRepository implements MovieRepositoryInterface{

    public function __construct(
        protected Movie $model
    ){}


    public function create(array $data) : Movie
    {
        $prices= [700,900,950,1000,1200,1500,1700];
        try {
            return $movie = Movie::create([
                'title'=>$data['title'],
                'overview'=>$data['overview'],
                'original_language'=>$data['original_language'],
                'release_date'=>$data['release_date'],
                'api_id'=>$data['id'],
                'media_id'=>$data['media_id'],
                'price'=>$prices[mt_rand(0,6)],
            ]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

       

    }
    public function deleteAll():void
    {
        try {
            Movie::query()->delete();

        
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new MovieException('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }

    public function movieExists(array $data) : ?Movie
    {
        $keys = array_keys($data);
        $column =  $keys[0];
        try {
            return Movie::where($column,$data[$column])->first();
        
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new MovieException('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function addGenre(object $movie,array $genre):void
    {
        try{
            $movie->genres()->attach($genre['id']);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }

    public function movieGenreExists(object $movie, array $genre) : ?array
    {
        $movieId =$movie->id;
        $genreId = $genre['id'];
        try{
            return DB::select('select * from movie_genres where movie_id = '.$movieId.' AND genre_id = '.$genreId);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
