<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Functions\Helper;
use App\Models\Project;
use GuzzleHttp\Handler\Proxy;
use App\Models\Type;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        for ($i = 0; $i < 100; $i++) {
            $new_project = new Project();
            $new_project->type_id = Type::inRandomOrder()->first()->id;
            $new_project->title = $faker->sentence(3);
            $new_project->slug = Helper::generateSlug($new_project->title, Project::class);
            $new_project->description = $faker->paragraph();
            $new_project->start_date = $faker->date();
            $new_project->end_date = $faker->date();
            $new_project->collaborators = $faker->numberBetween(1, 10);
            $new_project->img = $faker->imageUrl();
            //dump($new_project);
            $new_project->save();
        }
    }
}
