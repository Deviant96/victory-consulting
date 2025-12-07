@extends('admin.layouts.app')

@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')
@section('page-description', 'Manage your account information and security settings')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Profile Settings</h1>
    <p class="text-gray-600 mt-2">Manage your account information and security settings</p>
</div>

@livewire('admin.profile-edit')
@endsection
