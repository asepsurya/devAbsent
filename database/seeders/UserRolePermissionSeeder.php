<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_user_value =[
            'email_verified_at' => now(),
            'password' => 'newinopak',
            'remember_token' => Str::random(10),
        ];
        DB::beginTransaction();
        try {
            $walikelas = User::create(array_merge([
                'nomor'=>'99876776221',
                'nama'=>'Wali Kelas',
                'email'=>'walikelas.sakti@gmail.com',
                'role'=>'2',
            ],$default_user_value));
    
            $guru = User::create(array_merge([
                'nomor'=>'99876776222',
                'nama'=>'Guru',
                'email'=>'guru.sakti@gmail.com',
                'role'=>'3',
            ],$default_user_value));
    
            $siswa = User::create(array_merge([
                'nomor'=>'99876776223',
                'nama'=>'Siswa',
                'email'=>'siswa.sakti@gmail.com',
                'role'=>'4',
            ],$default_user_value));

            $siswa = User::create(array_merge([
                'nomor'=>'24257001',
                'nama'=>'siswa1@gmail.com',
                'email'=>'siswa1.sakti@gmail.com',
                'role'=>'4',
            ],$default_user_value));
    
            $superAdmin = User::create(array_merge([
                'nomor'=>'99876776229',
                'nama'=>'Administrator',
                'email'=>'superAdmin.sakti@gmail.com',
                'role'=>'1',
            ],$default_user_value));
    
            $role_walikelas =Role::create(['name'=>'walikelas']);
            $role_guru =Role::create(['name'=>'guru']);
            $role_siswa =Role::create(['name'=>'siswa']);
            $role_superAdmin =Role::create(['name'=>'administrator']);
    
            $permission = Permission::create(['name' => 'read role']);
            $permission = Permission::create(['name' => 'create role']);
            $permission = Permission::create(['name' => 'update role']);
            $permission = Permission::create(['name' => 'delete role']);

            $walikelas->assignRole('walikelas');
            $guru->assignRole('guru');
            $siswa->assignRole('siswa');
            $superAdmin->assignRole('administrator');
    
            $walikelas->givePermissionTo('read role');
            $walikelas->givePermissionTo('create role');
            $walikelas->givePermissionTo('update role');
            $walikelas->givePermissionTo('delete role');

            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
       
    }
}
