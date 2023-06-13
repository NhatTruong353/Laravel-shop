<?php

namespace App\Repositories\ProductComment;

use App\Models\ProductComment;
use App\Repositories\BaseRepository;
use App\Services\BaseService;

class ProductCommentRepository extends BaseRepository implements ProductCommentRepositoryInterface
{
    public function getModel(){
        return ProductComment::class;
    }
    public function getProductCommentOnIndex($request){
        $search = $request->search ?? '';
        $comments = $this->model->where('name','like','%' . $search . '%')->orderby('id','desc');
        $comments =$this->searchAndPagination($comments);
        $comments->appends(['search' => $search]);
        return $comments;
    }
    private function searchAndPagination($comments)
    {
        $perPage =  5;
        $comments = $comments->paginate($perPage);
        return $comments;
    }

}
