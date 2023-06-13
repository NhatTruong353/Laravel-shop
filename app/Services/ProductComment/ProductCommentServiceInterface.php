<?php

namespace App\Services\ProductComment;

use App\Services\ServiceInterface;

interface ProductCommentServiceInterface extends ServiceInterface
{
    public function getProductCommentOnIndex($request);
}
