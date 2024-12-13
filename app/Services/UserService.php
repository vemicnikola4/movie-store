<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\CartService;


class UserService
{
    public function __construct( UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function adminGetUsers( Request $request ) : LengthAwarePaginator
    {
        $cartService = app(CartService::class);

        $query = User::query();
        // $query->get();
        if ( $request['name']){
            $query->where( "name",'like',"%".$request['name']."%");

        }
        if ( $request['email']){
            $query->where( "email",'like',"%".$request['email']."%");

        }
        $query->where('is_admin',0);

        $users =  $this->userRepository->userQuery($query);
        foreach( $users as $user ){
            $user['carts_count'] = $cartService->getUserCartsCount($user->id);
            $user['carts_total'] = $cartService->getUserCartsSum($user->id);
        }
        return $users;
    } 
    public function getCarts(Request $request)
    {
        if ( $request['id']){
            return $this->cartRepository->carts( $request['id'] );

        }else{
            abort(403);
        }
    }
    public function getOne(int $userId) : ?User
    {
        return $this->userRepository->getOne($userId);
    }
    public function bestBuyer() : ?User 
    {
         return $this->userRepository->bestBuyer();   
    }

}