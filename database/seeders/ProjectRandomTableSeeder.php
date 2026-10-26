<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectRandomTableSeeder extends Seeder
{
    public function run(): void
    {
        $nomor = range(1, 25);
        shuffle($nomor); // acak urutan angka

        foreach ($nomor as $i) {
            Project::create([
                'title'       => 'Project Acak Ke-' . $i,
                'description' => 'Deskripsi untuk project acak ke-' . $i,
                'status'      => 'published',
            ]);
        }
    }
}