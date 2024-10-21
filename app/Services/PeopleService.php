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

    protected $apiService;

    public function __construct(ApiService $apiService,MediaService $mediaService,PersonRepositoryInterface $personRepository,MovieService $movieService)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;
        $this->movieService = $movieService;
        $this->personRepository = $personRepository;

    }


    public function insertPeople( $movieId ) : void
    {
            $movie = $this->movieService->getOne($movieId);
            $credits = $this->apiService->fetchPeople($movie->api_id);
            $castIds = [];
            $crewIds = [];
            foreach($credits['cast']as $cast){
                if (!in_array($cast['id'],$castIds )){
                    $castIds[]=$cast['id'];
                    $person = $this->apiService->fetchPerson($cast['id']);
                    $media = $this->mediaService->downloadImage($person['profile_path']);
                
                    $person['media_id'] = $media->id;
                    $person['movie_id'] = $movie->id;
                    
                    $this->personRepository->create($person);
                    
                   
                    
                }
                
            }


            foreach($credits['crew']as $crew){
                if (!in_array($crew['id'],$crewIds )){
                    $crewIds[]=$crew['id'];
                    $person = $this->apiService->fetchPerson($crew['id']);
                    $media = $this->mediaService->downloadImage($person['profile_path']);
        
                    $person['media_id'] = $media->id;
                    $person['movie_id'] = $movie->id;

                    $this->personRepository->create($person);
                }
                
            }

    }

    public function deletePeople() : void
    {
        $this->personRepository->deleteAll();

    }

}