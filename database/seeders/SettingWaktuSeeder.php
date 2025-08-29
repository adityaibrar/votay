<?php

namespace Database\Seeders;

use App\Models\SettingWaktu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingWaktuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_waktu')->insert([
            'waktu' => '2025-08-29',
        ]);
    }
}
