@extends('front.layout.master')

@section('title','My Coupons')

@section('body')


    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i>Home</a>
                        <span>My Coupons</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->
    <!-- Shopping cart section begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
{{--                @if(Cart::count() > 0)--}}
                @include('admin.components.notification');
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th style="width: 100px">Type</th>
                                        <th>Value</th>
                                        <th>Cart Value</th>
                                    </tr>
                                </thead>
                                <tbody>
{{--                                @if (is_array($orders) || is_object($orders))--}}
                                    @foreach($coupons as $coupon)
                                    <tr >
                                        <td class="cart-pic first-row">{{$coupon->code}}</td>
                                        @if($coupon->type == 0)
                                            <td class="first-row">Fixed</td>
                                        @else
                                            <td class="first-row">Percent</td>
                                        @endif
                                        @if($coupon->type == 0)
                                            <td class="total-price first-row">${{$coupon->value}}</td>
                                        @else
                                            <td class="total-price first-row">{{$coupon->value}} %</td>
                                        @endif
                                        <td class="total-price first-row">
                                            {{$coupon->cart_value}}
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>

            </div>
        </div>
    </section>
    <!-- Shopping cart section end -->
@endsection
