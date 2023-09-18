<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostCard extends Component
{
    public $postLink;
    public $postTitle;
    public $postSlug;
    public $postDateCreate;
    public $postUserName;
    public $postCategoryName;

    public function __construct($postLink, $postTitle, $postSlug, $postDateCreate, $postUserName, $postCategoryName)
    {
        $this->postLink = $postLink;
        $this->postTitle = $postTitle;
        $this->postSlug = $postSlug;
        $this->postDateCreate = $postDateCreate;
        $this->postUserName = $postUserName;
        $this->postCategoryName = $postCategoryName;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.post-card');
    }
}
