@extends('auth.index')

@section('title', 'Register')
@section('title-content', 'Register')

@prepend('styles')
    {{-- toastr css --}}
    <link rel="stylesheet" href="{{ url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css') }}" />

    <style>
        .form-control:focus {
            box-shadow: none;
            border: 1px solid darkorange;
        }

        .btn-primary {
            border: darkorange;
            background-color: darkorange;
        }

        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active {
            background-color: #e37d02 !important;
        }

        .form-control.is-invalid:focus {
            box-shadow: none;
        }

        a:hover {
            text-decoration: underline !important;
        }
    </style>
@endprepend

@section('content')
    {{-- form --}}
    <form method="POST" action="{{ route('registration_process') }}">
        @csrf

        {{-- fullname --}}
        <div class="mb-3">
            <label for="name" class="form-label text-dark">Name <span class="text-danger">*</span></label>
            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                maxlength="45" value="{{ old('name') }}">
        </div>

        {{-- username --}}
        <div class="mb-3">
            <label for="username" class="form-label text-dark">Username <span class="text-danger">*</span></label>
            <input type="text" id="username" name="username"
                class="form-control @error('username') is-invalid @enderror" maxlength="45" value="{{ old('username') }}">
        </div>

        {{-- email --}}
        <div class="mb-3">
            <label for="email" class="form-label text-dark">Email <span class="text-danger">*</span></label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                maxlength="45" value="{{ old('email') }}">
        </div>

        {{-- password --}}
        <div class="mb-4">
            <label for="password" class="form-label text-dark">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror">
        </div>

        {{-- button --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </div>

        {{-- arah login --}}
        <p class="p-0 m-0 text-center">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none" style="color: darkorange; font-weight: 500;">Login</a></p>
    </form>
@endsection

@prepend('scripts')
    {{-- jQuery cdn --}}
    <script src="{{ url('https://code.jquery.com/jquery-3.6.3.min.js') }}"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    {{-- toastr js --}}
    <script src="{{ url('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>

    <script>
        $("#username").on("input", function() {
            let currentValue = $(this).val();
            let newValue = currentValue.toLowerCase().replace(/[^a-z0-9._]/g, "");
            $(this).val(newValue);
        });

        $("#email").on("input", function() {
            let currentValue = $(this).val();
            let newValue = currentValue.toLowerCase().replace(/[^a-z0-9.@]/g, "");
            $(this).val(newValue);
        });

        function showToast(type, messages) {
            toastr.options = {
                closeButton: true,
                timeOut: "50000",
                extendedTimeOut: "1000",
            };

            if (type === "success") {
                messages
                    .slice()
                    .reverse()
                    .forEach((message) => {
                        toastr.success(message);
                    });
            }

            if (type === "error") {
                messages
                    .slice()
                    .reverse()
                    .forEach((message) => {
                        toastr.error(message);
                    });
            }
        }

        @if ($errors->any())
            const errors = {!! json_encode($errors->all()) !!};
            showToast('error', errors);
        @endif
    </script>
@endprepend
