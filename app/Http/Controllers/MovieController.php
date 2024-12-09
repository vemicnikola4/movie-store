<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Services\MovieService;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



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
    public function show(Request $request)
    {

        $movie = $this->movieService->showMovie($request['id']);
        $reviews = $this->movieService->getAllReviews($request['id']);
        if ( Auth::check() ){
            return inertia("User/Movies/Movie",[
                'movie'=>$movie,
                'reviewPostedMessage'=>session('reviewPostedMessage'),
                'reviews'=>$reviews
                
            ]);

        }else{
            return inertia("Movie",[
                'movie'=>$movie,
                
            ]);
        }
       
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

    public function postReview(Request $request){
        
        
        $validated = $request->validate([
            'comment' => 'required|string|min:5',
            'rating' => 'required|integer|min:1|max:10',
            'user_id' => 'required|integer|exists:users,id',
            'movie_id' => 'required|integer|exists:movies,id',
         ]);

        $reviewPostedMessage = $this->movieService->postReview($request);
        // $movie = $this->movieService->showMovie($request['movie_id']);

        return Redirect::route('user.movie.show',$request['movie_id'])
        ->with('reviewPostedMessage', $reviewPostedMessage );
        

       
    }
}
