<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Services\CartService ;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function __construct(MovieService $movieService,CartService $cartService  )
    {
        $this->movieService = $movieService;
        $this->cartService = $cartService;
       
    }
    public function movies(Request $request){
        $movies = $this->movieService->userGetMovies($request);
        return inertia('User/Movies/Index', [
       'queryParams'=>request()->query() ?: null,
        'paginator' => $movies
   
    ]);
    }
    public function cart (Request $request)
    {
        return inertia('User/Movies/Cart');
    }
    public function dashboard (Request $request)
    {   
        $lastPurchasse = $this->cartService->lastCartForUser(Auth::user()->id);
        $bestSelingMovies = $this->cartService->bestSelingMovies();
        $userReviews = $this->movieService->userReviews(Auth::user()->id);
        return inertia('User/Dashboard',[
            'lastPurchasse'=> $lastPurchasse,
            'bestSelingMovies'=>$bestSelingMovies,
            'userReviews'=>$userReviews,
        ]);
    }
    public function carts (Request $request)
    {
        $carts = $this->cartService->getUserCarts($request['id']);
        return inertia('User/Carts/Index',[
            'carts'=>$carts,
        ]);
    }
}
