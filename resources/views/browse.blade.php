@extends('app')

@section('title', 'Browse TechHaven')

@section('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/browse_page.css') }}">
@endsection

@section('content')
    <aside class="sidebar">
        <form id="filter-form" action="{{ route('browse') }}" method="GET">
        <div class="filter-group">
                <label class="filter-label">Zoradiť podľa</label>
                <label>
                    <select name="sort" class="filter filter-dropdown">
                        <option value="">Vyber Možnosť</option>
                        <option value="price-asc">Najlacnejšie</option>
                        <option value="price-desc">Najdrahšie</option>
                        <option value="date-asc">Najstaršie</option>
                        <option value="date-desc">Najnovšie</option>
                    </select>
                </label>
            </div>
            <!-- Price Range -->
            <div class="filter-group">
                <label class="filter-label">Cena</label>
                <div class="filter filter-range">
                    <label>
                        <input name="price_from" type="number" placeholder="From" value="0" min="0" max="20000">
                    </label> -
                    <label>
                        <input name="price_to" type="number" placeholder="To" value="20000" min="0" max="20000">
                    </label>
                </div>
            </div>

            <!-- Category Dropdown -->
            <div class="filter-group">
                <label class="filter-label">Kategória</label>
                <label>
                    <select name="category" class="filter filter-dropdown">
                        <option value="">Vyber Kategóriu</option>
                        <option value="phones">Mobily</option>
                        <option value="tablets">Tablety</option>
                        <option value="laptops">Notebooky</option>
                        <option value="game-consoles">Herné konzoly</option>
                    </select>
                </label>
            </div>

            <div class="filter-group filter-range">
                <label class="filter-label">RAM (GB)</label>
                <div class="filter filter-range">
                    <label>
                        <input type="number" name="ram_from" placeholder="From" value="1" min="1" max="64">
                    </label> -
                    <label>
                        <input type="number" name="ram_to" placeholder="To" value="64" min="1" max="64">
                    </label>
                </div>
            </div>

            <!-- Options for OS -->
            <div class="filter-group">
                <label class="filter-label">Operačný systém</label>
                <div class="filter filter-checkbox">
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osWindows" name="os[]" value="windows">
                        <label for="osWindows">Windows</label>
                    </div>
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osMac" name="os[]" value="mac">
                        <label for="osMac">Mac</label>
                    </div>
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osLinux" name="os[]" value="linux">
                        <label for="osLinux">Linux</label>
                    </div>
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osAndroid" name="os[]" value="android">
                        <label for="osAndroid">Android</label>
                    </div>
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osIOS" name="os[]" value="ios">
                        <label for="osIOS">iOS</label>
                    </div>
                    <div class="os-checkbox-div">
                        <input type="checkbox" id="osOther" name="os[]" value="other">
                        <label for="osOther">Iné</label>
                    </div>
                </div>
            </div>

            <div class="filter-group filter-range">
                <label class="filter-label">Veľkosť displeja (in)</label>
                <div class="filter filter-range">
                    <label>
                        <input type="number" name="display_from" placeholder="From" value="1" min="1" max="100">
                    </label> -
                    <label>
                        <input type="number" name="display_to" placeholder="To" value="100" min="1" max="100">
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
                        <img src="{{ asset('storage/images/product-images/' . $product->image_id_long . '.png') }}" alt="Product image" class="product-preview-image">
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
