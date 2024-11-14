<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use GuzzleHttp\Client;
use App\Services\MovieService;


class AdminController extends Controller
{
    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
       
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
 

    

   
}
