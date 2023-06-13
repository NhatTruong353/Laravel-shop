<?php

namespace App\Repositories\ProductCategory;

use App\Models\ProductCategory;
use App\Repositories\BaseRepository;

class ProductCategoryRepository extends BaseRepository implements ProductCategoryRepositoryInterface
{
    public function getModel(){
        return ProductCategory::class;
    }
    public function getProductCategoriesOnIndex($request){
        $search = $request->search ?? '';
        $categories = $this->model->where('name','like','%' . $search . '%')->orderby('id','desc');
        $categories =$this->searchAndPagination($categories);
        $categories->appends(['search' => $search]);
        return $categories;
    }
    private function searchAndPagination($categories)
    {
        $perPage =  5;
        $categories = $categories->paginate($perPage);
        return $categories;
    }
}
