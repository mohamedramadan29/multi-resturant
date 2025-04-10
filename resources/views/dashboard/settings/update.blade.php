@extends('dashboard.layouts.app')
@section('title', ' الاعدادات العامة')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> الاعدادات العامة </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> الاعدادات العامة </a>
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
                                    <h4 class="card-title" id="basic-layout-form"> الاعدادات العامة </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i> </a>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" method="POST" id="invoice-form"
                                            action="{{ route('dashboard.settings.update') }}" enctype="multipart/form-data">
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
                                                                value="{{ old('name', $setting->name) }}">
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> رابط الموقع <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="slug"
                                                                class="form-control" placeholder="" name="slug"
                                                                value="{{ old('slug') }}">
                                                        </div>
                                                    </div> --}}

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email"> البريد الالكتروني <span
                                                                    class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="email" id="email"
                                                                class="form-control" placeholder="" name="email"
                                                                value="{{ old('email', $setting->email) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone"> رقم الهاتف <span class="required_span">
                                                                    *</span> </label>
                                                            <input required type="text" id="phone"
                                                                class="form-control" name="phone"
                                                                value="{{ old('phone', $setting->phone) }}">

                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="address"> العنوان <span class="required_span">
                                                                    *
                                                                </span> </label>
                                                            <input required type="text" id="address"
                                                                class="form-control" placeholder="" name="address"
                                                                value="{{ old('address', $setting->address) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- اضافة المرفقات -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="title"> وصف عن المطعم </label>
                                                            <textarea name="description" class="form-control">{{ old('description', $setting->description) }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-12">
                                                        <div class="form-group">
                                                            <label for="address"> لوجو المطعم <span class="required_span">
                                                                    * </span> </label>
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
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4
                                                            style="border-bottom: 1px dotted #ccc; padding-bottom: 10px;margin-bottom: 10px">
                                                            التواصيل والسوشيال ميديا </h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="facebook"> فيسبوك </label>
                                                            <input type="url" id="facebook" class="form-control"
                                                                placeholder="" name="facebook"
                                                                value="{{ old('facebook', $setting->facebook) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="twitter"> تويتر (X) </label>
                                                            <input type="url" id="twitter" class="form-control"
                                                                placeholder="" name="twitter"
                                                                value="{{ old('twitter', $setting->twitter) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="instagram"> الانستقرام </label>
                                                            <input type="url" id="instagram" class="form-control"
                                                                placeholder="" name="instagram"
                                                                value="{{ old('instagram', $setting->instagram) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="youtube"> يوتيوب </label>
                                                            <input type="url" id="youtube" class="form-control"
                                                                placeholder="" name="youtube"
                                                                value="{{ old('youtube', $setting->youtube) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="snapchat"> سناب شات </label>
                                                            <input type="url" id="snapchat" class="form-control"
                                                                placeholder="" name="snapchat"
                                                                value="{{ old('snapchat', $setting->snapchat) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="tiktok"> تيك توك </label>
                                                            <input type="url" id="tiktok" class="form-control"
                                                                placeholder="" name="tiktok"
                                                                value="{{ old('tiktok', $setting->tiktok) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="whatsapp"> رابط الواتساب </label>
                                                            <input type="url" id="whatsapp" class="form-control"
                                                                placeholder="" name="whatsapp"
                                                                value="{{ old('whatsapp', $setting->whatsapp) }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4
                                                            style="border-bottom: 1px dotted #ccc; padding-bottom: 10px;margin-bottom: 10px">
                                                            الوان الموقع </h4>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="main_color"> اللون الاساسي </label>
                                                            <input type="color" id="main_color" class="form-control"
                                                                placeholder="" name="main_color"
                                                                value="{{ old('main_color', $setting->main_color) }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="second_color"> اللون الثاني  </label>
                                                            <input type="color" id="second_color" class="form-control"
                                                                placeholder="" name="second_color"
                                                                value="{{ old('second_color', $setting->secondary_color) }}">
                                                        </div>
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
                "{{ asset($setting->getLogo()) }}"
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
                "{{ asset($setting->getBanner()) }}"
            ],
        });
    </script>
    <!-- End File Input -->
@endsection
