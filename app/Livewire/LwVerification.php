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

    public function mount()
    {
        $this->checkUserRoles();

        if (request('rid')) {
            $this->requirement = Requirement::find(request('rid'));
        }

        if (request('id')) {

            $this->vid = request('id');
            $this->verification = Verification::find($this->vid);
            $this->gate_id = $this->verification->gate_id;
            $this->moc_id = $this->verification->moc_id;
            $this->poc_id = $this->verification->poc_id;
            $this->witness_id = $this->verification->witness_id;
            $this->vremarks = $this->verification->remarks;
        }

        $this->constants = config('verifications');
        $this->checkSessionVariables();

    }


    public function render()
    {
        $this->verification_data = $this->getVerificationData();

        return view('requirements.verifications-form',[
            'requirement' => $this->requirement ,
            'verification' => $this->verification,
            'verification_data' => $this->verification_data
        ]);
    }


    public function checkUserRoles() {

        $this->logged_user = Auth::user();
        $this->company_id = $this->logged_user->company_id;

        if ($this->logged_user->hasRole('admin')) {
            $this->is_user_admin = true;
        }

        if ($this->logged_user->hasRole('company_admin')) {
            $this->is_user_company_admin = true;
        }
    }


    public function checkSessionVariables() {

        if (session('current_project_id')) {
            $this->project_id = session('current_project_id');
            $this->company_id = Project::find($this->project_id)->company_id;
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

        $props['user_id'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['endproduct_id'] = $this->endproduct_id ? $this->endproduct_id : 0;
        $props['requirement_id'] = $this->requirement->id;
        $props['gate_id'] = $this->gate_id;
        $props['moc_id'] = $this->moc_id;
        $props['poc_id'] = $this->poc_id;
        $props['witness_id'] = $this->witness_id;
        $props['remarks'] = $this->vremarks;

        if ( $this->vid ) {
            // update
            Verification::find($this->vid)->update($props);
            session()->flash('message','Requirement verification has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            Verification::create($props);
            session()->flash('message','Requirement verification has been created successfully.');
        }

        return redirect("requirements/view/".$this->requirement->id);

    }







    public function getVerificationData () {

        $ver_milestones = Gate::where('company_id', $this->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_mocs = Moc::where('company_id', $this->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();


        $ver_pocs = Poc::where('company_id', $this->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_witnesses = Witness::where('company_id', $this->company_id)
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
