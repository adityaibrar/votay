<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\SettingSaldo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\SettingWaktu;
use Carbon\Carbon;
use App\Models\Osis;
use App\Models\HasilVoting;
use App\Models\User;

class SettingController extends Controller
{
     public function role(Request $request)
    {
        return view('role.role');
    }

     public function edit($id)
    {
         $role = Role::findOrFail($id);
    $permissions = Permission::all();
    $rolePermissions = $role->permissions->pluck('id')->toArray();

    return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    
  public function update(Request $request, $id)
{
    $role = Role::findOrFail($id);

    $request->validate([
        'name' => ['required', 'min:3', 'max:30'],
        'permissions' => ['required', 'array'],
    ]);

    $role->update([
        'name' => $request->name,
    ]);

    $role->permissions()->sync($request->permissions);

    return redirect('/role')->with('update_success', 'Role dan permissions berhasil diupdate');
}

 public function create()
    {
       return view('role.add');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => ['required', 'min:3', 'max:30'],
        'guard_name' => ['required', 'min:3', 'max:30'],
        ]);

     DB::beginTransaction();
     try {
        $role = new Role();
        $role->name = $request->name;
        $role->guard_name = $request->guard_name;
       
        $role->save();
        DB::commit();
     } catch (\Throwable $th) {
        DB::rollback();
        return redirect('/role')->with('success', 'Role gagal ditambahkan!' . $th->getMessage());
     }
        return redirect('/role')->with('success', 'Role berhasil ditambahkan!');
    }



   


 public function settingWaktu()
    {
        // Ambil semua pengaturan waktu
        $settings = SettingWaktu::all();

        // Awalnya kita asumsikan pengaturan sudah expired
        $expired = true;

        // Periksa setiap pengaturan waktu
        foreach ($settings as $setting) {
            // Jika ada pengaturan yang diatur pada hari ini, maka belum expired
            if (Carbon::parse($setting->waktu)->isToday()) {
                $expired = false;
                break;
            }
        }

        // Simpan status expired ke dalam session untuk digunakan di sidebar
        session()->put('expired', $expired);

        // Kirim data pengaturan dan status expired ke tampilan
        return view('setting.setting', compact('settings', 'expired'));
    }

    public function updateWaktu(Request $request)
    {
        $request->validate([
            'waktu' => 'required|date',
        ]);

        $id = $request->input('id');
        $tanggal = $request->input('waktu');

        $setting = SettingWaktu::find($id);

        if (!$setting) {
            return response()->json(['success' => false, 'message' => 'Setting waktu tidak ditemukan']);
        }

        $setting->waktu = $tanggal;

        if ($setting->save()) {
            // Perbarui status expired berdasarkan tanggal saat ini
            $expired = Carbon::now()->greaterThan($tanggal); // Menggunakan greaterThan untuk menyembunyikan menu setelah tanggal

            // Simpan $expired dalam session
            session()->put('expired', $expired);

            return response()->json(['success' => true, 'message' => 'Berhasil mengupdate setting waktu', 'tanggal' => $tanggal, 'expired' => $expired]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal mengupdate setting waktu']);
        }
    }

    //vote
    public function index(Request $request)
    {
        // Ambil semua data calon OSIS dari database
        $calonOsis = Osis::all();
             $settings = SettingWaktu::all();

            $expired = false;
    foreach ($settings as $setting) {
        if (Carbon::now()->greaterThanOrEqualTo($setting->waktu)) {
            $expired = true;
            break;
        }
    }
        // Return view dengan data calon OSIS
        return view('vote.vote', compact('calonOsis','settings','expired'));
    }


    public function storeVote(Request $request)
{
    // Validasi input
    $request->validate([
        'id_user' => 'required',
        'id_calon' => 'required',
    ]);

    // Cek apakah pengguna sudah melakukan voting sebelumnya
    $existingVote = HasilVoting::where('id_user', $request->id_user)->exists();
    if ($existingVote) {
        return redirect('/vote')->with('already_voted', true);
    }

    // Simpan hasil voting ke dalam tabel hasil_voting
    HasilVoting::create([
        'id_user' => $request->id_user,
        'id_calon' => $request->id_calon,
        'tanggal' => now(),
    ]);

    // Update status pemilihan pengguna
    User::where('id', $request->id_user)->update(['status_pemilihan' => 'Sudah Memilih']);

    return redirect('/vote')->with('vote_success', true);
}

}