<?php



namespace App\Services;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Media;
use App\Models\Movie;
use App\Models\Genre;
class ApiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = '0e3cf6c006f3a9f560d6b0500dda7520'; // Store your API key in the .env file
    }

    public function fetchMovies() : array
    {
        $allMovies=[];
        $totalPages = 3;
        try {
            for ($page = 1; $page <= $totalPages; $page++) {
                // Fetch the popular movies for each page
                $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/popular', [
                    'query' => [
                        'api_key' => $this->apiKey,
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
        
            return $allMovies;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function fetchMovie($movieId):array
    {
        try {
            $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/'.$movieId, [
                'query' => [
                    'api_key' => $this->apiKey,
                ],
            ]);
    
                if ($response->getStatusCode() === 200) {
                    $data = json_decode($response->getBody(), true);

                    return $data;
                } else {

                    return response()->json(['error' => 'Image download failed'], $response->getStatusCode());
                }
                
        
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchImage(string $imagePath){
        $baseUrl = 'https://image.tmdb.org/t/p/';
        $imageSize = 'w500';  
        $fullImageUrl = $baseUrl . $imageSize . $imagePath;


        

        try {
            $response = $this->client->get($fullImageUrl);
           

            if ($response->getStatusCode() === 200) {
                return $response->getBody()->getContents();
    
                // return response()->json(['success' => true, 'path' => $filePath]);
            } else {

                return response()->json(['error' => 'Image download failed'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function fetchPeople( $apiId ){
        try {       
                // Fetch the popular genres
                $response = $this->client->request('GET', 'https://api.themoviedb.org/3/movie/'.$apiId.'/credits', [
                    'query' => [
                        'api_key' => $this-> apiKey,
                    ],
                ]);
            
                if ($response->getStatusCode() === 200) {
                    $credits = json_decode($response->getBody(), true);
                    return $credits;
                } else {
                    return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
                }
                        
                
            // return response()->json($allMovies);
        } catch (\Exception $e) {
            dd('error');

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function fetchPerson( $personId ){
        try {       
                // Fetch the popular genres
                $response = $this->client->request('GET', 'https://api.themoviedb.org/3/person/'.$personId, [
                    'query' => [
                        'api_key' => $this-> apiKey,
                    ],
                ]);
            
                if ($response->getStatusCode() === 200) {
                    $person = json_decode($response->getBody(), true);
                    return $person;
                } else {
                    return response()->json(['error' => 'Request failed on page ' . $page], $response->getStatusCode());
                }
                        
                
            // return response()->json($allMovies);
        } catch (\Exception $e) {
            dd('error');

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}