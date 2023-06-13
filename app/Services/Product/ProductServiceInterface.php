<?php

namespace App\Services\Product;

use App\Services\ServiceInterface;
use Couchbase\View;

interface ProductServiceInterface extends ServiceInterface
{
    public function getRelatedProducts($product,$limit = 4);
    public function getFeaturedProducts();
    public function getProductOnIndex($request);
    public function getProductsByCategory($categoryName,$request);
    public function getProductsOnIndexAdmin($request);

}
