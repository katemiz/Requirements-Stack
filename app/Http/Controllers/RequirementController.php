<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Company;
use App\Models\Project;
use App\Models\Requirement;


class RequirementController extends Controller
{
    public $action;
    public $params;

    public function __construct()
    {
        $this->params = json_decode( file_get_contents(resource_path('/js/requirements.json')),true );
    }

    public function form(Request $request)
    {
        $projects = Project::all()->sortBy("name");

        if ( $projects->count() < 1) {

            $warnings = json_decode( file_get_contents(resource_path('/js/warnings.json')),true );

            return view('warning', [
                'warning' => $warnings['110'],
            ]);
        }

        $optionArr = [];

        foreach ($projects as $project) {
            $optionArr[$project->id] = $project->code;

        }


        $this->params['form']['project']['options'] = $optionArr;

        $this->action = 'create';
        $requirement = false;

        if ( isset($request->id) && !empty($request->id)) {
            $requirement = Requirement::find($request->id);
            $this->action = 'update';
            $this->params['update']['submitRoute'] = $this->params['update']['submitRoute'].$request->id;

            $this->params['form']['type']['value'] = $requirement->type;
            $this->params['form']['text']['value'] = $requirement->text;
        }

        return view('requirement.form', [
            'action' => $this->action,
            'requirement' => $requirement,
            'params' => $this->params
        ]);
    }



    public function store(Request $request)
    {
        $id = false;

        $props['user_id'] = 1; //Auth::id();

        $props['project_id'] = $request->input('project');



        if ( isset($request->id) && !empty($request->id)) {

            $validated = $request->validate([
                'code' => ['required', 'max:12'],
                'text' => ['required','max:128'],
            ]);

            // update
            $project = Project::find($request->id)->update(array_merge($props,$validated));

            $id = $request->id;
        } else {

            $validated = $request->validate([
                'code' => ['required', 'unique:projects', 'max:12'],
                'text' => ['required','max:128'],
            ]);

            // create
            $project = Project::create(array_merge($props,$validated));
            $id = $project->id;
        }

        return redirect('/projects/view/'.$id);
    }





}
