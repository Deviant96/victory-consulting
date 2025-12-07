{{-- Enhanced Select Component --}}
@props([
    'label' => '',
    'name',
    'value' => '',
    'options' => [],
    'placeholder' => 'Select an option',
    'required' => false,
    'disabled' => false,
    'help' => '',
])

<div {{ $attributes->merge(['class' => 'w-full']) }}>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700 mb-1">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="w-full px-4 py-2.5 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition disabled:bg-slate-50 disabled:text-slate-500 @error($name) border-red-500 focus:ring-red-500 @enderror"
    >
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @if(isset($slot) && !empty(trim($slot)))
            {{ $slot }}
        @else
            @foreach($options as $optValue => $optLabel)
                <option value="{{ $optValue }}" {{ old($name, $value) == $optValue ? 'selected' : '' }}>
                    {{ $optLabel }}
                </option>
            @endforeach
        @endif
    </select>
    
    @if($help)
        <p class="mt-1 text-xs text-slate-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
