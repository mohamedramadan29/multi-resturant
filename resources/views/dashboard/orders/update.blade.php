@extends('dashboard.layouts.app')
@section('title')
    تفاصيل الطلب
@endsection
@section('css')
@endsection
@section('content')
    <!-- ==================================================== -->
    <div class="app-content content">
        <div class="content-wrapper">

            <!-- Start Container Fluid -->
            <div class="container-xxl">
                <form method="post" action="{{ url('dashboard/orders/update/' . $order['id']) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 ">
                            @if ($errors->any())
                                @foreach ($errors->all() as $error)
                                    @php
                                        toastify()->error($error);
                                    @endphp
                                @endforeach
                            @endif
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> معلومات   </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label"> رقم الطاولة </label>
                                                <input disabled required type="text" id="table_number" class="form-control"
                                                    name="name" value="{{ $order['table_number'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label"> ملاحظات </label>
                                                <textarea class="form-control" disabled readonly name="" id="">{{ $order['notes'] }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> تفاصيل الطلب </h4>
                                </div>
                                <div class="card-body">
                                    <table class="table-bordered table">
                                        <thead>
                                            <tr>
                                                <th> المنتج </th>
                                                <th> العدد </th>
                                                <th> السعر </th>

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


                                                    <td> {{ number_format($detail['product_qty'] * $detail['product_price'], 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4"> السعر الكلي </td>
                                                <td colspan="2">
                                                    <strong class="text-danger">
                                                        {{ number_format($order['grand_total'], 2) }} </strong>


                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> حالة الطلب </h4>
                                </div>
                                <div class="card-body">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label"> تحديث حالة الطلب </label>
                                            <select class="form-select" name="order_status">
                                                <option value="" selected disabled> -- حدد حالة الطلب --</option>
                                                <option {{ $order['order_status'] == 'لم يبدا' ? 'selected' : '' }}
                                                    value="لم يبدا">لم يبدأ</option>
                                                <option {{ $order['order_status'] == 'بداية التنفيذ' ? 'selected' : '' }}
                                                    value="بداية التنفيذ"> بداية التنفيذ </option>
                                                <option {{ $order['order_status'] == 'مكتمل' ? 'selected' : '' }}
                                                    value="مكتمل">مكتمل </option>
                                                <option {{ $order['order_status'] == 'ملغي' ? 'selected' : '' }}
                                                    value="ملغي">ملغي</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}


                            <div class="form-actions">
                                {{-- <button type="submit" class="btn btn-primary">
                                    <i class="la la-check-square-o"></i> تحديث حالة الطلب
                                </button> --}}
                                <a href="{{ route('dashboard.orders.index') }}" type="button"
                                    class="mr-1 btn btn-warning">
                                    <i class="ft-x"></i> رجوع
                                </a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Container Fluid -->


    <!-- ==================================================== -->
    <!-- End Page Content -->
    <!-- ==================================================== -->
@endsection

@section('js')
@endsection
