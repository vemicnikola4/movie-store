<?php
namespace App\Services;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;



    class CartService
    {
        public function __construct(CartRepository $cartRepository)
        {
            $this->cartRepository = $cartRepository;
        }

        public function store(array $data)
        {
            return $this->cartRepository->create($data);
           
        }
        public function getCarts(Request $request)
        {
            return $this->cartRepository->getCartsForUser($request['id']);
           
        }

    }