@extends('dashboard.index')
@section('title-head', 'Dashboard - Manage Categories')
@section('title-content', 'Manage Categories')

@prepend('styles')
    <style>
        #search:focus {
            border-color: darkorange;
        }

        .thead-custom {
            color: darkorange;
            background-color: #F4F6F9;
        }

        .hoverable-row:hover {
            background-color: #ffeee1;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Manage Categories') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('All Categories') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('categories.create') }}"
                                class="btn btn-sm btn-dark bg-gradient">{{ __('Create') }}</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if (Session('success'))
                        <div id="alert-msg" class="alert alert-success alert-dismissible mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session('success') }}
                        </div>
                    @endif

                    @if (Session('error'))
                        <div id="alert-msg" class="alert alert-danger alert-dismissible mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session('error') }}
                        </div>
                    @endif

                    <label for="search">{{ __('Search') }}</label>
                    <input type="search" name="search" id="search" value="{{ $search }}" class="form-control"
                        placeholder="Search by name">

                    <div class="table-responsive mt-3">
                        <table class="table border-bottom text-nowrap">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center">{{ __('No') }}</th>
                                    <th class="text-left">{{ __('Name') }}</th>
                                    <th class="text-center">{{ __('Total Posts') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="hoverable-row">
                                        <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                        <td class="text-left align-middle">{{ $category->name }}</td>
                                        <td class="text-center align-middle">{{ $category->posts_count }} {{ __('Posts') }}
                                        </td>

                                        <td class="text-center align-middle">
                                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <div class="btn-group">
                                                    <a href="{{ route('categories.edit', $category->slug) }}"
                                                        class="btn btn-sm btn-warning bg-gradient">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>

                                                    <button type="submit" class="btn btn-sm btn-danger bg-gradient"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-5">
                                            <h4>{{ __('No categories found') }}</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script>
        $('#search').on('input', function() {
            filter();
        });

        function filter() {
            const searchValue = $('#search').val();
            const params = {};
            const url = '{{ route('categories.index') }}';

            if (searchValue.trim() !== '') {
                params.q = encodeURIComponent(searchValue.trim());
            }

            const queryString = Object.keys(params).map(key => key + '=' + params[key]);

            const finalUrl = url + '?' + queryString;
            window.location.href = finalUrl;
        }
    </script>
@endprepend
