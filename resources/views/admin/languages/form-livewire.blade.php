@extends('admin.layouts.app')

@section('title', isset($language) ? 'Edit Language' : 'New Language')

@section('content')
    @livewire('admin.languages.language-form', ['language' => $language ?? null])
@endsection
