<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Project;

class ListProjects extends Component
{
    use WithPagination;

    public $params;

    protected $listeners = ['delete' => 'deleteReal'];

    public $search = '';
    public $sortField = 'title';
    public $sortDirection = 'asc';
    public $msg = false;


    public function mount()
    {
        $this->params = json_decode( file_get_contents(resource_path('/js/projects.json')),true );
    }


    public function render(Request $request)
    {
        $projects = Project::search('title',$this->search)->orderBy($this->sortField,$this->sortDirection)->paginate(env('RESULTS_PER_PAGE'));

        if ($request->input('msg')) {
            $this->msg = $request->input('msg');
        }

        return view('projects.list-projects',[
            'records' => $projects,
            'params' => $this->params,
            'msg' => $this->msg
        ]);
    }


    public function resetFilter ()
    {
        $this->search = '';
    }

    public function deleteConfirm ($id)
    {
        $this->dispatchBrowserEvent('jsConfirmDelete', ['id' => $id]);
    }


    public function deleteReal($id)
    {
        Project::find($id)->delete();
        $this->dispatchBrowserEvent('informUserOnDelete');
    }


    public function changeSortDirection ($key) {

        $this->sortField = $key;

        if ($this->params['list']['headers'][$key]['direction'] == 'asc') {
            $this->params['list']['headers'][$key]['direction'] = 'desc';
        } else {
            $this->params['list']['headers'][$key]['direction'] = 'asc';
        }

        $this->sortDirection = $this->params['list']['headers'][$key]['direction'];
    }
}
