@extends('front.layout.master')

@section('title' , 'Product')

@section('body')


    <!-- -->
    <!-- Breadcrumb section begin -->
    <div class="breadcrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="/"><i class="fa fa-home"></i>Home</a>
                        <a href="shop">Shop</a>
                        <span>Detail</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb section end -->

    <!-- Productshop section begin -->
    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">

                <div class="col-lg-11">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="front/img/products/{{$product->productImages[0]->path ?? '' }}">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    @foreach($product->productImages as $productImage)
                                        <div class="pt active" data-imgbigurl="front/img/products/{{ $productImage->path }}">
                                            <img src="front/img/products/{{ $productImage->path }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <span>{{ $product->tag }}</span>
                                    <h3>{{ $product->name}}</h3>
                                    @php
                                        $wishitems = \Gloudemans\Shoppingcart\Facades\Cart::instance('wishlist')->content()->pluck('id');
                                    @endphp
                                    @if($wishitems->contains($product->id))
                                        <a class="heart-icon"><i class="icon_heart fill-heart"></i></a>
                                    @else
                                        <a style="color: black" href="javascript:addWish({{ $product->id }})" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                    @endif
{{--                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>--}}
                                </div>
                                <div class="pd-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $product->avgRating)
                                            <i class="fa fa-star"></i>
                                        @else
                                            <i class="fa fa-star-o"></i>
                                        @endif
                                    @endfor
                                    <span>({{count($product->productComments)}})</span>
                                </div>
                                <div class="pd-desc">
                                    <p>{{ $product->content}}</p>

                                    @if($product->discount != null)
                                        <h4>${{ $product->discount }}<span>${{ $product->price}}</span></h4>
                                    @else
                                        <h4>${{ $product->price }}</h4>
                                    @endif
                                </div>
                                <div class="pd-color">
                                    @if(array_unique(array_column($product->productDetails->toArray(),'color')) != null)
                                    <h6>Color</h6>
                                    <div class="pd-color-choose">
                                        @foreach(array_unique(array_column($product->productDetails->toArray(),'color')) as $productColor)
                                            <div class="cc-item">
                                                <input type="radio" id="cc-{{$productColor}}">
                                                <label for="cc-{{$productColor}}" class="cc-{{$productColor}}"></label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                                <div class="pd-size-choose">
                                    @foreach(array_unique(array_column($product->productDetails->toArray(),'size')) as $productSize)
                                        <div class="sc-item">
                                            <input type="radio" id="sm-{{$productSize}}">
                                            <label for="sm-{{$productSize}}">{{$productSize}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="quantity">
                                    <div class="pro-qty1" >
                                        <input type="number" name="quantity" id="quantity" min="1"  value="1">
                                    </div>
                                    @if($product->qty > 0)
                                    <a href="javascript:addCartInDetails({{ $product->id }})" class="primary-btn pd-cart">Add to Cart</a>
                                    @endif
                                </div>
                                <input hidden name="qty_fill" id="qty_fill" value="{{$product->qty}}">
                                <ul class="pd-tags">
                                    <li><span>CATEGORIES</span>:{{ $product->productCategory->name }}</li>
                                    <li><span>TAGS</span>:{{$product->tag}}</li>
                                </ul>
                                <div class="pd-share">
                                    <div class="p-code">
                                        Sku  :  {{$product->sku }}
                                    </div>
                                    <div class="pd-social">
                                        <a href="#"><i class="ti-facebook"></i></a>
                                        <a href="#"><i class="ti-twitter-alt"></i></a>
                                        <a href="#"><i class="ti-linkedin"></i></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="product-tab">
                        <div class="tab-item">
                            <ul class="nav" role="tablist">
                                <li><a class="active" href="#tab-1" data-toggle="tab" role="tab">Customer Reviews</a></li>
                                <li><a href="#tab-2" data-toggle="tab" role="tab">SPECIFICATION</a></li>
                                <li><a href="#tab-3" data-toggle="tab" role="tab">DESCRIPTION</a></li>
{{--                                Demsonguoidanhgia--}}
{{--                                ({{count($product->productComments)}})--}}
                            </ul>
                        </div>
                        <div class="tab-item-content">
                            <div class="tab-content">
                                <div class="tab-pane fade-in active" id="tab-1" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>Comments and rate</h4>
                                        {{--                                        //Demcomment--}}
                                        {{--                                        {{ count($product->productComments) }}--}}
                                        <div class="comment-option">
                                            @foreach($product->productComments as $productComment)
                                                @if($productComment->comment_status == 1)
                                                    <div class="co-item">
                                                        <div class="avatar-pic">
                                                            <img src="front/img/user/{{ $productComment->user->avatar ?? 'default-avatar.jpg' }}">
                                                        </div>
                                                        <div class="avatar-text">
                                                            <div class="at-rating">
                                                                @for($i=1;$i<=5;$i++)
                                                                    @if($i <= $productComment->rating)
                                                                        <i class="fa fa-star"></i>
                                                                    @else
                                                                        <i class="fa fa-star-o"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <h5>{{ $productComment->name}} <span>{{ date('M d, Y',strtotime($productComment->created_at)) }}</span></h5>
                                                            <div class="at-reply">
                                                                {{$productComment->messages}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                                @include('admin.components.notification');
                                            @if($orderDetails->count() > 0)
                                                @if($review == null)
                                                    <div class="leave-comment">
                                                    <h4>Leave A Comment</h4>
                                                    <form action="" method="post" class="comment-form">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id ?? null}}">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <input type="text" placeholder="Name" name="name" value="{{Auth::user()->name ?? ''}}">
                                                                @if ($errors->has('name'))
                                                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <input type="text" placeholder="Email" name="email" value="{{Auth::user()->email ?? ''}}">
                                                                @if ($errors->has('email'))
                                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <textarea placeholder="Messages" name="messages"></textarea>
                                                                @if ($errors->has('email'))
                                                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                                                @endif
                                                                <div class="personal-rating">
                                                                    <h6>Your Rating</h6>
                                                                    <div class="rate">
                                                                        <input type="radio" id="star5" name="rating" value="5" />
                                                                        <label for="star5" title="text">5 stars</label>
                                                                        <input type="radio" id="star4" name="rating" value="4" />
                                                                        <label for="star4" title="text">4 stars</label>
                                                                        <input type="radio" id="star3" name="rating" value="3" />
                                                                        <label for="star3" title="text">3 stars</label>
                                                                        <input type="radio" id="star2" name="rating" value="2" />
                                                                        <label for="star2" title="text">2 stars</label>
                                                                        <input type="radio" id="star1" name="rating" value="1" />
                                                                        <label for="star1" title="text">1 star</label>
                                                                    </div>
                                                                </div>
                                                                <div class="container">
                                                                    @if ($errors->has('rating'))
                                                                        <span class="text-danger">{{ $errors->first('rating') }}</span>
                                                                    @endif
                                                                </div>
                                                                <button type="submit" class="site-btn">Send Massage</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                    @endif
                                                @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $product->avgRating)
                                                                <i class="fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star-o"></i>
                                                            @endif
                                                        @endfor
                                                        <span>({{count($product->productComments)}})</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                    <div class="p-price">
                                                        ${{ $product->price }}
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Availability</td>
                                                <td>
                                                    <div class="p-stock">{{ $product->qty}} in stock</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Weight</td>
                                                <td>
                                                    <div class="p-weight">{{ $product->weight}}g</div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="p-catagory">Sku</td>
                                                <td>
                                                    <div class="p-code">{{ $product->sku }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="product-content">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-2" role="tabpanel">
                                    <div class="specification-table">
                                        <table>
                                            <tr>
                                                <td class="p-catagory">Customer Rating</td>
                                                <td>
                                                    <div class="pd-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $product->avgRating)
                                                                <i class="fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star-o"></i>
                                                            @endif
                                                        @endfor
                                                        <span>({{count($product->productComments)}})</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Price</td>
                                                <td>
                                                   <div class="p-price">
                                                       ${{ $product->price }}
                                                   </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Add To Cart</td>
                                                <td>
                                                    <div class="cart-add">+ add to cart</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Availability</td>
                                                <td>
                                                    <div class="p-stock">{{ $product->qty}} in stock</div>
                                                </td>
                                            </tr>
                                            <tr>
                                               <td class="p-catagory">Weight</td>
                                               <td>
                                                   <div class="p-weight">{{ $product->weight}}g</div>
                                               </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Size</td>
                                                <td>
                                                    <div class="p-size">
                                                        @foreach(array_unique(array_column($product->productDetails->toArray(),'size')) as $productSize)
                                                            {{$productSize}},
                                                        @endforeach
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Color</td>
                                                <td>
                                                    @foreach(array_unique(array_column($product->productDetails->toArray(),'color')) as $productColor)
                                                        <span class="cs-{{ $productColor}}"></span>
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-catagory">Sku</td>
                                                <td>
                                                    <div class="p-code">{{ $product->sku }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-3" role="tabpanel">
                                    <div class="customer-review-option">
                                        <h4>Comments and rate</h4>
{{--                                        //Demcomment--}}
{{--                                        {{ count($product->productComments) }}--}}
                                        <div class="comment-option">
                                            @foreach($product->productComments as $productComment)
                                                @if($productComment->comment_status == 1)
                                                    <div class="co-item">
                                                        <div class="avatar-pic">
                                                            <img src="front/img/user/{{ $productComment->user->avatar ?? 'default-avatar.jpg' }}">
                                                        </div>
                                                        <div class="avatar-text">
                                                            <div class="at-rating">
                                                                @for($i=1;$i<=5;$i++)
                                                                    @if($i <= $productComment->rating)
                                                                        <i class="fa fa-star"></i>
                                                                    @else
                                                                        <i class="fa fa-star-o"></i>
                                                                    @endif
                                                                @endfor
                                                            </div>
                                                            <h5>{{ $productComment->name}} <span>{{ date('M d, Y',strtotime($productComment->created_at)) }}</span></h5>
                                                            <div class="at-reply">
                                                                {{$productComment->messages}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        <div class="leave-comment">
                                            <h4>Leave A Comment</h4>
                                            @include('admin.components.notification');
                                            <form action="" method="post" class="comment-form">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id ?? null}}">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Name" name="name">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <input type="text" placeholder="Email" name="email">
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <textarea placeholder="Messages" name="messages"></textarea>
                                                        <div class="personal-rating">
                                                            <h6>Your Rating</h6>
                                                            <div class="rate">
                                                                <input type="radio" id="star5" name="rating" value="5" />
                                                                <label for="star5" title="text">5 stars</label>
                                                                <input type="radio" id="star4" name="rating" value="4" />
                                                                <label for="star4" title="text">4 stars</label>
                                                                <input type="radio" id="star3" name="rating" value="3" />
                                                                <label for="star3" title="text">3 stars</label>
                                                                <input type="radio" id="star2" name="rating" value="2" />
                                                                <label for="star2" title="text">2 stars</label>
                                                                <input type="radio" id="star1" name="rating" value="1" />
                                                                <label for="star1" title="text">1 star</label>
                                                            </div>
                                                        </div>
                                                        <button type="submit" class="site-btn">Send Massage</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Productshop section end -->

    <!-- Related Products section begin -->
    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Relate Productions</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($relatedProducts as $product)
                    <div class="col-lg-3 col-sm-6">
                        @include('front.components.product-item')
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Related Products section end -->
@endsection


