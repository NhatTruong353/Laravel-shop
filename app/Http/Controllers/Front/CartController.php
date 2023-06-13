<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Product\ProductServiceInterface;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface  $productService){
        $this->productService = $productService;
    }
    public function index()
    {
        $carts= Cart::instance('cart')->content();
        $total= Cart::instance('cart')->total();
        $subtotal = Cart::instance('cart')->subtotal();


        return view('front.shop.cart',compact('carts','total','subtotal'));
    }
    public function add(Request $request)
    {
        if($request->ajax()){
            $product = $this->productService->find($request->productId);
            $response['cart'] = Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1 ,
                'price' => $product->discount ?? $product->price,
                'weight' => $product->weight ?? 0,
                'options' => [
                    'images' => $product->productImages,
                ],
            ]);
            $response['count'] = Cart::instance('cart')->count();
            $response['total'] = Cart::instance('cart')->total();

            return $response;
        }
        return back();
    }
    public function addCartInDetails(Request $request)
    {
        $sl = $request->product_qty;
        if($request->ajax()){
            $product = $this->productService->find($request->productId);
            $response['cart'] = Cart::instance('cart')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => $sl ?? 1 ,
                'price' => $product->discount ?? $product->price,
                'weight' => $product->weight ?? 0,
                'options' => [
                    'images' => $product->productImages,
                ],
            ]);
            $response['count'] = Cart::instance('cart')->count();
            $response['total'] = Cart::instance('cart')->total();

            return $response;
        }
        return back();
    }
    public function delete(Request $request)
    {
        if($request->ajax()){
            $response['cart'] = Cart::instance('cart')->remove($request->rowId);

            $response['count'] = Cart::instance('cart')->count();
            $response['total'] = Cart::instance('cart')->total();
            $response['subtotal'] = Cart::instance('cart')->subtotal();

            return $response;
        }
        return back();
    }
    public function destroy()
    {
        Cart::destroy();
    }
    public function update(Request $request)
    {
        if($request->ajax()){
            $response['cart'] = Cart::instance('cart')->update($request->rowId,$request->qty);

            $response['count'] = Cart::instance('cart')->count();
            $response['subtotal'] = Cart::instance('cart')->subtotal();
            $response['total'] = Cart::instance('cart')->total();


            return $response;

        }


    }
}
