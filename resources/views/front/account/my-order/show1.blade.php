@extends('front.layout.master')

@section('title','Order Details')

@section('body')
    <!-- Shopping cart Section begin -->
    <section class="checkout-section spad">
        <div class="container">
            <form action="#" class="checkout-form">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="#" class="content-btn">Order ID:<b>{{$order->id}}</b></a>
                        </div>
                        <h4>Biling Details</h4>
                        <div class="row">
                            <div class="col-lg-6">
                                <label for="fir">First Name</label>
                                <input disabled type="text" id="fir" value="">
                            </div>
                            <div class="col-lg-6">
                                <label for="last">Last Name</label>
                                <input disabled type="text" id="last" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun-name">Company Name</label>
                                <input disabled type="text" id="cun-name" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="cun">Country</label>
                                <input disabled type="text" id="cun" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="fir">Street Address</label>
                                <input disabled type="text" id="street" class="street-first" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="zip">Postcode / ZIP (optional)</label>
                                <input disabled type="text" id="zip" value="">
                            </div>
                            <div class="col-lg-12">
                                <label for="town">Town/City</label>
                                <input disabled type="text" id="town" value="">
                            </div>
                            <div class="col-lg-6">
                                <label for="email">Email Adress</label>
                                <input disabled type="text" id="email" value="">
                            </div>
                            <div class="col-lg-6">
                                <label for="phone]">Phone</label>
                                <input disabled type="text" id="phone" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="checkout-content">
                            <a href="#" class="content-btn">
                                Status:
                                <b>{{ \App\Utilities\Constant::$order_status[$order->status] }}</b>
                            </a>
                        </div>
                        <div class="place-order">
                            <h4>Your Order</h4>
                            <div class="order-table">
                                <ul>
                                    <li>Product <span>Total</span></li>
                                    @foreach($order->orderDetails as $orderDetail)
                                        <li class="fw-normal">
                                            {{$orderDetail->product->name}} x {{$orderDetail->qty}}
                                            <span>${{$orderDetail->total}}</span></li>
                                    @endforeach
                                    <li class="total-price">Total
                                        <span>
                                            ${{ array_sum(array_column($order->orderDetails->toArray(),'total')) }}
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
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!--Shopping cart section end -->
@endsection
