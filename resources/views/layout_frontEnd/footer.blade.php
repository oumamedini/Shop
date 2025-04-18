<!-- Main Footer -->
<footer class="footer-shop">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>About Us</h5>
                <p>Your trusted online store for quality products. We provide the best shopping experience with a wide range of products and excellent customer service.</p>
                <div class="social-links mt-3">
                    <a href="#"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4 mb-md-0">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('shop.index') }}" class="text-muted">Shop</a></li>
                    <li class="mb-2"><a href="{{ route('shop.cart') }}" class="text-muted">Cart</a></li>
                    @auth
                        <li class="mb-2"><a href="{{ route('shop.orders') }}" class="text-muted">My Orders</a></li>
                    @else
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-muted">Login</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-muted">Register</a></li>
                    @endauth
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contact Info</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 text-muted"><i class="fas fa-map-marker-alt mr-2"></i>123 Street, City, Country</li>
                    <li class="mb-2 text-muted"><i class="fas fa-phone mr-2"></i>+1 234 567 890</li>
                    <li class="mb-2 text-muted"><i class="fas fa-envelope mr-2"></i>info@example.com</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-left">
                <p class="mb-0">Copyright &copy; 2025 <a href="#" class="text-primary">SOME</a>. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-right">
                <p class="mb-0 text-muted">Version 1.0</p>
            </div>
        </div>
    </div>
</footer>