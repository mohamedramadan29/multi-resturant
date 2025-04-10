@extends('front.layouts.master')
@section('title')
    تواصل معنا
@endsection
@section('content')
    <!-- Content -->
    <div id="content">
        @if (Session::has('Success_message'))
            @php
                toastify()->success(\Illuminate\Support\Facades\Session::get('Success_message'));
            @endphp
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                @php
                    toastify()->error($error);
                @endphp
            @endforeach
        @endif
        <!-- Section -->
        <section class="section bg-light">

            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-lg-5">
                        <div class="cart-details shadow bg-white stick-to-content mb-4">
                            <div class="bg-dark dark p-4">
                                <h5 class="mb-0"> تواصل معنا </h5>
                            </div>
                            <div class="contact-social">
                                <ul class="list-unstyled">
                                    <li>
                                        <a href="#"> <i class="bi bi-geo-alt-fill"></i> المملكة العربية السعودية
                                            الرياض - حي الأندلس </a>
                                    </li>
                                    <li>
                                        <a href="tel:552147147"> <i class="bi bi-telephone"></i> 552147147 </a>
                                    </li>
                                    <li>
                                        <a href="mailto:Traghaif@gmail.com"> <i class="bi bi-envelope"></i>
                                            Traghaif@gmail.com </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-7 order-lg-first">
                        <div class="bg-white p-4 p-md-5 mb-4">
                            <h4 class="border-bottom pb-4"><i class="ti ti-user mr-3 text-primary"></i> تواصل معنا {{ $restaurant->name }}
                            </h4>
                            <form action="{{ route('contact.store',['restaurant' => $restaurant->slug]) }}" method="post">
                                @csrf
                                <div class="row mb-5">
                                    <div class="form-group col-sm-6">
                                        <label> الاسم :</label>
                                        <input type="text" class="form-control" required name="name"
                                            value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label> رقم الهاتف :</label>
                                        <input type="number" class="form-control" required name="phone"
                                            value="{{ old('phone') }}">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label> عنوان الرسالة :</label>
                                        <input type="text" class="form-control" required name="subject"
                                            value="{{ old('subject') }}">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label> رسالتك :</label>
                                        <textarea name="message" id="" class="form-control" style="height: 90px">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary"><span> ارسال </span></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

        </section>


    </div>
    <!-- Content / End -->
@endsection
