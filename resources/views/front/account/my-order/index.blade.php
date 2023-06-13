@extends('front.layout.master')

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
                        <span>My Order</span>
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
                                        <th>Image</th>
                                        <th style="width: 100px">ID</th>
                                        <th class="p-name">Product</th>
                                        <th>Total</th>
                                        <th>Details</th>
                                    </tr>
                                </thead>
                                <tbody>
{{--                                @if (is_array($orders) || is_object($orders))--}}
                                    @foreach($orders as $order)
                                    <tr >
                                        <td class="cart-pic first-row"><img style="height: 150px" src="front/img/products/{{ $order->orderDetails[0]->product->productImages[0]->path }}"></td>
                                        <td class="first-row">#{{$order->id}}</td>
                                        <td class="cart-title first-row">
                                            <h5>
                                                {{$order->orderDetails[0]->product->name}}
                                                @if(count($order->orderDetails)>1)
                                                (and {{ count($order->orderDetails) }} other products)
                                                @endif
                                            </h5>
                                        </td>
                                        <td class="total-price first-row">
                                            ${{ $order->total_order }}
                                        </td>
                                        <td class="first-row">
                                            <a class="btn" href="./account/my-order/{{$order->id}}">Details</a>
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
