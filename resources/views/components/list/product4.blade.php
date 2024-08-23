@props(['title', 'products', 'shop' => route('shop')])

<section class="product container">
    <div class="grid wide">
        <div class="product-section">
            <h3>{{ $title }}</h3>
            <span><a href="{{ $shop }}">Đi đến shop</a></span>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col l-3 m-6 c-12">
                    <div class="product-item">
                        <a href="{{ route('detail', $product->id) }}">
                            <div class="product-top">
                                <div class="product-item-img">
                                    @if(Str::contains($product->image, 'product_images'))
                                        <img src="{{ asset('storage/' . $product->image) }}">
                                    @else
                                        <img src="{{ asset('img/' . $product->image) }}">
                                    @endif
                                </div>
                            </div>
                            <div class="product-bottom">
                                <div class="product-item-bottom">
                                    <div class="product-item-name line-champ-2">{{ $product->title }}</div>
                                    <div class="product-item-price"><a href="{{ route('detail', $product->id) }}">{{ number_format($product->price, 0, ',', '.') }} VNĐ</a></div>
                                </div>
                                <div class="buy-product">
                                    <a class="btn-product btn-product-buy" href="{{ route('detail', $product->id) }}">Mua ngay</a>
                                    {{-- Thêm sản phẩm vào sản phẩm yêu thích --}}
                                    <x-buttons.add-to-cart-icon class="btn-product-heart addProductFavorite" productId="{{ $product->id }}" route="{{ route('favorite-store')}}" children='<i class="fa-regular fa-heart"></i>'/>
                                    {{-- Thêm sản phẩm vào giỏ hàng --}}
                                    <x-buttons.add-to-cart-icon class="buy-product btn-product-cart addProductCart" productId="{{ $product->id }}" route="{{ route('cart.store')}}" children='<i class="fa-solid fa-cart-shopping"></i>'/>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
