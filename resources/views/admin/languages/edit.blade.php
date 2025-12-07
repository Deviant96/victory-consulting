@extends('admin.layouts.app')

@section('title', 'Edit Language')
@section('page-title', 'Edit Language')

@section('content')
    <div class="bg-white border border-gray-200 shadow-sm rounded-xl p-6">
        <form action="{{ route('admin.languages.update', $language) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            @include('admin.languages.form')

            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.languages.index') }}" class="px-4 py-2 text-sm text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancel</a>
                <button type="submit" class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg shadow">Update Language</button>
            </div>
        </form>
    </div>
@endsection
