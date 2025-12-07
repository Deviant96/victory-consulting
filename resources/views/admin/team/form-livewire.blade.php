@extends('admin.layouts.app')

@section('title', $isEditMode ? 'Edit Team Member' : 'Add Team Member')

@section('content')
    <livewire:admin.team-members.team-member-form :member-id="$memberId ?? null" />
@endsection
