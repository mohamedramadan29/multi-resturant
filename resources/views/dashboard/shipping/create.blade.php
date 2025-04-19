@extends('dashboard.layouts.app')

@section('title', ' اضافة منطقة شحن جديدة ')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> مناطق الشحن </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.shipping.index') }}"> مناطق الشحن  </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> اضافة منطقة شحن جديدة  </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">  اضافة منطقة شحن جديدة  </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" method="POST" action="{{ route('dashboard.shipping.create') }}"
                                            autocomplete="off">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    @if (Auth::guard('admin')->user()->type == 'superadmin')
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label"> حدد المطعم
                                                            </label>
                                                            <select name="resturant_id" id=""
                                                                class="form-control">
                                                                <option value="" selected disabled> -- حدد
                                                                    المطعم -- </option>
                                                                @foreach ($resturants as $rest)
                                                                    <option value="{{ $rest['id'] }}">
                                                                        {{ $rest['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                @else
                                                    <input type="hidden" name="resturant_id"
                                                        value="{{ Auth::guard('admin')->user()->resturant_id }}">
                                                @endif
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="area"> اسم المنطقة </label>
                                                            <input required type="text" id="area"
                                                                class="form-control" placeholder="" name="area"
                                                                value="{{ old('area') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="price"> سعر الشحن </label>
                                                            <input required type="number" id="price"
                                                                class="form-control" placeholder="" name="price" step="0.01"
                                                                value="{{ old('price') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>
@endsection
