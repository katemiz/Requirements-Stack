<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Company;
use App\Models\Endproduct;
use App\Models\Requirement;
use App\Models\Project;
use App\Models\User;
use App\Models\Verification;
use App\Models\Gate;
use App\Models\Moc;
use App\Models\Poc;
use App\Models\Witness;





class LwVerification extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW,VERIFICATION
    public $constants;

    public $vid = false;    // Verification ID
    public $requirement = false;    
    public $verification = false;    


    public $logged_user;

    public $companies = [];
    public $projects = [];
    public $endproducts = [];

    public $company_id;    
    public $project_id;
    public $endproduct_id;

    public $the_company = false;    // Viewed Phase Company
    public $the_project = false;    // Viewed Phase Project
    public $the_endproduct = false; // Viewed Phase EndProduct

    public $project_eproducts = [];

    // Verification

    #[Rule('required', message: 'Please select milestone/gate')] 
    public $gate_id;

    #[Rule('required', message: 'Please select MOC')] 
    public $moc_id;

    #[Rule('required', message: 'Please select POC')] 
    public $poc_id;

    #[Rule('required', message: 'Please select witness for this verification')] 
    public $witness_id;

    public $vremarks;   // Verification remarks

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $rtypes = [
        'GR' => 'General Requirement',
        'TR' => 'Technical Requirement'
    ];




    public function mount()
    {
        $this->checkUserRoles();

        if (request('rid')) {
            $this->requirement = Requirement::find(request('rid'));
            $this->verifications = $this->requirement->verifications;
        }

        if (request('id')) {
            $this->verification = Verification::find(request('id'));
        }

        $this->constants = config('verifications');

        $this->checkSessionVariables();

        $this->verification_data = $this->getVerificationData();
    }


    public function render()
    {


        return view('requirements.verifications-form',[
            'requirement' => $this->requirement ,
            'verifications' => $this->verifications,
            'verification' => $this->verification,
            'verification_data' => $this->verification_data
        ]);
    }


    public function checkUserRoles() {

        $this->logged_user = Auth::user();

        if ($this->logged_user->hasRole('admin')) {
            $this->is_user_admin = true;
        } else {
            $this->company_id = $this->logged_user->company_id;
        }

        if ($this->logged_user->hasRole('company_admin')) {
            $this->is_user_company_admin = true;
        }
    }



    public function checkSessionVariables() {

        if (session('current_project_id')) {
            $this->project_id = session('current_project_id');
        }

        if (session('current_eproduct_id')) {
            $this->endproduct_id = session('current_eproduct_id');
        }
    }






    public function viewItem($uid) {
        $this->action = 'VIEW';
        $this->uid = $uid;
    }


    public function editItem($uid) {
        $this->action = 'FORM';
        $this->uid = $uid;
    }


    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';

        $this->reset('code','name');
    }





    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem()
    {
        Phase::find($this->uid)->delete();
        session()->flash('message','Project phase has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['endproduct_id'] = $this->endproduct_id ? $this->endproduct_id : 0;
        $props['rtype'] = $this->rtype;
        $props['text'] = $this->text;
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            Requirement::find($this->uid)->update($props);
            session()->flash('message','Requirement has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->uid = Requirement::create($props)->id;
            session()->flash('message','Requirement has been created successfully.');
        }

        $this->action = 'VIEW';
    }







    public function getVerificationData () {

        $ver_milestones = Gate::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_mocs = Moc::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_pocs = Poc::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_witnesses = Witness::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();


        return [
            'ver_milestones' => $ver_milestones,
            'ver_mocs' => $ver_mocs,
            'ver_pocs' => $ver_pocs,
            'ver_witnesses' => $ver_witnesses
        ];

    }







}
