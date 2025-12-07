<?php

namespace App\Livewire\Admin\Articles;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithPagination;

class ArticlesIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $publishedFilter = '';
    public $perPage = 12;
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => ''],
        'publishedFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatingPublishedFilter()
    {
        $this->resetPage();
    }

    public function togglePublished($articleId)
    {
        $article = BlogPost::findOrFail($articleId);
        $article->update(['published' => !$article->published]);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $article->published ? 'Article published' : 'Article unpublished'
        ]);
    }

    public function deleteArticle($articleId)
    {
        $article = BlogPost::findOrFail($articleId);
        
        // Delete featured image if exists
        if ($article->featured_image && \Storage::disk('public')->exists($article->featured_image)) {
            \Storage::disk('public')->delete($article->featured_image);
        }
        
        $article->delete();

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Article deleted successfully'
        ]);
    }

    public function render()
    {
        $query = BlogPost::query();

        // Search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $this->search . '%')
                  ->orWhere('content', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Category filter
        if ($this->categoryFilter) {
            $query->where('category', $this->categoryFilter);
        }

        // Published filter
        if ($this->publishedFilter !== '') {
            $query->where('published', $this->publishedFilter === '1');
        }

        // Get categories for filter
        $categories = BlogPost::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        $articles = $query->orderBy('published_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.articles.articles-index', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }
}
