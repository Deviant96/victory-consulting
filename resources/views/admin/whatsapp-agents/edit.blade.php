@extends('admin.layouts.app')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.whatsapp-agents.index') }}" class="text-green-600 hover:text-green-700 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to WhatsApp Agents
    </a>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit WhatsApp Agent</h1>

    <form action="{{ route('admin.whatsapp-agents.update', $whatsappAgent) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-6">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Agent Name *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $whatsappAgent->name) }}" required 
                   placeholder="e.g., John Doe"
                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror">
            @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">WhatsApp Phone Number *</label>
            <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $whatsappAgent->phone_number) }}" required 
                   placeholder="e.g., +628123456789 or 628123456789"
                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 @error('phone_number') border-red-500 @enderror">
            @error('phone_number')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Include country code (e.g., +62 for Indonesia)</p>
        </div>

        <div class="mb-6">
            <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Display Order</label>
            <input type="number" name="order" id="order" value="{{ old('order', $whatsappAgent->order) }}" min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-green-500 focus:border-green-500 @error('order') border-red-500 @enderror">
            @error('order')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
        </div>

        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $whatsappAgent->is_active) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Active (show in widget)</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                Update Agent
            </button>
            <a href="{{ route('admin.whatsapp-agents.index') }}" class="px-6 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
