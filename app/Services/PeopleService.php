<?php
namespace App\Services;

use App\Models\Person;
use App\Models\Movie;
use App\Models\Media;
use App\Services\ApiService;
use App\Services\MediaService;


class PeopleService{

    protected $apiService;

    public function __construct(ApiService $apiService,MediaService $mediaService)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;

    }


    public function insertPeople($movie, $apiId){

        $credits = $this->apiService->fetchPeople($apiId);
        // $movie = Movie::where('api_id',$apiId);
        
        foreach($credits['cast']as $cast){
            $person = $this->apiService->fetchPerson($cast['id']);
        
            $mediaId = $this->mediaService->downloadImage($person['profile_path']);
        
            $castExists = Person::find($person['id']);
            if ( !$castExists){
                $dbPerson = new Person;
                $dbPerson->name = $person['name'];
                $dbPerson->gender = $person['gender'];
                $dbPerson->birthday_date = $person['birthday'];
                $dbPerson->biography = $person['biography'];
                $dbPerson->place_of_birth = $person['place_of_birth'];
                $dbPerson->known_for_department = $person['known_for_department'];
                $dbPerson->media_id = $mediaId;
                $dbPerson->save();

                $dbPerson->movies()->attach($movie->id);
            }
        }
        foreach($credits['crew']as $crew){
            $person = $this->apiService->fetchPerson($crew['id']);
            $mediaId = $this->mediaService->downloadImage($person['profile_path']);


            $castExists = Person::find($cast['id']);
            if ( !$castExists){
                $dbPerson = new Person;
                $dbPerson->name = $person['name'];
                $dbPerson->gender = $person['gender'];
                $dbPerson->birthday_date = $person['birthday'];
                $dbPerson->biography = $person['biography'];
                $dbPerson->place_of_birth = $person['place_of_birth'];
                $dbPerson->known_for_department = $person['known_for_department'];
                $dbPerson->media_id = $mediaId;
                $dbPerson->save();

                $dbPerson->movies()->attach($movie->id);

            }
        }

    }
}