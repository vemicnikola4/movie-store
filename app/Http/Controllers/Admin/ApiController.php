<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Media;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Person;

use App\Services\MovieService;
use App\Services\PeopleService;
use App\Services\GenreService;

class ApiController extends Controller
{
    protected $movieService;
    protected $peopleService;

    public function __construct(MovieService $movieService,PeopleService $peopleService,GenreService $genreService)
    {
        $this->movieService = $movieService;
        $this->peopleService = $peopleService;
        $this->genreService = $genreService;
    }

    public function getMovies(){


        $this->movieService->deleteMovies();
        
        $this->movieService->insertMovies();

        // $allMovies = Movie::all();

        // foreach($allMovies as $movie){
        //     $this->peopleService->insertPeople($movie, $movie['api_id']);
        // }

    }
    public function getPeople($movieId){

        set_time_limit(300);

        $this->peopleService->insertPeople($movieId);


    } 
    public function deleteDatabaseData(){

        
        $this->movieService->deleteMovies();
        
        $this->peopleService->deletePeople();


       
    }
 
    public function getGenres(){
        $this->genreService->insertGenres();

        return inertia("Admin/Dashboard");
    }





}
