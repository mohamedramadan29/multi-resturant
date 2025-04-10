@extends('dashboard.layouts.app')
@section('title')
    الرئيسية
@endsection
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- eCommerce statistic -->
                <div class="row">
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="info"> {{ $ordersCount }} </h3>
                                            <h6> الطلبات  </h6>
                                        </div>
                                        <div>
                                            <i class="float-right icon-basket-loaded info font-large-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="warning"> {{ $products }} </h3>
                                            <h6> المنتجات  </h6>
                                        </div>
                                        <div>
                                            <i class="float-right icon-pie-chart warning font-large-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-12">
                        <div class="card pull-up">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="media d-flex">
                                        <div class="text-left media-body">
                                            <h3 class="success"> {{ $categories }} </h3>
                                            <h6> التصنيفات   </h6>
                                        </div>
                                        <div>
                                            <i class="float-right icon-user-follow success font-large-2"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- Recent Transactions -->

                <!-- Bar charts section start -->
                <section id="chartjs-bar-charts">
                    <!-- Bar Chart -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> اكثر المنتجات طلبا </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <canvas id="bar-chart" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column Chart -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title"> تقرير شهري عن المبيعات </h4>
                                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <canvas id="column-chart" height="400"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row">
                    <div id="recent-transactions" class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title"> احدث المطاعم </h4>
                                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                                <div class="heading-elements">
                                    <ul class="mb-0 list-inline">
                                        <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right"
                                                href="#"> جميع الفواتير </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table id="recent-orders" class="table mb-0 table-hover table-xl">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> الاسم </th>
                                                <th> رقم الهاتف </th>
                                                <th> العنوان </th>
                                                <th> الحالة </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($returants as $resturant)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td> {{ $resturant->name }} </td>
                                                    <td>
                                                        {{ $resturant->phone }}
                                                    </td>
                                                    <td>
                                                        {{ $resturant->address }}
                                                    </td>
                                                    <td>
                                                        {{ $resturant->status }}
                                                    </td>
                                                </tr>
                                            @empty
                                                <td colspan="4"> لا يوجد بيانات </td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Recent Transactions -->
            </div>
        </div>
    </div>
@endsection


@section('js')
    {{-- <script src="{{ asset('assets/admin/js/components/apexchart-column.js') }}"></script>
    <!-- Apex Chart Bar Demo js -->
    <script src="{{ asset('assets/admin/js/components/apexchart-bar.js') }}"></script> --}}
    <!-- BEGIN PAGE LEVEL JS-->
    <!-- BEGIN VENDOR JS-->
    <script src="{{ asset('assets/admin/') }}/vendors/js/vendors.min.js" type="text/javascript"></script>
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
    <script src="{{ asset('assets/admin/') }}/vendors/js/charts/chart.min.js" type="text/javascript"></script>
    <!-- END PAGE VENDOR JS-->

    <script src="{{ asset('assets/admin/') }}/js/scripts/charts/chartjs/bar/bar.js" type="text/javascript"></script>


    <script src="{{ asset('assets/admin/') }}/js/scripts/charts/chartjs/bar/column.js" type="text/javascript"></script>
@endsection
