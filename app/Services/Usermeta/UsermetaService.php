<?php

namespace App\Services\Usermeta;

use App\Repositories\Usermeta\UsermetaRepositoryInterface;
use App\Services\BaseService;

class UsermetaService extends BaseService implements UsermetaServiceInterface
{
    public $repository;
    public function __construct(UsermetaRepositoryInterface $UsermetaRepository){
        $this->repository = $UsermetaRepository;
    }
    public function getUsermetaById($userId)
    {
        return $this->repository->getUsermetaById($userId);
    }
    public function getOrdersByUsermeta($request){
        return $this->repository->getOrdersByUsermeta($request);
    }
    public function getUsermetaByIdAndTime($userId,$time)
    {
        return $this->repository->getUsermetaByIdAndTime($userId,$time);
    }
}
