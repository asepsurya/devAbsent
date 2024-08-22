<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
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
        // create permissions
        Permission::create(['name' => 'create student']);
        Permission::create(['name' => 'delete student']);
        Permission::create(['name' => 'update student']);
        Permission::create(['name' => 'read student']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'walikelas']);
        $role1->givePermissionTo('update student');
        $role1->givePermissionTo('delete student');
        $role1->givePermissionTo('read student');
   

        $role2 = Role::create(['name' => 'guru']);
        $role2->givePermissionTo('create student');
        $role2->givePermissionTo('read student');
        $role2->givePermissionTo('delete student');
        $role2->givePermissionTo('update student');

        $role3 = Role::create(['name' => 'siswa']);
        $role3->givePermissionTo('read student');

        $role4 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $user = User::create(array_merge([
            'nomor'=>'99876776221',
            'nama'=>'Wali Kelas',
            'email'=>'walikelas.sakti@gmail.com',
            'role'=>'2',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role1);

        $user = User::create(array_merge([
            'nomor'=>'99876776222',
            'nama'=>'Guru',
            'email'=>'guru.sakti@gmail.com',
            'role'=>'3',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role2);
        // siswa
        $user = User::create(array_merge([
            'nomor'=>'24257003',
            'nama'=>'Sample Student',
            'email'=>'siswa.sakti@gmail.com',
            'role'=>'4',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role3);

        $user = User::create(array_merge([
            'nomor'=>'24257001',
            'nama'=>'Sample Student 1',
            'email'=>'siswa1.sakti@gmail.com',
            'role'=>'4',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role3);
        $user = User::create(array_merge([
            'nomor'=>'24257002',
            'nama'=>'Sample Student 2',
            'email'=>'siswa2.sakti@gmail.com',
            'role'=>'4',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role3);
        // end siswa 
        $user = User::create(array_merge([
            'nomor'=>'99876776229',
            'nama'=>'Administrator',
            'email'=>'superAdmin.sakti@gmail.com',
            'role'=>'1',
            'status'=>'2',
        ],$default_user_value));

        $user->assignRole($role4);

        DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
        }
        
        
    }
}
