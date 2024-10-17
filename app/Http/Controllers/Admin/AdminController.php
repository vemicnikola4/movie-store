<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function index(){
        return inertia("Admin/Dashboard",[
            'bestSellerMovie'=>'blood diamond',
            
        ]);
    }

    public function getData(Request $request)
    {
        // Create a Guzzle client instance
        $client = new Client();

        try {
            // Send a GET request to the API
            $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated?api_key=0e3cf6c006f3a9f560d6b0500dda7520');

            // Check if the response was successful
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
            } else {
                return response()->json(['error' => 'Request failed'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }

        foreach($data['results'] as $result){
            print_r($result['original_title']);
        }

    }
}
