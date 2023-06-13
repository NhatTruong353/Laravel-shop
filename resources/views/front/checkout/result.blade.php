@extends('front.layout.master')

@section('title','Result')

@section('body')


    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="./index"><i class="fa fa-home"></i>Home</a>
                        <a href="./checkout">CheckOut</a>
                        <span>Result</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->
    <!-- Shopping cart Section begin -->
    <div class="checkout-section spad">
        <div class="container">
            <div class="col-lg-12">
                <h4>
                    {{$notification}}
                </h4>
                <a href="./shop" class="primary-btn mt-5">Continue Shopping</a>
            </div>
        </div>
    </div>
    <!--Shopping cart section end -->
@endsection
