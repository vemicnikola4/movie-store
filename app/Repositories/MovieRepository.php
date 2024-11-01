<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use App\Models\Media;
use App\Models\Genre;
use Illuminate\Database\QueryException;
<<<<<<< HEAD
use App\Exceptions\MovieException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

=======
use Illuminate\Support\Facades\DB;
>>>>>>> fetching-movies-from-api

class MovieRepository implements MovieRepositoryInterface{

    public function __construct(
        protected Movie $model
    ){}


<<<<<<< HEAD
    public function create(array $data) 
    {
        $prices= [700,900,950,1000,1200,1500,1700];
        $movieExists = Movie::where('api_id',$data['id'])->first();
        if ( !$movieExists ){
            try {
                Movie::create([
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
=======
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

>>>>>>> fetching-movies-from-api
       

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
    public function getAll(): Collection
    {
        try{
           
            return Movie::all();
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }
    public function getOne($id) : Movie
    {
        return Movie::find($id);
    }
        
    public function addGenre($movie,$genre){
        try{
            $movie->genres()->attach($genre['id']);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }
    public function moviePersonExists($movieId,$personId){
        try{
            return DB::select('select * from movie_people where movie_id = ', [$movieId],'AND person_id=',[$personId]);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }

<<<<<<< HEAD
    public function movieQuery($query){
        try{
            return $query->get();
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function update($request): void
    {
        try{
            $movie = Movie::find($request['movie_id']);
            $movie->price= $request['price'];
            $movie->save();
=======
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
>>>>>>> fetching-movies-from-api
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }

<<<<<<< HEAD
    public function getImage($movie){


        $img = Media::find($movie->media_id);
        $contents = Storage::get($img->path)->first();
        dd($content);

    }

    public function apiMovieExists($movieApiId) : ?Movie
    {
        return Movie::where('api_id',$movieApiId)->first();
    }
    public function movieGenreExists ($movieId) : Bool
    {
        try{
            $movie = DB::select('select * from movie_genres where movie_id = '.$movieId.' limit 1');
            if ( $movie ){

                return true;
            }else{
                return false;
            }
=======
    public function movieGenreExists(object $movie, array $genre) : ?array
    {
        $movieId =$movie->id;
        $genreId = $genre['id'];
        try{
            return DB::select('select * from movie_genres where movie_id = '.$movieId.' AND genre_id = '.$genreId);
>>>>>>> fetching-movies-from-api
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}
