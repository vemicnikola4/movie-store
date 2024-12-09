<?php
namespace App\Repositories;
use App\Models\Genre;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\GenreRepositoryInterface;



class GenreRepository implements GenreRepositoryInterface
{

    public function __construct(
        protected Genre $model
    ){}


    public function create( array $data) : Genre
    {
        try {
            return Genre::create([
                'id'=>$data['id'],
                'name'=>$data['name']
            ]);
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getOne( $id) : ?Genre
    {
        try {
            return Genre::find($id);
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getOneByName( string $name) : ?Genre
    {
        try {
            return Genre::where('name',$name)->first();
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function genreExists($id) : ?Genre
    {
        try {
            return Genre::find($id);
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function movies(object $genre) : ?Collection
    { 
        try {
            return $genre->movies;
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function update(int $id, array $data) : void
    { 
        try{
            $cart = Cart::find($id);
            $cart->update([
                //end this
                
            ]);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function getAll(): Collection 
    {
        
    }
}