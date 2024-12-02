<?php

namespace App\Http\Controllers;

use App\Services\MovieService;
use App\Services\CartService ;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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
        return inertia('User/Dashboard');
    }
    public function carts (Request $request)
    {
        $carts = $this->cartService->getCarts($request);
        return inertia('User/Carts/Index',[
            'carts'=>$carts,
        ]);
    }
}
