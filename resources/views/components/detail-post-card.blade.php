{{-- category --}}
<span class="badge-custom badge-dark">{{ $post->category->name }}</span>

{{-- title --}}
<h3 class="post-title mb-2">{{ $post->title }}</h3>

{{-- author and view posts --}}
<p class="card-text" style="font-size: 14px;">Uploaded {{ $post->created_at->format('d M Y') }} by <strong>{{ $post->user->name }}</strong>&nbsp;&nbsp;·&nbsp;&nbsp;{{ $post->getFormattedCountAttribute($post->views_count) }} visited</p>

{{-- images --}}
@if (count($post->images) > 0)
    {{-- small --}}
    <div class="card-columns">
        {{-- @foreach ($post->images as $image)

        @endforeach --}}
        <div class="card">
            <img src="https://images.unsplash.com/photo-1694660311859-52ce3b99ef62?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" class="card-img-top" alt="...">
        </div>
        <div class="card">
            <img src="https://images.unsplash.com/photo-1694660311859-52ce3b99ef62?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" class="card-img-top" alt="...">
        </div>
        <div class="card">
            <img src="https://images.unsplash.com/photo-1694660311859-52ce3b99ef62?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" class="card-img-top" alt="...">
        </div>
    </div>
@endif

{{-- content --}}
<p class="card-text" style="margin-top: -10px;">{!! $post->content !!}</p>

{{-- like and favorite --}}
<div class="d-flex align-items-center">
    <form action="{{ route('post.like', $post->id) }}" method="POST" class="mr-3">
        @csrf
        <button type="submit" class="m-0 p-0 border-0"  style="line-height: 0; font-size: 16px; color: #222; background: transparent;" title="Like">
            @if ($post->likes->contains('users_id', auth()->user()->id))
                <i class="bi bi-heart-fill align-middle mr-1" style="color: #FF0000;"></i>{{ $post->getFormattedCountAttribute($post->likes->count()) }} like
            @else
                <i class="bi bi-heart align-middle mr-1" style="color: #FF0000;"></i>{{ $post->getFormattedCountAttribute($post->likes->count()) }} like
            @endif
        </button>
    </form>

    <form action="{{ route('post.favorite', $post->id) }}" method="POST">
        @csrf
        <button type="submit" class="m-0 p-0 border-0" style="line-height: 0; font-size: 16px; color: #222; background: transparent;" title="Favorite">
            @if ($post->favorites->contains('users_id', auth()->user()->id))
                <i class="bi bi-bookmark-fill align-middle mr-1" style="color: #FF8C00;"></i>{{ $post->getFormattedCountAttribute($post->favorites->count()) }} favorite
            @else
                <i class="bi bi-bookmark align-middle mr-1" style="color: #FF8C00;"></i>{{ $post->getFormattedCountAttribute($post->favorites->count()) }} favorite
            @endif
        </button>
    </form>
</div>
