<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nama' => 'Admin Desa',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'nama' => 'Warga Desa',
            'email' => 'warga@desa.com',
            'password' => Hash::make('password'),
            'role' => 'masyarakat'
        ]);
    }
}
