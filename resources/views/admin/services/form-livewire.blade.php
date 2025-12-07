@extends('admin.layouts.app')

@section('title', isset($service) ? 'Edit Service' : 'Add Service')

@section('content')
    <livewire:admin.services.service-form :serviceId="$service->id ?? null" />
@endsection
