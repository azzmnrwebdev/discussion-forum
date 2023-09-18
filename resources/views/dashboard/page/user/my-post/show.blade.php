@extends('dashboard.index')
@section('title-head', 'Dashboard - Detail Posts')
@section('title-content', 'Detail Posts')

@prepend('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,300;6..12,400&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500;600;700;800&display=swap');

        .card-body {
            color: #242424;
            font-family: 'Nunito Sans', sans-serif;
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

        .post-title {
            font-size: 26px;
            line-height: 36px;
            font-weight: 700;
            margin-bottom: 0;
            margin-top: 1rem;
            font-family: 'Roboto Slab', serif;
        }

        .card-text~p,
        .card-text~p~ul,
        .card-text~p~ol {
            font-size: 18px;
            line-height: 28px;
        }

        pre {
            background-color: #EEEEEE;
            padding: 14px 10px;
            border: 1px solid #C4C4C4;
            overflow-x: auto;
        }

        code {
            font-size: 18px;
            font-family: 'Monaco', monospace;
        }

        /* section comment */
        .ck-editor__editable_inline {
            height: 200px;
        }

        .ck-editor__editable_inline:focus,
        .ck.ck-editor__editable.ck-focused:not(.ck-editor__nested-editable) {
            box-shadow: none !important;
            border-color: #ced4da !important;
        }

        #section-comments .card .card-header .card-title {
            font-weight: 600;
            font-family: 'Monaco', monospace;
        }

        #section-comments article {
            margin-bottom: 0.625rem;
        }

        #section-comments article:last-child {
            margin-bottom: 0;
        }

        #section-comments .card .card-body .card-text.post-comments~p {
            font-size: 16px;
            color: #191919;
            line-height: 22px;
            font-family: 'Nunito Sans', sans-serif;
        }

        #section-comments .card .card-body .card-text.post-comments span.username {
            font-size: 15px;
        }

        #section-comments .card .card-body .card-text.post-comments span.username,
        #section-comments .card .card-body .card-text.post-date {
            color: #6B6B6B !important;
        }

        #section-comments .card .card-body .card-text.post-date {
            font-size: 14px !important;
            margin-top: -10px;
        }

        #section-comments .card .card-body .card-text.post-date a:hover,
        #section-comments .card .card-body button.view-reply:hover {
            text-decoration: underline;
        }

        #section-comments .card .card-body button.view-reply {
            border: 0;
            margin: 0;
            padding: 0;
            outline: 0;
            font-size: 14px;
            color: #6B6B6B;
            background: transparent;
        }

        /* sidebar post */
        .btn-user-liked-modal,
        .btn-user-favorited-modal {
            font-weight: 600;
            font-family: 'Nunito Sans', sans-serif;
        }

        .btn-user-liked-modal,
        .btn-user-favorited-modal,
        #userLikedModal .modal-dialog .modal-content .modal-body ul li,
        #userFavoritesModal .modal-dialog .modal-content .modal-body ul li {
            color: #6B6B6B;
        }

        .btn-user-liked-modal:hover,
        .btn-user-favorited-modal:hover,
        #userLikedModal .modal-dialog .modal-content .modal-body ul li:hover,
        #userFavoritesModal .modal-dialog .modal-content .modal-body ul li:hover {
            cursor: pointer;
            color: #191919;
            text-decoration: underline;
        }

        @media (min-width: 768px) {
            .post-title {
                font-size: 32px;
                line-height: 42px;
            }

            .card-text~p,
            .card-text~p~ul,
            .card-text~p~ol {
                font-size: 20px;
                line-height: 30px;
            }

            code {
                font-size: 20px;
            }
        }
    </style>

    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="{{ url('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css') }}">
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.posts.index') }}">{{ __('My Posts') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Detail') }}</li>
@endsection

@section('content')
    <div class="card" style="border-top: 4px solid darkorange;">
        <div class="card-body">
            <div class="row justify-content-center py-5">
                {{-- detail post --}}
                <div class="col-sm-10 col-lg-8 col-xl-6">
                    @if (Session('success'))
                        <div id="alert-msg" class="alert alert-success alert-dismissible mb-3">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            {{ Session('success') }}
                        </div>
                    @endif

                    <hr />

                    <div class="d-flex justify-content-around">
                        <a href="javascript:void(0)" class="btn-user-liked-modal" data-toggle="modal"
                            data-target="#userLikedModal">User Liked</a>
                        <a href="javascript:void(0)" class="btn-user-favorited-modal" data-toggle="modal"
                            data-target="#userFavoritesModal">User
                            Favorited</a>
                    </div>

                    <hr />

                    <x-detail-post-card :postId="$post->id" />

                    <hr />

                    {{-- komentar --}}
                    <section id="section-comments">
                        <form action="{{ route('comments.store') }}" method="post" class="mb-4">
                            @csrf

                            <div class="form-group">
                                <label class="form-label">Add Comment</label>
                                <input type="hidden" name="posts_id" value="{{ $post->id }}">
                                <textarea id="mainComment" name="content" class="form-control" placeholder="Type your comment"
                                    aria-describedby="contentHelp"></textarea>
                                <small id="contentHelp" class="form-text text-muted">Comments cannot exceed 300
                                    characters.</small>

                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" id="btn-comment" class="btn btn-sm btn-success" disabled>Send 🚀</button>
                        </form>

                        @if (Session('comment_success'))
                            <div id="alert-msg" class="alert alert-success alert-dismissible mb-3">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ Session('comment_success') }}
                            </div>
                        @endif

                        <div class="card" style="border-top: 4px solid darkorange;">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">Comments ({{ $totalComments }})</h5>
                                    <div class="card-tools">
                                        <button type="button" class="close d-none">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                @forelse ($post->comments as $comment)
                                    <article class="mr-0 mr-md-2">
                                        <p class="card-text post-comments mb-0">
                                            <span class="username">
                                                @if ($comment->user->name === $post->user->name)
                                                    {{ $comment->user->name }}&nbsp;·&nbsp;<strong
                                                        style="color: darkorange !important;">Author</strong>
                                                @else
                                                    {{ $comment->user->name }}
                                                @endif
                                            </span><br>
                                            {!! $comment->content !!}
                                        </p>

                                        <p class="card-text post-date mb-2">
                                            {{ $comment->formattedTimestamp($comment->created_at) }}&nbsp;&nbsp;·&nbsp;&nbsp;<a
                                                href="javascript:void(0);" class="text-reset" data-toggle="modal"
                                                data-target="#replyCommentModal{{ $comment->id }}"
                                                data-comment-id="{{ $comment->id }}">Reply</a></p>

                                        {{-- modal reply comment --}}
                                        <div class="modal fade" id="replyCommentModal{{ $comment->id }}" tabindex="-1"
                                            aria-labelledby="replyCommentModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="replyCommentModalLabel">Reply Comment
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <form action="{{ route('comments.reply', $comment->id) }}"
                                                            method="post">
                                                            @csrf

                                                            <div class="form-group">
                                                                <input type="hidden" name="posts_id"
                                                                    value="{{ $post->id }}">
                                                                <textarea id="replyComment" name="content" class="form-control" placeholder="Type your reply comment"
                                                                    aria-describedby="contentHelp"></textarea>
                                                                <small id="contentHelp"
                                                                    class="form-text text-muted">Comments cannot exceed 300
                                                                    characters.</small>

                                                                @error('content')
                                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <button type="submit"
                                                                class="btn btn-sm btn-success btn-reply-comment"
                                                                disabled>Send 🚀</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- reply --}}
                                        @if (count($comment->replies) > 0)
                                            <button type="button" class="view-reply" data-reply-button
                                                data-target="reply-card-{{ $comment->id }}"
                                                data-reply-count="{{ $totalReplyComments[$comment->id] }}">View
                                                {{ $totalReplyComments[$comment->id] }} reply</button>

                                            <div class="card mt-3 shadow-none"
                                                style="background-color: #F4F6F9; display: none;"
                                                data-reply-card="reply-card-{{ $comment->id }}">
                                                <div class="card-body">
                                                    @foreach ($comment->replies as $reply)
                                                        <article>
                                                            <p class="card-text post-comments mb-0">
                                                                <span class="username">
                                                                    @if ($reply->user->name === $post->user->name)
                                                                        {{ $reply->user->name }}&nbsp;·&nbsp;<strong
                                                                            style="color: darkorange !important;">Author</strong>
                                                                    @else
                                                                        {{ $reply->user->name }}
                                                                    @endif
                                                                </span><br>

                                                                {!! $reply->content !!}
                                                            </p>

                                                            <p class="card-text post-date">
                                                                {{ $reply->formattedTimestamp($reply->created_at) }}</p>
                                                        </article>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </article>
                                @empty
                                    <article>
                                        <p class="card-text post-comments mb-0">
                                            Be you first comment
                                        </p>
                                    </article>
                                @endforelse
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    {{-- user liked modal --}}
    <div class="modal fade" id="userLikedModal" tabindex="-1" aria-labelledby="userLikedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLikedModalLabel">User Liked ({{ count($likedUsers) }})</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (count($likedUsers) > 0)
                        <ul class="pl-0 ml-3 mb-0 d-inline-block">
                            @foreach ($likedUsers as $item)
                                <li class="card-text">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <h5 class="m-0 text-center">Empty</h5>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- user favorited modal --}}
    <div class="modal fade" id="userFavoritesModal" tabindex="-1" aria-labelledby="userFavoritesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userFavoritesModalLabel">User Favorited ({{ count($favoritedUsers) }})
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (count($favoritedUsers) > 0)
                        <ul class="pl-0 ml-3 mb-0 d-inline-block">
                            @foreach ($favoritedUsers as $item)
                                <li class="card-text">{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <h5 class="m-0 text-center">Empty</h5>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    {{-- ckeditor js --}}
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function() {
            // show hide card data reply comment
            const replyButtons = $('[data-reply-button]');
            replyButtons.each(function() {
                $(this).click(function() {
                    const targetId = $(this).attr('data-target');
                    const replyCard = $(`[data-reply-card="${targetId}"]`);

                    let isVisible = replyCard.is(':visible');
                    if (isVisible) {
                        replyCard.slideUp();
                        isVisible = false;
                    } else {
                        replyCard.slideDown();
                        isVisible = true;
                    }

                    const buttonText = isVisible ? "Hide" :
                        `View ${$(this).attr('data-reply-count')} reply`;
                    $(this).text(buttonText);
                });
            });

            // ckeditor installation
            ClassicEditor
                .create(document.querySelector('#mainComment'), {
                    toolbar: {
                        removeItems: ['undo', 'redo', 'heading', 'alignment', 'fontFamily', 'fontSize',
                            'fontColor', 'fontBackgroundColor', 'insertTable', 'blockQuote', 'indent',
                            'outdent', 'insertHTML', 'htmlEmbed', 'horizontalLine'
                        ],
                        shouldNotGroupWhenFull: false
                    }
                })
                .then(editor => {
                    window.editor = editor;

                    editor.model.document.on('change:data', () => {
                        const contentLength = editor.getData().replace(/<[^>]*>/g, '').trim().length;

                        if (contentLength >= 1 && contentLength <= 300) {
                            $('#btn-comment').prop('disabled', false);
                        } else {
                            $('#btn-comment').prop('disabled', true);
                        }
                    });
                })
                .catch(handleSampleError);

            document.querySelectorAll('#replyComment').forEach((textarea) => {
                ClassicEditor
                    .create(textarea, {
                        toolbar: {
                            removeItems: ['undo', 'redo', 'heading', 'alignment', 'fontFamily',
                                'fontSize', 'fontColor', 'fontBackgroundColor', 'insertTable',
                                'blockQuote', 'indent', 'outdent', 'insertHTML', 'htmlEmbed',
                                'horizontalLine'
                            ],
                            shouldNotGroupWhenFull: false
                        }
                    })
                    .then(editor => {
                        window.editor = editor;

                        editor.model.document.on('change:data', () => {
                            const contentLength = editor.getData().replace(/<[^>]*>/g, '')
                                .trim().length;

                            if (contentLength >= 1 && contentLength <= 300) {
                                $('.btn-reply-comment').prop('disabled', false);
                            } else {
                                $('.btn-reply-comment').prop('disabled', true);
                            }
                        });
                    })
                    .catch(handleSampleError);
            });

            function handleSampleError(error) {
                const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

                const message = [
                    'Oops, something went wrong!',
                    `Please, report the following error on ${ issueUrl } with the build id "1ptf54pogxbl-ivtyglvak89y" and the error stack trace:`
                ].join('\n');

                console.error(message);
                console.error(error);
            }
        });
    </script>
@endprepend
