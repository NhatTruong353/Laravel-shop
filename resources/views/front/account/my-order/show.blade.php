@extends('../front.layout.master')

@section('title','My Orders')

@section('body')


    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i>Home</a>
                        <a href="./account/my-order/">My Order</a>
                        <span>Order Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->
    <!-- Shopping cart section begin -->
    <div class="checkout-section spad">
        <div class="container">
            @if(session('notification'))
                <div class="alert alert-success" role="alert">
                    {{session('notification')}}
                </div>
            @endif
            <form action="./account/my-order/{{$order->id}}/cancel" class="checkout-form" >
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a class="content-btn">Order ID:<b>{{$order->id}}</b></a>
                        </div>
                        <h4>Biiling Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="fir">First Name</label>
                                <input disabled type="text" id="fir" value="{{$usermeta->first_name ?? ''}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name</label>
                                <input disabled type="text" id="last" value="{{$usermeta->last_name}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun-name">Company Name</label>
                                <input disabled type="text" id="cun-name" value="{{$usermeta->company_name}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun">Country</label>
                                <input disabled type="text" id="cun" value="{{$usermeta->country}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="fir">Street Address</label>
                                <input disabled type="text" id="street" class="street-first" value="{{$usermeta->street_address}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="zip">Postcode / ZIP (optional)</label>
                                <input disabled type="text" id="zip" value="{{$usermeta->postcode_zip}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="town">Town/City</label>
                                <input disabled type="text" id="town" value="{{$usermeta->town_city}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Adress</label>
                                <input disabled type="text" id="email" value="{{$order->users->email}}">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone]">Phone</label>
                                <input disabled type="text" id="phone" value="{{$usermeta->phone}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a class="content-btn">
                                Status:
                                <b>{{ \App\Utilities\Constant::$order_status[$order->status] }}</b>
                            </a>
                        </div>
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-total">
                                <ul class="order-table">
                                    @foreach($order->orderDetails as $orderDetail)
                                        <li class="fw-normal">
                                            {{$orderDetail->product->name}} x {{$orderDetail->qty}}

                                            <a href="shop/product/{{$orderDetail->product->id}}"  class="mualai">  Repurchase</a>
                                            <span>${{$orderDetail->total}}</span></li>

                                    @endforeach
                                        <li class="subtotal-price">Subtotal
                                            <span>
                                            ${{ array_sum(array_column($order->orderDetails->toArray(),'total')) }}
                                        </span>
                                        </li>
                                    @if($order->discount != 0)
                                            <li class="subtotal-price">Discount
                                                <span>
                                            -${{ $order->discount  }}
                                        </span>
                                            </li>
                                        @endif
                                    <li class="total-price">Total
                                        <span>
                                            ${{ $order->total_order }}
                                        </span>
                                    </li>
                                </ul>
                                <div class="payment-check">
                                    <div class="pc-item">
                                        <label for="pc-check">
                                            Pay later
                                            <input disabled type="radio" id="pc-check" name="payment_type" value="pay_later"
                                                {{$order->payment_type == 'pay_later' ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="pc-item">
                                        <label for="pc-paypal">
                                            Online Payment
                                            <input disabled type="radio" id="pc-paypal" name="payment_type" value="online_payment" {{$order->payment_type == 'online_payment' ? 'checked' : '' }}>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                @if($order->status == 1 or $order->status == 4)
                                    <div class="order-btn">
                                        <button type="submit" class="site-btn place-order">Cancel Order</button>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Shopping cart section end -->
@endsection
