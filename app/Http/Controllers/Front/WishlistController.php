<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductServiceInterface;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface  $productService){
        $this->productService = $productService;
    }
    public function index()
    {
        $wishlist= Cart::instance('wishlist')->content();
//        $total= Cart::total();
//        $subtotal = Cart::subtotal();


        return view('front.shop.wishlist',compact('wishlist'));
    }
    public function add(Request $request)
    {
        $wishitems = Cart::instance('wishlist')->content()->pluck('id');
        if($request->ajax()){

            $product = $this->productService->find($request->productId);
            if ($wishitems->contains($product->id)){
                ;
            }else{
                $response['wishlist'] = Cart::instance('wishlist')->add([
                    'id' => $product->id,
                    'name' => $product->name,
                    'qty' => 1 ,
                    'price' => $product->discount ?? $product->price,
                    'weight' => $product->weight ?? 0,
                    'options' => [
                        'images' => $product->productImages,
                    ],
                ]);
                $response['count'] = Cart::instance('wishlist')->count();

                return $response;
            }
        }
        return back();
    }
    public function delete(Request $request)
    {
        if($request->ajax()){
            $response['wishlist'] = Cart::instance('wishlist')->remove($request->rowId);

            $response['count'] = Cart::instance('wishlist')->count();

            return $response;
        }
        return back();
    }
}
