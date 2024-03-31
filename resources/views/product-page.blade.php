@extends('app')

@section('title', $product->name)

@section('windowSpecificStylesheets')
<link rel="stylesheet" href="{{ asset('css/product-page.css') }}">
@endsection

@section('content')
<div id="product-container">
    <div id="product-image-grid">
        <div id="product-image-div">
            <img src="{{ $product->images->count() > 0 ? asset('storage/images/product-images/'.$product->images->first()->filename) : asset('storage/images/product-images/BobTheExample.png') }}" class="product-image" id="main-product-image" alt="Main Product Image">
        </div>

        @foreach ($product->images->take(4) as $image)
        <label class="product-image-thumbnail" onclick="changeMainImage('{{ asset('storage/images/product-images/'.$image->filename) }}')">
            <img src="{{ asset('storage/images/product-images/'.$image->filename) }}" class="product-image" alt="product thumbnail">
        </label>
        @endforeach
    </div>
    <div id="product-info">
        <h3 class="product-title product-title-general">{{ $product->product_name }}</h3>
        <p class="product-description">{{ $product->product_description }}</p>
        <span class="product-price">{{ number_format($product->price, 2) }} €</span>

        <!-- Quantity input and Add to Cart button -->
        <label for="product-quantity-input" id="product-quantity-input-label">Počet:
            <input id="product-quantity-input" type="number" value="1" min="1" max="99">
        </label>
        <div class="product-button-div">
            <button class="product-button">Pridať do košíka</button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function changeMainImage(imagePath) {
        document.getElementById('main-product-image').src = imagePath;
    }
</script>
@endsection
