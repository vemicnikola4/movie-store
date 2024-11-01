<?php
namespace App\Repositories;
use App\Models\Genre;
use Illuminate\Database\QueryException;


class GenreRepository 
{

    public function __construct(
        protected Genre $model
    ){}


    public function create( array $data) : void
    {
        try {
            Genre::create([
                'id'=>$data['id'],
                'name'=>$data['name']
            ]);
      
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

    }
    public function getOne( $id) : Genre
    {
        try {
            return Genre::find($id);
      
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
}