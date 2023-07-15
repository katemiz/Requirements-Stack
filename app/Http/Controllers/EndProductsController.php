<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EndProduct;
use App\Models\Project;



class EndProductsController extends Controller
{
    public $action;
    public $params;

    public function __construct()
    {
        $this->params = json_decode( file_get_contents(resource_path('/js/endproducts.json')),true );
    }

    public function form(Request $request)
    {
        $projects = Project::all()->sortBy("title");

        if ( $projects->count() < 1) {

            $warnings = json_decode( file_get_contents(resource_path('/js/warnings.json')),true );

            return view('warning', [
                'warning' => $warnings['120'],
            ]);
        }

        $optionArr = [];

        foreach ($projects as $project) {
            $optionArr[$project->id] = $project->code;
        }

        $this->params['form']['project']['options'] = $optionArr;

        $this->action = 'create';
        $project = false;

        if ( isset($request->id) && !empty($request->id)) {
            $endproduct = EndProduct::find($request->id);
            $this->action = 'update';
            $this->params['update']['submitRoute'] = $this->params['update']['submitRoute'].$request->id;

            $this->params['form']['code']['value'] = $endproduct->code;
            $this->params['form']['title']['value'] = $endproduct->title;
        }

        return view('endproduct.form', [
            'action' => $this->action,
            'project' => $project,
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
                'title' => ['required','max:128'],
            ]);

            // update
            $endproduct = EndProduct::find($request->id)->update(array_merge($props,$validated));

            $id = $request->id;
        } else {

            $validated = $request->validate([
                'code' => ['required', 'unique:end_products', 'max:64'],
                'title' => ['required','max:128'],
            ]);

            // create
            $endproduct = EndProduct::create(array_merge($props,$validated));
            $id = $endproduct->id;
        }

        return redirect('/endproducts/view/'.$id);
    }


    public function view(Request $request)
    {
        $this->action = 'read';

        return view('endproduct.view', [
            'action' => $this->action,
            'endproduct' => EndProduct::find($request->id),
            'params' => $this->params
        ]);
    }


    public function delete($id)
    {
        Project::find($id)->delete();
        return redirect('/projects');
    }
}
