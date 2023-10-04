<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Phase;

class LwPhase extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    #[Rule('required', message: 'Please select project')] 
    public $project_id;

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

        $this->constants = config('phases');
    }


    public function render()
    {
        $this->logged_user = $this->checkUserRoles(Auth::user());

        return view('projects.phases.lw-phases',[
            'phases' => $this->getPhasesList()
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



    public function getPhasesList()  {

        if ($this->logged_user->is_admin) {

            $phases = Phase::where('code', 'LIKE', "%".$this->query."%")
                ->orWhere('name','LIKE',"%".$this->query."%")
                ->orWhere('description','LIKE',"%".$this->query."%")
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
        }

        if ($this->logged_user->is_company_admin) {

            $phases = Phase::where([
                ['company_id', '=', $this->logged_user->company_id],
                ['code', 'LIKE', "%".$this->query."%"],
                ['name', 'LIKE', "%".$this->query."%"],
                ['description', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['company_id', '=', $this->logged_user->company_id],
                ['code', 'LIKE', "%".$this->query."%"],
                ['name', 'LIKE', "%".$this->query."%"],
                ['description', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return $phases;
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

        $this->reset('code','name');
    }


    public function setProps() {

        $c = Phase::find($this->uid);

        $this->code = $c->code;
        $this->name = $c->name;
        $this->description = $c->description;
        $this->created_at = $c->created_at;
        $this->updated_at = $c->updated_at;
        $this->created_by = $c->user_id;
    }


    public function triggerDelete($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Phase::find($this->uid)->delete();
        session()->flash('message','Project phase has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateItem () {

        $this->validate();

        $props['user_id'] = Auth::id();
        $props['name'] = $this->name;
        $props['fullname'] = $this->fullname;

        if ( $this->uid ) {
            // update
            $props['updated_uid'] = Auth::id();
            Phase::find($this->uid)->update($props);
            session()->flash('message','Project phase has been updated successfully.');

        } else {
            // create
            $c = Phase::create($props);
            $this->uid = $c->id;

            session()->flash('message','Project phase has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
