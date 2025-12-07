<?php

namespace App\Livewire\Admin\Faqs;

use App\Models\Faq;
use Livewire\Component;

class FaqForm extends Component
{
    public $faqId;
    public $question = '';
    public $answer = '';
    public $category = '';
    public $order = 0;
    public $published = true;

    public $isEditMode = false;

    protected function rules()
    {
        return [
            'question' => 'required|string|max:500',
            'answer' => 'required|string|max:2000',
            'category' => 'nullable|string|max:100',
            'order' => 'required|integer|min:0',
            'published' => 'boolean',
        ];
    }

    public function mount($faqId = null)
    {
        if ($faqId) {
            $this->isEditMode = true;
            $this->faqId = $faqId;
            $this->loadFaq();
        } else {
            // Set default order to highest + 1
            $this->order = Faq::max('order') + 1 ?? 0;
        }
    }

    public function loadFaq()
    {
        $faq = Faq::findOrFail($this->faqId);
        
        $this->question = $faq->question;
        $this->answer = $faq->answer;
        $this->category = $faq->category ?? '';
        $this->order = $faq->order;
        $this->published = $faq->published;
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->isEditMode) {
            $faq = Faq::findOrFail($this->faqId);
            $faq->update($validated);
            
            $message = 'FAQ updated successfully';
        } else {
            Faq::create($validated);
            
            $message = 'FAQ created successfully';
        }

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $message
        ]);

        return redirect()->route('admin.faqs.index');
    }

    public function cancel()
    {
        return redirect()->route('admin.faqs.index');
    }

    public function render()
    {
        // Get existing categories for suggestions
        $existingCategories = Faq::distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        return view('livewire.admin.faqs.faq-form', [
            'existingCategories' => $existingCategories,
        ]);
    }
}
