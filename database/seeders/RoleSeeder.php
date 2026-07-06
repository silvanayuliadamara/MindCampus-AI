<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::create([
            'name' => 'mahasiswa',
            'description' => 'Mahasiswa pengguna kuesioner'
        ]);
        
        Role::create([
            'name' => 'admin',
            'description' => 'Administrator sistem pakar'
        ]);
    }
}
