<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return User::class;
    }
    public function getUsersOnIndex($request){
        $search = $request->search ?? '';
        $users = $this->model->where('name','like','%' . $search . '%')->orderby('id','desc');
        $users =$this->searchAndPagination($users);
        $users->appends(['search' => $search]);
        return $users;
    }
    private function searchAndPagination($users)
    {
        $perPage =  5;
        $users = $users->paginate($perPage);
        return $users;
    }
}
