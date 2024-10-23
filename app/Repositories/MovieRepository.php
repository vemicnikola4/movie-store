<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\QueryException;
use App\Exceptions\MovieException;

class MovieRepository implements MovieRepositoryInterface{

    public function __construct(
        protected Movie $model
    ){}


    public function create(array $data) 
    {
        $prices= [700,900,950,1000,1200,1500,1700];
        $movieExists = Movie::where('api_id',$data['id'])->first();
        if ( !$movieExists ){
            try {
                Movie::create([
                    'title'=>$data['title'],
                    'overview'=>$data['overview'],
                    'original_language'=>$data['original_language'],
                    'release_date'=>$data['release_date'],
                    'api_id'=>$data['id'],
                    'media_id'=>$data['media_id'],
                    'price'=>$prices[mt_rand(0,6)],
                ]);
            } catch (QueryException $e) {
                // Handle database-related errors
                throw new QueryException('Database error while creating Movie: ' .$e->getMessage());
                // return response()->json(['error' => 'Database error: ' . $e->getMessage()], 500);
            } catch (\Exception $e) {
                // Handle other exceptions
                throw new \Exception('An unexpected error occurred' .$e->getMessage());

            }
           
        }
       

    }
    public function deleteAll():void
    {
        Movie::query()->delete();

    }
    public function getAll(): Collection
    {
        return Movie::all();
    }
    public function getOne($id) : Movie
    {
        return Movie::find($id);
    }

}
