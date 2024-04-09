@extends('layouts.app')

@section('title', $product->name)

@push('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/product-page.css') }}">
@endpush

@section('content')
    <div id="product-container">
        <div id="product-image-grid">
            <div id="product-image-div">
                <img src="{{ $product->images->count() > 0 ? asset('storage/images/product-images/'.$product->images->first()->filename) : asset('storage/images/product-images/BobTheExample.png') }}"
                     class="product-image" id="main-product-image" alt="Main Product Image">
            </div>

            @foreach ($product->images->take(4) as $image)
                <label class="product-image-thumbnail"
                       onclick="changeMainImage('{{ asset('storage/images/product-images/'.$image->filename) }}')">
                    <img src="{{ asset('storage/images/product-images/'.$image->filename) }}" class="product-image"
                         alt="product thumbnail">
                </label>
            @endforeach
        </div>
        <div id="product-info">
            <h3 class="product-title product-title-general">{{ $product->product_name }}</h3>
            <p class="product-description">{{ $product->product_description }}</p>
            <span class="product-price">{{ number_format($product->price, 2) }} €</span>

            <!-- Quantity input and Add to Cart button -->
            <form action="{{ route('cart.add') }}" method="post" class="add-to-cart-button-form">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <label for="product-quantity-input" id="product-quantity-input-label">Počet:
                    <input id="product-quantity-input" name="product_count" type="number" value="1" min="1" max="99">
                </label>

                <div class="product-button-div">
                    <button type="submit" class="product-button">Pridať do košíka</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function changeMainImage(imagePath) {
            document.getElementById('main-product-image').src = imagePath;
        }
    </script>
    <script src="{{ asset('js/add-to-cart.js') }}"></script>
@endpush

