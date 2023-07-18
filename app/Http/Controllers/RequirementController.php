<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Company;
use App\Models\Project;
use App\Models\EndProduct;
use App\Models\Requirement;

use App\Rules\EditorRule;
use App\Rules\SelectRule;




class RequirementController extends Controller
{
    public $action;

    public function __construct () {

        $projects = Project::all()->sortBy("code");
        $endproducts = EndProduct::where('project_id',session('current_project_id'))->orderBy("code")->get();

        // dd(["aaaa"=>session('current_project_id')]);


        // dd($endproducts);

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
            $epArr[$endproduct->id] = $endproduct->code.', '.$endproduct->title;
        }

        config(["requirements.form.project.options" => $optionArr]);
        config(["requirements.form.endproduct.options" => $epArr]);

        // dd(config("requirements.form.endproduct.options"));

    } 



    public function form(Request $request)
    {

        // dd(config(["requirements.form.endproduct.options"]));

        if ( !session('current_project_id') || empty(session('current_project_id'))) {
            return redirect('/selectcurrentproject');
        }


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
        $props['cross_ref_no'] = $request->input('cross_ref_no');
        $props['remarks'] = $request->input('remarks');

        $validated = $request->validate([
            'rtype' => ['required', 'string', new SelectRule],
            'text' => 'required|min:25',
        ]);


        $props = array_merge($props,$validated);

        // dd($props);

        if ( isset($request->id) && !empty($request->id)) {

            // update
            $requirement = Requirement::find($request->id)->update($props);

            $id = $request->id;
        } else {

            // create
            $requirement = Requirement::create($props);
            $id = $requirement->id;
        }


        // END PRODUCTS

        $req = Requirement::find($id);

        foreach (config("requirements.form.endproduct.options") as $key => $v) {

            $varname  = "endproduct".$key;

            if ( $request->input($varname) ) {


                $req->end_products()->attach($request[$varname]);

            }



        }




        return redirect('/requirements/view/'.$id);
    }





}
