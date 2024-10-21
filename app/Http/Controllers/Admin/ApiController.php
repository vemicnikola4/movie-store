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

class ApiController extends Controller
{
    protected $movieService;
    protected $peopleService;

    public function __construct(MovieService $movieService,PeopleService $peopleService)
    {
        $this->movieService = $movieService;
        $this->peopleService = $peopleService;
    }

    public function getMovies(){


        $this->movieService->deleteMovies();
        
        $this->movieService->insertMovies();

        // $allMovies = Movie::all();

        // foreach($allMovies as $movie){
        //     $this->peopleService->insertPeople($movie, $movie['api_id']);
        // }

    }
    public function getPeople($movieApiId){

        set_time_limit(300);

        $this->peopleService->insertPeople($movieApiId);


    } 
    public function deleteDatabaseData(){

        
        $this->movieService->deleteMovies();
        
        $this->peopleService->deletePeople();


        // $allMovies = Movie::all();

        // foreach($allMovies as $movie){
        //     $this->peopleService->insertPeople($movie, $movie['api_id']);
        // }

    }
 
    



    // public function getGenres(){
    //     $client = new Client();
    //     $apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; // Replace with your TMDb API key
    //     $allGenres = [];

    //     try {
        
    //             // Fetch the popular genres
    //             $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list', [
    //                 'query' => [
    //                     'api_key' => $apiKey,
    //                 ],
    //             ]);

    //             if ($response->getStatusCode() === 200) {
    //                 $data = json_decode($response->getBody(), true);
    //                 $allGenres = array_merge($allGenres, $data); // Combine results from all pages
    //             } else {
    //                 return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
    //             }
            

    //         // return response()->json($allMovies);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    //     foreach ( $allGenres['genres'] as $genre ){
    //         $genreExists = Genre::where('id',$genre['id'])->first();
    //         if ( !$genreExists){
    //             $dbGenre = new Genre;
    //             $dbGenre->id= $genre['id'];
    //             $dbGenre->name= $genre['name'];
    //             $dbGenre->save();
    //         }
            
                

    //         }
    //         $allMovies = Movie::all();
    //         foreach($allMovies as $movie){
    //             try {
        
    //                 // Fetch the popular genres
    //                 $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movie['api_id'], [
    //                     'query' => [
    //                         'api_key' => $apiKey,
    //                     ],
    //                 ]);
        
    //                 if ($response->getStatusCode() === 200) {
    //                     $data = json_decode($response->getBody(), true);
    //                 } else {
    //                     return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
    //                 }
    //                 $genresIds = [];
    //                 foreach($data['genres'] as $g ){
    //                     $genresIds[]= $g['id'];
    //                 }
    //                 $movie->genres()->attach($genresIds);
                    
        
    //             // return response();
    //         } catch (\Exception $e) {
    //             return response()->json(['error' => $e->getMessage()], 500);
    //             }
    //         }
    // }


    // public function getPeople(){
    //     $client = new Client();
    //     $apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; 

    //     $allMovies = Movie::all();
    //     foreach ($allMovies as $movie){
    //         try {
       
    //             // Fetch the popular genres
    //             $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movie['api_id'].'/credits', [
    //                 'query' => [
    //                     'api_key' => $apiKey,
    //                 ],
    //             ]);
    
    //             if ($response->getStatusCode() === 200) {
    //                 $credits = json_decode($response->getBody(), true);
    //             } else {
    //                 return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
    //             }
                
    //             foreach($credits['cast']as $cast){
    //                 print_r($cast);
    //                 $castExists = People::find($cast['id']);
    //                 if ( !$castExists){
    //                     $person = new Person;
    //                     $person->
    //                 }
    //             }
    //             dd($credits);
    //         // return response()->json($allMovies);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    //     }
        

    // }

}
