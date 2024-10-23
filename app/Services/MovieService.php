<?php
// app/Services/MovieService.php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Movie;

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
        return Movie::find($id);
    }


    
}