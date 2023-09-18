@extends('dashboard.index')
@section('title-head', 'Dashboard - Privacy Settings')
@section('title-content', 'Privacy')

@prepend('styles')
    <style>
        .list-group-item:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Privacy') }}</li>
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
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center mb-3 rounded">
                    <span><i class="fas fa-heart mr-2"></i><b>Liked Posts</b></span>

                    <i class="fas fa-chevron-right" style="font-size: 14px; !important"></i>
                </a>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
