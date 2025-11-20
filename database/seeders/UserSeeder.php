<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Cabang;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // left sidebar
            'view_dashboard',
            'view_users',
            'view_permissions',
            'view_cabangs',
            'view_profiles',
            'view_universal',
                'view_falken',
                'view_philips',
                'view_mitsuboshi',
                'view_ngk',
                'view_universal_part',
            'view_ygp'
            //crud

        ];

        $user = User::create([
                'uuid' => Str::uuid()->toString(),
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('1t4lf4'),
                'remember_token' => Str::random(10),
        ]);
        $cabangs = Cabang::all();
        foreach ($cabangs as $cabang){
            $permissions[] = 'cabang_'.strtolower($cabang->kode_cabang);
        }
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        $user->syncPermissions($permissions);

        
    }
}
