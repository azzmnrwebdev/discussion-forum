@extends('dashboard.index')
@section('title-head', 'Dashboard - Account Settings')
@section('title-content', 'Account')

@prepend('styles')
    <style>
        .list-group-item:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Account') }}</li>
@endsection

@section('content')
    <div class="card" style="border-top: 4px solid darkorange;">
        <div class="card-body">
            @if (Session('success'))
                <div id="alert-msg" class="alert alert-success alert-dismissible mb-3">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ Session('success') }}
                </div>
            @endif

            <div class="list-group">
                <a href="{{ route('account.account_information') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-3 rounded">
                    <span><i class="fas fa-user-edit mr-2"></i><b>Account Information</b></span>

                    <i class="fas fa-chevron-right" style="font-size: 14px; !important"></i>
                </a>

                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-3 rounded border-top">
                    <span><i class="fas fa-trash mr-2"></i><b>Delete Account</b></span>

                    <i class="fas fa-chevron-right" style="font-size: 14px; !important"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
