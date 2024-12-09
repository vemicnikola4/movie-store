<?php
namespace App\Repositories;
use Illuminate\Database\Eloquent\Collection;
use App\Interfaces\MovieRepositoryInterface;
use App\Models\Movie;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;



class MovieRepository implements MovieRepositoryInterface{

    public function __construct(
        protected Movie $model
    ){}

    public function create(array $data) : Movie
    {
        $prices= [700,900,950,1000,1200,1500,1700];
        try {
            return $movie = Movie::create([
                'title'=>$data['title'],
                'overview'=>$data['overview'],
                'original_language'=>$data['original_language'],
                'release_date'=>$data['release_date'],
                'api_id'=>$data['id'],
                'media_id'=>$data['media_id'],
                'price'=>$prices[mt_rand(0,6)],
            ]);
        }catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 

       

    }
   
    public function update( int $id, array $data ) :void
    {
        try{
            Movie::where($id, $data['user_id'])->update([
                'price' => $data['price'],
                'discount' => $data['discount'],
            ]);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function massUpdateDiscount( $data ) :void
    {
        try{
            Movie::whereIn('id', $data['movie_id'])->update([
                'discount' => $data['discount']
            ]);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
   
    public function deleteAll():void
    {
        try {
            Movie::query()->delete();

        
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new MovieException('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }
    public function getAll(): Collection
    {
        try{

            return Movie::all();
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }


    public function getOne(int $id) : ? Movie
    {
        try{

            return Movie::find($id);

        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
        
    
 

    public function movieExists(array $data) : ?Movie
    {
        $keys = array_keys($data);
        $column =  $keys[0];
        try {
            return Movie::where($column,$data[$column])->first();
        
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new MovieException('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function addGenre(object $movie,array $genre):void
    {
        try{
            $movie->genres()->attach($genre['id']);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
        
    }

    public function movieGenreExists(object $movie, array $genre) : ?array
    {
        $movieId =$movie->id;
        $genreId = $genre['id'];
        try{
            return DB::select('select * from movie_genres where movie_id = '.$movieId.' AND genre_id = '.$genreId);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function movieQuery($query) 
 
    {
        try{
            return $movie = $query->paginate(15);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

   public function moviePerson(int $perosnId) : ? array
   {
       try{
           return DB::select('select * from people where id = '.$perosnId.'  LIMIT 1');
       }catch(\Exception $e){
           throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
       }
   }

    public function creditsExists(int $movieId) : ? array
    {
        try{
            return DB::select('select * from credits where movie_id = '.$movieId.'');
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function createCredits(array $credits) : void
    {
        try {
            DB::table('credits')->insert([
                'movie_id' => $credits['movie_id'],
                'cast' => json_encode($credits['cast']),
                'crew' => json_encode($credits['crew'])
            ]);
        }catch (\Exception $e) {
           //Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
    }
    
    public function credits(int $movieId) : ? array
    {
        try{
            return DB::select('select * from credits where movie_id = '.$movieId.' LIMIT 1');
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }


    public function postComment($request) : void
    {
        try{
            DB::table('comments')->insert([
                'movie_id' => $request['movie_id'],
                'user_id' => $request['user_id'],
                'comment' => $request['comment'],
                'rating'=>$request['rating'],
                'created_at' => Carbon::now()

            ]);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    
    public function commentExists($request) : ?array
    {
        try{
            return DB::select('select * from comments where movie_id = '.$request['movie_id'].' AND user_id = '.$request['user_id'].' LIMIT 1');
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function getReviews(int $movieId) : ?LengthAwarePaginator
    {
        try{
            return DB::table('comments')->where('movie_id',$movieId)->orderBy('created_at','desc')->paginate(3);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    public function ratingAvg(int $movieId) 
    {
        try{
            return  DB::table('comments')->avg('rating');;
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }

    public function getUserReviews(int $userId) : ?LengthAwarePaginator
    {
       
        try{
            return DB::table('comments')->where('user_id',$userId)->orderBy('created_at','desc')->paginate(3);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
    
   
}


