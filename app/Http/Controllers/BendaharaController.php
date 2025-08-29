<?php
    
namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class BendaharaController extends Controller
{
    public function bendahara(Request $request)
    {
        return view('user.user');
    }

    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if ($user) {
                $user->forceDelete();
                return redirect('/user')->with('success', 'Data berhasil dihapus secara permanen');
            } else {
                return redirect('/user')->with('error', 'Data tidak ditemukan.');
            }
        } catch (\Exception $e) {
            return redirect('/user')->with('error', 'Gagal menghapus data. Silakan coba lagi.');
        }
    }

    public function create()
    {
        $roles = Role::all();
        return view('user.add', compact('roles'));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => [
            'required', 
            'min:3', 
            'max:30', 
            'regex:/^[a-zA-Z\s]+$/', 
            function ($attribute, $value, $fail) {
                if (User::where('name', $value)->exists()) {
                    $fail($attribute . ' is registered.');
                }
            }
        ],
        'email' => 'required|unique:users,email',
        'password' => ['required', 'min:8', 'max:12'],
        'kelas' => 'required',
        'level' => 'required|array'
    ]);

    DB::beginTransaction();
    try {
        $bendahara = new User();
        $bendahara->name = $request->name;
        $bendahara->email = $request->email;
        $bendahara->password = Hash::make($request->password);
        $bendahara->kelas = $request->kelas;
        $bendahara->status_pemilihan = 'Belum Memilih'; 
        $bendahara->save();

        foreach ($request->level as $role) {
            $bendahara->assignRole($role);
        }

        DB::commit();

        return redirect('/user')->with('success', 'User berhasil ditambahkan.');
    } catch (\Throwable $th) {
        DB::rollback();

        return redirect('/user')->with('error', 'User gagal ditambahkan! ' . $th->getMessage());
    }
}

    public function edit($id)
    {
        $roles = Role::all();
        $guruu = User::find($id);

        return view('user.edit', compact('guruu', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $guruu = User::find($id);

        $request->validate([
            'name' => ['required', 'min:3', 'max:30', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => 'required|email|unique:users,email,' . $guruu->id,
            'password' => ['nullable', 'min:8', 'max:12'],
            'kelas' => 'required',
            // 'status_pemilihan' => 'required',
            'roles' => 'required|array', 
            'roles.*' => 'exists:roles,name',
        ]);

        DB::beginTransaction();
        try {
            $guruu->name = $request->name;
            $guruu->email = $request->email;
            $guruu->kelas = $request->kelas;
            // $guruu->status_pemilihan = $request->status_pemilihan;

            if ($request->filled('password')) {
                $guruu->password = Hash::make($request->password);
            }

            $guruu->save();

            $guruu->syncRoles($request->roles);

            DB::commit();

            return redirect('/user')->with('success', 'Data user berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollback();

            return redirect('/user')->with('error', 'User gagal diperbarui! ' . $th->getMessage());
        }
    }

    public function switchRole(Request $request)
    {
        $user = auth()->user();

        if (!session()->has('activeRole')) {
            if ($user->roles->count() === 1) {
                session(['activeRole' => $user->roles->first()->name]);
            }
        }

        Session::put('activeRole', $request->role);

        $hasRole = $user->hasRole(Session::get('activeRole'));

        if ($hasRole) {
            $activeRole = Session::get('activeRole');

            if ($activeRole) {
                $activeRole = \Spatie\Permission\Models\Role::where('name', $activeRole)->first();

                if ($activeRole) {
                    $permissions = $activeRole->permissions->pluck('name')->toArray();
                } else {
                    $permissions = [];
                }
            } else {
                $permissions = [];
            }

            Session::put('permissions', $permissions);

            $redirectPath = $activeRole === 'admin' ? '/user' : '/home';

            return redirect($redirectPath)->with('success', 'Role dan permissions berhasil diubah.');
        } else {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke peran ini.');
        }
    }

    public function showDetail($id)
    {
        $user = User::with('roles')->find($id);

        if (!$user) {
            return response()->json(['message' => 'Pengeluaran not found'], 404);
        }

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'kelas' => $user->kelas,
            'status_pemilihan' => $user->status_pemilihan,
        ]);
    }

    public function importUser(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,xls,csv|max:5120', // Ditingkatkan menjadi 5MB untuk menampung lebih banyak data
            ]);

            $file = $request->file('file');
            $namafile = $file->getClientOriginalName();
            $file->move(public_path('DataUser'), $namafile);

            // Validasi struktur file Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(public_path('DataUser/' . $namafile));
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Ambil header dari baris ke-2 (A2:D2)
            $headers = [];
            foreach ($worksheet->getRowIterator(2, 2) as $row) {
                $cellIterator = $row->getCellIterator('A', 'D');
                $cellIterator->setIterateOnlyExistingCells(false);
                foreach ($cellIterator as $cell) {
                    $headers[] = $cell->getValue();
                }
            }

            // Periksa apakah header sesuai dengan yang diharapkan
            $expectedHeaders = ['Nama', 'Email', 'Kelas', 'Role'];
            $missingHeaders = array_diff($expectedHeaders, $headers);

            if (!empty($missingHeaders)) {
                @unlink(public_path('DataUser/' . $namafile));
                return redirect()->back()->with('error', 'Format file tidak sesuai. Pastikan menggunakan template yang benar.');
            }

            // Baca semua data dari baris ke-3 sampai baris terakhir
            $highestRow = $worksheet->getHighestRow();
            
            // Proses data dalam batch untuk mengoptimalkan memori
            $batchSize = 100;
            $processedRows = 0;
            $duplicateData = [];
            
            for($row = 3; $row <= $highestRow; $row++) {
                $nama = $worksheet->getCell('A' . $row)->getValue();
                $email = $worksheet->getCell('B' . $row)->getValue();
                $kelas = $worksheet->getCell('C' . $row)->getValue();
                $role = $worksheet->getCell('D' . $row)->getValue();

                // Skip jika baris kosong
                if(empty($nama) && empty($email) && empty($kelas) && empty($role)) {
                    continue;
                }

                // Validasi role
                if(!in_array($role, ['1', '2'])) { // 1 untuk Guru, 2 untuk Siswa
                    throw new \Exception('Role tidak valid pada baris ' . $row);
                }

                // Cek duplikasi data
                $existingUser = User::where('email', $email)->first();
                if($existingUser) {
                    $duplicateData[] = [
                        'row' => $row,
                        'email' => $email,
                        'name' => $nama
                    ];
                    continue;
                }

                // Simpan ke database
                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => Hash::make('password123'), // Default password
                    'kelas' => $kelas,
                    'status_pemilihan' => 'Belum Memilih'
                ]);

                // Assign role
                $roleName = ($role == '1') ? 'guru' : 'siswa';
                $user->assignRole($roleName);

                $processedRows++;
                
                // Commit setiap batch untuk menghemat memori
                if($processedRows % $batchSize === 0) {
                    DB::commit();
                    DB::beginTransaction();
                }
            }

            DB::commit();
            @unlink(public_path('DataUser/' . $namafile));

            if(!empty($duplicateData)) {
                $duplicateMessage = 'Beberapa data tidak diimpor karena sudah ada:';
                foreach($duplicateData as $duplicate) {
                    $duplicateMessage .= "\nBaris {$duplicate['row']}: {$duplicate['name']} ({$duplicate['email']})";
                }
                return redirect('/user')->with('error', $duplicateMessage);
            }

            return redirect('/user')->with('success', 'Data User Berhasil Diimport');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if(file_exists(public_path('DataUser/' . $namafile))) {
                @unlink(public_path('DataUser/' . $namafile));
            }

            \Log::error('Import user failed: ' . $e->getMessage());

            return redirect('/user')->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplateExcel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data User');
        $sheet->setCellValue('A1', 'Import User');
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->setCellValue('A2', 'Nama');
        $sheet->setCellValue('B2', 'Email');
        $sheet->setCellValue('C2', 'Kelas');
        $sheet->setCellValue('D2', 'Role');
        $sheet->setCellValue('F2', 'Keterangan')->getStyle('F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('FFFF00');
        $sheet->setCellValue('F3', '1. Pengisian data dimulai dari baris ke-3');
        $sheet->setCellValue('F4', '2. Kolom D (Role) diisi dengan kode dari sheet Role');
        
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Role');
        $sheet2->setCellValue('A1', 'Kode');
        $sheet2->setCellValue('B1', 'Role');
        $sheet2->setCellValue('A2', '1');
        $sheet2->setCellValue('B2', 'Guru');
        $sheet2->setCellValue('A3', '2');
        $sheet2->setCellValue('B3', 'Siswa');
        
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'template-user.xlsx';
        $filePath = storage_path('app/public/' . $filename);
        $writer->save($filePath);
        
        return response()->download($filePath, $filename)->deleteFileAfterSend(true);
    }
}
