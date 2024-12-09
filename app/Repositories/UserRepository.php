<?php
namespace App\Repositories;
use App\Models\User;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;


class UserRepository implements UserRepositoryInterface
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
    public function create( array $data) : User
    {
      
    }

    public function getOne(int $id) : ?User 
    {
        
        try {
            return User::find($id);
            
        } catch (\Exception $e) {
            // Handle any other exceptions
            throw new \Exception('An unexpected error occurred: ' . $e->getMessage());
        } 
    }
    public function getAll(): Collection 
    {

    }
    public function update(int $id, array $data ) : void{
        
    }
}