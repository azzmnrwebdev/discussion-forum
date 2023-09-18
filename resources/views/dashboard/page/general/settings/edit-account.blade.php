@extends('dashboard.index')
@section('title-head', 'Dashboard - Account Settings | Account Information')
@section('title-content', 'Account Information')

@prepend('styles')
    <style>
        .form-control:focus {
            border-color: darkorange;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('account') }}">{{ __('Account') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Account Information') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-body">
                    <form action="{{ route('account.update_account', $userLogin->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="row">
                            {{-- name --}}
                            <div class="form-group col-12">
                                <label for="name">{{ __('Name') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $userLogin->name) }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- username --}}
                            <div class="form-group col-12">
                                <label for="username">{{ __('Username') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $userLogin->username) }}">

                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- email --}}
                            <div class="form-group col-12">
                                <label for="email">{{ __('Email') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $userLogin->email) }}">

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-warning">{{ __('Update Account') }}</button>
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
