<?php
namespace App\Services;
use App\Repositories\CartRepository;
use App\Services\MovieService;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Cart;


    class CartService
    {
        public function __construct(CartRepository $cartRepository, MovieService $movieService)
        {
            $this->cartRepository = $cartRepository;
            $this->movieService = $movieService;
        }

        public function store(array $data) : object
        {
            return $this->cartRepository->create($data);
           
        }
        public function getUserCarts(Request $request)
        {
            return $this->cartRepository->getCartsForUser($request['id']);
           
        }
        public function lastCartForUser(int $userId) : ? Cart
        {
            $lastCart =  $this->cartRepository->getLastCartForUser($userId);
            $lastCart->created_at->format('d-m-Y H:i');
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

    }