<!-- resources/views/layout_frontEnd/header.blade.php -->

<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-shop">
    <div class="container">
        <a href="{{ route('shop.index') }}" class="navbar-brand d-flex align-items-center">
            <i class="fas fa-shopping-bag mr-2" style="font-size: 1.5rem;"></i>
            <span class="brand-text">{{ config('app.name', 'Hanout') }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('shop.index') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-store mr-1"></i>
                        <span>Shop</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('shop.cart') }}" class="nav-link d-flex align-items-center">
                        <i class="fas fa-shopping-cart mr-1"></i>
                        <span>Cart</span>
                        @if(session('cart'))
                            <span class="cart-badge ml-1">{{ count((array) session('cart')) }}</span>
                        @endif
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="{{ route('shop.orders') }}" class="nav-link d-flex align-items-center">
                            <i class="fas fa-box mr-1"></i>
                            <span>My Orders</span>
                        </a>
                    </li>
                @endauth
            </ul>

            <!-- Search Form -->
            <form class="form-inline ml-3 search-form">
                <i class="fas fa-search search-icon"></i>
                <input class="form-control" type="search" placeholder="Search products..." aria-label="Search">
            </form>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt mr-1"></i>
                            <span>{{ __('Login') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">
                            <i class="fas fa-user-plus mr-1"></i>
                            <span>{{ __('Register') }}</span>
                        </a>
                    </li>
                @else
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-toggle="dropdown">
                                <i class="fas fa-user-shield mr-1"></i>
                                <span>Admin Panel</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt mr-2"></i>
                                    <span>Dashboard</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.products.index') }}">
                                    <i class="fas fa-box mr-2"></i>
                                    <span>Products</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.categories.index') }}">
                                    <i class="fas fa-tags mr-2"></i>
                                    <span>Categories</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.orders.index') }}">
                                    <i class="fas fa-shopping-bag mr-2"></i>
                                    <span>Orders</span>
                                </a>
                            </div>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-user mr-1"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('shop.orders') }}">
                                <i class="fas fa-box mr-2"></i>
                                <span>My Orders</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- /.navbar -->
