@extends('layouts.app')

@push('windowSpecificStylesheets')
    <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
@endpush

@section('content')
    <div class="slide-container">
        <button class="slide-arrow left-arrow">&#10094;</button>
        <div id="homepage_slide_1" class="slide">
            <a href="https://www.google.com" target="_blank">
                <img class="homepage-slide-image large-image"
                     src="https://istore.ph/cdn/shop/files/2023-iPhone14Pro-Promo-Blocks.jpg?v=1677226972&width=2000"
                     alt="Large Image">
                <img class="homepage-slide-image small-image"
                     src="{{ asset('images/homepageSlideshow/2023-iPhone14Pro-Promo-Blocks_900.jpg') }}"
                     alt="Small Image">
            </a>
            <!-- Source: https://istore.ph/ -->
        </div>
        <div id="homepage_slide_2" class="slide">
            <a href="https://www.google.com" target="_blank">
                <img class="homepage-slide-image"
                     src="https://i0.wp.com/store.ave.com.bn/wp-content/uploads/2022/11/SEA_iPad_Pro_Web_Banner_Avail_1400x700_FFH.png?fit=1400%2C700&ssl=1"
                     alt="Large Image"></a>
            <!-- Source: https://store.ave.com.bn/ipad-pro-banner/?v=fc37fbde490e-->
        </div>
        <button class="slide-arrow right-arrow">&#10095;</button>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/homepage.js') }}"></script>
@endpush
