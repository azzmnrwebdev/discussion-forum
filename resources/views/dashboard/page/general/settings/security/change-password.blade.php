@extends('dashboard.index')
@section('title-head', 'Dashboard - Security Settings | Change Password')
@section('title-content', 'Change Password')

@prepend('styles')
    <style>
        .form-control:focus {
            border-color: darkorange;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('security') }}">{{ __('Security') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Change Password') }}</li>
@endsection

@section('content')
    <div class="card" style="border-top: 4px solid darkorange;">
        <div class="card-body">
            <form action="{{ route('security.update_password') }}" method="post">
                @csrf

                <div class="form-group">
                    <label for="current_password">{{ __('Current Password') }} <span class="text-danger">{{ __('*') }}</span></label>
                    <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror">

                    @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">{{ __('New Password') }} <span class="text-danger">{{ __('*') }}</span></label>
                    <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror">

                    @error('new_password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-sm btn-warning">{{ __('Update Password') }}</button>
            </form>
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
