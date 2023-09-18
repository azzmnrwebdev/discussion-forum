@extends('dashboard.index')
@section('title-head', 'Dashboard - Manage Posts')
@section('title-content', 'Manage Posts')

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
    <li class="breadcrumb-item active">{{ __('Manage Posts') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('All Posts') }}</h3>
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
                                    <th class="text-center">{{ __('Author') }}</th>
                                    <th class="text-center">{{ __('Category') }}</th>
                                    <th class="text-center">{{ __('Visited') }}</th>
                                    <th class="text-center">{{ __('Uploaded') }}</th>
                                    <th class="text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($posts as $post)
                                    <tr class="hoverable-row">
                                            <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                            <td class="text-left align-middle text-wrap-title">{{ $post->title }}</td>

                                            <td class="text-center align-middle">
                                                <span class="badge-custom badge-dark">{{ $post->user->name }}</span>
                                            </td>

                                            <td class="text-center align-middle">
                                                @php $categoryColor = $categoryColors[$post->category->name]; @endphp
                                                <span class="badge-custom" style="background-color: {{ $categoryColor['background'] }}; color: {{ $categoryColor['text'] }}">{{ $post->category->name }}</span>
                                            </td>

                                            <td class="text-center align-middle">{{ $post->getFormattedCountAttribute($post->views_count) }}</td>
                                            <td class="text-center align-middle">{{ $post->formattedTimestamp($post->created_at) }}</td>

                                            <td class="text-center align-middle">
                                                <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <div class="btn-group">
                                                        <a href="{{ route('admin.posts.show', ['username' => $post->user->username, 'post' => $post->slug]) }}"
                                                            class="btn btn-sm btn-info bg-gradient">
                                                            <i class="fa fa-eye"></i>
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
                                        <td colspan="7" class="text-center py-5">
                                            <h4 class="m-0">{{ __('No posts found') }}</h4>
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
            const url = '{{ route('admin.posts.index') }}';

            if (searchValue.trim() !== '') {
                params.q = encodeURIComponent(searchValue.trim());
            }

            const queryString = Object.keys(params).map(key => key + '=' + params[key]);

            const finalUrl = url + '?' + queryString;
            window.location.href = finalUrl;
        }
    </script>
@endprepend
