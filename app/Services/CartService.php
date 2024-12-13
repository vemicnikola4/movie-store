<?php
namespace App\Services;
use App\Repositories\CartRepository;
use App\Services\MovieService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;


use App\Models\Cart;


    class CartService
    {
        public function __construct(CartRepository $cartRepository, MovieService $movieService, UserService $userService)
        {
            $this->cartRepository = $cartRepository;
            $this->movieService = $movieService;
            $this->userService = $userService;
        }

        public function store(array $data) : object
        {
            return $this->cartRepository->create($data);
           
        }
        public function getUserCarts(int $userId): ?LengthAwarePaginator
        {
            return $this->cartRepository->getCartsForUser($userId);
           
        }
        public function getAdminUserCarts(int $userId): ?Collection
        {
            return $this->cartRepository->getAdminCartsForUser($userId);
           
        }
        public function lastCartForUser(int $userId) : ? Cart
        {
            $lastCart =  $this->cartRepository->getLastCartForUser($userId);
            if ( $lastCart ){
                $lastCart->created_at->format('d-m-Y H:i');
                return $lastCart;
            }
            return $lastCart;
        }
        public function bestSelingMovies() : ? array
        {
            $soldMovies = $this->cartRepository->moviesSold();
            

            $bestSellers = [];
            foreach($soldMovies as $soldMovie ){
                $bestSellers[$soldMovie->movie_id] = $this->cartRepository->soldMoviesCount($soldMovie->movie_id);
            }

            arsort($bestSellers);

            $topSellerMovies = [];

            foreach( $bestSellers as $key => $val ){
                $topSellerMovies[]= $this->movieService->getOne($key);
                if (count($topSellerMovies) == 5 ){
                    break;
                }
            }

            return $topSellerMovies;
        }
        public function getUserCartsCount(int $userId)
        {
            return $this->cartRepository->userCartsCount($userId);
        }
        public function getUserCartsSum(int $userId)
        {
            return $this->cartRepository->userCartsSum($userId);
            
        }
        public function bestRatedMovies() : ?array
        {
            $ratedMovies = $this->cartRepository->ratedMovies();
            $movies =[];
            if ($ratedMovies){
                foreach($ratedMovies as $movie){
                    $movies[$movie->movie_id]=$this->cartRepository->movieRatingAvg($movie->movie_id);
                }
            }
            arsort($movies);

            $bestRatedMovies = [];
            foreach( $movies as $key => $val){
                $bestRatedMovies[] = $this->movieService->getOne($key);
                $bestRatedMovies[count($bestRatedMovies)-1]['rating'] = $val;
                if ( count( $bestRatedMovies) === 5 ){
                    break;
                }
            }

            return $bestRatedMovies;
         }
        public function getBuyers(){
            return $this->cartRepository->getBuyers();
        }
        public function bestBuyer(){
            $buyers = $this->getBuyers();
            $buyersCartSums = [];
            foreach( $buyers as $buyer ){
                $buyersCartSums[$buyer->user_id] =  $this->cartRepository->userCartsSum($buyer->user_id);  
            }
            
            foreach( $buyersCartSums as $key => $val ){
                  $bestBuyer = $this->userService->getOne($key);
                  $bestBuyer['carts_total'] = $val;
                  $bestBuyer['purchasess_count'] = $this->cartRepository->countBuys($key);
                  return $bestBuyer ;
            }
            

        }

    }