@extends('dashboard.index')
@section('title-head', 'Dashboard - Create Users')
@section('title-content', 'Create Users')

@prepend('styles')
    <style>
        .form-control:focus {
            border-color: darkorange;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('Manage Users') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div class="row">
                            {{-- name --}}
                            <div class="form-group col-12 col-md-6">
                                <label for="name">{{ __('Name') }} <span
                                        class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- username --}}
                            <div class="form-group col-12 col-md-6">
                                <label for="username">{{ __('Username') }} <span
                                        class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" name="username" id="username"
                                    class="form-control @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}">

                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- email --}}
                            <div class="form-group col-12 col-md-6">
                                <label for="email">{{ __('Email') }} <span
                                        class="text-danger">{{ __('*') }}</span></label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- role --}}
                            <div class="form-group col-12 col-md-6">
                                <label for="role" class="form-label">{{ __('Role') }} <span
                                        class="text-danger">{{ __('*') }}</span></label>

                                <select name="role" id="role"
                                    class="form-control @error('role') is-invalid @enderror">
                                    <option value="" disabled selected>{{ __('-- Select Role --') }}</option>

                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                        {{ __('Admin') }}
                                    </option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                        {{ __('Normal User') }}
                                    </option>
                                </select>

                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- password --}}
                            <div class="form-group col-12">
                                <label for="password">{{ __('Password') }} <span
                                        class="text-danger">{{ __('*') }}</span></label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    value="{{ old('password') }}">

                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success">{{ __('Save User') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script>
        $(function() {
            $("#username").on("input", function() {
                let currentValue = $(this).val();
                let newValue = currentValue.toLowerCase().replace(/[^a-z0-9._]/g, "");
                $(this).val(newValue);
            });

            $("#email").on("input", function() {
                let currentValue = $(this).val();
                let newValue = currentValue.toLowerCase().replace(/[^a-z0-9.@_+]/g, "");
                $(this).val(newValue);
            });
        });
    </script>
@endprepend
