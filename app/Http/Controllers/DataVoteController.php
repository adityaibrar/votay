<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Polling; // Import model Polling
use App\Models\User;
use App\Models\Osis; // Import model User
use DB;
use App\Models\SettingWaktu;
use Carbon\Carbon;

class DataVoteController extends Controller
{

    public function viewPolling()
    {
        // Mengambil semua hasil voting
        $hasilVotings = Polling::all();

        // Reset jumlah_vote di tabel Osis sebelum diperbarui
        Osis::query()->update(['jumlah_vote' => 0]);

        // Mengupdate jumlah suara berdasarkan hasil voting
        Osis::whereIn('id', $hasilVotings->pluck('id_calon'))
            ->update(['jumlah_vote' => \DB::raw('jumlah_vote + 1')]);

        // Ambil data calon Osis yang sudah diurutkan berdasarkan jumlah suara (ranking)
        $calonOsis = Osis::orderBy('jumlah_vote', 'desc')->get();

        // Ambil pengaturan waktu voting
        $settings = SettingWaktu::all();
        $expired = $settings->some(fn($setting) => Carbon::now()->greaterThanOrEqualTo($setting->waktu));

        // Kirim data ke tampilan
        return view('laporan.datapolling', compact('calonOsis', 'settings', 'expired'));
    }



    public function cetaklaporan()
    {
        // Dapatkan calon dengan jumlah suara terbanyak
        $calonTerpilih = Osis::orderBy('jumlah_vote', 'desc')->first();
        $cosis = Osis::all();

        // return view('halaman.datapolling', ['calonOsis' => $calonOsis]);
        $settings = SettingWaktu::all();

        $expired = false;
        foreach ($settings as $setting) {
            if (Carbon::now()->greaterThanOrEqualTo($setting->waktu)) {
                $expired = true;
                break;
            }
        }

        return view('laporan.cetaklaporan', ['cosis' => $cosis], compact('settings', 'expired', 'calonTerpilih'));
    }


    public function viewVoted()
    {
        // Mengambil data hasil voting beserta nama calon dan jumlah suara
        $hasilVotings = Polling::all();

        // Ambil nama calon dari model User
        foreach ($hasilVotings as $hasilVoting) {
            $user = User::with('roles')->find($hasilVoting->id_user); // Mengambil data user dengan roles
            $hasilVoting->name = $user ? $user->name : 'Tidak Ditemukan';
            $hasilVoting->email = $user ? $user->email : 'Tidak Ditemukan';
            $hasilVoting->level = $user ? $user->level : 'Tidak Ditemukan';
            $hasilVoting->roles = $user ? $user->roles->pluck('name')->implode(', ') : 'Tidak Ada Role'; // Menambahkan roles
        }

        foreach ($hasilVotings as $hasilVoting) {
            $user = Osis::find($hasilVoting->id_calon);
            $hasilVoting->nama_calon = $user ? $user->nama_calon : 'Tidak Ditemukan';
        }

        $settings = SettingWaktu::all();

        $expired = false;
        foreach ($settings as $setting) {
            if (Carbon::now()->greaterThanOrEqualTo($setting->waktu)) {
                $expired = true;
                break;
            }
        }

        return view('laporan.datavoted', ['hasilVotings' => $hasilVotings], compact('settings', 'expired'));
    }
}
