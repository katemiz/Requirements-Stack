<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $admin = User::create([
            "name" => 'Admin',
            "lastname" =>'Admin',
            "email" => 'admin@admin.com',
            "password" => 'admin@admin.com'
        ]);

        $role = Role::create(['name' => 'admin']);
        $admin->assignRole('admin');


        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'TÜBİTAK SAGE',
            'fullname' => 'TÜBİTAK Savunma Sanayii Araştırma ve Geliştirme Enstitüsü'
        ]);

        Project::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 1,
            'code' => 'PVR',
            'title' => 'Pressure Regulating Valve'
        ]);





    }
}