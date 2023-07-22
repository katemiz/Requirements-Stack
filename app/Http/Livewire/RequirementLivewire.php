<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;

use App\Models\Project;



use Livewire\Component;

class RequirementLivewire extends Component
{

    public $selection;
    public $action;
    public $reqId;
    public $requirement;

    public $projects;
    public $selectedPrj = false;
    //public $endproducts;


    public function mount() {
        $this->selection = request('action');

        if ( request('id') ) {
            $this->reqId = request('id');
        }


        $this->projects = Project::all()->sortBy("code");
        //$this->endproducts = EndProduct::all()->sortBy('code');

        if ($this->projects->count() == 1 ) {

            $this->selectedPrj = $this->projects["0"];

            //dd($this->selectedPrj);
        }
    }


    public function render()
    {


        if ($this->selection == 'form') {


            $this->action = 'create';
            $this->requirement = false;
    
            if ( isset($request->id) && !empty($request->id)) {
                $this->requirement = Requirement::find($request->id);
                $this->action = 'update';
            }



            return view('requirement.form',);

        }
    }
}
