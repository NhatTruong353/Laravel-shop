<?php

namespace App\Services\Blog;

use App\Services\ServiceInterface;

interface BlogServiceInterface extends ServiceInterface
{
    public function getLatesBlogs($limit = 3);
}
