@extends('layouts.app')

@section('content')
    <h1>Elenco progetti</h1>

    @if (session('cancelled'))
        <p class="text-success">L'elemento è stato eliminato correttamente</p>
    @endif


    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Tipo</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->id }}</td>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->start_date }}</td>
                    <td>{{ $project->end_date }}</td>
                    <td>
                        @if ($project->type)
                            <span class="badge bg-success">
                                {{ $project->type->name }}
                            </span>
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-info">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form class="d-inline" action="{{ route('admin.projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
@endsection
