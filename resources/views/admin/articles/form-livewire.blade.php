@extends('admin.layouts.app')

@section('title', isset($article) ? 'Edit Article' : 'New Article')

@section('content')
    <livewire:admin.articles.article-form :articleId="$article->id ?? null" />
@endsection
