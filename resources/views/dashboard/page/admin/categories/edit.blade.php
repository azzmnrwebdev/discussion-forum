@extends('dashboard.index')
@section('title-head', 'Dashboard - Edit Categories')
@section('title-content', 'Edit Categories')

@prepend('styles')
    <style>
        .form-control:focus {
            border-color: darkorange;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('Manage Categories') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="post">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="name">{{ __('Category Name') }} <span
                                    class="text-danger">{{ __('*') }}</span></label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $category->name) }}">

                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-sm btn-warning">{{ __('Update Category') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
@endprepend
