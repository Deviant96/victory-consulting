@extends('admin.layouts.app')

@section('title', 'Add Translation Key')
@section('page-title', 'Add Translation Key')

@section('content')
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
        <form action="{{ route('admin.translations.store') }}" method="POST" class="space-y-6">
            @csrf
            @include('admin.translations.form')

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.translations.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg shadow hover:bg-indigo-700">Save Key</button>
            </div>
        </form>
    </div>
@endsection
