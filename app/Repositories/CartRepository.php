<?php
namespace App\Repositories;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;



class CartRepository{

    public function __construct(
        protected Cart $model
    ){}

    public function create( array $data) 
    {
        try {
             $cart = Cart::create([
                'user_id'=> Auth::user()->id,
                'ordered_items'=>json_encode($data['jsonCart']),
                'created_at'=>now(),
                'cart_total'=>$data['total']

            ]);
            foreach($data['cart'] as $item ){
                $cart->movies()->attach($item['id']);

            }
            return "Your order placed successfully" ;
            
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getCartsForUser( int $id ) : ?Collection
    { 
        try {
             return Cart::where('user_id',$id)->get();
            
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getLastCartForUser( int $userId ) : ?Cart 
    { 
        try {
            return Cart::where('user_id', $userId)->orderBy('created_at','desc')->first();
            
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function moviesSold() 
    { 
        try {
            return DB::select('select DISTINCT movie_id from ordered_items ');

            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function soldMoviesCount($id) 
    { 
        try {
           return DB::table('ordered_items')->where('movie_id',$id)->count();

            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }

}