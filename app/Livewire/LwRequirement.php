<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


use App\Models\Company;
use App\Models\Chapter;
use App\Models\Counter;
use App\Models\Endproduct;
use App\Models\Requirement;
use App\Models\Project;
use App\Models\User;
use App\Models\Verification;
use App\Models\Gate;
use App\Models\Moc;
use App\Models\Poc;
use App\Models\Test;
use App\Models\Witness;


class LwRequirement extends Component
{
    use WithPagination;

    public $action = 'LIST'; // LIST,FORM,VIEW,VERIFICATION
    public $constants;

    public $show_latest = true; /// Show only latest revisions

    public $is_definition = false;

    public $uid = false;
    public $vid = false;    // Verification ID

    public $query = '';
    public $sortField = 'created_at';
    public $sortDirection = 'DESC';

    public $logged_user;

    public $is_user_admin = false;
    public $is_user_company_admin = false;

    // Advanced Search
    public $advanced_search=false;
    public $ep_filter = false;


    // Verification
    public $companies = [];
    public $projects = [];
    public $endproducts = [];

    public $the_company = false;    // Viewed Phase Company
    public $the_project = false;    // Viewed Phase Project
    public $the_endproduct = false; // Viewed Phase EndProduct

    public $project_eproducts = [];

    public $all_revs = [];

    public $requirement_no;
    public $requirement; // Requirement Object
    public $revision;

    #[Rule('required|numeric', message: 'Please select company')]
    public $company_id = false;

    #[Rule('required', message: 'Please select project')]
    public $project_id = false;

    public $endproduct_id = false;
    public $endproduct_ids = [];
    public $chapter_id = false;
    public $chapter;

    public $source;
    public $xrefno;

    public $is_latest;

    public $title;

    #[Rule('required', message: 'Requirement text is missing')]
    public $text;

    public $remarks;    // Requirement remarks
    public $vremarks;   // Verification remarks

    public $created_by;
    public $updated_by;
    public $created_at;
    public $updated_at;

    public $status;

    // Tests
    public $requirement_tests;

    public $tests;


    public $rtypes = [
        'GR' => 'General Requirement',
        'TR' => 'Technical Requirement',
        'DEF' => 'Definition'
    ];

    #[Rule('required', message: 'Please select requirement type')]
    public $rtype;


    public function mount()
    {
        if (request('action')) {
            $this->action = strtoupper(request('action'));

            if (request('action') == 'viewByNo' && request('id')) {
                $this->uid = $this->getIdByRequirementNo(request('id'));
            }
        }

        if (request('id')) {
            $this->uid = request('id');
            $this->setProps();
        }

        $this->constants = config('requirements');
    }


    public function render()
    {
        $this->checkUserRoles();
        $this->checkCurrentProduct();
        $this->getCompaniesList();
        $this->getProjectsList();
        $this->getTestsList();

        $this->checkSessionVariables();

        return view('requirements.requirements',[
            'requirements' => $this->getRequirementsList(),
            'verifications' => $this->getExistingVerifications(),
            'verification_data' => $this->getVerificationProps(),
            'chapters' => $this->getChaptersList()
        ]);
    }

    public function checkIsDefinition() {

        if ($this->rtype == 'DEF') {
            $this->is_definition = true;
        } else {
            $this->is_definition = false;
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


    public function checkSessionVariables() {

        if (session('current_project_id')) {
            $this->project_id = session('current_project_id');
            $this->company_id = Project::find($this->project_id)->company_id;
        }

        if (session('current_eproduct_id')) {
            $this->endproduct_id = session('current_eproduct_id');
        }
    }


    public function getRequirementsList()  {

        if ($this->is_user_admin) {

            if (session('current_project_id')) {

                if (strlen(trim($this->query)) < 2 ) {

                    // ADMIN/PROJECT SET/NO QUERY
                    $requirements = Requirement::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    // ADMIN/PROJECT SET/QUERY EXISTS
                    $requirements = Requirement::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('text', 'LIKE', "%".$this->query."%")
                                  ->orWhere('requirement_no', 'LIKE', "%".$this->query."%")
                                  ->orWhere('remarks', 'LIKE', "%".$this->query."%");

                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));
                }

            } else {



                if (strlen(trim($this->query)) < 2 ) {

                    // ADMIN/NO PROJECT/NO QUERY
                    $requirements = Requirement::when($this->show_latest, function ($query) {
                        $query->where('is_latest', true);
                    })
                    ->when($this->advanced_search && $this->rtype, function ($query) {
                        $query->where('rtype', $this->rtype);
                    })
                    ->when($this->advanced_search && $this->chapter_id, function ($query) {
                        $query->where('chapter_id', $this->chapter_id);
                    })
                    ->when($this->advanced_search && $this->ep_filter, function ($query) {
                        $query->whereHas('endproducts', function ($query) {
                            $query->where('endproduct_id', $this->ep_filter);
                        });
                    })
                    ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                } else {

                    // ADMIN/NO PROJECT/QUERY EXISTS
                    $requirements = Requirement::where('project_id', session('current_project_id'))
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('text', 'LIKE', "%".$this->query."%")
                                ->orWhere('requirement_no', 'LIKE', "%".$this->query."%")
                                ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));
                }
            }

        } else {

            if (session('current_project_id')) {

                if (strlen(trim($this->query)) < 2 ) {

                    $requirements = Requirement::where('project_id', session('current_project_id'))

                        ->where('company_id', $this->logged_user->company_id)
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                        //dd([$requirements->total(),session('current_project_id')]);


                        //dd($requirements);




                } else {

                    $requirements = Requirement::where('project_id', session('current_project_id'))
                        ->where('company_id', $this->logged_user->company_id)
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('text', 'LIKE', "%".$this->query."%")
                                ->orWhere('requirement_no', 'LIKE', "%".$this->query."%")
                                ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                }



            } else {

                if (strlen(trim($this->query)) < 2 ) {

                    $requirements = Requirement::where('company_id', $this->logged_user->company_id)
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                        //dd([$requirements->total(),session('current_project_id')]);


                } else {

                    $requirements = Requirement::where('company_id', $this->logged_user->company_id)
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', session('current_eproduct_id'));
                            });
                        })
                        ->when(session('current_eproduct_id'), function ($query) {
                            $query->where('endproduct_id', session('current_eproduct_id'));
                        })
                        ->when($this->show_latest, function ($query) {
                            $query->where('is_latest', true);
                        })
                        ->when($this->advanced_search && $this->rtype, function ($query) {
                            $query->where('rtype', $this->rtype);
                        })
                        ->when($this->advanced_search && $this->chapter_id, function ($query) {
                            $query->where('chapter_id', $this->chapter_id);
                        })
                        ->when($this->advanced_search && $this->ep_filter, function ($query) {
                            $query->whereHas('endproducts', function ($query) {
                                $query->where('endproduct_id', $this->ep_filter);
                            });
                        })
                        ->where(function ($sqlquery) {
                            $sqlquery->where('text', 'LIKE', "%".$this->query."%")
                                ->orWhere('requirement_no', 'LIKE', "%".$this->query."%")
                                ->orWhere('remarks', 'LIKE', "%".$this->query."%");
                        })
                        ->orderBy($this->sortField,$this->sortDirection)
                        ->paginate(env('RESULTS_PER_PAGE'));

                }

            }



        }

        return $requirements;
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

        if (session('current_project_id')) {
            $this->project_eproducts = Endproduct::where('project_id',session('current_project_id'))->get();
        }
    }


    public function getTestsList()  {
        if ($this->project_id) {

            $this->tests = Test::where('project_id', session('current_project_id'))

                // ->when(session('current_eproduct_id'), function ($query) {
                //     $query->where('endproduct_id', session('current_eproduct_id'));
                // })

                ->when($this->show_latest, function ($query) {
                    $query->where('is_latest', true);
                })->get();

            return true;
        }

        $this->tests = collect([]);
    }


    public function getChaptersList()  {

        if ($this->project_id) {
            return Chapter::where('project_id',$this->project_id)
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_eproduct_id'));
                })->get();
        }

        return collect([]);
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


    public function getIdByRequirementNo($requirement_no) {
        $r = Requirement::where('requirement_no',$requirement_no)->where('is_latest',true)->sole();
        return $r->id;
    }


    public function viewItem($id) {
        $this->action = 'VIEW';
        $this->uid = $id;
        $this->setProps();
    }


    public function editItem($uid) {
        $this->action = 'FORM';
        $this->rtype = 'GR';
        $this->uid = $uid;
    }


    public function addItem() {
        $this->uid = false;
        $this->action = 'FORM';
        $this->rtype = 'GR';
        $this->reset('code','name');
    }


    public function setProps() {

        if ($this->uid && in_array($this->action,['VIEW','FORM','VERIFICATION']) ) {

            $this->requirement = Requirement::find($this->uid);

            $this->requirement_no = $this->requirement->requirement_no;
            $this->revision = $this->requirement->revision;
            $this->rtype = $this->requirement->rtype;
            $this->title = $this->requirement->title;
            $this->text = $this->requirement->text;
            $this->is_latest = $this->requirement->is_latest;
            $this->remarks = $this->requirement->remarks;
            $this->company_id = $this->requirement->company_id;
            $this->project_id = $this->requirement->project_id;
            $this->endproduct_id = $this->requirement->endproduct_id;
            $this->chapter_id = $this->requirement->chapter_id;
            $this->xrefno = $this->requirement->cross_ref_no;
            $this->source = $this->requirement->source;
            $this->status = $this->requirement->status;
            $this->created_at = $this->requirement->created_at;
            $this->updated_at = $this->requirement->updated_at;
            $this->created_by = User::find($this->requirement->user_id)->fullname;
            $this->updated_by = User::find($this->requirement->updated_uid)->fullname;

            $this->the_company = Company::find($this->requirement->company_id);
            $this->the_project = Project::find($this->requirement->project_id);

            $this->tests = $this->requirement->tests;

            if ($this->requirement->chapter_id > 0) {
                $this->chapter = Chapter::find($this->requirement->chapter_id);
            }

            if ($this->requirement->endproduct_id > 0) {
                $this->the_endproduct = Endproduct::find($this->requirement->endproduct_id);
            }

            $this->requirement_tests  = [];

            if( count($this->requirement->tests) > 0 ) {
                foreach ($this->requirement->tests as $t) {
                    array_push($this->requirement_tests,$t->id);
                }
            }

            $this->endproduct_ids  = [];

            if( count($this->requirement->endproducts) > 0 ) {
                foreach ($this->requirement->endproducts as $ep) {
                    array_push($this->endproduct_ids,$ep->id);
                }
            }


            // Revisions
            foreach (Requirement::where('requirement_no',$this->requirement_no)->get() as $req) {
                $this->all_revs[$req->revision] = $req->id;
            }

            $this->checkIsDefinition();
        }

        return true;
    }

    public function getExistingVerifications() {

        if ($this->requirement) {
            return $this->requirement->verifications;
        }

        return false;
    }


    public function triggerDelete($type, $uid) {

        if ($type === 'requirement') {
            $this->uid = $uid;
        }

        if ($type === 'verification') {
            $this->vid = $uid;
        }

        $this->dispatch('ConfirmDelete', type:$type);
    }


    #[On('onDeleteConfirmed')]
    public function deleteItem($type)
    {
        if ($type === 'requirement') {
            Requirement::find($this->uid)->delete();
            Verification::where('requirement_id',$this->uid)->delete();
            session()->flash('message','Requirement and linked verifications have been deleted successfully.');

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
        //$props['endproduct_id'] = $this->endproduct_id ? $this->endproduct_id : 0;
        $props['chapter_id'] = $this->chapter_id ? $this->chapter_id : 0;
        $props['rtype'] = $this->rtype;
        $props['source'] = $this->source;
        $props['cross_ref_no'] = $this->xrefno;
        $props['title'] = $this->title;
        $props['text'] = $this->text;
        $props['remarks'] = $this->remarks;

        if ( $this->uid ) {
            // update
            Requirement::find($this->uid)->update($props);
            session()->flash('message','Requirement has been updated successfully.');

        } else {
            // create
            $props['user_id'] = Auth::id();
            $props['requirement_no'] = $this->getRequirementNo();

            $this->uid = Requirement::create($props)->id;
            session()->flash('message','Requirement has been created successfully.');
        }

        $requirement = Requirement::find($this->uid);

        $requirement->endproducts()->detach();
        $requirement->endproducts()->attach($this->endproduct_ids);

        $requirement->tests()->detach();
        $requirement->tests()->attach($this->requirement_tests);

        $this->setProps();

        // ATTACHMENTS, TRIGGER ATTACHMENT COMPONENT
        $this->dispatch('triggerAttachment',modelId: $this->uid);
        $this->action = 'VIEW';
    }


    public function formVerification ($rid,$vid) {

        $this->uid = $rid;
        if ($vid) {
            $this->vid = $vid;
        }
        $this->action = 'VERIFICATION';
    }


    public function getVerificationProps () {

        $verification = false;

        $ver_milestones = Gate::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_mocs = Moc::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_pocs = Poc::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        $ver_witnesses = Witness::where('company_id', $this->logged_user->company_id)
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->get();

        if ($this->vid) {
            $verification = Verification::find($this->vid);
        }

        return [
            'verification' => $verification,
            'ver_milestones' => $ver_milestones,
            'ver_mocs' => $ver_mocs,
            'ver_pocs' => $ver_pocs,
            'ver_witnesses' => $ver_witnesses
        ];
    }



    public function getRequirementNo() {

        $parameter = 'requirement_no';
        $initial_no = config('appconstants.counters.requirement_no');
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
        $this->dispatch('ConfirmDelete', type:'freeze');
    }

    #[On('onFreezeConfirmed')]
    public function doFreeze() {

        $this->action = 'VIEW';
        Requirement::find($this->uid)->update(['status' =>'Frozen']);

        $this->setProps();
    }


    public function reviseConfirm($uid) {
        $this->uid = $uid;
        $this->dispatch('ConfirmDelete', type:'revise');
    }


    #[On('onReviseConfirmed')]
    public function doRevise() {

        $original_requirement = Requirement::find($this->uid);

        $revised_requirement = $original_requirement->replicate();
        $revised_requirement->status = 'Verbatim';
        $revised_requirement->revision = $original_requirement->revision+1;
        $revised_requirement->save();

        foreach ($original_requirement->verifications as $verification) {
            $rev_verification = $verification->replicate();
            $rev_verification->requirement_id = $revised_requirement->id;
            $rev_verification->save();
        }

        $original_requirement->update(['is_latest' => false]);

        Log::info($original_requirement);

        $this->uid = $revised_requirement->id;
        $this->action = 'VIEW';
        $this->setProps();
    }



    public function getPreviousNextRequirement($direction) {

        $next = Requirement::where('requirement_no', '>', $this->requirement_no)
            ->where('is_latest',true)->orderBy('requirement_no','asc')
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->first();

        $previous = Requirement::where('requirement_no', '<', $this->requirement_no)
            ->where('is_latest',true)->orderBy('requirement_no','desc')
            ->where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })->first();

        if ($direction === 'next' && $next === null) {

            $min_no = Requirement::where('is_latest',true)
                ->where('project_id', session('current_project_id'))
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_eproduct_id'));
                })->min('requirement_no');

            $next = Requirement::where('requirement_no', $min_no)
                ->where('is_latest',true)
                ->where('project_id', session('current_project_id'))
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_eproduct_id'));
                })->sole();
        }

        if ($direction == 'previous' && $previous == null) {

            $max_no = Requirement::where('is_latest',true)
                ->where('project_id', session('current_project_id'))
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_eproduct_id'));
                })->max('requirement_no');

            $previous = Requirement::where('requirement_no', $max_no)
                ->where('is_latest',true)
                ->where('project_id', session('current_project_id'))
                ->when(session('current_eproduct_id'), function ($query) {
                    $query->where('endproduct_id', session('current_eproduct_id'));
                })->sole();
        }

        if ($direction == 'next') {
            $this->uid = $next->id;
        }

        if ($direction == 'previous') {
            $this->uid = $previous->id;
        }

        $this->setProps();
    }

}
