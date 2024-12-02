<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CartService;
use App\Http\Requests\CartStoreRequest;



class CartController extends Controller
{
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
       
    }
    public function store(CartStoreRequest $request)
    {
            $data =  $request->validated();
            $mesagge = $this->cartService->store($data);
            
            return inertia('User/Movies/Cart',[
                'message'=>$mesagge,
            ]);
       
        
    }
}
