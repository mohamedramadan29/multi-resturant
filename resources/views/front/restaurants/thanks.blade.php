@extends('front.layouts.master')
@section('title')
    الرئيسية
@endsection

@section('content')
    <!-- Content -->
    <div id="content">

        <!-- Section -->
        <section class="section bg-light">
            <div class="container">
                <div class="row">
                    @php
                    $settingVideo = \App\Models\dashboard\Setting::whereNull('resturant_id')->first();
                        $orderdata = \App\Models\dashboard\Order::where(
                            'id',
                            \Illuminate\Support\Facades\Session::get('order_id'),
                        )->first();
                    @endphp
                    <div class="col-lg-8 offset-lg-4">
                        <span class="icon icon-xl icon-success"><i class="bi bi-check2-square"></i></span>
                        <h1 class="mb-2" style="font-weight: 300"> تم اضافة طلبك بنجاح !! شكرا لك </h1>
                        <h2 style="font-size: 20px;font-weight: bold;border: 1px dashed #fad521;padding: 10px;border-radius: 5px; display: inline-block;"
                            class="mb-2" style="font-weight: 300"> رقم الطلب :: <span> {{ Session::get('order_id') }}
                            </span> </h2>
                        <h4 class=" mb-5"> سوف يتم اتمام الطلب خلال 10 دقيقة </h4>
                        <a href="{{ route('restaurant.show', ['restaurant' => $restaurant->slug]) }}"
                            class="btn btn-outline-secondary"><span> طلب جديد </span></a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Video Modal -->
        <div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-dark text-white position-relative">
                    <div class="modal-body p-0">
                        <button type="button" class="btn btn-sm btn-light position-absolute"
                            style="top: 10px; right: 10px; background-color: #9d9c9c;" data-bs-dismiss="modal" aria-label="Close">
                            &times;
                        </button>
                        <video id="thankYouVideo" class="w-100" controls autoplay>
                            <source src="{{ asset('assets/uploads/videos/'.$settingVideo['video']) }}" type="video/mp4">
                            Your browser does not support HTML5 video.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Content / End -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#thankYouModal').modal('show');

            // اختيارياً: إغلاق المودال عند انتهاء الفيديو
            const video = document.getElementById('thankYouVideo');
            video.onended = function() {
                $('#thankYouModal').modal('hide');
            };
        });
    </script>
@endsection
