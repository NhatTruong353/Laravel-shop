<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductComment;
use App\Services\Brand\BrandServiceInterface;
use App\Services\Product\ProductServiceInterface;
use App\Services\Blog\BlogServiceInterface;
use App\Services\ProductCategory\ProductCategoryService;
use App\Services\ProductCategory\ProductCategoryServiceInterface;
use App\Services\ProductComment\ProductCommentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    private $productService;
    private $productCommentService;
    private $productCategoryService;
    private $brandService;

    public function __construct(ProductServiceInterface         $productService,
                                ProductCommentServiceInterface  $productCommentService,
                                ProductCategoryServiceInterface $productCategoryService,
                                BrandServiceInterface           $brandService){
        $this->productService = $productService;
        $this->productCommentService = $productCommentService;
        $this->productCategoryService = $productCategoryService;
        $this->brandService = $brandService;
    }
    public function show($id){

        $categories =$this->productCategoryService->all();
        $brands =$this->brandService->all();
        $product = $this->productService->find($id);
        session()->push('products.recently_viewed', $product->getKey());
        $relatedProducts =$this->productService->getRelatedProducts($product);
        $userId = Auth::id();
        $productId = $product->id;

        $orderDetails = DB::table('orders_details')
            ->join('orders', 'orders_details.order_id', '=', 'orders.id')
            ->where('orders.user_id', $userId)
            ->where('orders.status', 7) // Đơn hàng đã được hoàn thành
            ->where('orders_details.product_id', $productId)
            ->get();
        $review = ProductComment::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        return view('front.shop.show',compact('product','relatedProducts','categories','brands','orderDetails','review'));
    }
    public function postComment(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'rating' => 'required'
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'rating.required' => 'Rating is required',
        ]);

        if (Auth::check()) {
            $data = $request->all();
            $data['comment_status'] = 0;
            $this->productCommentService->create($data);
            return redirect()->back()->with('notification','Comment and rate success.Please wait for acceptance!');
        }else{
            return back()->with('notification','ERROR: Please login to comment');
        }
    }
    public function index(Request $request){
        $categories =$this->productCategoryService->all();
        $brands =$this->brandService->all();
        $products = $this->productService->getProductOnIndex($request);
        $proRe = session()->get('products.recently_viewed');
        $showProducts = Product::find($proRe);
        return view('front.shop.index',compact('products','categories','brands','showProducts'));
    }
    public function category($categoryName,Request $request){
        $categories = $this->productCategoryService->all();
        $brands =$this->brandService->all();
        $products = $this->productService->getProductsByCategory($categoryName,$request);
        $proRe = session()->get('products.recently_viewed');
        $showProducts = Product::find($proRe);

        return view('front.shop.index',compact('products','categories','brands','showProducts'));
    }
}
