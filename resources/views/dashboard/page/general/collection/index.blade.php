@extends('dashboard.index')
@section('title-head', 'Dashboard - My Collection')
@section('title-content', 'My Collection')

@prepend('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500;600;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,300;6..12,400&display=swap');

        .ellipsis {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .post-wrapper {
            margin-bottom: 1.5rem;
        }

        .post-wrapper:last-child {
            margin-bottom: 0;
        }

        .post-title {
            font-size: 20px;
            font-weight: 800;
            color: #242424;
            line-height: 24px;
            font-family: 'Roboto Slab', serif;
        }

        .post-title:hover {
            color: #242424;
        }

        .post-content {
            font-size: 16px;
            color: #6B6B6B;
            line-height: 20px;
            font-family: 'Nunito Sans', sans-serif;
        }

        .post-footer {
            font-size: 13px !important;
            color: #6B6B6B !important;
            font-family: 'Nunito Sans', sans-serif;
        }

        .badge-custom {
            padding: 2px 6px;
            font-weight: 500;
            font-size: 13px;
            text-align: center;
            white-space: nowrap;
            display: inline-block;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('My Collection') }}</li>
@endsection

@section('content')
    <div class="card" style="border-top: 4px solid darkorange;">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-10 col-lg-8 col-xl-6 py-4">
                    @if (Session('success'))
                        <div id="alert-msg" class="alert alert-success alert-dismissible mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ Session('success') }}
                        </div>
                    @endif

                    @forelse ($likedPosts as $post)
                        <x-post-card
                            :postLink="route('collection.show', $post->slug)"
                            :postTitle="$post->title"
                            :postSlug="$post->slug"
                            :postDateCreate="$post->formattedTimestamp($post->created_at)"
                            :postUserName="$post->user->name"
                            :postCategoryName="$post->category->name"
                        />
                    @empty
                        <div class="alert alert-info m-0" role="alert">
                            There are no posts that have been liked yet
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    <script>
        $(document).ready(function() {
            const likedPosts = @json($likedPosts);

            likedPosts.forEach(function(post, index) {
                const dataContent = post.content;

                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = dataContent;

                const firstPElement = tempDiv.querySelector('p');
                const postContent = document.querySelectorAll('.post-content');

                if (postContent[index]) {
                    postContent[index].innerHTML = firstPElement.innerHTML;
                }
            });
        });
    </script>
@endprepend
