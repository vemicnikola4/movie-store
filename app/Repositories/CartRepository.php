<?php
namespace App\Repositories;

use App\Models\Cart;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;




class CartRepository{

    public function __construct(
        protected Cart $model
    ){}

    public function create( array $data) : string
    {
        try {
             Cart::create([
                'user_id'=> Auth::user()->id,
                'ordered_items'=>json_encode($data['cart']),
                'created_at'=>now(),
                'cart_total'=>$data['total']

            ]);
            return "Your order placed successfully" ;
            
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getCartsForUser( int $id ) 
    { 
        try {
             return Cart::where('user_id',$id)->get();
            
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }

}