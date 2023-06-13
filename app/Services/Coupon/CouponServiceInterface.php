<?php

namespace App\Services\Coupon;

use App\Services\ServiceInterface;

interface CouponServiceInterface extends ServiceInterface
{
    public function getCouponsOnIndex($request);
}
