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

   
}
