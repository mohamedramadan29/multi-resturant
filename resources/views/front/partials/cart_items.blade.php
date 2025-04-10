<div class="offcanvas offcanvas-start cart-offcanvas" tabindex="-1" id="offcanvascart"
    aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">سلة الشراء</h5>

    </div>
    <div class="offcanvas-body">
        <div class="panel-cart-content cart-details">
            @php
                $session_id = \Illuminate\Support\Facades\Session::get('session_id');
                $cartItems = App\Models\front\Cart::getcartitems($resturantsetting->resturant_id);
                $total_price = 0;
            @endphp

            @if ($cartItems->count() > 0)
                <table class="cart-table1">
                    @foreach ($cartItems as $item)
                        @php
                            $total_price = intval($total_price + $item['total_price']);
                        @endphp
                        <tr>
                            <td class="title">
                                <span class="name"><a href="#product-modal" data-toggle="modal"> {{ $item['name'] }}
                                    </a></span>
                                <span class="caption text-muted"> {{ $item['productdata']['name'] }} </span>
                                @if ($item['size'])
                                    <span class="caption badge badge-danger"> {{ $item['size'] }} </span>
                                @endif
                            </td>
                            <td class="price cart-total1" data-id="{{ $item['id'] }}">
                                {{ number_format($item['total_price']) }} </td>
                            <td class="actions">
                                <div class="tf-mini-cart-btns">
                                    <div class="wg-quantity small">
                                        <span class="btn-quantity minus-btn" data-id="{{ $item['id'] }}">-</span>
                                        <input type="number" name="number" data-id="{{ $item['id'] }}"
                                            value="{{ $item['qty'] }}" min="1">
                                        <span class="btn-quantity plus-btn" data-id="{{ $item['id'] }}">+</span>
                                    </div>
                                </div>
                                <form method="post"
                                    action="{{ route('cart.delete', ['id' => $item['id'], 'restaurant' => $restaurant->slug]) }}">
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
                        <div class="col-7 text-right text-muted"> المجموع الفرعي :</div>
                        <div class="col-5">
                            <strong> <span class="cart-products-total1"> {{ number_format($total_price, 2) }} </span> د.ع
                            </strong>
                        </div>
                    </div> --}}
                    {{-- <div class="row">
                        <div class="col-7 text-right text-muted">التوصيل :</div>
                        <div class="col-5">
                            <strong>$<span class="cart-delivery">0.00</span></strong>
                        </div>
                    </div> --}}
                    <div class="row text-lg">
                        <div class="col-7 text-right text-muted"> الاجمالي :</div>
                        <div class="col-5">
                            <strong> <span class="cart-total1 total-value">{{ number_format($total_price) }}</span>
                                د.ع
                            </strong>
                        </div>
                    </div>
                    {{-- <a href="{{ route('checkout',['restaurant' => $restaurant->slug]) }}" class="btn btn-primary checkout_button complete_order">إتمام
                        الطلب</a> --}}
                        <a href="{{ route('checkout',['restaurant' => $restaurant->slug]) }}" class="btn btn-primary complete_order">إتمام
                            الطلب</a>
                </div>
            @else
                <div class="cart-empty">
                    <i class="ti ti-shopping-cart"></i>
                    <p> سلة الشراء فارغة </p>
                </div>
            @endif
        </div>

    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                //url: '/cart/update',
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
