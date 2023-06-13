<?php

namespace App\Repositories\Usermeta;

use App\Models\Usermeta;
use App\Repositories\BaseRepository;

class UsermetaRepository  extends BaseRepository implements UsermetaRepositoryInterface
{

    public function getModel()
    {
        return Usermeta::class;
    }
    public function getUsermetaByIdAndTime($userId,$time)
    {
        return $this->model
            ->where('user_id',$userId)
            ->where('created_at',$time)
            ->get()
            ->first();
    }
    public function getUsermetaById($userId)
    {
        return $this->model
            ->where('user_id',$userId)
            ->get()
            ->first();
    }
    public function getOrdersByUsermeta($request){
        $search = $request->search ?? '';
        $usermetas = $this->model->where(Usermeta::where('first_name','like','%' . $search . '%')->orwhere('last_name','like','%' . $search . '%'))->orderby('id','desc');
        $usermetas =$this->searchAndPagination($usermetas);
        $usermetas->appends(['search' => $search]);
        return $usermetas;
    }
    private function searchAndPagination($usermetas)
    {
        $perPage =  5;
        $usermetas = $usermetas->paginate($perPage);
        return $usermetas;
    }
}
