<?php

namespace App\Livewire\Admin\Articles;

use App\Models\BlogPost;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class ArticleForm extends Component
{
    use WithFileUploads;

    public $articleId;
    public $title = '';
    public $slug = '';
    public $excerpt = '';
    public $content = '';
    public $featured_image;
    public $existingImage = '';
    public $category = '';
    public $author = '';
    public $tags = [];
    public $tagInput = '';
    public $published = false;
    public $published_at;

    public $isEditMode = false;

    protected function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'nullable|string|max:100',
            'author' => 'nullable|string|max:100',
            'tags' => 'array',
            'published' => 'boolean',
            'published_at' => 'nullable|date',
        ];

        if ($this->isEditMode) {
            $rules['slug'] = 'required|string|max:255|unique:blog_posts,slug,' . $this->articleId;
            $rules['featured_image'] = 'nullable|image|max:2048';
        } else {
            $rules['featured_image'] = 'nullable|image|max:2048';
        }

        return $rules;
    }

    public function mount($articleId = null)
    {
        if ($articleId) {
            $this->isEditMode = true;
            $this->articleId = $articleId;
            $this->loadArticle();
        }
    }

    public function loadArticle()
    {
        $article = BlogPost::findOrFail($this->articleId);
        
        $this->title = $article->title;
        $this->slug = $article->slug;
        $this->excerpt = $article->excerpt ?? '';
        $this->content = $article->content;
        $this->existingImage = $article->featured_image ?? '';
        $this->category = $article->category ?? '';
        $this->author = $article->author ?? '';
        $this->tags = $article->tags ?? [];
        $this->published = $article->published;
        $this->published_at = $article->published_at?->format('Y-m-d\TH:i');
    }

    public function updatedTitle($value)
    {
        if (!$this->isEditMode || empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function removeImage()
    {
        $this->featured_image = null;
        $this->existingImage = '';
    }

    public function addTag()
    {
        $tag = trim($this->tagInput);
        
        if ($tag && !in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
            $this->tagInput = '';
        }
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
    }

    public function save()
    {
        $validated = $this->validate();

        // Handle image upload
        if ($this->featured_image) {
            $path = $this->featured_image->store('articles', 'public');
            $validated['featured_image'] = $path;
        } elseif ($this->existingImage) {
            $validated['featured_image'] = $this->existingImage;
        }

        // Set published_at if published
        if ($validated['published'] && !$validated['published_at']) {
            $validated['published_at'] = now();
        }

        if ($this->isEditMode) {
            $article = BlogPost::findOrFail($this->articleId);
            
            // Delete old image if new one uploaded
            if ($this->featured_image && $article->featured_image && \Storage::disk('public')->exists($article->featured_image)) {
                \Storage::disk('public')->delete($article->featured_image);
            }
            
            $article->update($validated);
            
            $message = 'Article updated successfully';
        } else {
            BlogPost::create($validated);
            
            $message = 'Article created successfully';
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('admin.articles.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.articles.index');
    }

    public function render()
    {
        // Get existing categories for suggestions
        $existingCategories = BlogPost::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('livewire.admin.articles.article-form', [
            'existingCategories' => $existingCategories,
        ]);
    }
}
