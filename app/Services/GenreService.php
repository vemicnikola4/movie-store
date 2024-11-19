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
    
        public function insertOne(array $genre) 
        {   
            $this->genreRepository->create($genre);
        }

        public function genreExists($id) 
        {
            return $this->genreRepository->genreExists($id);
        }
        public function getOne($id) 
        {
            return $this->genreRepository->genreExists($id);
        }
        public function getOneByName(string $name) 
        {
            return $this->genreRepository->getOneByName($name);
        }
        public function genreMovies( object $genre )
        {
            return $this->genreRepository->movies($genre);
        }

    }

