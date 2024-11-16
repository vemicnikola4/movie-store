<?php
namespace App\Repositories;
use App\Models\User;


class UserRepository
{
    public function __construct(
        protected User $model
    ){}

    public function userQuery( $query )
    {
        try{
            return $users = $query->paginate(10);
        }catch(\Exception $e){
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        }
    }
}