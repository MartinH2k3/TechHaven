@extends('app')

@section('title', 'Shopping Cart - TechHaven')

@section('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endsection

@section('content')
    <nav id="shopping-cart-nav" class="shopping-cart-container">
        <a href="{{ route('homepage') }}" class="cart-stage-ref"><i class="fas fa-home"></i> Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '1']) }}" class="cart-stage-ref">Košík</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '2']) }}" class="cart-stage-ref">Platba a doprava</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '3']) }}" class="cart-stage-ref">Dodacie údaje</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '4']) }}" class="cart-stage-ref">Zhrnutie</a>
    </nav>

    {{-- Dynamically include the stage component based on the query parameter --}}
    @php
        $stage = request()->query('stage', '1');
    @endphp

    @if($stage == '1')
        <x-cart-stage1 :cart-items="$cartItems"/>
    @elseif($stage == '2')
        <x-cart-stage2 />
    @elseif($stage == '3')
        <x-cart-stage3 />
    @elseif($stage == '4')
        <x-cart-stage4 />
    @else
        <x-cart-stage1 /> {{-- Default: stage 1 --}}
    @endif
@endsection
