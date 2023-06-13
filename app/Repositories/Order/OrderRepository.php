<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Models\User;
use App\Models\Usermeta;
use App\Repositories\BaseRepository;
use http\Env\Request;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    public function getModel()
    {
        return Order::class;
    }

    public function getOrderByUserId($userId)
    {
        return $this->model
            ->where('user_id',$userId)
            ->orderby('id','desc')
            ->get();
    }
    public function getOrdersOnIndex($request){
        $search = $request->search ?? '';
        $orders = $this->model->where('name_title','like','%' . $search . '%')->orderby('id','desc');

        $orders =$this->searchAndPagination($orders);
        $orders->appends(['search' => $search]);
        return $orders;
    }
    private function searchAndPagination($orders)
    {
        $perPage =  5;
        $orders = $orders->paginate($perPage);
        return $orders;
    }
    public function getTopProduct($request){
        $orders = DB::table('orders')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->pluck('id');
    }
}
