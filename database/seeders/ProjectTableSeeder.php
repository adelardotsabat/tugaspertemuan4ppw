<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    public function run(): void
    {
        Project::truncate(); // kosongkan tabel supaya data tidak menumpuk

        for ($i = 1; $i <= 20; $i++) {
            Project::create([
                'title'       => 'Project Judul Ke-' . $i,
                'description' => 'Deskripsi untuk project judul ke-' . $i,
                'status'      => 'published',
            ]);
        }
    }
}