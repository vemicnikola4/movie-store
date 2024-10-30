<?php
// app/Services/MovieService.php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Movie;
use App\Models\Media;

use App\Interfaces\MovieRepositoryInterface;
use App\Repositories\MovieRepository;

use App\Services\ApiService;
use App\Services\MediaService;



class MovieService
{
    // protected $apiService;
    // protected $movieRepository;

    public function __construct(ApiService $apiService,MediaService $mediaService,MovieRepositoryInterface  $movieRepository)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;
        $this->movieRepository = $movieRepository;
    }
    
    public function insertMovies()
    {
        $allMovies = $this->apiService->fetchMovies(); // Call the apiService method

        foreach ( $allMovies as $movie ){

            $this->insertOneMovie($movie);
            
        }
    }
    public function insertOneMovie($movie){
        
        $media = $this->mediaService->downloadImage($movie['poster_path']);
        $movie['media_id'] = $media->id;
        
        $this->movieRepository->create($movie);
    }

    public function deleteMovies() : void
    {
        $this->movieRepository->deleteAll();

    }
    public function getOne($id) : Movie 
    {
        $movie = $this->movieRepository->getOne($id);
        $media = $this->mediaService->getOne($movie->media_id);

        $movie['people']=$movie->people;
        $movie['genres']=$movie->genres;
        $movie['image_path'] = asset('storage/'.$media->path);

        foreach( $movie['people'] as $person ){
            $media = $this->mediaService->getOne($person->media_id);

            $person['image_path'] = asset('storage/'.$media->path);
        }

        return $movie;
    }

    public function insertMovieGenres(){

        $allMovies = $this->allMovies();

        foreach ( $allMovies as $dbMovie ){
            if(!$this->movieRepository->movieGenreExists($dbMovie->id)){
                $apiMovie = $this->apiService->fetchOneMovie($dbMovie->api_id);

                foreach($apiMovie['genres'] as $genre ){
                    $this->movieRepository->addGenre($dbMovie,$genre);
                }
            }
            
            
        }

    }
    public function allMovies(){

        return $this->movieRepository->getAll();
    }

    public function adminGetMovies($request)
    {
        $query = Movie::query();

        if ( $request['sort_by_release_date'] ){
            $query->orderBy('release_date',$request['sort_by_release_date']);
        }
        if ( $request['sort_by_title'] ){
            $query->orderBy('title',$request['sort_by_title']);
        }
        if ( $request['sort_by_price'] ){
            $query->orderBy('price',$request['sort_by_price']);
        }

        if ( $request['title']){
            $query->where( "title",'like',"%".$request['title']."%");
        }
        if($request['price'] )
        {
            $query->where('price', '=', $request['price']);
        }


        // $movies = $query->get();
        $movies = $this->movieRepository->movieQuery($query);

        
        
        foreach($movies as $movie){
            
            $movie['people']=$movie->people;
            $media = $this->mediaService->getOne($movie->media_id);

            $movie['image_path']= asset('storage/'.$media->path);
           
        }
        return $movies;
        

    }
    public function adminUpdateMovie($request) : void 
    {
        $this->movieRepository->update($request);
       

    }
    


    
}