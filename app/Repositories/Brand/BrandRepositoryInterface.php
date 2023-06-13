<?php

namespace App\Repositories\Brand;

use App\Repositories\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{
    public function getBrandsOnIndex($request);
}
