<?php
// app/Services/MovieService.php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Movie;

use App\Interfaces\MovieRepositoryInterface;
use App\Services\ApiService;
use App\Services\GenreService;
use App\Services\MediaService;



class MovieService
{
    

    public function __construct(ApiService $apiService,MediaService $mediaService,MovieRepositoryInterface  $movieRepository,GenreService $genreService)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;
        $this->genreService = $genreService;
        $this->movieRepository = $movieRepository;
    }
    
    public function insertMovies()
    {
        $fetchedMovies = $this->apiService->fetchMovies(); // Call the apiService method

        foreach ( $fetchedMovies as $movie ){
            $fetchedMovie = $this->apiService->fetchMovie($movie['id']);

            $movieExists = $this->movieRepository->movieExists(['api_id'=>$fetchedMovie['id']]);
            if ( !$movieExists ){
                
                $createdMovie = $this->insertOneMovie($fetchedMovie);


                foreach($fetchedMovie['genres'] as $genre ){
                    if ( $this->genreService->genreExists($genre['id']) ){
                        $this->movieRepository->addGenre($createdMovie,$genre);
                    }else{
                        $this->genreService->insertOne($genre);
                        $this->movieRepository->addGenre($createdMovie,$genre);

                    }
                    
                }


            }else{
                
                foreach($fetchedMovie['genres'] as $genre ){
                    if ( $this->genreService->genreExists($genre['id']) ){
                        if ( !$this->movieRepository->movieGenreExists($movieExists, $genre)){
                            $this->movieRepository->addGenre($movieExists,$genre);
                        }
                    }else{
                        $this->genreService->insertOne($genre);
                        if ( !$this->movieRepository->movieGenreExists($movieExists, $genre)){
                            $this->movieRepository->addGenre($movieExists,$genre);
                        }

                    }
                    
                }
            }
            
        }
    }
    public function insertOneMovie(array $movie){
        $media = $this->mediaService->downloadImage($movie['poster_path']);
        $movie['media_id'] = $media->id;
        
        return $this->movieRepository->create($movie);
    }

    public function deleteMovies() : void
    {
        $this->movieRepository->deleteAll();

    }


    
}