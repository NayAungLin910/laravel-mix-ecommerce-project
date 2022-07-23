<style>
    .header {
        height: 30vh;
    }
</style>
<div class="header">
    <div class="w-80">
        <!-- navigation -->
        <div class="nav d-flex justify-content-between pt-3">
            <div class="nav-first d-flex justify-content-between align-items-center">
                <a href="{{ url('/') }}">
                    <img src="assets/images/logo.png" width="50" alt="">
                </a>
                <div class="nav-item-group ml-5">

                    <a href="{{ url('/') }}"
                        class="text-white btn btn btn-outline-warning">{{ __('site.home') }}</a>
                    <a href="{{ url('/product') }}"
                        class="text-white btn btn btn-outline-dark">{{ __('site.product') }}</a>
                    <a href="" class="text-white btn btn btn-outline-dark ">{{ __('site.about') }}</a>

                    <a href="#" class="btn btn-outline-dark cart-container">
                        <i class="fas text-danger  fa-shopping-basket fs-1"></i>
                        <span class="cart-no bg-danger text-white" id="cartCount">{{ $cart_count }}</span>
                    </a>

                </div>
            </div>
            <div class="d-flex jusity-content-center">
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-dark text-white dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Account
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @guest
                                <a class="dropdown-item" href="{{ url('/login') }}">Login</a>
                                <a class="dropdown-item" href="{{ url('/register') }}">Register</a>
                            @endguest
                            @auth
                                <a class="dropdown-item" href="{{ url('/profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ url('/logout') }}">Logout</a>
                            @endauth
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-center align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-dark text-white dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Language
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{ url('/locale/mm') }}">မြန်မာ</a>
                            <a class="dropdown-item" href="{{ url('/locale/en') }}">English</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 d-flex justify-content-center align-items-center">
        <h4 class="text-white">@yield('header-text')</h4>
    </div>
</div>
