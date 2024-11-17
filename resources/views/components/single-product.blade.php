<!-- Single Product Component -->
<div class="single-product">
    <div class="product-image">
        <img src="{{ image_url($product->img) }}" style="height: 300px;" alt="{{ $product->name }}">
        @if ($product->price_after_discount!=0)
        <span class="sale-tag">-{{$product->discount_percentage?$product->discount_percentage ."%": $product->fixed_discount."$" }}</span>
        @endif
        {{-- <div class="button">
            <a href="product-details/{{ $product->id }}" class="btn"><i class="lni lni-cart"></i> Add to Cart</a>
        </div> --}}
        <div class="button">
            <livewire:add-to-cart :productId="$product->id" wire:key="{{ $product->id }}" />
            </div>
    </div>
    <div class="product-info">
        <span class="category">{{ $product->categories()->first()?->name }}</span>
        <h4 class="title">
            <a href="{{route('website.products.show', $product->id)}}">{{ $product->name }}</a>
        </h4>
        <ul class="review">
            @for($i = 0; $i < 5; $i++)
                <li>
                    <i class="{{ $i < $product->rating ? 'lni lni-star-filled' : 'lni lni-star' }}"></i>
                </li>
            @endfor
            <li><span>{{ $product->rating }} Review(s)</span></li>
        </ul>
        <div class="price">
            <span>${{ $product->price_after_discount ==0?$product->price: $product->price_after_discount }}</span>
            @if($product->price_after_discount !=0)<span class="discount-price">${{$product->price}}</span>@endif
        </div>
    </div>
</div>
