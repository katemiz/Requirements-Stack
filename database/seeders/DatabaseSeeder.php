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

        // PHASES

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Pre-Phase A',
            'name' => 'Concept Studies',
            'description' => '<p><strong>Purpose</strong></p><p>To produce a broad spectrum of ideas and alternatives for missions from which new programs/projects can be selected. Determine feasibility of desired system, develop mission concepts, draft system-level requirements, assess performance, cost, and schedule feasibility; identify potential technology needs, and scope.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>Feasible system concepts in the form of simulations, analysis, study reports, models, and mock-ups</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase A',
            'name' => 'Concept and Technology Development',
            'description' => '<p><strong>Purpose</strong></p><p>To determine the feasibility and desirability of a suggested new system and establish an initial baseline compatibility with NASA’s strategic plans. Develop final mission concept, system-level requirements, needed system technology developments, and program/project technical management plans.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>System concept definition in the form of simulations, analysis, engineering models and mock-ups, and trade study definition</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase B',
            'name' => 'Preliminary Design and Technology Completion',
            'description' => '<p><strong>Purpose</strong></p><p>To define the project in enough detail to establish an initial baseline capable of meeting mission needs. Develop system structure end product (and enabling product) requirements and generate a preliminary design for each system structure end product.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>End products in the form of mock-ups, trade study results, specification and interface documents, and prototypes</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase C',
            'name' => 'Final Design and Fabrication',
            'description' => '<p><strong>Purpose</strong></p><p>To complete the detailed design of the system (and its associated subsystems, including its operations systems), fabricate hardware, and code software. Generate final designs for each system structure end product.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>End product detailed designs, end product component fabrication, and software development</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase D',
            'name' => 'System Assembly, Integration and Test, Launch',
            'description' => '<p><strong>Purpose</strong></p><p>To assemble and integrate the system (hardware, software, and humans), meanwhile developing confidence that it is able to meet the system requirements. Launch and prepare for operations. Perform system end product implementation, assembly, integration and test, and transition to use.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>Operations-ready system end product with supporting related enabling products</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase E',
            'name' => 'Operations and Sustainment',
            'description' => '<p><strong>Purpose</strong></p><p>To conduct the mission and meet the initially identified need and maintain support for that need. Implement the mission operations plan.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>Desired system</p>'
        ]);

        Phase::create([
            'updated_uid' => 1,
            'user_id' => 1,
            'company_id' => 0,
            'project_id' => 0,
            'endproduct_id' => 0,
            'code' => 'Phase F',
            'name' => 'Closeout',
            'description' => '<p><strong>Purpose</strong></p><p>To implement the systems decommissioning/disposal plan developed in Phase E and perform analyses of the returned data and any returned samples.&nbsp;</p><p>&nbsp;</p><p><strong>Typical Outcomes</strong></p><p>Product closeout</p>'
        ]);




    }
}