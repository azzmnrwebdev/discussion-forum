<?php

namespace App\View\Components;

use App\Models\Post;
use Illuminate\View\Component;

class DetailPostCard extends Component
{
    public $post;

    public function __construct($postId)
    {
        $this->post = Post::find($postId);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.detail-post-card');
    }
}
