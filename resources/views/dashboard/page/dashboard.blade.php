@extends('dashboard.index')
@section('title-head', 'Dashboard')
@section('title-content', 'Dashboard')

@prepend('styles')
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
@endsection

@section('content')
    <div class="card" style="border-top: 4px solid #42B549;">
        <div class="card-body">
            <h3>Halaman dashboard</h3>
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
