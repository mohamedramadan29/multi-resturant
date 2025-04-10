@php
    $categories = \App\Models\dashboard\Category::where('status', 1)->get();
    $cartCount = \App\Models\front\Cart::getcartitems($resturantsetting->resturant_id)->count();
    $carttotal = \App\Models\front\Cart::getcarttotal($resturantsetting->resturant_id);
@endphp
<!-- Body Wrapper -->
<div id="body-wrapper">
    <!-- Header Desktop -->
    <header id="header" class="light">
        <div class="container">
            <div class="row desktop-header">
                <div class="col-md-3">
                    <div class="module module-logo dark">
                        @if (isset($restaurant))
                            <a class="index_page"
                                href="{{ route('restaurant.show', ['restaurant' => $restaurant->slug]) }}">
                                <img src="{{ $resturantsetting->getLogo() }}" alt="{{ $resturantsetting->name }}"
                                    width="150px" />
                            </a>
                        @else
                            <a class="index_page" href="{{ url('/') }}">
                                <img src="{{ $resturantsetting->getLogo() }}" alt="{{ $resturantsetting->name }}"
                                    width="150px" />
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    @if (isset($restaurant))
                        <ul class="items-menu list-unstyled">
                            <li><a href="{{ route('restaurant.show', ['restaurant' => $restaurant->slug]) }}"> القائمة
                                </a></li>
                            {{-- <li><a href=""> حسابي </a></li>
                            <li><a href=""> اتصل بنا </a></li> --}}
                        </ul>
                    @else
                        <ul class="items-menu list-unstyled">
                            <li><a href="{{ route('index') }}"> الرئيسية
                                </a></li>
                            {{-- <li><a href=""> حسابي </a></li>
                            <li><a href=""> اتصل بنا </a></li> --}}
                        </ul>
                    @endif
                </div>
                <div class="col-md-2">
                    <a class="module module-cart right" data-bs-toggle="offcanvas" data-bs-target="#offcanvascart"
                        role="button">
                        <span class="cart-icon">
                            <i class="bi bi-bag-heart-fill"></i>
                            <span class="notification1">{{ $cartCount }}</span>
                        </span>
                        <span class="cart-value"> <span>{{ number_format($carttotal) }}</span> د.ع </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Header Mobile -->
    <header id="header-mobile" class="light">
        <div class="module module-nav-toggle">
            <a href="#" id="nav-toggle">
                <span></span><span></span><span></span><span></span>
            </a>
        </div>
        <div>
            @if (isset($restaurant))
                <a class="index_page" href="{{ route('restaurant.show', ['restaurant' => $restaurant->slug]) }}">
                    <img src="{{ $resturantsetting->getLogo() }}" alt="{{ $resturantsetting->name }}"
                        width="150px" />
                </a>
            @else
                <a class="index_page" href="{{ url('/') }}">
                    <img src="{{ $resturantsetting->getLogo() }}" alt="{{ $resturantsetting->name }}"
                        width="150px" />
                </a>
            @endif
        </div>
        <a class="module module-cart right" data-bs-toggle="offcanvas" data-bs-target="#offcanvascart" role="button">
            <i class="bi bi-bag-heart-fill"></i>
            <span class="notification1">{{ $cartCount }}</span>
        </a>
    </header>

    <!-- Header / End -->
    <!-- القائمة المنسدلة -->
    <div id="dropdownMenu" class="dropdown-menu">
        <ul class="menu-items">
            @if (isset($restaurant))
                {{-- قائمة خاصة بالمطعم --}}
                <li><a href="{{ route('restaurant.show', ['restaurant' => $restaurant->slug]) }}"><i class="bi bi-menu-up"></i>
                        القائمة </a></li>
                {{-- <li><a href="{{ route('account', ['restaurant' => $restaurant->slug]) }}"><i class="bi bi-person"></i>
                        حسابي </a></li>
                <li><a href="{{ route('contact', ['restaurant' => $restaurant->slug]) }}"><i
                            class="bi bi-telephone"></i>
                        اتصل بنا</a></li> --}}
            @else
                {{-- قائمة عامة للموقع بدون مطعم --}}
                <li><a href="#><i class="bi bi-house"></i> الرئيسية </a></li>
                {{-- <li><a href="#"><i class="bi bi-shop"></i> المطاعم </a></li>
                <li><a href="#"><i class="bi bi-telephone"></i> اتصل بنا </a></li> --}}
            @endif

            @if (Auth::check())
                {{-- <li><a href="{{ route('user.logout', ['restaurant' => $restaurant->slug]) }}"><i
                            class="bi bi-box-arrow-in-right"></i> تسجيل الخروج</a>
                </li> --}}
            @else
                {{-- <li><a class="checkout_button"
                        href="{{ route('check.login.status', ['restaurant' => $restaurant->slug]) }}"><i
                            class="bi bi-box-arrow-in-right"></i> تسجيل الدخول</a></li> --}}
            @endif
        </ul>
    </div>



    @include('front.partials.cart_items')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Mobile Nav Toggle  -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const navToggle = document.getElementById("nav-toggle");
            const dropdownMenu = document.getElementById("dropdownMenu");

            // عند الضغط على زر القائمة
            navToggle.addEventListener("click", function(e) {
                e.preventDefault();
                console.log("clicked"); // تحقق أن الزر يعمل
                dropdownMenu.classList.toggle("active");
            });

            // إغلاق القائمة عند الضغط خارجها
            document.addEventListener("click", function(e) {
                if (!navToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove("active");
                }
            });
        });
    </script>
    <!-- End Mobile Nav Toggle  -->
