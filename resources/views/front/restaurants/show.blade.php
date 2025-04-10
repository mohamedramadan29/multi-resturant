@extends('front.layouts.master')
@section('title')
    {{ $restaurant->name }}
@endsection

@section('content')
    <!-- Content -->
    <div id="content">
        @if (Session::has('Success_message'))
            @php
                toastify()->success(\Illuminate\Support\Facades\Session::get('Success_message'));
            @endphp
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @php
                    toastify()->error($error);
                @endphp
            @endforeach
        @endif
        <!-- Page Title -->
        <div class="hero_section page-title" style="background-image: url('{{ $resturantsetting->getBanner() }}')">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            <div class="container">
                <div class="row no-gutters">
                    <div id="categories-menu" class="categories-container">
                        <ul class="list-unstyled all_categories">
                            @foreach ($categories as $category)
                                <li><a href="#{{ $category['slug'] }}">{{ $category['name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-md-12">
                        @foreach ($categories as $category)
                            <!-- Category Details -->
                            <div id="{{ $category['slug'] }}" class="menu-category">
                                <div class="menu-category-content padded">
                                    <div class="row gutters-sm">
                                        @foreach ($category['products'] as $product)
                                            <div class="col-lg-3 col-12">
                                                <!-- Menu Item -->
                                                <div class="menu-item menu-grid-item">
                                                    @if ($product['is_featured'] == 1)
                                                        <span class="badge bg-success featured-badge">مميز</span>
                                                    @endif
                                                    <img loading="lazy" style="width: 100%" class="mb-4"
                                                        src="{{ $product->getImage() }}" alt="{{ $product['name'] }}" />
                                                    <h6 class="mb-0">{{ $product['name'] }}</h6>
                                                    <div class="row align-items-center mt-4">
                                                        <div class="col-6">
                                                            @if ($product['product_type'] == 'variable')
                                                                @foreach ($product->variations as $variation)
                                                                    <span class="text-md mr-4">
                                                                        <span class="text-muted"></span> <span
                                                                            data-product-base-price class="product-price">
                                                                            {{ $variation['price'] }}
                                                                        </span> <img loading="lazy" width="20px"
                                                                            src="{{ asset('assets/uploads/riyal.svg') }}"
                                                                            alt="">
                                                                    </span>
                                                                @endforeach
                                                            @else
                                                                <span class="text-md mr-4">
                                                                    <span class="text-muted"></span> <span
                                                                        data-product-base-price class="product-price">
                                                                        {{ $product['price'] }}
                                                                        د.ع
                                                                    </span>
                                                            @endif
                                                        </div>
                                                        <div class="col-6 text-sm-right mt-2 mt-sm-0">
                                                            <button class="btn btn-secondary btn-sm add_to_cart"
                                                                data-action="open-cart-modal" data-bs-toggle="modal"
                                                                data-bs-target="#product-modal_{{ $product['id'] }}"
                                                                data-id="1">
                                                                <span> تفاصيل المنتج </span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!----------------------- Product Model -------------->
                                            <!-- Modal / Product -->
                                            <div class="modal fade product-modal" id="product-modal_{{ $product['id'] }}"
                                                tabindex="-1" role="dialog" aria-hidden="true"
                                                aria-labelledby="exampleModalLabel" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header d-flex justify-content-between">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">
                                                                {{ $product['name'] }}
                                                            </h1>
                                                            <button style="margin:0;" type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-product-details">
                                                            <div class="product-image" loading="lazy"
                                                                style="background-image: url('{{ $product->getImage() }}');">
                                                            </div>
                                                            <div class="row align-items-center" style="padding:15px;">
                                                                <div class="col-12">
                                                                    <h6 class="mb-1 product-modal-name">
                                                                        {{ $product['name'] }}</h6>
                                                                    <span
                                                                        class="product-modal-ingredients">{{ $product['description'] }}</span>
                                                                    @if ($product['carb'] != null)
                                                                        <span class="d-block" style="color:#000000">
                                                                            <strong> السعرات الحرارية :
                                                                                {{ $product['carb'] }} سعر حراري</strong>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <form id="addToCart_{{ $product['id'] }}" class=""
                                                            method="post" action="{{ route('cart.add',['restaurant' => $restaurant->slug]) }}">
                                                            <div class="quantity_section">
                                                                <div>
                                                                    <div class="quantity">
                                                                        <div
                                                                            class="quantity-control d-flex align-items-center">
                                                                            <!-- زر تقليل العدد -->
                                                                            <button class="decrease-quantity btn"
                                                                                data-product-id="{{ $product['id'] }}"
                                                                                data-product-price="{{ $product['price'] }}">
                                                                                -
                                                                            </button>
                                                                            <!-- إدخال العدد -->
                                                                            <input id="quantity-{{ $product['id'] }}"
                                                                                type="number" value="1"
                                                                                name="quantity" class="mx-2 text-center"
                                                                                style="width: 60px;" min="1"
                                                                                data-product-id="{{ $product['id'] }}"
                                                                                data-product-price="{{ $product['price'] }}">
                                                                            <!-- زر زيادة العدد -->
                                                                            <button class="increase-quantity btn"
                                                                                data-product-id="{{ $product['id'] }}"
                                                                                data-product-price="{{ $product['price'] }}">
                                                                                +
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- تحديد الحجم إذا كان المنتج متغير -->
                                                                @if ($product['product_type'] == 'variable')
                                                                    <div class="price_section">
                                                                        <label for="product-size-{{ $product['id'] }}"
                                                                            class="form-label mt-2"> اختر الحجم </label>
                                                                        <select required
                                                                            class="form-select mb-3 size-select"
                                                                            id="product-size-{{ $product['id'] }}"
                                                                            name="size"
                                                                            data-product-id="{{ $product['id'] }}">
                                                                            <option value="" selected disabled>اختر
                                                                                الحجم
                                                                            </option> <!-- خيار افتراضي -->
                                                                            @foreach ($product['variations'] as $variation)
                                                                                <option value="{{ $variation['id'] }}"
                                                                                    data-price="{{ $variation['price'] }}">
                                                                                    {{ $variation['size'] }} -
                                                                                    {{ $variation['price'] }}
                                                                                    د.ع
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                @else
                                                                    <div class="price_section">
                                                                        <span id="total-price-{{ $product['id'] }}"
                                                                            class="product-modal-price">{{ $product['price'] }}
                                                                            د.ع
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            @csrf
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product['id'] }}">
                                                            <input type="hidden"
                                                                id="hidden-quantity-{{ $product['id'] }}" name="number"
                                                                value="1">
                                                            <input type="hidden" id="hidden-price-{{ $product['id'] }}"
                                                                name="price" value="{{ $product['price'] }}">

                                                            @if ($product['product_type'] == 'variable')
                                                                <input type="hidden"
                                                                    id="hidden-size-{{ $product['id'] }}" name="size">
                                                            @endif

                                                            <div class="row align-items-center">
                                                                <button type="submit"
                                                                    id="addtocartbutton_{{ $product['id'] }}"
                                                                    class="btn btn-secondary btn-block btn-lg">
                                                                    اضف الى السلة
                                                                </button>
                                                            </div>
                                                        </form>

                                                        <script>
                                                            $(document).ready(function() {
                                                                $(".size-select").on('change', function() {
                                                                    var selectedOption = $(this).find(":selected");
                                                                    var newPrice = selectedOption.data("price");
                                                                    var productId = $(this).data("product-id");

                                                                    if (selectedOption.val() !== "") { // تأكد من أن الحجم ليس الخيار الافتراضي
                                                                        $("#hidden-price-" + productId).val(newPrice);
                                                                        $("#hidden-size-" + productId).val(selectedOption.val());
                                                                    }
                                                                });


                                                                // منع الإرسال فقط إذا كان المنتج من النوع variable
                                                                $("#addToCart_{{ $product['id'] }}").on("submit", function(e) {
                                                                    var productType = @json($product['product_type']); // استرجاع نوع المنتج
                                                                    if (productType === 'variable') {
                                                                        var productId = $(this).find(".size-select").data("product-id");
                                                                        var selectedSize = $("#hidden-size-" + productId).val();
                                                                        if (!selectedSize) {
                                                                            alert("يرجى اختيار الحجم قبل إضافة المنتج إلى السلة.");
                                                                            e.preventDefault(); // منع الإرسال
                                                                        }
                                                                    }
                                                                });
                                                            });
                                                        </script>



                                                    </div>
                                                </div>
                                            </div>
                                            <!--------------------- End Product Model ---------------->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content / End -->

    </div>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // زيادة العدد
            document.querySelectorAll(".increase-quantity").forEach(button => {
                button.addEventListener("click", function($e) {
                    $e.preventDefault();
                    const productId = this.dataset.productId;
                    const productPrice = parseFloat(this.dataset.productPrice);
                    const quantityInput = document.getElementById(`quantity-${productId}`);
                    const hiddenQuantityInput = document.getElementById(
                        `hidden-quantity-${productId}`);
                    const totalPriceElement = document.getElementById(`total-price-${productId}`);

                    // زيادة العدد
                    let quantity = parseInt(quantityInput.value);
                    quantity++;
                    quantityInput.value = quantity;
                    hiddenQuantityInput.value = quantity; // تحديث الحقل المخفي

                    // تحديث المجموع
                    const totalPrice = (quantity * productPrice).toFixed(2);
                    totalPriceElement.textContent = totalPrice;
                });
            });

            // تقليل العدد
            document.querySelectorAll(".decrease-quantity").forEach(button => {
                button.addEventListener("click", function($e) {
                    $e.preventDefault();
                    const productId = this.dataset.productId;
                    const productPrice = parseFloat(this.dataset.productPrice);
                    const quantityInput = document.getElementById(`quantity-${productId}`);
                    const hiddenQuantityInput = document.getElementById(
                        `hidden-quantity-${productId}`);
                    const totalPriceElement = document.getElementById(`total-price-${productId}`);

                    // تقليل العدد (إذا كان أكبر من 1)
                    let quantity = parseInt(quantityInput.value);
                    if (quantity > 1) {
                        quantity--;
                        quantityInput.value = quantity;
                        hiddenQuantityInput.value = quantity; // تحديث الحقل المخفي

                        // تحديث المجموع
                        const totalPrice = (quantity * productPrice).toFixed(2);
                        totalPriceElement.textContent = totalPrice;
                    }
                });
            });

            // تحديث الحقل المخفي عند إدخال الكمية يدويًا
            document.querySelectorAll("input[type='number']").forEach(input => {
                input.addEventListener("input", function() {
                    const productId = this.dataset.productId;
                    const productPrice = parseFloat(this.dataset.productPrice);
                    const quantity = parseInt(this.value);
                    const hiddenQuantityInput = document.getElementById(
                        `hidden-quantity-${productId}`);
                    const totalPriceElement = document.getElementById(`total-price-${productId}`);

                    if (quantity >= 1) {
                        hiddenQuantityInput.value = quantity; // تحديث الحقل المخفي

                        // تحديث المجموع
                        const totalPrice = (quantity * productPrice).toFixed(2);
                        totalPriceElement.textContent = totalPrice;
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categoriesMenu = document.getElementById("categories-menu");
            const categoryLinks = document.querySelectorAll(".all_categories li a");
            const sections = document.querySelectorAll(".menu-category");

            const menuOffset = categoriesMenu.offsetTop;

            function handleScroll() {
                if (window.scrollY >= menuOffset) {
                    categoriesMenu.classList.add("fixed-menu");
                } else {
                    categoriesMenu.classList.remove("fixed-menu");
                }

                let currentSection = "";
                sections.forEach((section) => {
                    const sectionTop = section.offsetTop - 150; // تعديل ليعمل مع القائمة الثابتة
                    if (window.scrollY >= sectionTop) {
                        currentSection = section.getAttribute("id");
                    }
                });

                categoryLinks.forEach((link) => {
                    link.classList.remove("active");
                    if (link.getAttribute("href").slice(1) === currentSection) {
                        link.classList.add("active");
                    }
                });
            }

            window.addEventListener("scroll", handleScroll);

            // تنقل سلس عند الضغط على أي عنصر من القائمة
            categoryLinks.forEach((link) => {
                link.addEventListener("click", function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute("href").slice(1);
                    document.getElementById(targetId).scrollIntoView({
                        behavior: "smooth",
                        block: "start"
                    });
                });
            });
        });
    </script>
    <script></script>
@endsection
