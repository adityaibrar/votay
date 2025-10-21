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
        // Menggunakan query ORM untuk menghitung jumlah suara secara real-time
        // dengan left join antara tabel calon_osis dan hasil_voting (Polling)
        $calonOsis = Osis::leftJoin('hasil_voting', 'calon_osis.id', '=', 'hasil_voting.id_calon')
            ->select('calon_osis.*', DB::raw('COUNT(hasil_voting.id) as jumlah_vote'))
            ->groupBy('calon_osis.id')
            ->orderBy('jumlah_vote', 'desc')
            ->get();

        // Ambil pengaturan waktu voting
        $settings = SettingWaktu::all();
        $expired = $settings->some(fn($setting) => Carbon::now()->greaterThanOrEqualTo($setting->waktu));

        // Kirim data ke tampilan
        return view('laporan.datapolling', compact('calonOsis', 'settings', 'expired'));
    }



    public function cetaklaporan()
    {
        // Menggunakan query ORM untuk menghitung jumlah suara secara real-time
        // Dapatkan calon dengan jumlah suara terbanyak
        $calonTerpilih = Osis::leftJoin('hasil_voting', 'calon_osis.id', '=', 'hasil_voting.id_calon')
            ->select('calon_osis.*', DB::raw('COUNT(hasil_voting.id) as jumlah_vote'))
            ->groupBy('calon_osis.id')
            ->orderBy('jumlah_vote', 'desc')
            ->first();

        // Dapatkan semua calon dengan jumlah suara real-time
        $cosis = Osis::leftJoin('hasil_voting', 'calon_osis.id', '=', 'hasil_voting.id_calon')
            ->select('calon_osis.*', DB::raw('COUNT(hasil_voting.id) as jumlah_vote'))
            ->groupBy('calon_osis.id')
            ->orderBy('jumlah_vote', 'desc')
            ->get();

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
