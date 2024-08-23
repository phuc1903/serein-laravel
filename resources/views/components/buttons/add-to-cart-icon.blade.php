@props(['children', 'class', 'productId', 'quantity' => 1, 'route'])

<button class="btn-product {{ $class }}" type="submit"
    data-route="{{ $route}}" 
    data-product-id="{{ $productId }}"
    data-quantity="{{ $quantity }}"
    >
    {!! $children !!}
</button>
