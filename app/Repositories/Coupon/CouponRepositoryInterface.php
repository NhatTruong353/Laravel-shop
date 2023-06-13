<?php

namespace App\Repositories\Coupon;

use App\Repositories\RepositoryInterface;

interface CouponRepositoryInterface extends RepositoryInterface
{
    public function getCouponsOnIndex($request);
}
