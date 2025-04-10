@extends('dashboard.layouts.app')
@section('title', ' تعديل التصنيف ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> تعديل التصنيف </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.categories.index') }}"> التصنيفات
                                    </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> تعديل التصنيف </a>
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
                                    <h4 class="card-title" id="basic-layout-form"> تعديل التصنيف </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i> </a>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form method="post"
                                            action="{{ route('dashboard.categories.update',$category['id']) }}"
                                            enctype="multipart/form-data">
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
                                                                        <option @selected($rest['id'] == $category['resturant_id']) value="{{ $rest['id'] }}">
                                                                            {{ $rest['name'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <input type="hidden" name="resturant_id"
                                                            value="{{ Auth::guard('admin')->user()->resturant_id }}">
                                                    @endif
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label"> عنوان
                                                                القسم </label>
                                                            <input required type="text" id="name"
                                                                class="form-control" name="name"
                                                                value="{{ $category['name'] }}">
                                                        </div>

                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="crater" class="form-label"> حالة التفعيل
                                                            </label>
                                                            <select required name="status" class="form-control"
                                                                id="crater" data-choices data-choices-groups
                                                                data-placeholder="Select Crater">
                                                                <option value=""> -- حدد الحالة --</option>
                                                                <option @if ($category['status'] == 1) selected @endif
                                                                    value="1">مفعل</option>
                                                                <option @if ($category['status'] == 0) selected @endif
                                                                    value="0">غير مفعل</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="description" class="form-label"> وصف
                                                                القسم </label>
                                                            <textarea required class="form-control bg-light-subtle" id="description" rows="7" name="description">{{ $category['description'] }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <input type="file" class="form-control" name="image"
                                                                id="single-image-edit" accept="image/*">

                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <h4 class="card-title d-block"> معلومات السيو <span
                                                                class="badge badge-info bg-info"> اختياري </span>
                                                        </h4>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="meta_title" class="form-label">
                                                                العنوان
                                                            </label>
                                                            <input type="text" id="meta_title" class="form-control"
                                                                name="meta_title" value="{{ $category['meta_title'] }}">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6">

                                                        <div class="form-group">
                                                            <label for="meta_keywords" class="form-label">
                                                                الكلمات المفتاحية </label>
                                                            <input type="text" id="meta_keywords" name="meta_keywords"
                                                                class="form-control"
                                                                value="{{ $category['meta_keywords'] }}">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-0">
                                                            <label for="meta_description" class="form-label">الوصف
                                                            </label>
                                                            <textarea class="form-control bg-light-subtle" id="meta_description" rows="4" name="meta_description">{{ $category['meta_description'] }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-actions">
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="la la-check-square-o"></i> حفظ
                                                        </button>
                                                        <a href="{{ route('dashboard.categories.index') }}"
                                                            type="button" class="mr-1 btn btn-warning">
                                                            <i class="ft-x"></i> رجوع
                                                        </a>
                                                    </div>
                                                </div>
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
                "{{ asset($category->getImage()) }}"
            ],
        });
    </script>
    <!-- End File Input -->
@endsection
