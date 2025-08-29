<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Category;
use App\Models\SettingWaktu;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{



    public function users(Request $request)
    {
        if ($request->ajax()) {
            $bendahara = User::role(['guru', 'admin', 'siswa'])
                ->with('roles')
                ->select(['id', 'name', 'email', 'kelas', 'status_pemilihan'])
                ->get();

            return DataTables::of($bendahara)
                ->addIndexColumn()
                ->addColumn('kelas', function ($row) {
                    return $row->kelas ?: '-';
                })
                ->addColumn('roles', function ($row) {
                    return $row->roles->pluck('name')->implode(', ');
                })
                ->addColumn('opsi', function ($row) {
                    return '
                    <div class="d-flex align-items-center">
                        <form action="/user/' . $row->id . '/edit" method="GET" class="mr-1">
                            <button type="submit" class="btn btn-warning btn-xs"><i class="fas fa-edit"></i></button>
                        </form>
                        <form action="/user/' . $row->id . '/destroy" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['roles', 'opsi'])
                ->make(true);
        }
    }


    public function kategoris(Request $request)
    {
        if ($request->ajax()) {
            $categories = Category::select(['id', 'name', 'jenis_kategori', 'description'])->get();

            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('jenis_kategori', function ($row) {
                    return $row->jenis_kategori == 1 ? 'pemasukan' : 'pengeluaran';
                })
                ->addColumn('opsi', function ($row) {
                    return '
                    <div class="d-flex align-items-center">
                        <form action="' . route('kategori.edit', $row->id) . '" method="GET" class="mr-1">
                            <button type="submit" class="btn btn-warning btn-xs">
                                <i class="fas fa-edit"></i>
                            </button>
                        </form>

                        <form action="/kategori/' . $row->id . '/destroy" method="POST">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-xs">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
    }

    public function roles(Request $request)
    {
        if ($request->ajax()) {
            $role = Role::select(['id', 'name', 'guard_name'])->get();

            return DataTables::of($role)
                ->addIndexColumn()
                ->addColumn('opsi', function ($row) {
                    return '
                    <div class="d-flex justify-content-center">
                        <form action="/role/' . $row->id . '/edit" method="GET" class="mr-1">
                            <button type="submit" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></button>
                        </form>
                    </div>
                ';
                })
                ->rawColumns(['opsi'])
                ->make(true);
        }
    }
}
