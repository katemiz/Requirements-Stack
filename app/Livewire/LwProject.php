<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Company;
use App\Models\Project;


class LwProject extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $companies;

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    #[Rule('required', message: 'Please select company')] 
    public $company_id;

    #[Rule('required', message: 'Please enter project short code')] 
    public $code;

    #[Rule('required', message: 'Please enter project full title')] 
    public $title;

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

        $this->constants = config('projects');
    }


    public function render()
    {
        $this->logged_user = $this->checkUserRoles(Auth::user());
        $this->getCompaniesList();

        return view('projects.projects.lw-projects',[
            'projects' => $this->getProjectsList()
        ]);
    }


    public function getProjectsList()  {

        if ($this->logged_user->is_admin) {

            $projects = Project::where('code', 'LIKE', "%".$this->query."%")
            ->orWhere('title','LIKE',"%".$this->query."%")
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        if ($this->logged_user->is_company_admin) {

            $projects = Project::where([
                ['company_id', '=', $this->logged_user->company_id],
                ['code', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['company_id', '=', $this->logged_user->company_id],
                ['title', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
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

        $this->setProps();
    }

    public function editItem($uid) {
        $this->uid = $uid;
        $this->action = 'FORM';

        $this->setProps();
    }

    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';

        $this->reset('code','title');
    }


    public function setProps() {

        $c = Project::find($this->uid);

        $this->code = $c->code;
        $this->company_id = $c->company_id;
        $this->title = $c->title;
        $this->created_at = $c->created_at;
        $this->updated_at = $c->updated_at;
        $this->created_by = $c->user_id;
        $this->updated_by = $c->updated_uid;
    }


    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Project::find($this->uid)->delete();
        session()->flash('message','Project has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['code'] = $this->code;
        $props['title'] = $this->title;

        if ( $this->uid ) {
            // update
            Project::find($this->uid)->update($props);
            session()->flash('message','Project has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $c = Project::create($props);
            $this->uid = $c->id;

            session()->flash('message','Project has been created successfully.');
        }

        $this->action = 'VIEW';
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



    public function getCompaniesList() {

        if ($this->logged_user->is_admin) {
            $this->companies = Company::all();
        }

        if ($this->logged_user->is_company_admin) {
            $this->companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }
    }










}
