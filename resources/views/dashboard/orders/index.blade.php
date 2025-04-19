orders
@extends('dashboard.layouts.app')
@section('title', ' ادارة الطلبات ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> ادارة الطلبات </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> ادارة الطلبات
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="content-header-right col-md-6 col-12">

                </div>
            </div>
            <div class="content-body">

                <!-- Bordered striped start -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <form action="{{ request()->url() }}" method="get">
                                    @csrf
                                    <label> بحث بين تاريخ </label>
                                    <div class="d-flex gap-1">
                                        <input type="date" name="from_date" class="form-control"
                                            value="{{ request()->from_date }}">
                                        <input type="date" name="to_date" class="form-control"
                                            value="{{ request()->to_date }}">
                                        <button type="submit" class="btn btn-primary"> بحث </button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th> رقم الطلب </th>
                                                    <th> اسم العميل </th>
                                                    <th> رقم الهاتف </th>
                                                    <th> طريقة الاستلام  </th>

                                                    <th> قيمة الشحن   </th>
                                                    <th> الاجمالي </th>
                                                    {{-- <th> حالة الطلب </th> --}}
                                                    <th> العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($orders as $order)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td> {{ $order['name'] }} </td>
                                                        <td> {{ $order['phone'] }} </td>
                                                        <td>
                                                            @if($order['payment_type'] == 'delivery')
                                                                <span class="badge badge-info bg-info"> توصيل </span>
                                                                @else
                                                                <span class="badge badge-info bg-success"> استلام داخل المطعم </span>
                                                            @endif
                                                            </td>

                                                        <td> {{$order['shipping_price']}} د.ع </td>
                                                        <td> {{ $order['grand_total'] }} د.ع </td>
                                                        {{-- <td>
                                                            @if ($order['order_status'] == 'لم يبدا')
                                                                <span class="badge badge-info bg-warning">
                                                                    {{ $order['order_status'] }} </span>
                                                            @elseif($order['order_status'] == 'بداية التنفيذ')
                                                                <span class="badge badge-info bg-info">
                                                                    {{ $order['order_status'] }}
                                                                </span>
                                                            @elseif($order['order_status'] == 'مكتمل')
                                                                <span class="badge badge-info bg-success">
                                                                    {{ $order['order_status'] }} </span>
                                                            @elseif($order['order_status'] == 'ملغي')
                                                                <span class="badge badge-info bg-danger">
                                                                    {{ $order['order_status'] }} </span>
                                                            @endif
                                                        </td> --}}
                                                        <td>
                                                            <a class="btn btn-info btn-sm"
                                                                href="{{ route('dashboard.orders.update', $order->id) }}"><i
                                                                    class="la la-edit"></i> تفاصيل الطلب </a>
                                                            <a class="btn btn-warning btn-sm"
                                                                href="{{ route('dashboard.orders.print', $order->id) }}"><i
                                                                    class="la la-print"></i> طباعة الفاتورة </a>

                                                            {{-- <button type="button" class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#delete_order_{{ $order->id }}">
                                                                حذف <i class="la la-trash"></i>
                                                            </button> --}}
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <td colspan="6"> لا يوجد طلبات حتي الان </td>
                                                    <!-- Modal -->
                                                    @include('dashboard.orders.delete')
                                                @endforelse
                                            </tbody>
                                        </table>
                                        {{ $orders->links() }}

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bordered striped end -->
            </div>
        </div>
    </div>


@endsection
