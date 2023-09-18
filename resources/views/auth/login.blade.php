@extends('auth.index')

@section('title', 'Login')
@section('title-content', 'Login')

@prepend('styles')
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

        .form-check-input {
            border-color: darkorange;
        }

        .form-check-input:focus {
            outline: 0;
            box-shadow: none;
            border-color: darkorange;
        }

        .form-check-input:checked {
            background-color: darkorange;
        }

        a:hover {
            text-decoration: underline !important;
        }
    </style>
@endprepend

@section('content')
    {{-- alert success --}}
    @if (Session('success'))
        <div class="alert alert-success" role="alert">
            {{ Session('success') }}
        </div>
    @endif

    {{-- alert errors --}}
    @if (Session('errors'))
        <div class="alert alert-danger" role="alert">
            @foreach ($errors->all() as $error)
                - {{ $error }}<br />
            @endforeach
        </div>
    @endif

    {{-- form --}}
    <form method="POST" action="{{ route('login_process') }}">
        @csrf

        {{-- email or username --}}
        <div class="mb-3">
            <label for="email_or_username" class="form-label text-dark">Email or Username <span
                    class="text-danger">*</span></label>
            <input type="text" id="email_or_username" name="email_or_username"
                class="form-control @error('email_or_username') is-invalid @enderror" maxlength="45"
                value="{{ old('email_or_username') }}">
        </div>

        {{-- password --}}
        <div class="mb-3">
            <label for="password" class="form-label text-dark">Password <span class="text-danger">*</span></label>
            <input type="password" id="password" name="password"
                class="form-control @error('password') is-invalid @enderror">
        </div>

        {{-- remember me --}}
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        {{-- button --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </div>

        {{-- arah register --}}
        <p class="p-0 m-0"><a href="#" class="text-decoration-none" style="color: darkorange; font-weight: 500;">Forgot password?</a></p>
        <p class="p-0 m-0">Don't have an account yet? <a href="{{ route('register') }}" class="text-decoration-none" style="color: darkorange; font-weight: 500;">Register</a></p>
    </form>
@endsection

@prepend('scripts')
    {{-- jQuery cdn --}}
    <script src="{{ url('https://code.jquery.com/jquery-3.6.3.min.js') }}"
        integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>

    <script>
        $("#email_or_username").on("input", function() {
            let currentValue = $(this).val();
            let newValue = currentValue.toLowerCase().replace(/[^a-z0-9._.@]/g, "");
            $(this).val(newValue);
        });
    </script>
@endprepend
