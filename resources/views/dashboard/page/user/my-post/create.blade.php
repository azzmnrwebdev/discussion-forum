@extends('dashboard.index')
@section('title-head', 'Dashboard - Create Posts')
@section('title-content', 'Create Posts')

@prepend('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- filepond css --}}
    <link href="{{ url('https://unpkg.com/filepond/dist/filepond.css') }}" rel="stylesheet">
    <link href="{{ url('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css') }}" rel="stylesheet"/>
    <link href="{{ url('https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css') }}" rel="stylesheet"/>

    <style>
        .form-control:focus {
            border-color: darkorange;
        }

        .ck-editor__editable_inline {
            height: 300px;
        }

        .ck-editor__editable_inline:focus,
        .ck.ck-editor__editable.ck-focused:not(.ck-editor__nested-editable) {
            box-shadow: none !important;
            border-color: #ced4da !important;
        }

        #tagList li:hover,
        #kategoriList li:hover {
            cursor: pointer;
            background-color: #f0f0f0;
        }

        #tagList .list-group-item:last-child,
        #kategoriList .list-group-item:last-child {
            margin-bottom: 0 !important;
        }

        #tagList li.selected,
        #kategoriList li.selected,
        #tagList li.selected:hover,
        #kategoriList li.selected:hover {
            background-color: rgba(22, 255, 41, 0.398);
        }

        .filepond--drop-label label {
            font-weight: 400 !important;
        }
    </style>
@endprepend

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('user.posts.index') }}">{{ __('My Posts') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card" style="border-top: 4px solid darkorange;">
                <div class="card-body">
                    <form action="{{ route('user.posts.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            {{-- title --}}
                            <div class="form-group col-12">
                                <label for="title">{{ __('Post Title') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Title">

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- category --}}
                            <div class="form-group col-12">
                                <label for="inputCategory" class="form-label">{{ __('Category') }} <span class="text-danger">{{ __('*') }}</span></label>
                                <input type="hidden" name="categories_id" id="kategoriID" value="{{ old('categories_id') }}">
                                <input type="text" name="input_category" id="inputCategory" class="form-control @error('categories_id') is-invalid @enderror bg-white" value="{{ old('input_category') }}" placeholder="Click Here" readonly>

                                @error('categories_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- modal celect category --}}
                            <div class="modal fade" id="kategoriModal" tabindex="-1" aria-labelledby="kategoriModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="kategoriModalLabel">Select Category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            {{-- search category --}}
                                            <div class="mb-3">
                                                <label for="kategoriSearch" class="form-label">{{ __('Search') }}</label>
                                                <input type="search" id="kategoriSearch" class="form-control" placeholder="Search category">
                                            </div>

                                            <hr />

                                            {{-- list category --}}
                                            <div style="width: 100%; height: 230px; overflow-y: scroll;">
                                                <ul class="list-group mr-1" id="kategoriList">
                                                    @foreach ($categories as $category)
                                                        <li class="mb-2 rounded list-group-item border-top"
                                                            title="{{ $category->name }}"
                                                            data-category-id="{{ $category->id }}">{{ $category->name }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- images --}}
                            <div class="form-group col-12">
                                <label for="image">{{ __('Multiple Image') }}</label>
                                <input type="file" name="image" id="image" class="filepond mb-0" accept="image/png,image/jpg,image/jpeg" data-allow-reorder="true"  data-max-file-size="3MB" data-max-files="4" aria-describedby="imageHelp" multiple>
                                <small id="imageHelp" class="form-text text-muted">Image uploads are only required if your question requires one.</small>
                            </div>

                            {{-- content --}}
                            <div class="form-group col-12">
                                <label for="content">{{ __('Content') }} <span class="text-danger">{{ __('*') }}</span></label>

                                @error('content')
                                    <div class="invalid-feedback d-block mb-2" style="margin-top: -5px !important;">
                                        {{ $message }}</div>
                                @enderror

                                <textarea id="content" name="content" class="form-control" placeholder="Content">{{ old('content') }}</textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check mr-3"></i>{{ __('Save Post') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    {{-- filepond js --}}
    <script src="{{ url('https://unpkg.com/filepond/dist/filepond.min.js') }}"></script>
    <script src="{{ url('https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js') }}"></script>
    <script src="{{ url('https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ url('https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ url('https://unpkg.com/filepond-plugin-image-validate-size/dist/filepond-plugin-image-validate-size.js') }}"></script>
    <script src="{{ url('https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js') }}"></script>

    {{-- ckeditor js --}}
    <script src="{{ asset('ckeditor/build/ckeditor.js') }}"></script>

    <script>
        $(document).ready(function() {
            // select kategori
            const kategoriID = $('#kategoriID');
            const inputCategory = $('#inputCategory');
            const kategoriModal = $('#kategoriModal');
            const kategoriSearch = $('#kategoriSearch');
            const kategoriList = $('#kategoriList');

            inputCategory.click(() => kategoriModal.modal('show'));

            kategoriSearch.on('keydown', (event) => {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });

            kategoriSearch.on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                kategoriList.find('li').closest('li').show();
                kategoriList.find('li').each(function() {
                    const kategoriLabel = $(this).text().trim().toLowerCase();
                    if (!kategoriLabel.includes(searchTerm)) {
                        $(this).closest('li').hide();
                    }
                });
            });

            kategoriList.on('click', 'li', function() {
                const selectedCategory = $(this).text();
                const categoryId = $(this).data('category-id');

                inputCategory.val(selectedCategory);
                kategoriID.val(categoryId);
                kategoriModal.modal('hide');

                markSelectedCategory(categoryId);
            });

            function markSelectedCategory(selectedCategoryId) {
                kategoriList.find('li').each(function() {
                    const categoryItem = $(this);
                    const categoryId = categoryItem.data('category-id');
                    categoryItem.toggleClass('selected', categoryId === selectedCategoryId);
                });
            }

            const selectedCategoryId = kategoriID.val();
            markSelectedCategory(selectedCategoryId);

            // filepond
            FilePond.registerPlugin(
                FilePondPluginFilePoster,
                FilePondPluginImagePreview,
                FilePondPluginFileEncode,
                FilePondPluginImageValidateSize,
                FilePondPluginImageExifOrientation
            );

            const inputFile = document.querySelector('input[id="image"]');
            const pond = FilePond.create(inputFile);

            FilePond.setOptions({
                server: {
                    process: '{{ route('filePond.upload_image') }}',
                    revert: (uniqueFileId, load, error) => {
                        deleteImage(uniqueFileId);
                        error('Error terjadi saat delete file');
                        load();
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                },
            });

            function deleteImage(fileName) {
                $.ajax({
                    url: '{{ route('filePond.delete_image') }}',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: "DELETE",
                    data: {image: fileName},
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(response) {
                        console.log('error')
                    }
                });
            }

            // ckeditor
            ClassicEditor
                .create( document.querySelector( '#content' ), {
                    toolbar: {
                        removeItems: ['fontFamily', 'insertTable', 'blockQuote', 'insertHTML', 'htmlEmbed'],
                        shouldNotGroupWhenFull: false
                    }
                } )
                .then( editor => {
                    window.editor = editor;
                } )
                .catch( handleSampleError );

            function handleSampleError( error ) {
                const issueUrl = 'https://github.com/ckeditor/ckeditor5/issues';

                const message = [
                    'Oops, something went wrong!',
                    `Please, report the following error on ${ issueUrl } with the build id "1ptf54pogxbl-ivtyglvak89y" and the error stack trace:`
                ].join( '\n' );

                console.error( message );
                console.error( error );
            }
        });
    </script>
@endprepend
