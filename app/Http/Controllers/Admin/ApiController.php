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

class ApiController extends Controller
{

    
    public function getMovies()
    {
    $client = new Client();
    $apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; // Replace with your TMDb API key
    $totalPages = 2; // Set the number of pages you want to fetch
    $allMovies = [];

    try {
        for ($page = 1; $page <= $totalPages; $page++) {
            // Fetch the popular movies for each page
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular', [
                'query' => [
                    'api_key' => $apiKey,
                    'language' => 'en-US',
                    'page' => $page,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                $allMovies = array_merge($allMovies, $data['results']); // Combine results from all pages
            } else {
                return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
            }
        }

        // return response()->json($allMovies);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }

    foreach ( $allMovies as $movie ){
        $this->downloadImage($movie['poster_path']);
        var_dump($movie);
        $image_path = 'images/'.basename($movie['poster_path']);
        $media = Media::where('path',$image_path)->first();;
        $media_id = $media->id;

        $prices= [700,900,950,1000,1200,1500,1700];
        $movieExists = Movie::where('api_id',$movie['id'])->first();
        if ( !$movieExists ){
            $dbMovie = new Movie;
            $dbMovie->title = $movie['title'];
            $dbMovie->overview = $movie['overview'];
            $dbMovie->original_language = $movie['original_language'];
            $dbMovie->release_date = $movie['release_date'];
            $dbMovie->api_id = $movie['id'];
            $dbMovie->media_id = $media_id;
            $dbMovie->price = $prices[mt_rand(0,6)];
            $dbMovie->save();
        }
            

    }
    }

    public function downloadImage($imagePath)
    {
    $client = new Client();
    $baseUrl = 'https://image.tmdb.org/t/p/';
    $imageSize = 'w500'; // Change to your desired image size (e.g., w500, original)
    $fullImageUrl = $baseUrl . $imageSize . $imagePath;

    $extention = substr($imagePath,strpos($imagePath,'.')+1 );

    try {
        // Make a GET request to download the image
        $response = $client->get($fullImageUrl);

        if ($response->getStatusCode() === 200) {
            $imageContent = $response->getBody()->getContents();
                
            // Define a storage path (you can change this as needed)
            $filePath = 'images/' . basename($imagePath);


            // Save the image to storage
            $imageExists = Media::where('path',$filePath)->first();

            if ( !$imageExists){
                Storage::disk('public')->put($filePath, $imageContent);

                $media = new Media;
                $media->path = $filePath;
                $media->extention = $extention;
                $media->alt = 'image';
                $media->save();
            }
                

                

                


            return response()->json(['success' => true, 'path' => $filePath]);
        } else {
            return response()->json(['error' => 'Image download failed'], $response->getStatusCode());
        }
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }



    public function getGenres(){
    $client = new Client();
    $apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; // Replace with your TMDb API key
    $allGenres = [];

    try {
       
            // Fetch the popular genres
            $response = $client->request('GET', 'https://api.themoviedb.org/3/genre/movie/list', [
                'query' => [
                    'api_key' => $apiKey,
                ],
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                $allGenres = array_merge($allGenres, $data); // Combine results from all pages
            } else {
                return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
            }
        

        // return response()->json($allMovies);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
    foreach ( $allGenres['genres'] as $genre ){
        $genreExists = Genre::where('id',$genre['id'])->first();
        if ( !$genreExists){
            $dbGenre = new Genre;
            $dbGenre->id= $genre['id'];
            $dbGenre->name= $genre['name'];
            $dbGenre->save();
        }
        
            

        }
        $allMovies = Movie::all();
        foreach($allMovies as $movie){
            try {
       
                // Fetch the popular genres
                $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movie['api_id'], [
                    'query' => [
                        'api_key' => $apiKey,
                    ],
                ]);
    
                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody(), true);
                } else {
                    return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
                }
                $genresIds = [];
                foreach($data['genres'] as $g ){
                    $genresIds[]= $g['id'];
                }
                $movie->genres()->attach($genresIds);
                
    
            // return response();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        }
    }

    public function getPeople(){
        $client = new Client();
        $apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; 

        $allMovies = Movie::all();
        foreach ($allMovies as $movie){
            try {
       
                // Fetch the popular genres
                $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movie['api_id'].'/credits', [
                    'query' => [
                        'api_key' => $apiKey,
                    ],
                ]);
    
                if ($response->getStatusCode() === 200) {
                    $credits = json_decode($response->getBody(), true);
                } else {
                    return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
                }
                
                foreach($credits['cast']as $cast){
                    print_r($cast);
                    $castExists = People::find($cast['id']);
                    if ( !$castExists){
                        $person = new Person;
                    }
                }
                dd($credits);
            // return response()->json($allMovies);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        }
        

    }

}
