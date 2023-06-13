
<div class="product-item item {{$product->tag}}">
    <div class="pi-pic">
        <img src="front/img/products/{{$product->productImages[0]->path ?? ''}}">
        @if($product->discount != null)
            <div class="sale">Sale</div>
        @endif
        @php
            $wishitems = \Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content()->pluck('id');
        @endphp
        <div class="icon">
            @if($wishitems->contains($product->id))
                    <a style="color: black" href="javascript:addWish({{ $product->id }})"><i class="icon_heart fill-heart"></i></a>
            @else
                    <a style="color: black" href="javascript:addWish({{ $product->id }})"><i class="icon_heart"></i></a>
            @endif
{{--                <a href="javascript:addWish({{ $product->id }})"><i class="icon_heart"></i></a>--}}
        </div>
        <ul>
            <li class="w-icon active"><a href="javascript:addCart({{ $product->id }})"><i class="icon_bag_alt"></i></a></li>
            <li class="quick-view"><a href="shop/product/{{ $product->id}}">+ Quick View</a></li>
            <li class="w-icon"><a href=""><i class="fa fa-random"></i></a></li>
        </ul>
    </div>
    <div class="pi-text">
        <div class="cateogy-name">{{$product->tag}}</div>
        <a href="shop/product/{{ $product->id }}">
            <h5>{{ $product->name }}</h5>
        </a>
        <div class="product-price">
            @if($product->discount != null)
                ${{ $product->discount }}
                <span>${{ $product->price }}</span>
            @else
                ${{ $product->price }}
            @endif
        </div>
    </div>
</div>
