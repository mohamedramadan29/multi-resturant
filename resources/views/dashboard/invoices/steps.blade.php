@extends('dashboard.layouts.app')
@section('title', ' حركة حســاب الفاتورة ')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="mb-2 content-header-left col-md-6 col-12 breadcrumb-new">
                    <h3 class="mb-0 content-header-title d-inline-block"> حركة حســاب الفاتورة </h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item active"> حركة حســاب الفاتورة
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>

            </div>
            <div class="content-body">
                <div class="row match-height">
                    <div class="col-lg-12 col-md-12">
                        <div class="card" style="height: 321.695px;">
                            <div class="card-header">
                                <h4 class="card-title">حركة حســاب الفاتورة  [ {{ $invoice->id }} ] </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-h font-medium-3"></i></a>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <table class="table">
                                        <thead>
                                            <tr>
                                                <th> التفاصيل  </th>
                                                <th> التاريخ </th>
                                                <th> المسؤول </th>
                                            </tr>
                                        </thead>
                                        @forelse ($steps as $step)
                                        <tr>
                                            <td>
                                                {{ $step['step_details'] }}
                                            </td>
                                            <td>
                                                {{ $step['created_at'] }}
                                            </td>
                                            <td>
                                                {{ $step->Admin->name }}
                                            </td>
                                        </tr>

                                        @empty
                                            لا يوجد حركات بعد علي الفاتورة
                                        @endforelse
                                    </table>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
