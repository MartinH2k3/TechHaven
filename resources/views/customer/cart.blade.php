@extends('layouts.app')

@section('title', 'Shopping Cart - TechHaven')

@push('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
@endpush
@include('components.alert')

@section('content')
    @php
        $currentStage = session()->get('current_stage', 1);
    @endphp
    <nav id="shopping-cart-nav" class="shopping-cart-container">
        <a href="{{ route('homepage') }}" class="cart-stage-ref"><i class="fas fa-home"></i> Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '1']) }}" class="cart-stage-ref">Košík</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '2']) }}" class="cart-stage-ref">Platba a doprava</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '3']) }}" class="cart-stage-ref {{ 3 > $currentStage ? 'disabled' : '' }}" >Dodacie údaje</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart.show', ['stage' => '4']) }}" class="cart-stage-ref {{ 4 > $currentStage ? 'disabled' : '' }}" >Zhrnutie</a>
    </nav>

    {{-- Dynamically include the stage component based on the query parameter --}}
    @php
        $stage = request()->query('stage', '1');
    @endphp
    <div class="cart-stage-container">
        @if($stage == '1')
            <x-cart-stage1 :cart-items="$cartItems"/>
        @elseif($stage == '2')
            <x-cart-stage2/>
        @elseif($stage == '3')
            <x-cart-stage3/>
        @elseif($stage == '4')
            <x-cart-stage4 :cart-items="$cartItems" :payment-method="$paymentMethod" :delivery-method="$deliveryMethod" />
        @else
            <x-cart-stage1 :cart-items="$cartItems"/> {{-- Default: stage 1 --}}
        @endif

        @if($stage < 4)
            <button id="next-stage-button" class="switch-to-next-stage">Next Stage</button>
        @endif

        @if (session('alert'))
            <script>
                alert('{{ session('alert') }}');
            </script>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('next-stage-button').addEventListener('click', function() {
            window.location.href = "{{ route('cart.show', ['stage' => $stage + 1]) }}";
        });
    </script>
@endpush
