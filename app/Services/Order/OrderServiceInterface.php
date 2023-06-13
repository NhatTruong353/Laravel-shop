<?php

namespace App\Services\Order;

use App\Services\ServiceInterface;

interface OrderServiceInterface extends ServiceInterface
{
    public function getOrderByUserId($userId);
    public function getOrdersOnInDex($request);
    public function getTopProduct($request);
}
