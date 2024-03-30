@extends('app')

@section('title', 'Browse TechHaven')

@section('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/browse-page.css') }}">
@endsection

@section('content')
    <aside class="sidebar">
        <form id="filter-form" action="{{ route('browse') }}" method="GET">
            <div class="filter-group">
                <label class="filter-label">Zoradiť podľa</label>
                <label>
                    <select name="sort" class="filter filter-dropdown">
                        <option value="">Vyber Možnosť</option>
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Najlacnejšie</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Najdrahšie</option>
                        <option value="date-asc" {{ request('sort') == 'date-asc' ? 'selected' : '' }}>Najstaršie</option>
                        <option value="date-desc" {{ request('sort') == 'date-desc' ? 'selected' : '' }}>Najnovšie</option>
                    </select>
                </label>
            </div>
            <!-- Price Range -->
            <div class="filter-group">
                <label class="filter-label">Cena</label>
                <div class="filter filter-range">
                    <label>
                        <input name="price_from" type="number" placeholder="From" value="{{ request('price_from', '0') }}" min="0" max="20000">
                    </label> -
                    <label>
                        <input name="price_to" type="number" placeholder="To" value="{{ request('price_to', '20000') }}" min="0" max="20000">
                    </label>
                </div>
            </div>

            <!-- Category Dropdown -->
            <div class="filter-group">
                <label class="filter-label">Kategória</label>
                <label>
                    <select name="category" class="filter filter-dropdown">
                        <option value="">Vyber Kategóriu</option>
                        <option value="Mobily" {{ request('category') == 'Mobily' ? 'selected' : '' }}>Mobily</option>
                        <option value="Tablety" {{ request('category') == 'Tablety' ? 'selected' : '' }}>Tablety</option>
                        <option value="Notebooky" {{ request('category') == 'Notebooky' ? 'selected' : '' }}>Notebooky</option>
                        <option value="Herné konzoly" {{ request('category') == 'Herné konzoly' ? 'selected' : '' }}>Herné konzoly</option>
                    </select>
                </label>
            </div>

            <div class="filter-group filter-range">
                <label class="filter-label">RAM (GB)</label>
                <div class="filter filter-range">
                    <label>
                        <input type="number" name="ram_from" placeholder="From" value="{{ request('ram_from', '1') }}" min="1" max="64">
                    </label> -
                    <label>
                        <input type="number" name="ram_to" placeholder="To" value="{{ request('ram_to', '64') }}" min="1" max="64">
                    </label>
                </div>
            </div>

            <!-- Options for OS -->
            <!-- For checkboxes, you need to check if the value is in the array returned by request('os') -->
            <div class="filter-group">
                <label class="filter-label">Operačný systém</label>
                <div class="filter filter-checkbox">
                    <!-- Repeat for each OS option, checking if it's in the array -->
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osWindows" name="os[]" value="Windows" {{ is_array(request('os')) && in_array('Windows', request('os')) ? 'checked' : '' }}>
                        <label for="osWindows">Windows</label>
                    </div>
                    <!-- Repeat for other OS options -->
                </div>
            </div>

            <div class="filter-group filter-range">
                <label class="filter-label">Veľkosť displeja (in)</label>
                <div class="filter filter-range">
                    <label>
                        <input type="number" name="display_from" placeholder="From" value="{{ request('display_from', '1') }}" min="1" max="100">
                    </label> -
                    <label>
                        <input type="number" name="display_to" placeholder="To" value="{{ request('display_to', '100') }}" min="1" max="100">
                    </label>
                </div>
            </div>

            <button type="submit" class="filter-button">Filtrovať</button>
        </form>

    </aside>
    <div class="browse-page-container">
        <section id="product-grid">
            @foreach ($products as $product)
                <figure class="grid-item">
                    <a href="{{ url('/product', $product->id) }}" class="anchor-for-product-preview-image">
                        <img src="{{ $product->images->count() > 0 ? asset('storage/images/product-images/'.$product->images->first()->path) : asset('storage/images/product-images/BobTheExample.png') }}" alt="Product image" class="product-preview-image">
                    </a>
                    <span class="product-preview-title product-title-general">{{ $product->product_name }}</span>
                    <p class="product-preview-description">{{ $product->product_description }}</p>
                    <span class="product-preview-price">{{ $product->price }} €</span>
                    <span class="product-preview-add-to-cart"><i class="fas fa-shopping-cart"></i></span>
                </figure>
            @endforeach
        </section>

        {{ $products->onEachSide(1)->links('vendor.pagination.css-slider') }}

    </div>
@endsection
