<?php
namespace App\Services;
use App\Repositories\GenreRepository;



class GenreService
{
    public function __construct(ApiService $apiService,GenreRepository $genreRepository)
    {
        $this->apiService = $apiService;
        $this->genreRepository = $genreRepository;
    }
    public function insertGenres() 
    {
        $allGenres = $this->apiService->fetchGenres();
        
        foreach( $allGenres['genres'] as $genre ){
            $this->insertOneGenre($genre);
        }
    }

    public function insertOneGenre(array $genre) 
    {   
        $genreExists =  $this->genreRepository->getOne($genre['id']);
        if( !$genreExists ){
            $this->genreRepository->create($genre);
        }
    }
  

}
