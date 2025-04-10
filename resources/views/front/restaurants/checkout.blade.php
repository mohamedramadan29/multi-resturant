@extends('front.layouts.master')
@section('title')
    اتمام الطلب
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
        {{-- <div class="hero_section page-title" style="background-image: url('{{ asset('assets/front/uploads/slogan2.png') }}')">
            <div class="container">
                <div class="row">
                </div>
            </div>
        </div> --}}
        <!-- Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="cart-details shadow bg-white stick-to-content mb-4">
                            @php
                                $session_id = \Illuminate\Support\Facades\Session::get('session_id');
                                $cartItems = App\Models\front\Cart::getcartitems($resturantsetting->resturant_id);
                                $total_price = 0;
                            @endphp

                            <div class="bg-dark dark p-4">
                                <h5 class="mb-0"> مراجعة الطلب </h5>
                            </div>
                            @if ($cartItems->count() > 0)
                                <table class="cart-table1">
                                    @foreach ($cartItems as $item)
                                        @php
                                            $total_price = intval($total_price + $item['total_price']);
                                        @endphp
                                        <tr>
                                            <td class="title">
                                                <span class="name"><a href="#product-modal" data-toggle="modal">
                                                        {{ $item['name'] }} </a></span>
                                                <span class="caption text-muted"> {{ $item['productdata']['name'] }} </span>
                                                @if ($item['size'])
                                                    <span class="caption badge badge-danger"> | {{ $item['size'] }} </span>
                                                @endif
                                            </td>
                                            <td class="price cart-total1" data-id="{{ $item['id'] }}">
                                                {{ number_format($item['total_price']) }} </td>
                                            <td class="actions">
                                                <div class="tf-mini-cart-btns">
                                                    <div class="wg-quantity small">
                                                        <span class="btn-quantity minus-btn"
                                                            data-id="{{ $item['id'] }}">-</span>
                                                        <input type="number" name="number" data-id="{{ $item['id'] }}"
                                                            value="{{ $item['qty'] }}" min="1">
                                                        <span class="btn-quantity plus-btn"
                                                            data-id="{{ $item['id'] }}">+</span>
                                                    </div>
                                                </div>
                                                <form method="post" action="{{ url('cart/delete/' . $item['id']) }}">
                                                    @csrf
                                                    <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                                                    <button type="submit" class="tf-mini-cart-remove"><i
                                                            class="bi bi-trash-fill"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                                <div class="cart-summary1">
                                    {{-- <div class="row">
                                    <div class="col-7 text-right text-muted">Order total:</div>
                                    <div class="col-5"><strong>$<span class="cart-products-total">0.00</span></strong>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7 text-right text-muted">Devliery:</div>
                                    <div class="col-5"><strong>$<span class="cart-delivery">0.00</span></strong></div>
                                </div> --}}
                                    <hr class="hr-sm">
                                    <div class="row text-lg">
                                        <div class="col-7 text-right text-muted"> الاجمالي :</div>
                                        <div class="col-5">
                                            <strong> <span
                                                    class="cart-total1 total-value">{{ number_format($total_price) }}</span>
                                                د.ع
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="cart-empty">
                                    <i class="ti ti-shopping-cart"></i>
                                    <p> سلة الشراء فارغة </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 order-lg-first">
                        <form method="post" action="{{ route('order.store',['restaurant' => $restaurant->slug]) }}">
                            @csrf
                            <div class="bg-white p-4 p-md-5 mb-4">
                                <h4 class="border-bottom pb-4" style="font-weight: 500"><i
                                        class="bi bi-person text-primary"></i> مراجعة البيانات
                                </h4>
                                <div class="row mb-5">
                                    {{-- <div class="form-group col-sm-6">
                                        <label> الاسم : <span class="text-danger"> * </span> </label>
                                        <input required type="text" class="form-control" name="name"
                                            value="{{ Auth::user()->name }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label> رقم الهاتف : <span class="text-danger"> * </span></label>
                                        <input readonly type="text" class="form-control" name="phone"
                                            value="{{ Auth::user()->phone }}">
                                    </div> --}}
                                    <div class="form-group col-sm-6">
                                        <label> رقم الطاولة  : <span class="text-danger"> * </span> </label>
                                        <input required type="number" class="form-control" name="table_number"
                                            value="{{ old('table_number') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label> ملاحظات : </label>
                                        <textarea name="notes" id="" cols="10" rows="4" class="form-control"></textarea>
                                    </div>
                                </div>


                            </div>
                            <div class="text-center">
                                <button class="btn btn-primary btn-lg"><span> ارسال الطلب </span></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
    @endsection


    @section('js')
        <script>
            $(document).ready(function() {
                // زيادة الكمية عند الضغط على الزر +
                $('.plus-btn').off('click').on('click', function(e) {
                    e.preventDefault(); // منع السلوك الافتراضي

                    let itemId = $(this).data('id');
                    let inputField = $('input[name="number"][data-id="' + itemId + '"]');
                    let newQuantity = parseInt(inputField.val()) + 1;
                    updateCart(itemId, newQuantity);
                });

                // نقصان الكمية عند الضغط على الزر -
                $('.minus-btn').off('click').on('click', function(e) {
                    e.preventDefault(); // منع السلوك الافتراضي
                    let itemId = $(this).data('id');
                    let inputField = $('input[name="number"][data-id="' + itemId + '"]');
                    let newQuantity = parseInt(inputField.val()) - 1;
                    if (newQuantity > 0) {
                        updateCart(itemId, newQuantity);
                    }
                });

                // تحديث الكمية عند كتابة المستخدم كمية مباشرة في حقل الإدخال
                $('input[name="number"]').off('input').on('input', function(e) {
                    let itemId = $(this).data('id');
                    let newQuantity = parseInt($(this).val());
                    // التأكد من أن القيمة المدخلة صحيحة وأن الكمية أكبر من 0
                    if (!isNaN(newQuantity) && newQuantity > 0) {
                        updateCart(itemId, newQuantity);
                    }
                });

                // تحديث الكمية في السلة
                function updateCart(itemId, newQuantity) {
                    $.ajax({
                        // url: '/cart/update',
                        url: '/' + "{{ $restaurant->slug }}" + '/cart/update',
                        method: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}", // تأكيد الحماية ضد CSRF
                            "item_id": itemId,
                            "quantity": newQuantity
                        },
                        success: function(response) {
                            // تحديث الكميات والأسعار بناءً على الاستجابة
                            $('input[name="number"][data-id="' + itemId + '"]').val(newQuantity);

                            // تحديث المجموع لكل منتج
                            $('.cart-total1[data-id="' + itemId + '"]').text(response
                                .itemTotal.toFixed(2));

                            // تحديث المجموع الفرعي (Subtotal)
                            $('.total-value').text(response.subtotal.toFixed(2));
                        },
                        error: function(xhr) {
                            console.log('Error updating cart');
                        }
                    });
                }
            });
        </script>
    @endsection
