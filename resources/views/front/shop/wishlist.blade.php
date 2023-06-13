@extends('front.layout.master')

@section('title','Wishlist')

@section('body')


    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i>Home</a>
                        <a href="/shop">Shop</a>
                        <span>Wishlist</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->
    <!-- Shopping cart section begin -->
    <div class="shopping-cart spad">
        <div class="container">
            <div class="row">
                @if(Cart::instance('wishlist')->count() > 0)
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="p-name">Product Name</th>
                                        <th>Price</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($wishlist as $item)
                                    <tr data-rowid="{{ $item->rowId }}">
                                        <td class="cart-pic first-row"><img style="height: 170px" src="front/img/products/{{ $item->options->images[0]->path}}"></td>
                                        <td class="cart-title first-row">
                                            <h5><a class="name_wish" id="name_wish" href="shop/product/{{$item->id}}"> {{$item->name}}</a></h5>
                                        </td>
                                        <td class="p-price first-row">${{ number_format($item->price,2) }}</td>
                                        <td class="close-td first-row">
                                            <i onclick="removeWish('{{ $item->rowId }}')" class="ti-close"></i>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                @else
                    <div class="col-lg-12">
                        <h4>Your wishlist is empty.</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Shopping cart section end -->
@endsection
