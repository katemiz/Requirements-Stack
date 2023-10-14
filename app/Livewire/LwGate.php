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
use App\Models\Gate;
use App\Models\Phase;
use App\Models\Project;
use App\Models\User;



class LwGate extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;
    public $companies = [];
    public $projects = [];
    public $endproducts = [];

    public $the_company = false;    // Viewed Phase Company
    public $the_project = false;    // Viewed Phase Project
    public $the_endproduct = false; // Viewed Phase EndProduct


    public $project_eproducts = [];


    #[Rule('required', message: 'Please select company')] 
    public $company_id = false;

    #[Rule('required', message: 'Please select project')] 
    public $project_id = false;

    // #[Rule('required', message: 'Please select End Product')] 
    public $endproduct_id = 0;

    #[Rule('required', message: 'Please enter phase code. (eg P1)')] 
    public $code;

    #[Rule('required', message: 'Please enter phase name (eg Feasibility Phase)')] 
    public $name;

    public $description;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
            $this->setProps();
        }

        $this->constants = config('dgates');
    }


    public function render()
    {
        $this->logged_user = $this->checkUserRoles(Auth::user());

        $this->getCompaniesList();
        $this->getProjectsList();

        $this->setProps();

        return view('projects.gates.lw-gates',[
            'gates' => $this->getGatesList()
        ]);
    }


    public function checkUserRoles($usr) {

        $usr->is_admin = false;
        $usr->is_company_admin = false;

        if ($usr->hasRole('admin')) {
            $usr->is_admin = true;
        }

        if ($usr->hasRole('company_admin')) {
            $usr->is_company_admin = true;
        }

        return $usr;
    }



    public function getGatesList()  {

        if ($this->logged_user->is_admin) {

            if (strlen(trim($this->query)) < 2 ) {

                $phases = Gate::orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

            } else {

                $phases = Gate::where('code', 'LIKE', "%".$this->query."%")
                ->orWhere('name','LIKE',"%".$this->query."%")
                ->orWhere('description','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
            }
        }

        if ($this->logged_user->is_company_admin) {

            if (strlen(trim($this->query)) < 2 ) {

                $phases = Gate::where('company_id',$this->logged_user->company_id)
                ->where(function ($sqlquery) {
                    $sqlquery->where('code', 'LIKE', "%".$this->query."%")
                          ->orWhere('name', 'LIKE', "%".$this->query."%")
                          ->orWhere('description', 'LIKE', "%".$this->query."%");
                })
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));

            } else {

                $phases = Gate::where('company_id', $this->logged_user->company_id)
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
            }
        }

        return $phases;
    }


    public function getCompaniesList()  {

        if ($this->logged_user->is_admin) {
            $this->companies = Company::all();
        }

        if ($this->logged_user->is_company_admin) {
            $this->companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }
    }


    public function getProjectsList()  {

        if ($this->logged_user->is_admin && $this->company_id) {
            $this->projects = Project::where('company_id',$this->company_id)->get();
        }

        if ($this->logged_user->is_company_admin) {
            $this->projects = Project::where('company_id',$this->logged_user->company_id)->get();
        }

        if (count($this->projects) == 1) {
            $this->project_id = $this->projects['0']->id;
        }

        $this->getEndProductsList();

    }


    public function getEndProductsList()  {

        if ($this->project_id) {
            $this->project_eproducts = Endproduct::where('project_id',$this->project_id)->get();
        }
    }





    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if ($this->constants['list']['headers'][$key]['direction'] == 'asc') {
            $this->constants['list']['headers'][$key]['direction'] = 'desc';
        } else {
            $this->constants['list']['headers'][$key]['direction'] = 'asc';
        }

        $this->sortDirection = $this->constants['list']['headers'][$key]['direction'];
    }


    public function resetFilter() {
        $this->query = '';
    }


    public function viewItem($uid) {
        $this->uid = $uid;
        $this->action = 'VIEW';
    }


    public function editItem($uid) {
        $this->uid = $uid;
        $this->action = 'FORM';
    }


    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';
        $this->reset('code','name');
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $c = Gate::find($this->uid);

            $this->code = $c->code;
            $this->name = $c->name;
            $this->description = $c->description;
            $this->endproduct_id = $c->endproduct_id;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->fullname;
            $this->updated_by = User::find($c->updated_uid)->fullname;

            $this->the_company = Company::find($c->company_id);
            $this->the_project = Project::find($c->project_id);

            if ($c->endproduct_id > 0) {
                $this->the_endproduct = Endproduct::find($c->endproduct_id);
            }
        }
    }


    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem()
    {
        Gate::find($this->uid)->delete();
        session()->flash('message','Project milestone/decision gate has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['endproduct_id'] = $this->endproduct_id ? $this->endproduct_id : 0;
        $props['code'] = $this->code;
        $props['name'] = $this->name;
        $props['description'] = $this->description;

        if ( $this->uid ) {
            // update
            Gate::find($this->uid)->update($props);
            session()->flash('message','Project milestone/decision gate has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->uid = Gate::create($props)->id;
            session()->flash('message','Project milestone/decision gate has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
