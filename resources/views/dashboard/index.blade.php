<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title-head')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="{{ url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/adminlte.min.css') }}">

    <style>
        .sidebar-dark-primary {
            background-color: #020918;
        }

        .main-sidebar .sidebar .user-panel .info a,
        .main-sidebar .sidebar nav .nav-sidebar .nav-header,
        .main-sidebar .sidebar nav .nav-sidebar .nav-item .nav-link p,
        .main-sidebar .sidebar nav .nav-sidebar .nav-item .nav-link .nav-icon {
            color: #F8FAFC;
        }

        .main-sidebar .sidebar .user-panel {
            border-color: #F8FAFC;
        }

        .main-sidebar .sidebar nav .nav-sidebar .nav-item .nav-link.active {
            box-shadow: none;
            background-color: darkorange;
        }

        .main-sidebar .sidebar nav .nav-sidebar .nav-item .nav-link.active p,
        .main-sidebar .sidebar nav .nav-sidebar .nav-item .nav-link.active .nav-icon {
            color: #F8FAFC;
        }
    </style>

    {{-- Custom CSS --}}
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        {{-- Navbar --}}
        @include('dashboard.partials.navbar')

        {{-- Sidebar --}}
        @include('dashboard.partials.sidebar')

        {{-- Content Wrapper. Contains page content --}}
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2 align-items-center">
                        <div class="col-sm-6">
                            <h1>@yield('title-content')</h1>
                        </div>

                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>
        </div>

        {{-- Main Footer --}}
        @include('dashboard.partials.footer')

        {{-- Control Sidebar --}}
        <aside class="control-sidebar control-sidebar-dark">
            {{-- Control sidebar content goes here --}}
        </aside>
    </div>

    <!-- jQuery -->
    <script src="{{ asset('AdminLTE/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap -->
    <script src="{{ asset('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>

    <!-- Custom Javascript -->
    @stack('scripts')
</body>

</html>
