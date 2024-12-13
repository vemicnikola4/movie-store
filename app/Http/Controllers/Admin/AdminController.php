<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use GuzzleHttp\Client;
use App\Services\MovieService;
use App\Services\UserService;
use App\Services\CartService;
use App\Models\Cart;


class AdminController extends Controller
{
    public function __construct(MovieService $movieService, UserService $userService,CartService $cartService)
    {
        $this->movieService = $movieService;
        $this->userService = $userService;
        $this->cartService = $cartService;
       
    }
    public function index(){
        $bestSelingMovies = $this->cartService->bestSelingMovies();
        $bestRatedMovies = $this->cartService->bestRatedMovies();
        $bestBuyer = $this->cartService->bestBuyer();

        return inertia("Admin/Dashboard",[
            'bestSelingMovies'=>  $bestSelingMovies,
            'bestRatedMovies'=>  $bestRatedMovies,
            'bestBuyer'=>  $bestBuyer,
            
        ]);
    }

    public function movies(Request $request){
         
        $movies = $this->movieService->adminGetMovies($request);
        return inertia("Admin/Movies/Index",[
            'paginator'=>$movies,
            'queryParams'=>request()->query() ?: null,

            
            
        ]);

    }
    public function movieShow( $id  ){
        $movie = $this->movieService->showMovie($id);
        $reviews = $this->movieService->getAllReviews( $id );

        return inertia("Admin/Movies/Movie",[
            'movie'=>$movie,
            'reviews'=>$reviews,
            
        ]);
    }
    public function movieUpdate( Request $data ){
        $this->movieService->adminUpdateMovie($data);
    }

    public function users(Request $request){
         
        $users = $this->userService->adminGetUsers($request);
        
        return inertia("Admin/Users/Index",[
            'paginator'=>$users,
            'queryParams'=>request()->query() ?: null,

            
            
        ]);
    }
    public function userCarts(Request $request){
         
        $carts = $this->cartService->getUserCarts($request['id']);
        return inertia('Admin/Users/Carts',[
            'carts'=>$carts,
        ]);
    }
    public function userCartShow(Request $cart)
    {

            $cart = Cart::find($cart['id']);
                 return inertia('Admin/Users/Cart',[
                'cart'=>$cart,
            ]);
       
        
    }
    public function userDashboard (Request $request)
    {   
        $user = $this->userService->getOne($request['id']);
        $lastPurchasse = $this->cartService->lastCartForUser($request['id']);
        $userCarts = $this->cartService->getAdminUserCarts($request['id']);
        $userReviews = $this->movieService->userReviews($request['id']);
        return inertia('Admin/Users/Dashboard',[
            'user'=>$user,
            'lastPurchasse'=> $lastPurchasse,
            'userCarts'=>$userCarts,
            'userReviews'=>$userReviews,
        ]);
    }

 

    

   
}
