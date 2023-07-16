<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Project;


class ProjectController extends Controller
{
    public $action;
    public $params;

    public function __construct()
    {
        $this->params = json_decode( file_get_contents(resource_path('/js/projects.json')),true );
    }

    public function form(Request $request)
    {
        $companies = Company::all()->sortBy("name");

        if ( $companies->count() < 1) {

            return view('warning', [
                'warning' => config('warnings.100'),
            ]);
        }

        $optionArr = [];

        foreach ($companies as $company) {
            $optionArr[$company->id] = $company->name;
        }

        $this->params['form']['company']['options'] = $optionArr;

        $this->action = 'create';
        $project = false;

        if ( isset($request->id) && !empty($request->id)) {
            $project = Project::find($request->id);
            $this->action = 'update';
            $this->params['update']['submitRoute'] = $this->params['update']['submitRoute'].$request->id;

            $this->params['form']['code']['value'] = $project->code;
            $this->params['form']['title']['value'] = $project->title;
        }

        return view('projects.form', [
            'action' => $this->action,
            'project' => $project,
            'params' => $this->params
        ]);
    }


    public function store(Request $request)
    {
        $id = false;

        $props['user_id'] = 1; //Auth::id();

        $props['company_id'] = $request->input('company');



        if ( isset($request->id) && !empty($request->id)) {

            $validated = $request->validate([
                'code' => ['required', 'max:12'],
                'title' => ['required','max:128'],
            ]);

            // update
            $project = Project::find($request->id)->update(array_merge($props,$validated));

            $id = $request->id;
        } else {

            $validated = $request->validate([
                'code' => ['required', 'unique:projects', 'max:12'],
                'title' => ['required','max:128'],
            ]);

            // create
            $project = Project::create(array_merge($props,$validated));
            $id = $project->id;
        }

        return redirect('/projects/view/'.$id);
    }


    public function view(Request $request)
    {
        $this->action = 'read';

        //dd(Project::find($request->id)->company());

        return view('projects.view', [
            'action' => $this->action,
            'project' => Project::find($request->id),
            'params' => $this->params
        ]);
    }


    public function delete($id)
    {
        Project::find($id)->delete();
        return redirect('/projects');
    }
}
