@extends('admin-layout')
@section('title', 'Vytvoriť produkt')
@section('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/admin-add.css') }}">
@endsection
@section('content')
    <form class="add-product-form" action="{{ route('admin.add') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h1>Pridať produkt</h1>

        <div class="form-group">
            <label for="product_name">Názov:</label>
            <input type="text" id="product_name" name="product_name" placeholder="Zadaj Názov" maxlength="62" required>
        </div>

        <!-- Category Dropdown -->
        <div class="filter-group">
            <label for="select-category" class="filter-label">Kategória:</label>
            <select id="select-category" name="category" class="filter filter-dropdown" required>
                <option value="">Vyber Kategóriu</option>
                <option value="Mobily">Mobily</option>
                <option value="Tablety">Tablety</option>
                <option value="Notebooky">Notebooky</option>
                <option value="Herné konzoly">Herné konzoly</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_memory">RAM (GB):</label>
            <input type="number" id="product_memory" name="ram" placeholder="Zadaj RAM (GB)" min="0" max="999" required>
        </div>

        <div class="filter-group">
            <label for="select-product_operating_system" class="filter-label">Operačný systém:</label>
            <select id="select-product_operating_system" name="operating_system" class="filter filter-dropdown" required>
                <option value="">Vyber operačný systém</option>
                <option value="Windows">Windows</option>
                <option value="Mac">Mac</option>
                <option value="Linux">Linux</option>
                <option value="Android">Android</option>
                <option value="iOS">iOS</option>
                <option value="Other">Iné</option>
            </select>
        </div>

        <div class="form-group">
            <label for="product_display_size">Veľkosť displeja (in):</label>
            <input type="number" id="product_display_size" name="display_size"  step="0.1" placeholder="Zadaj veľkosť displeja (in)" min="1" max="100" required>
        </div>

        <div class="form-group">
            <label for="product_description">Opis:</label>
            <textarea id="product_description" name="product_description" placeholder="Zadaj Opis" maxlength="365" required></textarea>
        </div>

        <div class="form-group">
            <label for="product_price">Cena:</label>
            <input type="number" id="product_price" name="price" placeholder="Zadaj Cenu" min="0" step="0.01" required>
        </div>

        <div class="form-group">
            <label>Obrázky produktu:</label>
            <input type="file" id="product_image" name="product_image[]" placeholder="Vyber súbory" multiple required>
        </div>

        <button type="submit" id="add-product-button">Pridať produkt</button>
    </form>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
