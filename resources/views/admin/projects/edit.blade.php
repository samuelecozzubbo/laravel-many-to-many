@extends('layouts.app')

@section('content')
    <h1>Modifica {{ $project->title }}</h1>
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }} </li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf <!-- Token CSRF necessario per protezione -->
        @method('PUT')
        {{-- Title --}}
        <div class="form-group">
            <label for="title">Titolo</label>
            <input value="{{ old('title', $project->title) }}" type="text" name="title" id="title"
                class="@error('title') is-invalid @enderror form-control">
            @error('title')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="txt">Descrizione</label>
            <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control"
                rows="5">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Start date --}}
        <div class="form-group">
            <label for="reading_time">Data di inizio</label>
            <input value="{{ old('start_date', $project->start_date) }}" type="string" name="start_date" id="start_date"
                class="@error('start_date') is-invalid @enderror form-control" min="1">
            @error('start_date')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- End date --}}
        <div class="form-group">
            <label for="end_date">Data di fine</label>
            <input value="{{ old('end_date', $project->end_date) }}" type="string" name="end_date" id="end_date"
                class="@error('end_date') is-invalid @enderror form-control">
            @error('end_date')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        {{-- Collaborators --}}
        <div class="form-group">
            <label for="collaborators">Numero di collaboratori</label>
            <input value="{{ old('collaborators', $project->collaborators) }}" type="number" name="collaborators"
                id="collaborators" class="@error('collaborators') is-invalid @enderror form-control" min="1">
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
                    <option value="{{ $type->id }}" @if (old('type_id', $project->type_id) == $type->id) selected @endif>
                        {{ $type->name }}
                    </option>
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
                        @if (
                            ($errors->any() && in_array($technology->id, old('technologies', []))) ||
                                (!$errors->any() && $project->technologies->contains($technology))) checked @endif>
                    <label class="btn btn-outline-primary"
                        for="technology-{{ $technology->id }}">{{ $technology->name }}</label>
                @endforeach
            </div>
        </div>

        {{-- Immagine --}}
        <div class="form-group mb-3">
            <label for="img">Immagine</label>
            <input type="file" name="img" id="img" class="form-control" placeholder="Scegli un file"
                onchange=showImage(event)>
            {{-- Mostra immagine --}}
            <img src="{{ asset('storage/' . $project->img) }}" alt="{{ $project->image_original_name }}"
                onerror="this.src='/img/no-image.png'" class="thumb w-50" id="thumb">
            @error('img')
                <small class="text-danger"> {{ $message }} </small>
            @enderror
        </div>

        <script>
            function showImage(event) {
                //console.log(event.target.files[0]);
                //console.log(URL.createObjectURL(event.target.files[0]));

                const thumb = document.getElementById('thumb');
                thumb.src = URL.createObjectURL(event.target.files[0]);

            }
        </script>


        <button type="submit" class="btn btn-danger">Modifica Progetto</button>
    </form>
@endsection
