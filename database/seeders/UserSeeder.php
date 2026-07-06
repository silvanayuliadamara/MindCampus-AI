<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $mahasiswaRole = Role::where('name', 'mahasiswa')->first();

        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => $adminRole->id,
        ]);

        $mahasiswa = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => $mahasiswaRole->id,
        ]);

        $mahasiswa->profile()->create([
            'university' => 'Universitas Indonesia',
            'major' => 'Ilmu Komputer',
            'semester' => 8,
            'gender' => 'L'
        ]);
    }
}
