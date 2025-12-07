@extends('admin.layouts.app')

@section('title', isset($solution) ? 'Edit Business Solution' : 'Add Business Solution')

@section('content')
    <livewire:admin.business-solutions.business-solution-form :solutionId="$solution->id ?? null" />
@endsection
