<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Company;
use App\Models\Project;
use App\Models\EndProduct;
use App\Models\Requirement;



class RequirementController extends Controller
{
    public $action;

    public function form(Request $request)
    {

        if ( !session('current_project_id') || empty(session('current_project_id'))) {
            return redirect('/selectcurrentproject');
        }

        $projects = Project::all()->sortBy("code");
        $endproducts = EndProduct::where('project_id',session('current_project_id'))->orderBy("code")->get();

        if ( $projects->count() < 1) {

            return view('warning', [
                'warning' => config('warnings.110')
            ]);
        }

        $optionArr = [];

        foreach ($projects as $project) {
            $optionArr[$project->id] = $project->code;
        }

        $epArr = [];

        foreach ($endproducts as $endproduct) {
            $epArr[$endproduct->id] = $endproduct->code;
        }

        config(["requirements.form.project.options" => $optionArr]);
        config(["requirements.form.endproduct.options" => $epArr]);

        $this->action = 'create';
        $requirement = false;

        if ( isset($request->id) && !empty($request->id)) {
            $requirement = Requirement::find($request->id);
            $this->action = 'update';
        }

        return view('requirement.form', [
            'action' => $this->action,
            'requirement' => $requirement
        ]);
    }



    public function store(Request $request)
    {
        $props['user_id'] = 1; //Auth::id();

        $props['project_id'] = $request->input('project');
        $props['rtype'] = $request->input('rtype');
        $props['cross_ref_no'] = $request->input('cross_ref_no');
        $props['remarks'] = $request->input('remarks');


        $validated = $request->validate([
            'rtype' => ['required'],
            'hidElIdtext' => ['required'],
        ]);


        $props = array_merge($props,$validated);

        dd($props);

        if ( isset($request->id) && !empty($request->id)) {

            // update
            $requirement = Requirement::find($request->id)->update($props);

            $id = $request->id;
        } else {

            // create
            $requirement = Requirement::create($props);
            $id = $requirement->id;
        }

        return redirect('/requirements/view/'.$id);
    }





}
