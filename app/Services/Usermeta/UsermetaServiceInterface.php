<?php

namespace App\Services\Usermeta;

use App\Services\ServiceInterface;

interface UsermetaServiceInterface extends ServiceInterface
{
    public function getUsermetaById($userId);
    public function getOrdersByUsermeta($request);
    public function getUsermetaByIdAndTime($userId,$time);
}
