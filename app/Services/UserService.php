<?php
namespace App\Services;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{
    public function __construct( UserRepository $userRepository )
    {
        $this->userRepository = $userRepository;
    }

    public function adminGetUsers( Request $request ) : LengthAwarePaginator
    {
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
    public function getOne(int $movieId) : ?User
    {
        return $this->userRepository->getOne($movieId);
    }

}