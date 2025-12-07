@extends('admin.layouts.app')

@section('title', isset($item) ? 'Edit Why Choose Item' : 'Add Why Choose Item')

@section('content')
    <livewire:admin.why-choose-items.why-choose-item-form :itemId="$item->id ?? null" />
@endsection
