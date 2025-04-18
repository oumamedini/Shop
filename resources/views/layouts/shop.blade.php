<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hanout') }} - Shop</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #7C3AED;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F3F4F6;
        }

        .navbar-shop {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .navbar-shop .navbar-brand {
            color: #fff !important;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .navbar-shop .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .navbar-shop .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }

        .product-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #fff;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
            transition: all 0.3s ease;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-card .card-body {
            padding: 1.5rem;
        }

        .product-card .card-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .product-card .price {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.2rem;
        }

        .btn-cart {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(79, 70, 229, 0.2);
            color: #fff;
        }

        .cart-badge {
            position: relative;
            top: -8px;
            right: -8px;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            background: #DC2626;
            color: #fff;
            border-radius: 6px;
        }

        .footer-shop {
            background: #fff;
            padding: 2rem 0;
            margin-top: 4rem;
            border-top: 1px solid #E5E7EB;
        }

        .footer-shop h5 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #1F2937;
        }

        .footer-shop p {
            color: #6B7280;
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .footer-shop .social-links a {
            color: #6B7280;
            margin-right: 1rem;
            transition: all 0.2s ease;
        }

        .footer-shop .social-links a:hover {
            color: var(--primary-color);
        }

        .category-badge {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: #fff;
            padding: 0.35em 0.75em;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .search-form {
            position: relative;
        }

        .search-form input {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            padding-left: 2.5rem;
            background: rgba(255,255,255,0.1);
            color: #fff;
            width: 300px;
        }

        .search-form input::placeholder {
            color: rgba(255,255,255,0.7);
        }

        .search-form .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.7);
        }
    </style>
    @stack('styles')
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        @include('layout_frontEnd.header')

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="container py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

        @include('layout_frontEnd.footer')
    </div>

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Custom Scripts -->
    @stack('scripts')
</body>
</html>
