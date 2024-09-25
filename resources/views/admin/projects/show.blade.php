@extends('layouts.app')

@section('content')
    <div class="container">
        @if (@session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <h1>{{ $project->title }}</h1>
        <p>Description: {{ $project->description }}</p>
        <p>Start Date: {{ $project->start_date }}</p>
        <p>End Date: {{ $project->end_date }}</p>
        <p>Collaborators: {{ $project->collaborators }}</p>
        <p>Categoria: {{ $project->type ? $project->type->name : 'Nessuna categoria' }}</p>
        @if ($project->img)
            <img src="{{ $project->img }}" alt="{{ $project->title }}">
        @endif
        <br>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-warning mt-3">Torna alla lista</a>
    </div>
@endsection
