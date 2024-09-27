<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Functions\Helper;
use App\Http\Requests\ProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('id', 'desc')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Helper::generateSlug($data['title'], Project::class);

        //VERIFICO se viene caricata l'immagine ossia se esiste la chaive img
        if (array_key_exists('img', $data)) {
            //se esiste la chiave salvo immagine dentro storage nella cartella uploads
            $img = Storage::put('public/uploads', $data['img']);
            //ottengo il nome originale dell'immagine
            //aggiungo i valori a $data
            $original_name = $request->file('img')->getClientOriginalName();
            $data['img'] = $img;
            $data['image_original_name'] = $original_name;
        }

        $project = Project::create($data);
        //Verifico che in data esista la chiave tags che sta a significare che sono stati selezionati dei tag
        if (array_key_exists('technologies', $data)) {
            //Se esiste la chiave creo con attach la relazione con il post creato e gli id dei tag selezionati
            $project->technologies()->attach($data['technologies']);
        }

        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $data = $request->all();
        if ($data['title'] != $project->title) {
            $data['slug'] = Helper::generateSlug($data['title'], Project::class);
        }

        //VERIFICO se viene caricata l'immagine ossia se esiste la chaive img
        if (array_key_exists('img', $data)) {
            $img = Storage::delete($project->img);

            //cancello la vecchia e metto la buova img
            $img = Storage::put('public/uploads', $data['img']);
            $original_name = $request->file('img')->getClientOriginalName();
            $data['img'] = $img;
            $data['image_original_name'] = $original_name;
        }


        $project->update($data);

        //Verifico che in data esista la chiave technologies che sta a significare che sono stati selezionate delle tecnologie
        if (array_key_exists('technologies', $data)) {
            //Se invio dei tag aggiorno tutte le relazioni
            //sync aggiunge le relazioni mancanti e cancella quelle che non esistono più
            $project->technologies()->sync($data['technologies']);
        } else {
            //se non vengono inviati tag devo cancellare le relazioni
            //detach cancella tutte le relzioni
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.show', $project)->with('message', 'Post modificato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //SE è PRESENTE UN IMMAGINE LA ELIMINO
        if ($project->img) {
            Storage::delete($project->img);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')->with('cancelled', 'Post eliminato con successo');
    }
}
