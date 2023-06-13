<?php

namespace App\Repositories\Usermeta;

use App\Repositories\RepositoryInterface;

interface UsermetaRepositoryInterface extends RepositoryInterface
{
    public function getUsermetaById($userId);
    public function getOrdersByUsermeta($request);
    public function getUsermetaByIdAndTime($userId,$time);
}
