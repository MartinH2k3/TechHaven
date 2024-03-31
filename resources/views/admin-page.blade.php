@extends('admin-layout')

@section('content')
    <div class="admin-container">
        <h1>Admin</h1>
        <a href="{{ route('admin-add') }}" class="button-link">
            <button type="button" class="create-product">Vytvoriť nový produkt</button>
        </a>
        <a href="{{ route('admin-manage') }}" class="button-link">
            <button type="button" class="remove-product">Zmeniť/odstrániť produkt</button>
        </a>
    </div>
@endsection
