<div class="post-wrapper">
    {{-- title --}}
    <a href="{{ $postLink }}" class="post-title text-decoration-none ellipsis mb-1">{{ $postTitle }}</a>

    {{-- content --}}
    <p class="post-content ellipsis mb-0 mb-2"></p>

    {{-- date and category --}}
    <p class="post-footer mb-0"> {{ $postDateCreate }}&nbsp;&nbsp;·&nbsp;&nbsp;{{ $postUserName }}&nbsp;&nbsp;·&nbsp;&nbsp;<span class="badge-custom" style="background-color: #f1f5f9; color: #6B6B6B;">{{ $postCategoryName }}</span></p>
</div>
