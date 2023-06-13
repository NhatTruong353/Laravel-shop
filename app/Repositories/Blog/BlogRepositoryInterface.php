<?php

namespace App\Repositories\Blog;

interface BlogRepositoryInterface
{
    public function getLatesBlogs($limit = 3);
}
