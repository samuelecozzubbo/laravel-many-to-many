@extends('layouts.app')

@section('content')
    <h1>Crea un nuovo progetto</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token CSRF necessario per protezione -->

        {{-- Title --}}
        <div class="form-group">
            <label for="title">Titolo</label>
            <input value="{{ old('title') }}" type="text" name="title" id="title"
                class="@error('title') is-invalid @enderror form-control">
            @error('title')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="txt">Descrizione</label>
            <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"
                rows="5">{{ old('description') }}</textarea>
            @error('description')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Start date --}}
        <div class="form-group">
            <label for="reading_time">Data di inizio</label>
            <input value="{{ old('start_date') }}" type="date" name="start_date" id="start_date"
                class="@error('start_date') is-invalid @enderror form-control" min="1">
            @error('start_date')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- End date --}}
        <div class="form-group">
            <label for="end_date">Data di fine</label>
            <input value="{{ old('end_date') }}" type="string" name="end_date" id="end_date"
                class="@error('end_date') is-invalid @enderror form-control">
            @error('end_date')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Collaborators --}}
        <div class="form-group">
            <label for="collaborators">Numero di collaboratori</label>
            <input value="{{ old('collaborators') }}" type="number" name="collaborators" id="collaborators"
                class="@error('collaborators') is-invalid @enderror form-control" min="1">
            @error('collaborators')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Tipo --}}
        <div class="form-group">
            <label for="type">Tipo</label>
            <select class="form-select" aria-label="Default select example" id="type" name="type_id">
                <option value="">Seleziona un tipo di progetto</option>
                @foreach ($types as $type)
                    <option @if (old('type_id') == $type->id) selected @endif value="{{ $type->id }}">
                        {{ $type->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tecnologie --}}
        <div class="form-group">
            <label for="type">Tecnologie</label>
            <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                @foreach ($technologies as $technology)
                    <input type="checkbox" class="btn-check" id="technology-{{ $technology->id }}" autocomplete="off"
                        value="{{ $technology->id }}" name="technologies[]"
                        @if (in_array($technology->id, old('technologies', []))) checked @endif>
                    <label class="btn btn-outline-primary"
                        for="technology-{{ $technology->id }}">{{ $technology->name }}</label>
                @endforeach
            </div>
        </div>

        {{-- Immagine --}}
        <div class="form-group mb-3">
            <label for="img">Immagine</label>
            <input type="file" name="img" id="img" class="form-control" placeholder="Scegli un file">
            @error('img')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>


        <button type="submit" class="btn btn-primary">Crea Progetto</button>
    </form>
@endsection
