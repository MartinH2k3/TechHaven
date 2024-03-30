<header>
    <!-- button toggling the navigation bar -->
    <input type="checkbox" id="toggle-navbar" hidden />
    <label for="toggle-navbar" class="toggle-icon fancy-text" id="nav-bar-toggle-icon"><i class="fas fa-chevron-up"></i></label>

    <input type="checkbox" id="login-toggle" hidden>

    <nav id="nav-bar">
        <div id="logo-container">
            <a href="{{ route('homepage') }}" class="fancy-text">TechHaven</a>
        </div>
        <div id="enter-browse-page">
            <a href="{{ route('browse') }}" class="fancy-text">Prezerať</a>
        </div>
        <ul id="categories">
            @foreach($categoriesWithProducts as $categoryName => $groups)
                <li class="category-box">
                    <a href="{{ route('browse', ['category' => $categoryName]) }}"><span class="hover-border fancy-text">{{ $categoryName }}</span></a>
                    <div class="category-menu">
                        <div class="menu-column recommend">
                            <h4>Odporúčané</h4>
                            <ul>
                                @foreach($groups['recommended'] as $product)
                                    <li><a href="{{ route('product-page', ['product-id' => $product->id]) }}">{{ $product->product_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="menu-column newest">
                            <h4>Novinky</h4>
                            <ul>
                                @foreach($groups['newest'] as $product)
                                    <li><a href="{{ route('product-page', ['product-id' => $product->id]) }}">{{ $product->product_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="menu-column cheapest">
                            <h4>Najvýhodnejšie</h4>
                            <ul>
                                @foreach($groups['cheapest'] as $product)
                                    <li><a href="{{ route('product-page', ['product-id' => $product->id]) }}">{{ $product->product_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        <ul id="nav-bar-icon-list">
            <li class="nav-bar-icon">
                <label for="search-toggle" id="search-icon"><i class="fas fa-search fancy-text"></i></label>
                <input type="checkbox" id="search-toggle" class="search-checkbox" />
                <form class="search-form">
                    <label>
                        <input type="text" class="search-field" placeholder="Search..." />
                    </label>
                </form>
            </li>
            <li class="nav-bar-icon"><a href="shopping_cart_template.html"><i class="fas fa-shopping-cart fancy-text"></i></a></li>
            <li class="nav-bar-icon"><label for="login-toggle" id="profile-icon"><i class="fas fa-user fancy-text"></i></label></li>
        </ul>
    </nav>
    <div id="overlay"></div>

    <div id="login_screen">
        @include('components.login')
    </div>

    <div id="content-offset"></div> <!-- In final version, this won't exist. The script will add margin to the main when nav-bar is visible -->
    <script src="{{ asset('js/header.js') }}"></script>
</header>
