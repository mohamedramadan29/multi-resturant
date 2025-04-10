@extends('dashboard.layouts.app')

@section('title', ' اضافة منتج جديد ')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> المنتجات </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.products.index') }}"> المنتجات </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> اضافة منتج جديد </a>
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
                                    <h4 class="card-title" id="basic-layout-form"> اضافة منتج جديد </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form method="post" action="{{ route('dashboard.products.create') }}"
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
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="name" class="form-label"> اسم
                                                                المنتج
                                                            </label>
                                                            <input required type="text" id="name" name="name"
                                                                class="form-control" placeholder=""
                                                                value="{{ old('name') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="category_id" class="form-label"> حدد
                                                                القسم الرئيسي </label>
                                                            <select required class="form-control" id="category_id"
                                                                data-choices data-choices-groups
                                                                data-placeholder="Select Categories" name="category_id">
                                                                <option value=""> -- حدد القسم --
                                                                </option>
                                                                @foreach ($MainCategories as $maincat)
                                                                    <option value="{{ $maincat['id'] }}">
                                                                        {{ $maincat['name'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="status" class="form-label"> حالة
                                                                المنتج </label>
                                                            <select class="form-control" id="status" name="status">
                                                                <option value=""> -- حدد حالة المنتج
                                                                    --
                                                                </option>
                                                                <option value="1" selected> مفعل
                                                                </option>
                                                                <option value="0"> ارشيف</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="short_description" class="form-label">
                                                                وصف مختصر عن
                                                                المنتج </label>
                                                            <textarea class="form-control bg-light-subtle" id="short_description" rows="5" placeholder=""
                                                                name="short_description">{{ old('short_description') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="description" class="form-label"> وصف
                                                                المنتج </label>
                                                            <textarea required class="form-control bg-light-subtle" id="description" rows="7" placeholder=""
                                                                name="description">{{ old('description') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="carb" class="form-label">
                                                                السعرات
                                                                الحرارية </label>
                                                            <input type="text" id="carb" name="carb"
                                                                class="form-control" placeholder=""
                                                                value="{{ old('carb') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="is_featured" class="form-label">
                                                                منتج
                                                                مميز </label>
                                                            <select name="is_featured" id="is_featured"
                                                                class="form-control">
                                                                <option value="0" selected> لا
                                                                </option>
                                                                <option value="1"> نعم </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="image" class="form-label"> صورة
                                                                المنتج </label>
                                                            <input required type="file" id="single-image"
                                                                name="image" class="form-control" accept="image/*">
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="product-type" class="form-label"> حدد
                                                                نوع
                                                                المنتج </label>
                                                            <!-- check if the product is simple or variable -->
                                                            <select name="product_type" id="product-type"
                                                                class="form-control">
                                                                <option value="simple">بسيط</option>
                                                                <option value="variable">متغير</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div id="simple-product-fields">
                                                            <div class="form-group">
                                                                <label for="product-price" class="form-label">
                                                                    السعر </label>
                                                                <input step="0.01" type="number" id="price"
                                                                    name="price" class="form-control" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div id="variable-product-fields" style="display: none">
                                                            <div id="size-price-container">
                                                                <!-- سيتم إضافة الحقول هنا -->
                                                            </div>
                                                            <button type="button" class="btn btn-primary mt-3"
                                                                id="add-size">إضافة
                                                                حجم</button>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="card-header">
                                                            <h4 class="card-title"> معلومات السيو ومحركات البحث </h4>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="meta_title" class="form-label">
                                                                العنوان </label>
                                                            <input type="text" id="meta_title" name="meta_title"
                                                                class="form-control" placeholder=""
                                                                value="{{ old('meta_title') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="meta_keywords" class="form-label">
                                                                الكلمات المفتاحية </label>
                                                            <input type="text" id="meta_keywords" name="meta_keywords"
                                                                class="form-control" placeholder=""
                                                                value="{{ old('meta_keywords') }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="meta_description" class="form-label">
                                                                الوصف </label>
                                                            <textarea class="form-control bg-light-subtle" id="meta_description" rows="7" placeholder=""
                                                                name="meta_description">{{ old('meta_description') }}</textarea>
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
    <script>
        document.getElementById('product-type').addEventListener('change', function() {
            if (this.value === 'simple') {
                document.getElementById('simple-product-fields').style.display = 'block';
                document.getElementById('variable-product-fields').style.display = 'none';
            } else {
                document.getElementById('simple-product-fields').style.display = 'none';
                document.getElementById('variable-product-fields').style.display = 'block';
            }
        });
    </script>

    <script>
        document.getElementById('add-size').addEventListener('click', function() {
            let container = document.getElementById('size-price-container');
            let index = document.querySelectorAll('.size-price-group').length; // لحساب عدد الأحجام

            let html = `
            <div class="row size-price-group" id="size-price-${index}">
                <div class="col-lg-5">
                    <label class="form-label">الحجم</label>
                    <input type="text" name="sizes[]" class="form-control" placeholder="مثال: صغير، متوسط، كبير" required>
                </div>
                <div class="col-lg-5">
                    <label class="form-label">السعر</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="prices[]" class="form-control" placeholder="" required>
                    </div>
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger remove-size" data-id="${index}">حذف</button>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', html);
        });

        // حذف الحقل عند النقر على زر "حذف"
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-size')) {
                let id = event.target.getAttribute('data-id');
                document.getElementById(`size-price-${id}`).remove();
            }
        });
    </script>
@endsection
