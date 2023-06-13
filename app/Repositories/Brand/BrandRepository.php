<?php

namespace App\Repositories\Brand;

use App\Models\Brand;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{

    public function getModel()
    {
        return Brand::class;
    }
    public function getBrandsOnIndex($request){
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
