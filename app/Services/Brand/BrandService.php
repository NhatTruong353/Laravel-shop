<?php

namespace App\Services\Brand;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Services\BaseService;

class BrandService extends BaseService implements BrandServiceInterface
{
    public $repository;
    public function __construct(BrandRepositoryInterface $BrandRepository){
        $this->repository = $BrandRepository;
    }
    public function getBrandsOnInDex($request){
        return $this->repository->getBrandsOnInDex($request);
    }
}
