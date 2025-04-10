@extends('dashboard.layouts.app')
@section('title', ' طباعة الطلب ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> طباعة الطلب </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية</a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.orders.index') }}">الطلبات</a>
                                </li>
                                <li class="breadcrumb-item active"> طباعة الطلب
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <input type="hidden" value="{{ $order->name }}" id="customername">
                <section class="card">
                    <div id="invoice-template" class="card-body">
                        <!-- Invoice Company Details -->
                        <div id="invoice-company-details d-flex" class="row">
                            <div class="text-left col-md-6 col-sm-6">
                                <div class="media">
                                    <img width="200px" src="{{ $setting->getLogo() }}" alt="company logo" class="" />
                                </div>
                            </div>
                            <div class="text-right col-md-6 col-sm-6">
                                <h2> رقم الطلب </h2>
                                <p class="pb-3"> Num-{{ $order->id }}</p>

                            </div>
                        </div>
                        <!--/ Invoice Company Details -->
                        <!-- Invoice Customer Details -->
                        <div id="invoice-customer-details" class="pt-2 row">
                            <div class="text-left col-md-6 col-sm-6">
                                <p class="text-muted"> السيد / ة </p>
                                <ul class="px-0 list-unstyled">
                                    <li class="text-bold-800"> {{ $order->name }}</li>
                                    <li> {{ $order->phone }} </li>
                                </ul>
                            </div>
                            <div class="text-right col-md-6 col-sm-6">
                                <p>
                                    <span class="text-muted"> تاريخ الطلب :</span> {{ $order->created_at }}
                                </p>
                            </div>
                        </div>
                        <!--/ Invoice Customer Details -->
                        <!-- Invoice Items Details -->
                        <div id="invoice-items-details" class="pt-2">
                            <div class="row">
                                <div class="table-responsive col-sm-12">
                                    <table class="table-bordered table">
                                        <thead>
                                            <tr>
                                                <th> المنتج </th>
                                                <th> العدد </th>
                                                <th> السعر </th>
                                                <th> رقم الطاولة  </th>
                                                <th> السعر الكلي </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($order['details'] as $detail)
                                                <tr>
                                                    <td> {{ $detail['product_name'] }}
                                                        @if ($detail['size'])
                                                            <span class="caption badge badge-danger bg-danger">
                                                                {{ $detail['size'] }}
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td> {{ $detail['product_qty'] }} </td>
                                                    <td> {{ $detail['product_price'] }} </td>
                                                    <td> {{ $order['table_number'] }} </td>
                                                    <td> {{ number_format($detail['product_qty'] * $detail['product_price'], 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="3"> السعر الكلي </td>
                                                <td colspan="2">
                                                    <strong class="text-danger">
                                                        {{ number_format($order['grand_total'], 2) }} </strong>


                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="text-center col-md-7 col-sm-12 text-md-left">
                                    <p class="lead"> للاستفسارات :</p>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <table class="table table-borderless table-sm">
                                                <tbody>
                                                    <tr>
                                                        <td> الإدارة :</td>
                                                        <td class="text-right"> {{ $setting->phone }} </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Invoice Footer -->
                        <div id="invoice-footer">
                            <div class="row">
                                <div class="text-center col-md-5 col-sm-12">
                                    <button onclick="setPrintTitle(); window.print();" type="button"
                                        class="my-1 btn btn-info btn-lg print_button"><i class="la la-paper-plane-o"></i>
                                        طباعة </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection


<style>
    @media print {
        footer {
            display: none;
        }

        .header-navbar .navbar-wrapper,
        body.vertical-layout.vertical-menu.menu-expanded .main-menu,
        .content-wrapper .content-header {
            display: none;
            width: 0
        }

        body.vertical-layout.vertical-menu.menu-expanded .content {
            margin-right: 0 !important;
        }

        @page {
            margin: 0;
            padding: 0;
            background-color: #fff
        }

        html body .content .content-wrapper {
            background-color: #fff;
        }

        .print_button {
            display: none !important;
        }
    }
</style>

<script>
    function setPrintTitle() {
        // تعيين عنوان مخصص للصفحة ليتم طباعته
        document.title = document.getElementById('customername').value;

        // التأكد من أن العنوان الجديد قد تم تعيينه بشكل صحيح
        console.log("تم تعيين عنوان مخصص للطباعة: " + document.title);

        // إضافة استماع لحدث اكتمال الطباعة لاستعادة العنوان الأصلي بعد الطباعة
        window.onafterprint = function() {
            document.title = document.getElementById('customername').value;
            console.log("استعادة عنوان الصفحة الأصلي: " + document.title);
        };
    }
</script>
