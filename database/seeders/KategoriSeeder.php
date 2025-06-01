<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Infrastruktur',
            'Kesehatan',
            'Pelayanan',
            'Keamanan',
            'Lingkungan',
            'Pendidikan'
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create(['nama_kategori' => $kategori]);
        }
    }
}
