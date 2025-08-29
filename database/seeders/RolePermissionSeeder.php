<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Permission::UpdateOrCreate(['name'=>'Home']);
        Permission::UpdateOrCreate(['name'=>'Admin']);
        Permission::UpdateOrCreate(['name'=>'User']);
        Permission::UpdateOrCreate(['name'=> 'Data Calon OSIS']);
        Permission::UpdateOrCreate(['name'=> 'Setting']);
        Permission::UpdateOrCreate(['name'=>'Laporan']);



        Role::UpdateOrCreate(['name'=>'Admin']);
        Role::UpdateOrCreate(['name'=>'Guru']);
        Role::UpdateOrCreate(['name'=>'Siswa']);


        $roleAdmin = Role::findByName('Admin');
        $roleAdmin->givePermissionTo('Home');
        $roleAdmin->givePermissionTo('Admin');
        $roleAdmin->givePermissionTo('User');
        $roleAdmin->givePermissionTo('Data Calon OSIS');
        $roleAdmin->givePermissionTo('Setting');
        $roleAdmin->givePermissionTo('Laporan');




        $roleGuru = Role::findByName('Guru');
        $roleGuru->givePermissionTo('Home');


        $roleSiswa = Role::findByName('Siswa');
        $roleSiswa->givePermissionTo('Home');

    }
}
