<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
@include('dashboard.layouts._head_scripts')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    @yield('content')
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    @include('dashboard.layouts._footer_scripts')
</body>

</html>
