<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MovieService;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Media;
use App\Models\Movie;




use GuzzleHttp\Client;

class AdminController extends Controller
{
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
       
    }
    public function index() :  Response
    {
        return inertia("Admin/Dashboard");
    }

    public function movies(Request $request):  Response
    {
        $movies = $this->movieService->adminGetMovies($request);
       
        return Inertia::render('Admin/Movies/Index', [
            'movies' => $movies,
            'queryParams'=>request()->query() ?: null,
        ]);
    }
    public function movieUpdate(Request $request) 
    {
        
        $movies = $this->movieService->adminUpdateMovie($request);
        
        return redirect()->route('admin.movie');    
    }
    public function movieShow($id)
    {
        // $this->movieService->deleteMovie($id);
        $movie = $this->movieService->getOne($id);
    dd($movie);

        // return Inertia::render('Admin/Movies/Index', [
        //     'movie' => $movie,
        //     'successMessage'=>'Movie Deleted Successfuly',
        // ]);
    }



   
}
