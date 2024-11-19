<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Services\MovieService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;




class MovieController extends Controller
{
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movies = $this->movieService->guestGetMovies($request);
             return inertia('LandingPage', [
            'queryParams'=>request()->query() ?: null,
             'canLogin' => Route::has('login'),
             'canRegister' => Route::has('register'),
             'paginator' => $movies
        
         ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        $movie = $this->movieService->showMovie($movie->id);

        return inertia("Movie",[
            'movie'=>$movie,
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
