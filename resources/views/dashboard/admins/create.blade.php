@extends('dashboard.layouts.app')

@section('title', ' اضافة اداري جديد ')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> الادارين </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.admins.index') }}"> الادارين </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> اضافة اداري جديد </a>
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
                                    <h4 class="card-title" id="basic-layout-form"> اضافة اداري جديد </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" method="POST" action="{{ route('dashboard.admins.create') }}"
                                            autocomplete="off">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name"> الاسم </label>
                                                            <input required type="text" id="name"
                                                                class="form-control" placeholder="" name="name"
                                                                value="{{ old('name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="email"> البريد الالكتروني </label>
                                                            <input required type="email" id="email"
                                                                class="form-control" placeholder="" name="email"
                                                                value="{{ old('email') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="phone"> رقم الهاتف </label>
                                                            <input required type="text" id="phone"
                                                                class="form-control" placeholder="" name="phone"
                                                                value="{{ old('phone') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password"> كلمة المرور </label>
                                                            <input required type="password" id="password"
                                                                class="form-control" placeholder="" name="password">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="password_confirmation"> تاكيد كلمة المرور </label>
                                                            <input required type="password" id="password_confirmation"
                                                                class="form-control" placeholder=""
                                                                name="password_confirmation">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="role_id"> حدد الصلاحية </label>
                                                            <select required name="role_id" id=""
                                                                class="form-control">
                                                                <option value="" disabled selected> -- حدد الصلاحية --
                                                                </option>
                                                                @foreach ($roles as $role)
                                                                    <option
                                                                        {{ old('role_id') == $role->id ? 'selected' : '' }}
                                                                        value="{{ $role->id }}"> {{ $role->role }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="status"> حالة الاداري </label>
                                                            <select required name="status" id=""
                                                                class="form-control">
                                                                <option value="" disabled selected> -- حدد الحالة --
                                                                </option>
                                                                <option value="1">فعال</option>
                                                                <option value="0">غير فعال</option>
                                                            </select>
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
