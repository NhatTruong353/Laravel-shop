<?php

namespace App\Repositories\Blog;

use App\Models\Blog;
use App\Repositories\BaseRepository;
use App\Services\BaseService;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function getModel()
    {
        return Blog::class;
    }
    public function getLatesBlogs($limit = 3){
        return $this->model->orderBy('id','desc')
            ->limit($limit)
            ->get();
    }
}
