@extends('dashboard.layouts.app')
@section('title', ' تعديل بيانات المطعم ')
@section('css')

    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css"
        crossorigin="anonymous">
    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.4/css/fileinput.min.css" media="all"
        rel="stylesheet" type="text/css" />

@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> تعديل بيانات المطعم </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.resturants.index') }}"> المطاعم
                                    </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> تعديل بيانات المطعم </a>
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
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">{{ $error }}</div>
                                    @endforeach
                                @endif
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form"> تعديل بيانات المطعم </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i> </a>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" method="POST" id="invoice-form"
                                            action="{{ route('dashboard.resturants.update', $restaurant->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <!-- باقي الحقول -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> اسم المطعم <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="name"
                                                                class="form-control" placeholder="" name="name"
                                                                value="{{ old('name', $restaurant->name) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name">  رابط الموقع  <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="slug"
                                                                class="form-control" placeholder="" name="slug"
                                                                value="{{ old('slug', $restaurant->slug) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> رابط المطعم <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="slug"
                                                                class="form-control" placeholder="" name="slug"
                                                                value="{{ old('slug', $restaurant->slug) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> حدد المالك <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <select name="owner_id" id="" class="form-control">
                                                                <option value="" selected disabled> -- حدد المالك --
                                                                </option>
                                                                @foreach ($admins as $owner)
                                                                    <option @selected($restaurant->owner_id == $owner->id)
                                                                        value="{{ $owner['id'] }}">
                                                                        {{ $owner['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email"> البريد الالكتروني <span
                                                                    class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="email" id="email"
                                                                class="form-control" placeholder="" name="email"
                                                                value="{{ old('email', $restaurant->email) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone"> رقم الهاتف <span class="required_span">
                                                                    *</span> </label>
                                                            <input required type="text" id="phone"
                                                                class="form-control" name="phone"
                                                                value="{{ old('phone', $restaurant->phone) }}">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address"> العنوان <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="address"
                                                                class="form-control" placeholder="" name="address"
                                                                value="{{ old('address', $restaurant->address) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="price"> حالة التفعيل <span
                                                                    class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <select required name="status" id=""
                                                                class="form-control">
                                                                <option value="" selected disabled> -- حدد حالة
                                                                    التفعيل -- </option>
                                                                <option @selected($restaurant->status == 1) value="1"> مفعل
                                                                </option>
                                                                <option @selected($restaurant->status == 0) value="0"> غير
                                                                    مفعل </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- اضافة المرفقات -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="title"> وصف عن المطعم </label>
                                                            <textarea name="description" class="form-control">{{ old('description', $restaurant->description) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group">
                                                            <label for="address"> لوجو المطعم <span
                                                                    class="required_span"> * </span> </label>
                                                            <input type="file" class="form-control" name="logo"
                                                                id="single-image-edit">
                                                        </div>
                                                        <div id="imagePreview" class="flex-wrap mt-3 d-flex"></div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group">
                                                            <label for="address"> البانر الاساسي <span
                                                                    class="required_span"> * </span> </label>
                                                            <input type="file" class="form-control" name="banner"
                                                                id="single-image-edit2">
                                                        </div>
                                                        <div id="imagePreview" class="flex-wrap mt-3 d-flex"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="la la-check-square-o"></i> حفظ
                                                </button>
                                                <button type="button" class="mr-1 btn btn-warning">
                                                    <i class="ft-x"></i> رجوع
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
@section('js')
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.4/js/fileinput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.5.4/js/locales/LANG.js"></script>
    <script src="{{ asset('assets/vendor/locale/ar.js') }}"></script>



    <!-- Start file Input  Update  -->
    <script>
        $("#single-image-edit").fileinput({
            theme: 'fa5',
            allowedFileTypes: ['image'],
            language: 'ar',
            maxFileCount: 1,
            enableResumableUpload: false,
            showUpload: false,
            initialPreviewAsData: true,
            initialPreview: [
                "{{ asset($restaurant->getLogo()) }}"
            ],
        });
    </script>
    <!-- End File Input -->
    <!-- Start file Input  Update  -->
    <script>
        $("#single-image-edit2").fileinput({
            theme: 'fa5',
            allowedFileTypes: ['image'],
            language: 'ar',
            maxFileCount: 1,
            enableResumableUpload: false,
            showUpload: false,
            initialPreviewAsData: true,
            initialPreview: [
                "{{ asset($restaurant->getBanner()) }}"
            ],
        });
    </script>
    <!-- End File Input -->
@endsection



@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            nameInput.addEventListener('input', function() {
                const name = nameInput.value;

                // استخدم speakingurl لتحويل الاسم إلى slug
                const slug = getSlug(name, {
                    lang: 'ar', // دعم اللغة العربية
                    separator: '-', // الفاصل بين الكلمات
                    custom: {
                        'ـ': ''
                    } // إزالة الأحرف غير المفيدة
                });

                slugInput.value = slug;
            });
        });
    </script>

@endsection
