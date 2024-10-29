<?php
namespace App\Services;

use App\Models\Person;
use App\Models\Movie;
use App\Models\Media;
use App\Services\ApiService;
use App\Services\MediaService;
use App\Services\MovieService;
use App\Interfaces\PersonRepositoryInterface;




class PeopleService{


    public function __construct(ApiService $apiService,MediaService $mediaService,PersonRepositoryInterface $personRepository,MovieService $movieService)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;
        $this->movieService = $movieService;
        $this->personRepository = $personRepository;

    }


    public function insertPeople( $movieId ) : void
    {
        
        //geting movie from DB
            $movie = $this->movieService->getOne($movieId);

        //fetching movie people from api
            $credits = $this->apiService->fetchPeople($movie->api_id);

            
            foreach($credits['cast']as $cast){

                    $personExists = $this->personRepository->getOne($cast['id']);

                    if ( !$personExists ){
                        $person = $this->apiService->fetchPerson($cast['id']);

                        $media = $this->mediaService->downloadImage($person['profile_path']);
                    
                        $person['media_id'] = $media->id;
                        $person['movie_id'] = $movie->id;
                    
                        
                    
                        $this->personRepository->create($person);

                    }else{
                        if ( !$this->personRepository->moviePersonExists($movieId,$cast['id'])){
                            $this->personRepository->attachMovie($cast['id'],$movieId);

                        }
                    }
                    
                   
                    
            }
                
            


            foreach($credits['crew']as $crew){
                $personExists = $this->personRepository->getOne($crew['id']);

                if ( !$personExists ){
                    $person = $this->apiService->fetchPerson($crew['id']);

                    $media = $this->mediaService->downloadImage($person['profile_path']);
            
                    $person['media_id'] = $media->id;
                    $person['movie_id'] = $movie->id;
                
                   
                    $this->personRepository->create($person);

                }else{
                    if ( !$this->personRepository->moviePersonExists($movieId,$crew['id']) ){
                        $this->personRepository->attachMovie($crew['id'],$movieId);

                    }
                }
                
            }

    }

    public function deletePeople() : void
    {
        $this->personRepository->deleteAll();
    }
    
}