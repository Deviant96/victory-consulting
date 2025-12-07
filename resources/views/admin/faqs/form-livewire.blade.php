@extends('admin.layouts.app')

@section('title', isset($faq) ? 'Edit FAQ' : 'Add FAQ')

@section('content')
    <livewire:admin.faqs.faq-form :faqId="$faq->id ?? null" />
@endsection
