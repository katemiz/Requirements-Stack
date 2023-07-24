<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

class GateController extends Controller
{
    public $action;

    public function form(Request $request)
    {
        $projects = Project::all()->sortBy("name");

        if ( $projects->count() < 1) {

            return view('warning', [
                'warning' => config('warnings.100'),
            ]);
        }

        $optionArr = [];

        foreach ($projects as $project) {
            $optionArr[$project->id] = $project->name;
        }

        config(['dgates.form.projects.options' => $optionArr]);

        $this->action = 'create';
        $dgate = false;

        if ( isset($request->id) && !empty($request->id)) {
            $dgate = Meeting::find($request->id);
            $this->action = 'update';
        }

        return view('projects.gates-form', [
            'action' => $this->action,
            'dgate' => $dgate,
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

        return view('projects.view', [
            'action' => $this->action,
            'project' => Project::find($request->id)
        ]);
    }


    public function delete($id)
    {
        Project::find($id)->delete();
        return redirect('/projects');
    }
}
