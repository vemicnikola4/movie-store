<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use GuzzleHttp\Client;
use App\Services\MovieService;
use App\Services\UserService;


class AdminController extends Controller
{
    public function __construct(MovieService $movieService, UserService $userService)
    {
        $this->movieService = $movieService;
        $this->userService = $userService;
       
    }
    public function index(){
        return inertia("Admin/Dashboard",[
            'bestSellerMovie'=>'blood diamond',
            
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

        return inertia("Admin/Movies/Movie",[
            'movie'=>$movie,
            
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


 

    

   
}
