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

                                                    {{-- <th> قيمة الشحن   </th> --}}
                                                    <th> الاجمالي </th>
                                                    <th> حالة الطلب </th>
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

                                                        {{-- <td> {{$order['shipping_price']}} </td> --}}
                                                        <td> {{ $order['grand_total'] }} </td>
                                                        <td>
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
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="{{ url('admin/order/update/' . $order['id']) }}"
                                                                    class="btn btn-soft-primary btn-sm">
                                                                    <iconify-icon icon="solar:pen-2-broken"
                                                                        class="align-middle fs-18"></iconify-icon>
                                                                </a>
                                                                {{-- <a href="{{url('admin/order/print/'.$order['id'])}}" class="btn btn-soft-primary btn-sm">
                                                                <i class='bx bxs-printer'></i>
                                                            </a>
                                                            <button type="button" class="btn btn-soft-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete_category_{{$order['id']}}">
                                                                <iconify-icon icon="solar:trash-bin-minimalistic-2-broken"
                                                                              class="align-middle fs-18"></iconify-icon>
                                                            </button> --}}
                                                            </div>
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
