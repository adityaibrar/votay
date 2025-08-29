<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'admin',
                'status_pemilihan' => 'Belum Memilih',
                'kelas' => null,
                'password' => bcrypt('admin'),
                'remember_token' => Str::random(10),
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        $admin->assignRole('admin', 'guru');
    }
}
