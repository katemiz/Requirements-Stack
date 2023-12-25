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
use App\Models\Project;
use App\Models\User;
use App\Models\Gate;
use App\Models\Moc;
use App\Models\Phase;
use App\Models\Poc;
use App\Models\Witness;

class LwEndProduct extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    public $is_user_admin = false;
    public $is_user_company_admin = false;

    public $the_company = false;    // Viewed Phase Company
    public $the_project = false;    // Viewed Phase Project

    #[Rule('required', message: 'Please select company')]
    public $company_id = false;

    #[Rule('required', message: 'Please select project')]
    public $project_id = false;

    #[Rule('required', message: 'Please enter End Product code. (eg PVR)')]
    public $code;

    #[Rule('required', message: 'Please enter End Product title (eg Forward Section)')]
    public $title;

    public $description;

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    #[Rule('required|boolean', message: 'Please select Phases Option')]
    public $use_parent_phases = true;

    #[Rule('required|boolean', message: 'Please select Gates Option')]
    public $use_parent_gates = true;

    #[Rule('required|boolean', message: 'Please select MOCs Option')]
    public $use_parent_mocs = true;

    #[Rule('required|boolean', message: 'Please select POCs Option')]
    public $use_parent_pocs = true;


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
            $this->setProps();
        }

        $this->checkUserRoles();
        $this->checkSessionVariables();

        $this->constants = config('endproducts');
    }


    public function render()
    {
        $this->setProps();

        return view('projects.eproducts.lw-eproducts',[
            'companies' => $this->getCompaniesList(),
            'projects' => $this->getProjectsList(),
            'eproducts' => $this->getEProductsList(),
            'populate_defaults' => $this->getPopulateDefaults()
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


    public function getEProductsList()  {

        if ($this->is_user_admin) {

            if (session('current_project_id')) {

                if (strlen(trim($this->query)) < 2 ) {

                    $eproducts = Endproduct::where('project_id', session('current_project_id'))
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    $eproducts = Endproduct::where('project_id', session('current_project_id'))
                    ->where('code', 'LIKE', "%".$this->query."%")
                    ->orWhere('title','LIKE',"%".$this->query."%")
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
                }

            } else {

                if (strlen(trim($this->query)) < 2 ) {

                    $eproducts = Endproduct::orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    $eproducts = Endproduct::where('code', 'LIKE', "%".$this->query."%")
                    ->orWhere('title','LIKE',"%".$this->query."%")
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
                }
            }

        } elseif ($this->is_user_company_admin) {

            if (session('current_project_id')) {

                if (strlen(trim($this->query)) < 2 ) {

                    $eproducts = Endproduct::where('project_id', session('current_project_id'))
                    ->where('company_id',$this->logged_user->company_id)
                    ->where(function ($sqlquery) {
                        $sqlquery->where('code', 'LIKE', "%".$this->query."%")
                              ->orWhere('title', 'LIKE', "%".$this->query."%");
                    })
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    $eproducts = Endproduct::where('project_id', session('current_project_id'))
                    ->where('company_id', $this->logged_user->company_id)
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
                }

            } else {

                if (strlen(trim($this->query)) < 2 ) {

                    $eproducts = Endproduct::where('company_id',$this->logged_user->company_id)
                    ->where(function ($sqlquery) {
                        $sqlquery->where('code', 'LIKE', "%".$this->query."%")
                              ->orWhere('title', 'LIKE', "%".$this->query."%");
                    })
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    $eproducts = Endproduct::where('company_id', $this->logged_user->company_id)
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));
                }
            }

        } else {

            $eproducts = Endproduct::where('company_id', $this->logged_user->company_id)
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return $eproducts;
    }


    public function getCompaniesList()  {

        if ($this->is_user_admin) {
            $companies = Company::all();
        } else {
            $companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }

        return $companies;
    }


    public function getProjectsList()  {

        if (!$this->company_id) {
            return [];
        }

        if ($this->is_user_admin) {
            $projects = Project::where('company_id',$this->company_id)->get();
        } elseif ($this->is_user_company_admin) {
            $projects = Project::where('company_id',$this->logged_user->company_id)->get();
        } else {
            $projects = $this->logged_user->projects;
        }

        if (count($projects) == 1) {
            $this->project_id = $projects['0']->id;
        }

        return $projects;
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

        $this->reset('code','title');
    }


    public function populate($uid) {
        $this->uid = $uid;
        $this->action = 'POPULATE';
    }


    public function getPopulateDefaults() {

        if ($this->action != 'POPULATE') {
            return false;
        }

        // PHASES
        $predefinedPhases = Phase::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // MILESTONES
        $predefinedMilestones = Gate::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // MOCS
        $predefinedMocs = Moc::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        // POCS
        $predefinedPocs = Poc::where([
            ['company_id',1],
            ['project_id',1],
        ])
        ->orderBy('code','asc')
        ->get();

        return [
            'is_for_project' => false,
            'phases' => $predefinedPhases,
            'milestones' => $predefinedMilestones,
            'mocs' => $predefinedMocs,
            'pocs' => $predefinedPocs
        ];
    }












    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $c = Endproduct::find($this->uid);

            $this->code = $c->code;
            $this->title = $c->title;
            $this->description = $c->description;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->fullname;
            $this->updated_by = User::find($c->updated_uid)->fullname;

            $this->use_parent_phases = $c->use_parent_phases;
            $this->use_parent_gates =$c->use_parent_gates;
            $this->use_parent_mocs =$c->use_parent_mocs;
            $this->use_parent_pocs =$c->use_parent_pocs;

            $this->the_company = Company::find($c->company_id);
            $this->the_project = Project::find($c->project_id);
        }
    }


    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem()
    {
        Phase::find($this->uid)->delete();
        session()->flash('message','End Product has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['code'] = $this->code;
        $props['title'] = $this->title;
        $props['description'] = $this->description;

        $props['use_parent_phases'] = $this->use_parent_phases;
        $props['use_parent_gates'] = $this->use_parent_gates;
        $props['use_parent_mocs'] = $this->use_parent_mocs;
        $props['use_parent_pocs'] = $this->use_parent_pocs;

        if ( $this->uid ) {
            // update
            Endproduct::find($this->uid)->update($props);
            session()->flash('message','End Product has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $this->uid = Endproduct::create($props)->id;
            session()->flash('message','End Product has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
