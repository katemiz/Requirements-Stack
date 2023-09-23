<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;

class ListUsers extends Component
{
    use WithPagination;

    public $params;

    protected $listeners = ['delete' => 'deleteReal'];

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $msg = false;



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




    public function render(Request $request)
    {
        $current_user = $this->userHasRoles(Auth::user());

        if ($current_user->is_admin) {
            $users = User::where([
                ['lastname', 'LIKE', "%".$this->search."%"],
            ])
            ->orwhere([
                ['name', 'LIKE', "%".$this->search."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        if ($current_user->is_company_admin) {

            $users = User::where([
                ['company_id', '=', $current_user->company_id],
                ['lastname', 'LIKE', "%".$this->search."%"],
            ])
            ->orwhere([
                ['company_id', '=', $current_user->company_id],
                ['name', 'LIKE', "%".$this->search."%"],
            ])
            ->orderBy($this->sortField,$this->sortDirection)
            ->paginate(env('RESULTS_PER_PAGE'));
        }

        return view('admin.users-list',[
            'records' => $users,
            'params' => $this->params
        ]);
    }


    public function resetFilter ()
    {
        $this->search = '';
    }

    public function deleteConfirm ($id)
    {
        $this->dispatch('jsConfirmDelete', id:$id);
    }


    public function deleteReal($id)
    {
        Company::find($id)->delete();
        $this->dispatch('informUserOnDelete');
    }


    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if (config('users.list.headers')[$key]['direction'] == 'asc') {
            config('users.list.headers')[$key]['direction'] = 'desc';
        } else {
            config('users.list.headers')[$key]['direction'] = 'asc';
        }

        $this->sortDirection = config('users.list.headers')[$key]['direction'];
    }
}
