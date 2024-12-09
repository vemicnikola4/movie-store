<?php
// app/Services/MovieService.php

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Movie;
use App\Models\Media;
use App\Models\User;

use App\Interfaces\MovieRepositoryInterface;
use App\Repositories\MovieRepository;

use App\Services\ApiService;
use App\Services\GenreService;
use App\Services\MediaService;
use App\Services\PeopleService;
use App\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;



class MovieService
{
    
    protected $peopleService;

    public function __construct(ApiService $apiService,MediaService $mediaService,MovieRepository  $movieRepository,GenreService $genreService)
    {
        $this->apiService = $apiService;
        $this->mediaService = $mediaService;
        $this->genreService = $genreService;
        $this->movieRepository = $movieRepository;
    }
    public function getPeopleService(){
        if (!$this->peopleService) {
            $this->peopleService = app(PeopleService::class);
        }
        return $this->peopleService;
    }


    public function insertMovies()
    {
        $fetchedMovies = $this->apiService->fetchMovies(); // Call the apiService method

        foreach ( $fetchedMovies as $movie ){

            $fetchedMovie = $this->apiService->fetchMovie($movie['id']);

            $movieExists = $this->movieRepository->movieExists(['api_id'=>$fetchedMovie['id']]);
            if ( !$movieExists ){
                
                $createdMovie = $this->insertOneMovie($fetchedMovie);


                foreach($fetchedMovie['genres'] as $genre ){
                    if ( $this->genreService->genreExists($genre['id']) ){
                        $this->movieRepository->addGenre($createdMovie,$genre);
                    }else{
                        $this->genreService->insertOne($genre);
                        $this->movieRepository->addGenre($createdMovie,$genre);

                    }
                    
                }


            }else{
                
                foreach($fetchedMovie['genres'] as $genre ){
                    if ( $this->genreService->genreExists($genre['id']) ){
                        if ( !$this->movieRepository->movieGenreExists($movieExists, $genre)){
                            $this->movieRepository->addGenre($movieExists,$genre);
                        }
                    }else{
                        $this->genreService->insertOne($genre);
                        if ( !$this->movieRepository->movieGenreExists($movieExists, $genre)){
                            $this->movieRepository->addGenre($movieExists,$genre);
                        }

                    }
                    
                }
            }
            
        }
    }
        
    public function insertOneMovie(array $movie){
        
        $media = $this->mediaService->downloadImage($movie['poster_path']);
        $movie['media_id'] = $media->id;
        
        return $this->movieRepository->create($movie);
    }

    public function deleteMovies() : void
    {
        $this->movieRepository->deleteAll();

    }
    public function getOne($id) : Movie 
    {
        $movie = $this->movieRepository->getOne($id);
        $media = $this->mediaService->getOne($movie->media_id);

        // $movie['people']=$movie->people;
        $movie['genres']=$movie->genres;
        $movie['image_path'] = asset('storage/'.$media->path);

        // foreach( $movie['people'] as $person ){
        //     $media = $this->mediaService->getOne($person->media_id);

        //     $person['image_path'] = asset('storage/'.$media->path);
        // }

        return $movie;
    }

    public function insertMovieGenres(){

        $allMovies = $this->allMovies();

        foreach ( $allMovies as $dbMovie ){
            if(!$this->movieRepository->movieGenreExists($dbMovie->id)){
                $apiMovie = $this->apiService->fetchOneMovie($dbMovie->api_id);

                foreach($apiMovie['genres'] as $genre ){
                    $this->movieRepository->addGenre($dbMovie,$genre);
                }
            }
            
            
        }

    }
    public function getAll(){

        $movies =  $this->movieRepository->getAll();
        foreach($movies as $movie){

            $media = $this->mediaService->getOne($movie->media_id);
            $genres = $movie->genres;
            $movie['genres'] = $genres;
            $movie['image_path']= asset('storage/'.$media->path);
           
        }
        return $movies;
    }

    public function adminGetMovies(Request $request)
    { 
        return $this->movieQuery($request);
        
        

    }
    public function userGetMovies(Request $request){
        $data = $request->all();
        if (count($data) > 0 ){
            return $this->movieQuery($request);

        }else{
            return $this->getAll();
        }
    }
    public function guestGetMovies(Request $request)
    { 
        $data = $request->all();
        if (count($data) > 0 ){
            return $this->movieQuery($request);

        }else{
            return $this->getAll();
        }
        

    }

    public function movieQuery(Request $request) : ?LengthAwarePaginator
    {
        $query = Movie::query();
        
        if ( $request['sort_by_release_date'] ){
            $query->orderBy('release_date',$request['sort_by_release_date']);
        }
        if ( $request['sort_by_title'] ){
            $query->orderBy('title',$request['sort_by_title']);
        }
        if ( $request['sort_by_price'] ){
            $query->orderBy('price',$request['sort_by_price']);
        }

        if ( $request['title']){
            $query->where( "title",'like',"%".$request['title']."%");
        }
        if($request['price'] )
        {
            $query->where('price', '=', $request['price']);
        }
        if($request['discounted'] )
        {
            if ( $request['discounted'] == 'only_discounted' ){
                $query->where('discount', '!=', null );

            }
        }
        if($request['release_date'] )
        {
            $dateStringStart = $request['release_date']."-1-1";
            $dateStringEnd = $request['release_date']."-12-31";
            $startDate= \DateTime::createFromFormat('Y-m-d', $dateStringStart);
            $endDate = \DateTime::createFromFormat('Y-m-d', $dateStringEnd);
            $query->whereBetween('release_date', [$startDate, $endDate]);
        }


        if ( $request['genre'])
        {
            $genre = $this->genreService->getOneByName($request['genre']);
            
            if ( $genre ){
                $ids = [];
                $movies = $this->genreService->genreMovies($genre);
                foreach ($movies as $movie)
                {
                    $ids[]= $movie->id;
                    
                }
                $query->whereIn('id',$ids);
            }else{
                
                $request['genre'] = 'Error genre misspeled!';
            }
           

        }

        $movies = $this->movieRepository->movieQuery($query);


        // $movies = $query->get();
        

        
        
        foreach($movies as $movie){

            $movie['credits'] = $this->movieRepository->credits($movie->id);
            $media = $this->mediaService->getOne($movie->media_id);
            $movie['genres']=$movie->genres;
           

            $movie['image_path']= asset('storage/'.$media->path);
           
        }
        return $movies;

    }
    public function adminUpdateMovie(Request $data) : void 
    {
        if ( is_array($data['movie_id'])){
            $this->movieRepository->massUpdateDiscount($data);

        }else{
            $this->movieRepository->update($data['id'],$data);

        }

       

    }
   
    public function movieExists( array $data ) : ?Movie
    {
       
        return $this->movieRepository->movieExists( $data );
    }

    public function showMovie($id) : Movie 
    {
        $peopleService = app(PeopleService::class);

        $movie = $this->movieRepository->getOne($id);
        $media = $this->mediaService->getOne($movie->media_id);
        $credits =  $this->movieRepository->credits($movie->id);
        $ratingAvg =  $this->movieRepository->ratingAvg($movie->id);

        $movie['genres']=$movie->genres;
        $movie['rating']=number_format($ratingAvg, 1, ',', ' ');
        $movie['image_path'] = asset('storage/'.$media->path);

        $movieCast = json_decode($credits[0]->cast);
        $movieCrew = json_decode($credits[0]->crew);
        foreach( $movieCast as $cast ){
            $person = $peopleService->getOnePerson($cast->id);

            $media = $this->mediaService->getOne($person->media_id);

            $person['image_path'] = asset('storage/'.$media->path);
            $person['character'] =$cast->character;
            $castArr[]= $person;
        }
        foreach($movieCrew as $crew ){
            $person =  $peopleService->getOnePerson($crew->id);

            $media = $this->mediaService->getOne($person->media_id);

            $person['image_path'] = asset('storage/'.$media->path);
            $person['job'] =$crew->job;

            $crewArr[] = $person;


        }
        $movie['crew'] = $crewArr;
        $movie['cast'] = $castArr;
        return $movie;
    }
    public function movieCreditsExists(int $movieId) : array
    { 
        return $this->movieRepository->creditsExists( $movieId);
    }
    public function createMovieCredits($credits) : void
    {
        $this->movieRepository->createCredits($credits);
    }
    
    public function getCart(Request $request)
    {
        $data = request()->all();
        $movies = [];
        foreach($data['movies'] as $id){
            $movies[]=$this->movieRepository->getOne($id);
        }

        return $movies;
    }
    public function postReview(Request $request ) : ?string
    {
        if(  !$this->movieRepository->commentExists($request)  ){
            $this->movieRepository->postComment($request);

            return "Review posted successfuly!";
            
        }else{
            return "You already posted review for this movie!";

        }
        
    }
    public function getAllReviews(int $movieId) : ?LengthAwarePaginator
    {
        $userService = app(UserService::class);
        $reviews =  $this->movieRepository->getReviews($movieId);
        // dd($reviews);
        foreach($reviews as $review ){
            $review->user = $userService->getOne($review->user_id);
        }
        return $reviews;
    }
    public function userReviews($userId) :  ?LengthAwarePaginator
    {
        $reviews = $this->movieRepository->getUserReviews($userId);
        // dd($reviews);
        foreach($reviews as $review ){
            $review->movie =$this->getOne($review->movie_id);
            $date = \DateTime::createFromFormat('Y-m-d H:i:s', $review->created_at);
            $review->created_at = $date->format('d-m-Y H:i');
        }
        return $reviews;
 
    }

    
}