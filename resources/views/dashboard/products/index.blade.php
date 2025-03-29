@extends('dashboard.layouts.app')
@section('title', ' ادارة المنتجات ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> ادارة المنتجات </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> ادارة المنتجات
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
                                <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary"> اضافة منتج </a>
                            </div>
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <thead class="bg-light-subtle">
                                                <tr>
                                                    <th style="width: 20px;">
                                                    </th>
                                                    <th> اسم المنتج </th>
                                                    <th> القسم </th>
                                                    <th> السعر </th>
                                                    <th> الصورة </th>
                                                    <th> المنتج مميز </th>
                                                    <th> العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($products as $product)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        <td><a
                                                                href="{{ url('admin/product/update/' . $product['slug']) }}"></a>
                                                            {{ $product['name'] }} </td>
                                                        <td> {{ $product['Main_Category']['name'] }} </td>
                                                        <td> {{ $product['price'] }} </td>
                                                        <td>
                                                            <img class="img-thumbnail"
                                                                src="{{ $product->getImage() }}"
                                                                width="80" height="80px" alt="">
                                                        </td>
                                                        <td>
                                                            @if ($product['is_featured'] == 1)
                                                                <span class="badge bg-success">مميز</span>
                                                            @else
                                                                <span class="badge bg-danger">غير مميز</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-info btn-sm"
                                                                href="{{ route('dashboard.products.update', $product->id) }}"><i
                                                                    class="la la-edit"></i> تعديل </a>
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#delete_product_{{ $product->id }}">
                                                                حذف <i class="la la-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Modal -->
                                                    @include('dashboard.products.delete')
                                                    @empty
                                                    <td colspan="7"> لا يوجد بيانات </td>

                                                @endforelse

                                            </tbody>
                                        </table>


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
