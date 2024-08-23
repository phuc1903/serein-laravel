<x-layouts.layout title="{{ $product->title }}">

    <div class="summary container">
        <div class="grid wide summary__box">
            <div class="row">
                <div class="col l-6 summary-images">
                    @if(Str::contains($product->image, 'product_images'))
                        <img class="img-main" src="{{ asset('storage/' . $product->image) }}">
                    @else
                        <img class="img-main" src="{{ asset('img/' . $product->image) }}">
                    @endif
                </div>

                <div class="col l-6 summary-content">
                    <div class="summary-content-name "> {{ $product->title }}
                        <div class="summary-content-vote">
                            5.0
                        </div>
                    </div>

                    <div class="summary-content-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</div>
                    <div class="summary-content-desciption">
                        {{ $product->description }}
                    </div>
                    
                    <div class="detailquantity">
                        <div class="detailquantity__quantity">
                            <!-- <p class="detailquantity__quantity-text">2 in stock</p> -->
                            <div class="detailquantity__quantity__updown">
                                <div class="quantity__minus detail-pre pre-quantity">-</div>
                                <input 
                                    id="quantityProductDetail"
                                    name="quantity"
                                    type="text" value="1"
                                    min="1"
                                    class="quantity__value product_quantity quantity-input" 
                                    style="text-align: center;"
                                    >
                                </input>
                                <div class="quantity__add detail-add add-quantity">+</div>
                            </div>

                        </div>
                        <div class="detailquantity__cart">
                            <x-buttons.add-to-cart-icon class="detailquantity__buy BuyProduct" productId="{{ $product->id }}" route="{{ route('cart.store')}}" children='Mua ngay'/>
                            {{-- <a id="add-cart"> --}}
                            <x-buttons.add-to-cart-icon class="detailquantity__addtocart addProductCart" productId="{{ $product->id }}" route="{{ route('cart.store')}}" children='Thêm giỏ hàng'/>
                            {{-- </a> --}}
                        </div>
                        <div class="Category">
                            Category:
                            <div class="detail__Category">
                                <div class="detail__Category__type">Nhẫn, Nhẫn Bạc</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <x-list.product4 title="Sản phẩm liên quan" :products="$relatedProduct"></x-list.product4>
    </div>

</x-layouts.layout>
