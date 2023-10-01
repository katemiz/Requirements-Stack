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

    public $cid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

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
            $this->cid = request('id');
            $this->setProps();
        }

        $this->constants = config('phases');
    }


    public function render()
    {
        $phases = Phase::where('code', 'LIKE', "%".$this->query."%")
        ->orWhere('name','LIKE',"%".$this->query."%")
        ->orWhere('description','LIKE',"%".$this->query."%")
        ->orderBy($this->sortField,$this->sortDirection)
        ->paginate(env('RESULTS_PER_PAGE'));

        return view('projects.phases.lw-phases',[
            'phases' => $phases
        ]);
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

    public function viewItem($cid) {
        $this->cid = $cid;
        $this->action = 'VIEW';

        $this->setProps();
    }

    public function editItem($cid) {
        $this->cid = $cid;
        $this->action = 'FORM';

        $this->setProps();
    }

    public function addItem() {
        $this->cid = false;
        $this->action = 'FORM';

        $this->reset('name','fullname');
    }


    public function setProps() {

        $c = Company::find($this->cid);

        $this->name = $c->name;
        $this->fullname = $c->fullname;
        $this->created_at = $c->created_at;
        $this->updated_at = $c->updated_at;
        $this->created_by = $c->user_id;
        $this->updated_by = $c->updated_uid;
    }


    public function triggerDelete($cid) {
        $this->cid = $cid;
        $this->dispatch('ConfirmDelete');
    }


    #[On('onDeleteConfirmed')]
    public function deleteRole()
    {
        Company::find($this->cid)->delete();
        session()->flash('message','Company has been deleted successfully.');
        $this->action = 'LIST';
        $this->resetPage();
    }

    
    public function storeUpdateItem () {

        $this->validate();

        $props['user_id'] = Auth::id();
        $props['name'] = $this->name;
        $props['fullname'] = $this->fullname;

        if ( $this->cid ) {
            // update
            $props['updated_uid'] = Auth::id();
            Company::find($this->cid)->update($props);
            session()->flash('message','Company has been updated successfully.');

        } else {
            // create
            $c = Company::create($props);
            $this->cid = $c->id;

            session()->flash('message','Company has been created successfully.');
        }

        $this->action = 'VIEW';
    }
}
