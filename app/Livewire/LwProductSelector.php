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
use App\Models\Phase;
use App\Models\Project;
use App\Models\User;



class LwProductSelector extends Component
{

    public $logged_user;

    public $is_user_admin = false;
    public $is_user_company_admin = false;

    public $redirect_to;

    public $products = [];

    public $company_id;
    public $endproduct_id;
    public $project_id;


    public function mount()
    {
        if (request('pageBackIdentifier')) {
            $this->getRedirectLink();
        } else {
            $this->redirect_to = url()->previous();
        }

        $this->checkUserRoles();

    }


    public function render()
    {

        $this->getProducts();

        return view('pselector.product-selector', [
            'companies' => $this->getCompaniesList()
        ]);
    }


    public function getRedirectLink() {

        switch (request('pageBackIdentifier')) {
            case 'rl':
                $this->redirect_to = '/requirements/list';
                break;

            default:
                $this->redirect_to = '/';
                break;
        }
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


    public function getCompaniesList()  {

        if ($this->is_user_admin) {
            $companies = Company::all();
        } else  {
            $companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }

        return $companies;
    }


    public function getProducts()  {

        if (!$this->company_id) {
            $this->products = [];
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

        $this->reset('products');

        foreach ($projects as $prj) {
            $this->products[$prj->id]['project'] = $prj->toArray();
            $this->products[$prj->id]['ep'] = Endproduct::where('project_id',$prj->id)->get();
        }
    }


    public function setCurrent($idProject,$idEP)  {

        /*
        session('current_project_id');
        session('current_project_name');

        session('current_eproduct_id');
        session('current_eproduct_name');
        */

        $ep = $idEP > 0 ? Endproduct::find($idEP) : false;

        session([
            'current_project_id' => $idProject,
            'current_project_name' => Project::find($idProject)->code,
            'current_eproduct_id' => $ep ? $ep->id : false,
            'current_eproduct_name' => $ep ? $ep->code : false,
        ]);

        return redirect($this->redirect_to);
    }
}
