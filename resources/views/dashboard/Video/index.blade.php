@extends('dashboard.layouts.app')
@section('title', ' رفع الفيديو ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> رفع الفيديو </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"><a href="#"> رفع الفيديو </a>
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
                                    <h4 class="card-title" id="basic-layout-form"> رفع الفيديو </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i> </a>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form" method="POST" id="invoice-form"
                                            action="{{ route('dashboard.settings.update') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-body">
                                                <input class="form-control" type="file" id="videoUpload" />
                                                <br>
                                                <button type="button" onclick="uploadVideo(event)" class="btn btn-primary">
                                                    رفع الفيديو <i class="fa fa-upload"></i>
                                                </button>
                                                <p id="uploadStatus" style="display:none; color: green; margin-top: 10px;">
                                                    جاري تحميل الفيديو...
                                                </p>

                                            </div>
                                        </form>
                                        <!-- عرض الفيديو -->
                                        @if (!empty($settingVideo['video']))
                                            <div class="video-container" style="margin-top: 20px;">
                                                <video controls width="400"
                                                    style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                                    <source
                                                        src="{{ asset('assets/uploads/videos/' . $setting['video']) }}"
                                                        type="video/mp4">
                                                    <!-- نص بديل إذا كان المتصفح لا يدعم الفيديو -->
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endif
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


    <!-- ####################### chunk Video ########################## -->

    <script>
        function uploadVideo(event) {
            event.preventDefault();
            const fileInput = document.getElementById('videoUpload');
            const file = fileInput.files[0];
            const uploadStatus = document.getElementById('uploadStatus');

            if (!file) {
                alert("يرجى اختيار فيديو!");
                return;
            }

            // عرض "جاري التحميل"
            uploadStatus.style.display = "block";
            uploadStatus.textContent = "جاري تحميل الفيديو...";


            const chunkSize = 1 * 1024 * 1024; // 1MB لكل جزء
            const totalChunks = Math.ceil(file.size / chunkSize);
            let chunkIndex = 0;
            const fileIdentifier = new Date().getTime() + "_" + file.name.replace(/\s+/g, '_');

            // الحصول على CSRF Token من الميتا تاج في <head>
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function uploadNextChunk() {
                if (chunkIndex >= totalChunks) {
                    mergeChunks();
                    return;
                }

                const start = chunkIndex * chunkSize;
                const end = Math.min(start + chunkSize, file.size);
                const chunk = file.slice(start, end);

                let formData = new FormData();
                formData.append("chunk", chunk);
                formData.append("chunkIndex", chunkIndex);
                formData.append("fileIdentifier", fileIdentifier);
                formData.append("totalChunks", totalChunks);

                fetch(`/dashboard/settings/upload-chunk`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken // تمرير CSRF Token
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log("رفع الجزء:", data.chunkIndex);
                        chunkIndex++;
                        uploadNextChunk();
                    })
                    .catch(error => {
                        console.error("خطأ أثناء رفع الجزء:", error);
                        uploadStatus.textContent = "حدث خطأ أثناء رفع الفيديو.";
                    });
            }

            function mergeChunks() {
                let formData = new FormData();
                formData.append("fileIdentifier", fileIdentifier);
                formData.append("originalFileName", file.name);
                formData.append("totalChunks", totalChunks);

                fetch(`/dashboard/settings/merge-chunks`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": csrfToken // تمرير CSRF Token
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "completed") {
                            alert("تم رفع الفيديو بنجاح: " + data.video_path);
                        }
                    })
                    .catch(error => {
                        console.error("خطأ أثناء دمج الأجزاء:", error);
                    });
            }

            uploadNextChunk();
        }
    </script>

@endsection
