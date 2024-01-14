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
use App\Models\Counter;
use App\Models\Endproduct;
use App\Models\Requirement;
use App\Models\Project;
use App\Models\User;
use App\Models\Test;



class LwTest extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW,VERIFICATION
    public $constants;

    public $show_latest = true; /// Show only latest revisions

    public $uid = false;

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    public $is_user_admin = false;
    public $is_user_company_admin = false;

    public $companies = [];
    public $projects = [];
    public $endproducts = [];

    public $the_company = false;    // Viewed Phase Company
    public $the_project = false;    // Viewed Phase Project
    public $the_endproduct = false; // Viewed Phase EndProduct

    public $project_eproducts = [];
    public $requirements = [];

    public $all_revs = [];

    public $test_no;
    public $revision;

    #[Rule('required|numeric', message: 'Please select company')]
    public $company_id = false;

    #[Rule('required', message: 'Please select project')]
    public $project_id = false;

    public $endproduct_id = false;
    public $is_latest;

    #[Rule('required', message: 'Test title/description is missing')]
    public $title;

    public $remarks;    // Requirement remarks

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $status;

    public $test_types = [
        'LAB' => 'Laboratory Test',
        'QUAL' => 'Qualifaction Test',
        'CER' => 'Certification Test',
        'DEV' => 'Development Test',
        'ENV' => 'Environmental Conditions Test'
    ];

    #[Rule('required', message: 'Please select test type')]
    public $test_type = 'DEV';


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));
        }

        if (request('id')) {
            $this->uid = request('id');
            $this->setProps();
        }

        $this->constants = config('tests');
    }


    public function render()
    {
        $this->checkUserRoles();
        $this->checkCurrentProduct();
        $this->getCompaniesList();
        $this->getProjectsList();

        $this->checkSessionVariables();

        $this->setProps();

        return view('projects.tests.tests',[
            'tests' => $this->getTestsList()
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


    public function getTestsList()  {

        if ($this->is_user_admin) {

            if (session('current_project_id')) {

                if (strlen(trim($this->query)) < 2 ) {

                    // ADMIN/PROJECT SET/NO QUERY
                    $tests = Test::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    // ADMIN/PROJECT SET/QUERY EXISTS
                    $tests = Test::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('title', 'LIKE', "%".$this->query."%")
                                  ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));
                }

            } else {

                if (strlen(trim($this->query)) < 2 ) {

                    // ADMIN/NO PROJECT/NO QUERY
                    $tests = Test::when($this->show_latest, function ($query) {
                        $query->where('is_latest', true);
                    })
                    ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    // ADMIN/NO PROJECT/QUERY EXISTS
                    $tests = Test::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('title', 'LIKE', "%".$this->query."%")
                                  ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));
                }
            }

        } else {

            if (strlen(trim($this->query)) < 2 ) {

                $tests = Test::where('company_id', $this->logged_user->company_id)
                    ->when(session('current_project_id'), function ($query) {
                        $query->where('project_id', session('current_project_id'));
                    })
                    ->when(session('current_eproduct_id'), function ($query) {
                        $query->where('endproduct_id', session('current_eproduct_id'));
                    })
                    ->when($this->show_latest, function ($query) {
                        $query->where('is_latest', true);
                    })
                    ->orderBy($this->sortField,$this->sortDirection)
                    ->paginate(env('RESULTS_PER_PAGE'));

            } else {

                $tests = Test::where('company_id', $this->logged_user->company_id)
                ->when(session('current_project_id'), function ($query) {
                    $query->where('project_id', session('current_project_id'));
                })
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_project_id'));
                })
                ->when($this->show_latest, function ($query) {
                    $query->where('is_latest', true);
                })
                ->where(function ($sqlquery) {
                    $sqlquery->where('title', 'LIKE', "%".$this->query."%")
                            ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                })
                ->orderBy($this->sortField,$this->sortDirection)
                ->paginate(env('RESULTS_PER_PAGE'));
            }
        }

        return $tests;
    }


    public function checkCurrentProduct() {

        /*
        session('current_project_id');
        session('current_project_name');

        session('current_eproduct_id');
        session('current_eproduct_name');
        */

        if (!session('current_project_id') && !session('current_product_id')) {
            return redirect('/product-selector/rl');
        }
    }


    public function getCompaniesList()  {

        if ($this->is_user_admin) {
            $this->companies = Company::all();
        } else {
            $this->companies = Company::where('id',$this->logged_user->company_id)->get();
            $this->company_id = $this->logged_user->company_id;
        }
    }


    public function getProjectsList()  {

        if ($this->is_user_admin && $this->company_id) {
            if (session('current_project_id')) {
                $this->project_id = session('current_project_id');
                $this->projects = Project::find($this->project_id)->get();

            } else {
                $this->projects = Project::where('company_id',$this->company_id)->get();
            }
        } else {
            $this->projects = Project::where('company_id',$this->logged_user->company_id)->get();
        }

        if (count($this->projects) == 1) {
            $this->project_id = $this->projects['0']->id;
        }

        $this->getEndProductsList();
    }


    public function getEndProductsList()  {

        if ($this->project_id) {
            $this->project_eproducts = Endproduct::where('project_id',$this->project_id)->get();
        }
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
        $this->action = 'VIEW';
        $this->uid = $uid;
    }


    public function editItem($uid) {
        $this->action = 'FORM';
        $this->uid = $uid;
    }


    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';

        $this->reset('code','name');
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM']) ) {

            $c = Test::find($this->uid);

            $this->test_no = $c->test_no;
            $this->revision = $c->revision;
            $this->test_type = $c->test_type;
            $this->title = $c->title;
            $this->is_latest = $c->is_latest;
            $this->remarks = $c->remarks;
            $this->company_id = $c->company_id;
            $this->project_id = $c->project_id;
            $this->endproduct_id = $c->endproduct_id;
            $this->status = $c->status;
            $this->created_at = $c->created_at;
            $this->updated_at = $c->updated_at;
            $this->created_by = User::find($c->user_id)->fullname;
            $this->updated_by = User::find($c->updated_uid)->fullname;

            $this->the_company = Company::find($c->company_id);
            $this->the_project = Project::find($c->project_id);

            if ($c->endproduct_id > 0) {
                $this->the_endproduct = Endproduct::find($c->endproduct_id);
            }

            $this->requirements = $c->requirements;

            // Revisions
            foreach (Test::where('test_no',$this->test_no)->get() as $req) {
                $this->all_revs[$req->revision] = $req->id;
            }
        }
    }


    public function triggerDelete($type, $uid) {

        if ($type === 'test') {
            $this->uid = $uid;
        }

        $this->dispatch('ConfirmModal', type:$type);
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem($type)
    {
        if ($type === 'test') {
            Test::find($this->uid)->delete();
            session()->flash('message','Test has been deleted successfully.');

            $this->action = 'LIST';
            $this->resetPage();
        }

        if ($type === 'verification') {
            Verification::find($this->vid)->delete();
            session()->flash('message','Verification has been deleted successfully.');
        }
    }


    public function storeUpdateItem () {

        $this->validate();

        $props['updated_uid'] = Auth::id();
        $props['company_id'] = $this->company_id;
        $props['project_id'] = $this->project_id;
        $props['endproduct_id'] = $this->endproduct_id ? $this->endproduct_id : 0;
        $props['test_type'] = $this->test_type;
        $props['title'] = $this->title;
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            Test::find($this->uid)->update($props);
            session()->flash('message','Test has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['test_no'] = $this->getTestNo();
            $this->uid = Test::create($props)->id;
            session()->flash('message','Test has been created successfully.');
        }

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);
        $this->action = 'VIEW';
    }



    public function getTestNo() {

        $parameter = 'test_no';
        $initial_no = config('appconstants.counters.test_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }


    public function freezeConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'freeze');
    }

    #[On('onFreezeConfirmed')]
    public function doFreeze() {

        $this->action = 'VIEW';
        Test::find($this->uid)->update(['status' =>'Frozen']);
    }


    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmModal', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_test = Test::find($this->uid);

        $revised_test = $original_test->replicate();
        $revised_test->status = 'Verbatim';
        $revised_test->revision = $original_test->revision+1;
        $revised_test->save();

        $original_test->update(['is_latest' => false]);

        $this->uid = $revised_test->id;
        $this->action = 'VIEW';
    }
}

