@extends('admin.layouts.app')

@section('title', isset($translationKey) ? 'Edit Translation' : 'New Translation')

@section('content')
    @livewire('admin.translations.translation-form', ['translationKey' => $translationKey ?? null])
@endsection
