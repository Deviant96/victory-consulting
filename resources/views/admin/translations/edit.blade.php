@extends('admin.layouts.app')

@section('title', 'Edit Translation')
@section('page-title', 'Edit Translation')

@section('content')
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
        <form action="{{ route('admin.translations.update', $translationKey) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.translations.form')

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.translations.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Back</a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg shadow">Update Translations</button>
            </div>
        </form>
    </div>
@endsection
