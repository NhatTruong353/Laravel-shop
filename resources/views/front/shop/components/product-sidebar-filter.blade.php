<form action="{{ request()->segment(2) == 'product' ? 'shop' : ''}}">
    <div class="filter-widget">
        <h4 class="fw-title">Categories</h4>
        <ul class="filter-catagories">
            @foreach($categories as $category)
                <li><a href="shop/category/{{ $category->name }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
        </ul>
    </div>
</form>
<form action="">
    <div class="filter-widget">
        <h4 class="fw-title">Brand</h4>
        <div class="fw-brand-check">
            @foreach($brands as $brand)
                <div class="bc-item">
                    <label for="bc-{{ $brand->id }}">
                        {{ $brand->name }}
                        <input type="checkbox"
                               {{ (request("brand")[$brand->id] ?? '') == 'on' ? 'checked' : '' }}
                               id="bc-{{$brand->id}}"
                               name="brand[{{ $brand->id }}]"
                               onchange="this.form.submit();"
                        >
                        <span class="checkmark"></span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="filter-widget">
        <h4 class="fw-title">Price</h4>
        <div class="filter-range-wrap">
            <div class="range-slider">
                <div class="price-input">
                    <input type="text" id="minamount" name="price_min">
                    <input type="text" id="maxamount" name="price_max">
                </div>
            </div>
            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                 data-min="10" data-max="999"
                 data-min-value="{{ str_replace('$', '', request('price_min')) }}"
                 data-max-value="{{ str_replace('$', '', request('price_max')) }}">
                <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
                <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
        </div>
        <button type="submit" class="filter-btn">Filter</button>
    </div>

    <div class="filter-widget">
        <div class="recent-post">
            <h4>Last view Products</h4>
            <div class="recent-blog">
                @if(session()->has('products'))
                    @foreach ($showProducts as $product)
                    <a href="shop/product/{{ $product->id}}" class="rb-item">
                        <div class="rb-pic">
                            <img src="front/img/products/{{$product->productImages[0]->path ?? ''}}">
                        </div>
                        <div class="rb-text">
                            <h6>{{$product->name}}</h6>
                            @if($product->discount != null)
                                <p>${{ $product->discount }}</p>

                            @else
                                <p>${{ $product->price }}</p>
                            @endif
                            <p style="color: #0a66b7">Buy Now</p>
                        </div>
                    </a>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
