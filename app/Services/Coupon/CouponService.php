<?php

namespace App\Services\Coupon;

use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Services\BaseService;

class CouponService extends BaseService implements CouponServiceInterface
{
    public $repository;
    public function __construct(CouponRepositoryInterface $CouponRepository){
        $this->repository = $CouponRepository;
    }
    public function getCouponsOnIndex($request){
        return $this->repository->getCouponsOnIndex($request);
    }
}
