<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;

use App\Models\Moc;
use App\Models\Poc;
use App\Models\Phase;



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
            "name" => 'Kılıç Ali',
            "lastname" =>'Temiz',
            "company_id" => 0,
            "email" => 'katemiz@gmail.com',
            "password" => 'kapkara'
        ]);

        $user1 = User::create([
            "name" => 'Kılıç Ali',
            "lastname" =>'Temiz',
            "company_id" => 0,
            "email" => 'katemiz@masttech.com',
            "password" => 'kapkara'
        ]);

        $user2 = User::create([
            "name" => 'Ümit',
            "lastname" =>'Kutluay',
            "company_id" => 1,
            "email" => 'umit.kutluay@tubitak.gov.tr',
            "password" => 'Sage2023tubitak'
        ]);

        $role = Role::create(['name' => 'admin']);
        $cadmin = Role::create(['name' => 'company_admin']);
        $reqeng = Role::create(['name' => 'requirement_engineer']);

        $admin->assignRole('admin');
        $user1->assignRole('requirement_engineer');
        $user2->assignRole('company_admin');
        $user2->assignRole('requirement_engineer');


        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'TÜBİTAK SAGE',
            'fullname' => 'TÜBİTAK Savunma Sanayii Araştırma ve Geliştirme Enstitüsü'
        ]);

        Company::create([
            'user_id' => 1,
            'updated_uid' =>1,
            'name' => 'Masttech',
            'fullname' => 'Elektromekanik Sistemler Sanayii ve Ticaret AŞ'
        ]);

        Project::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 1,
            'code' => 'YHRT',
            'title' => 'Yüksek Hızlı Rüzgar Tüneli Projesi'
        ]);

        // MOCs

        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 9',
            'name' => 'Equipment Qualification',
            'description' => '<p>Note:</p><p>Equipment Qualification is a process that may include all previous means of compliance:</p>'
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 7',
            'name' => 'Design Inspection',
            'description' => '<ul><li>Inspection / Audit Reports</li></ul>'
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 6',
            'name' => 'Flight Tests',
            'description' => ''
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 5',
            'name' => 'Ground Tests on Related Products',
            'description' => ''
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 4',
            'name' => 'Laboratory Tests',
            'description' => ''
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 3',
            'name' => 'Safety Assessment',
            'description' => '<ul><li>Safety Analysis:</li></ul>'
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 2',
            'name' => 'Calculation / Analysis',
            'description' => '<ul><li>Substantiation Reports</li></ul>'
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 1',
            'name' => 'Design Review',
            'description' => '<ul><li>Description</li><li>Drawings</li></ul>'
        ]);

        
        Moc::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'MC 0',
            'name' => 'Compliance Statement',
            'description' => '<p>Compliance Statement</p><p>Reference to design change documents</p><p>Election of methods, factors</p><p>Definition</p>'
        ]);




    }
}