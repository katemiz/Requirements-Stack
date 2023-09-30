<?php

namespace App\Livewire;

use App\Models\Company;
use App\Models\User;


use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LwUser extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW
    public $constants;

    public $companies;

    public $uid;


    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;
    public $user;

    public $uroles = [];
    public $allroles;




    


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
        }

        $this->constants = config('users');
    }


    public function render()
    {
        $this->logged_user = $this->userHasRoles(Auth::user());

        $users = false;

        if ( $this->action === 'VIEW') {
            $this->setUnsetProps();
        }

        if ( $this->action === 'FORM' && $this->uid) {
            $this->setUnsetProps();

            $this->companies['name'] = 'company_id';
            $this->companies['label'] = 'Select Company';
            $this->companies['options'] = [];
    
            if ($this->logged_user->is_admin) {
                foreach (Company::all() as $cmp) {
                    $this->companies['options'][$cmp->id] = $cmp->name;
                }
            }
    
            if ($this->logged_user->is_company_admin) {
                $this->companies['options'][$this->logged_user->company_id] = $this->logged_user->company_name;
            }

        }

        if ( $this->action === 'LIST') {
            $users = $this->getUsersList();
        }

        return view('admin.lw-users',[
            'users' => $users
        ]);
    }


    public function userHasRoles($usr) {

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


    public function getUsersList() {

        if ($this->logged_user->is_admin) {
            $users = User::where([
                ['lastname', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['name', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        if ($this->logged_user->is_company_admin) {

            $users = User::where([
                ['company_id', '=', $this->logged_user->company_id],
                ['lastname', 'LIKE', "%".$this->query."%"],
            ])
            ->orwhere([
                ['company_id', '=', $this->logged_user->company_id],
                ['name', 'LIKE', "%".$this->query."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return $users;
    }


    public function resetFilter() {
        $this->query = '';
    }

    public function viewItem($uid) {
        $this->uid = $uid;
        $this->action = 'VIEW';

        $this->user = User::find($uid);
    }


    public function editItem($uid) {
        $this->uid = $uid;
        $this->action = 'FORM';

        $this->user = User::find($uid);
    }


    public function setUnsetProps($opt = 'set') {

        if ($opt === 'set') {

            $allroles = Role::all()->get();

            $this->user = User::find($this->uid);

            // foreach ($this->user->roles as $role) {
            //     array_push($role->id,$this->uroles);
            // }




        } 
    }



}







