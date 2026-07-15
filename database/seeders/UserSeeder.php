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
            'name' => 'Admin',
            'email' => '',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        $mahasiswa = User::create([
            'name' => 'Dimas',
            'email' => 'dimas@serenity.com',
            'password' => Hash::make('password'),
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
