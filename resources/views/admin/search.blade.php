@extends('layouts.admin')
@section('title', 'Vyhľadať produkt')
@section('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/admin-search.css') }}">
@endsection
@props(['products'])
<!--Include the alert component, when product is changed or removed.-->
@include('components.alert')

@section('content')
    <div class="search-product-container">
        {{$products->count()}}
        <h1>Hľadaj produkty</h1>
        <form class="search_for_product_name_form" action="{{ route('admin.search') }}" method="GET">
            <label for="search_for_product_name">Hľadaj názov produktu:</label>
                <input type="text" id="search_for_product_name" name="search" placeholder="Názov Produktu" maxlength="62" required>
            <button type="submit" id="search-button">Vyhľadať</button>
        </form>
        <div class="products-table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Názov</th>
                        <th>Kategória</th>
                        <th>RAM (GB)</th>
                        <th>Operačný systém</th>
                        <th>Veľkosť displeja (in)</th>
                        <th>Cena</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td><a href="{{ route('admin.manage',['id' => $product->id]) }}">{{ $product->product_name }}</a></td>
                            <td>{{ $product->category }}</td>
                            <td>{{ $product->ram }}</td>
                            <td>{{ $product->operating_system }}</td>
                            <td>{{ $product->display_size }}</td>
                            <td>{{ $product->price }} €</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
