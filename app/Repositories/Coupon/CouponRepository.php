<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use App\Repositories\BaseRepository;

class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{

    public function getModel()
    {
        return Coupon::class;
    }
    public function getCouponsOnIndex($request){
        $search = $request->search ?? '';
        $coupons = $this->model->where('code','like','%' . $search . '%')->orderby('id','desc');
        $coupons =$this->searchAndPagination($coupons);
        $coupons->appends(['search' => $search]);
        return $coupons;
    }
    private function searchAndPagination($coupons)
    {
        $perPage =  5;
        $coupons = $coupons->paginate($perPage);
        return $coupons;
    }
}
