<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Technology;

class ProjectTechnologyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 200; $i++) {
            //estraggo un progetto random
            $project = Project::inRandomOrder()->first();

            //AI FINI DELLA RELAZIONE SERVE AVERE DA UN LATO UN ENTITA' E
            //DALL'ALTRO LATO L'ID DELL'ENTITA'
            //PERCHE' SI UTILIZZA IL METODO attach()
            //estraggo id di una tecnologia random
            $technology_id = Technology::inRandomOrder()->first()->id;

            //Aggiungo la relazione fra il progetto estratto e l'id della tecnologia estratta
            $project->technologies()->attach($technology_id);
        }
    }
}
