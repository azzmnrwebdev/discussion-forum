@extends('dashboard.index')
@section('title-head', 'Dashboard - My Posts')
@section('title-content', 'My Posts')

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

        .badge-custom {
            padding: 2px 6px;
            font-weight: 700;
            font-size: 0.75em;
            text-align: center;
            white-space: nowrap;
            display: inline-block;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }

        .align-middle {
            vertical-align:middle!important;
        }

        @media (min-width: 768px) {
            .text-wrap-title {
                white-space: normal!important;
            }
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('My Posts') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('All Posts') }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('user.posts.create') }}"
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
                        placeholder="Search by title">

                    <div class="table-responsive mt-3">
                        <table class="table border-bottom text-nowrap">
                            <thead class="thead-custom">
                                <tr>
                                    <th class="text-center">{{ __('No') }}</th>
                                    <th class="text-left">{{ __('Title') }}</th>
                                    <th class="text-center">{{ __('Category') }}</th>
                                    <th class="text-center">{{ __('Visited') }}</th>
                                    <th class="text-center">{{ __('Uploaded') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($posts->count() > 0)
                                    @foreach ($posts as $row)
                                        <tr class="hoverable-row">
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td class="text-left align-middle text-wrap-title">{{ $row->title }}</td>
                                            <td class="text-center align-middle">
                                                @php $categoryColor = $categoryColors[$row->category->name]; @endphp
                                                <span class="badge-custom" style="background-color: {{ $categoryColor['background'] }}; color: {{ $categoryColor['text'] }}">{{ $row->category->name }}</span>
                                            </td>
                                            <td class="text-center align-middle">{{ $row->getFormattedCountAttribute($row->views_count) }}</td>
                                            <td class="text-center align-middle">{{ $row->formattedTimestamp($row->created_at) }}</td>

                                            <td class="text-center align-middle">
                                                <form action="{{ route('user.posts.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="btn-group">
                                                        <a href="{{ route('user.posts.show', $row->slug) }}"
                                                            class="btn btn-sm btn-info bg-gradient">
                                                            <i class="fa fa-eye"></i>
                                                        </a>

                                                        <a href="{{ route('user.posts.edit', $row->slug) }}"
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
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <h4 class="m-0">{{ __('No posts found') }}</h4>
                                        </td>
                                    </tr>
                                @endif
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
            const url = '{{ route('user.posts.index') }}';

            if (searchValue.trim() !== '') {
                params.q = encodeURIComponent(searchValue.trim());
            }

            const queryString = Object.keys(params).map(key => key + '=' + params[key]);

            const finalUrl = url + '?' + queryString;
            window.location.href = finalUrl;
        }
    </script>
@endprepend
