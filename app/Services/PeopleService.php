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
        $movieExists = $this->movieService->movieExists(['id'=>$movieId]);
        if ( $movieExists ){

            //fetching movie people from api
                $credits = $this->apiService->fetchPeople($movieExists->api_id);
                foreach($credits['cast']as $cast){
    
                        $personExists = $this->personRepository->getOne($cast['id']);
                    
                        if ( !$personExists ){
                            $person = $this->apiService->fetchPerson($cast['id']);
    
                            $media = $this->mediaService->downloadImage($person['profile_path']);
                        
                            $person['media_id'] = $media->id;
                            // $person['movie_id'] = $movie->id;
                        
                            
                        
                            $newPerson = $this->personRepository->create($person);
                            if ( !$this->personRepository->movieCastExists($movieId,$newPerson->id )){
                                
                                $this->personRepository->createMovieCast($movieId, $newPerson->id, $cast['character']);
                            }else{
                                if ( !$this->personRepository->movieCastCharacterExists($movieId,$newPerson->id,$cast['character'] )){
                                    $this->personRepository->createMovieCast($movieId, $newPerson->id, $cast['character']);
                                }

                            }
    
                           
    
                        }else{
                            if ( !$this->personRepository->movieCastExists($movieId,$personExists->id )){
                                
                                $this->personRepository->createMovieCast($movieId, $personExists->id, $cast['character']);
                            }else{
                                if ( !$this->personRepository->movieCastCharacterExists($movieId,$personExists->id,$cast['character'] )){
                                    $this->personRepository->createMovieCast($movieId, $personExists->id, $cast['character']);
                                }

                            }
                            
                        }
                        
                       
                        
                }
    
                foreach($credits['crew']as $crew){
                    $personExists = $this->personRepository->getOne($crew['id']);
    
                    if ( !$personExists ){
                        $person = $this->apiService->fetchPerson($crew['id']);

                        $media = $this->mediaService->downloadImage($person['profile_path']);
                    
                        $person['media_id'] = $media->id;
                    
                        
                    
                        $newPerson = $this->personRepository->create($person);

                        if ( !$this->personRepository->movieCrewExists($movieId,$newPerson->id )){
                                
                            $this->personRepository->createMovieCrew($movieId, $newPerson->id, $crew['job']);

                        }else{
                            if ( !$this->personRepository->movieCrewJobExists($movieId,$newPerson->id,$crew['job'] )){
                                $this->personRepository->createMovieCrew($movieId, $newPerson->id, $crew['job']);
                            }

                        }
                       

                    }else{
                        
                        if ( !$this->personRepository->movieCrewExists($movieId,$personExists->id )){
                                
                            $this->personRepository->createMovieCrew($movieId, $personExists->id, $crew['job']);

                        }else{
                            if ( !$this->personRepository->movieCrewJobExists($movieId,$personExists->id,$crew['job'] )){
                                $this->personRepository->createMovieCrew($movieId, $personExists->id, $crew['job']);
                            }

                        }
                      
                    }
                    
                }
        }
            

    }

    public function deletePeople() : void
    {
        $this->personRepository->deleteAll();
    }
    
}