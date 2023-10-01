<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Company;

class ListCompanies extends Component
{
    use WithPagination;

    protected $listeners = ['delete' => 'deleteReal'];

    public $search = '';
    public $sortField = 'name';
    public $sortDirection = 'asc';
    public $msg = false;


    public function render(Request $request)
    {
        $companies = Company::search('fullname',$this->search)->orderBy($this->sortField,$this->sortDirection)->paginate(env('RESULTS_PER_PAGE'));

        if ($request->input('msg')) {
            $this->msg = $request->input('msg');
        }

        return view('companies.list-companies',[
            'records' => $companies,
            'msg' => $this->msg
        ]);
    }


    public function resetFilter ()
    {
        $this->search = '';
    }

    public function deleteConfirm ($id)
    {
        $this->dispatch('jsConfirmDelete', id: $id);
    }


    public function deleteReal($id)
    {
        Company::find($id)->delete();
        $this->dispatch('informUserOnDelete');
    }


    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if (config('companies.list.headers')[$key]['direction'] == 'asc') {
            config('companies.list.headers')[$key]['direction'] = 'desc';
        } else {
            config('companies.list.headers')[$key]['direction'] = 'asc';
        }

        $this->sortDirection = config('companies.list.headers')[$key]['direction'];
    }
}
