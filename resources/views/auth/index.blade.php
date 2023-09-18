<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DiskusiYuk - @yield('title')</title>

    {{-- bootstrap css --}}
    <link href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

    @stack('styles')
</head>

<body class="d-flex justify-content-center align-items-center" style="min-height: 100vh; height: 100%; background: #fdfdfd;">
    <div class="container">
        <div class="row justify-content-center justify-content-lg-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4">
                <div class="card shadow" style="border-radius: 20px;">
                    <div class="card-body p-0" style="padding: 40px 30px !important;">
                        {{-- title --}}
                        <h3 class="card-title mb-4 text-center text-uppercase" style="font-weight: 700 !important;">@yield('title-content')</h3>

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- bootstrap js --}}
    <script src="{{ url('https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>

    @stack('scripts')
</body>

</html>
