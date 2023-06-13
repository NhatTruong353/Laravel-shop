@extends('front.layout.master')

@section('title','Check Out')

@section('body')
<!-- Shopping cart Section begin -->
<div class="checkout-section spad">
    <div class="container">
        <form action="" method="post" class="checkout-form" >
            @csrf
            <div class="row">
                @if(Cart::instance('cart')->count() > 0)
                    <div class="col-lg-6">

                        <h4>Biiling Details</h4>
                        <div class="row">


                            <input type="hidden" id="user_id" name="user_id" value="{{Auth::user()->id ?? ''}}">
                            <input type="hidden" id="name_order" name="name_order" value="{{Auth::user()->email ?? ''}}">
                            <div class="col-lg-6">
                                <label for="fir">First Name<span>*</span></label>
                                <input type="text" id="fir" name="first_name" value="{{$usermeta->first_name ?? ''}}">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name<span>*</span></label>
                                <input type="text" id="last" name="last_name" value="{{$usermeta->last_name ?? ''}}">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="cun-name">Company Name</label>
                                <input type="text" id="cun-name" name="company_name" value="{{$usermeta->company_name ?? ''}}">
                                @if ($errors->has('company_name'))
                                    <span class="text-danger">{{ $errors->first('company_name') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="cun">Country</label>
                                <input type="text" id="cun" name="country" value="{{$usermeta->country ?? ''}}">
                                @if ($errors->has('country'))
                                    <span class="text-danger">{{ $errors->first('country') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="street">Street Adress</label>
                                <input type="text" id="street" class="street-first" name="street_address" value="{{$usermeta->street_address ?? ''}}">
                                @if ($errors->has('street_address'))
                                    <span class="text-danger">{{ $errors->first('street_address') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="zip">Postcode / ZIP (optinal)</label>
                                <input type="text" id="zip" name="postcode_zip" value="{{$usermeta->postcode_zip ?? ''}}">
                                @if ($errors->has('postcode_zip'))
                                    <span class="text-danger">{{ $errors->first('postcode_zip') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-12">
                                <label for="tow">Town / City <span>*</span></label>
                                <input type="text" id="tow" name="town_city" value="{{$usermeta->town_city ?? ''}}">
                                @if ($errors->has('town_city'))
                                    <span class="text-danger">{{ $errors->first('town_city') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Adress<span>*</span></label>
                                <input disabled type="text" id="email" name="email" value="{{Auth::user()->email ?? ''}}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-lg-6">
                                <label for="phone">Phone<span>*</span></label>
                                <input type="text" id="phone" name="phone" value="{{$usermeta->phone ?? ''}}">
                                @if ($errors->has('phone'))
                                    <span class="text-danger">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
{{--                            <div class="col-lg-12">--}}
{{--                                <div class="create-item">--}}
{{--                                    <label>--}}
{{--                                        Create an Account--}}
{{--                                        <input type="checkbox" id="acc-create" name="">--}}
{{--                                        <span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                        </div>
                    </div>
                    <div class="col-lg-6">

                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    <li>Product <span>Total</span></li>

                                    @foreach($carts as $cart)
                                            <?php
                                            $product = App\Models\Product::find($cart->id);
                                            $productQuantity = $product->qty;
                                            $displayQuantity = $cart->qty;
                                            ?>
                                        @if ($cart->qty > $productQuantity)
                                            <p class="text-danger">your product quantity has been changed as the maximum product {{$cart->name}} is only {{$productQuantity}}</p>
                                        @endif
                                            <?php
                                                if ($cart->qty > $productQuantity) {
                                                    $displayQuantity = $productQuantity;
                                                    \Gloudemans\Shoppingcart\Facades\Cart::update($cart->rowId, $displayQuantity);
                                                }
                                            ?>
                                        <li class="fw-normal">{{ $cart->name }} x {{ $cart->qty }} <span>${{$cart->price * $cart->qty}}</span></li>

                                    @endforeach


                                    <li class="fw-normal">Subtotal <span>${{$subtotal}}</span></li>

                                    <li hidden class="fw-normal show_coupon_box">Coupon Code: <i id="coupon_code_str" name="coupon_code_str"> </i> <a href="javascript:void(0)" onclick="remove_coupon_code()" class="remove_coupon_new_link">  Remove</a> <span id="coupon_code_price" name="coupon_code_price"></span></li>
                                    <li class="total-price" >Total <span id="total_price_order" name="total_price_order">${{$total}}</span></li>
                                    <input hidden type="number" id="discount" name="discount" value="">
                                    <input hidden type="number" id="total_order" name="total_order" value="">
                                </ul>
                                <div class="checkout-content">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <input type="text" placeholder="Enter your coupon code" name="coupon_code" id="coupon_code" class="apply_coupon_code_box">
                                            <div id="coupon_code_msg"></div>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="apply_coupon_code_box btn-danger" type="button" value="Apply" style="background: #a31c3c"  onclick="applyCouponCode()">
                                        </div>
                                    </div>


                                </div>

                                <div class="checkout-content">
                                    <div class="row">
                                        <select id="discount_code" name="discount_code">
                                            <option value="">- Chọn mã giảm giá -</option>
                                            @foreach($discountCodes as $discountCode)
                                                <option value="{{ $discountCode->code }}">{{ $discountCode->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Pay later
                                            <input type="radio" id="pc-check" name="payment_type" value="pay_later" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Online Payment
                                            <input type="radio" id="pc-paypal" name="payment_type" value="online_payment">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="order-btn">
                                    <button type="submit" class="site-btn place-order">Place Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <h4>Your Cart Is Empty</h4>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
<!--Shopping cart section end -->
@endsection
