<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Project;


class CompanyController extends Controller
{
    public $action;
    public $params;

    public function __construct()
    {
        $this->params = json_decode( file_get_contents(resource_path('/js/companies.json')),true );
    }

    public function form(Request $request)
    {
        $this->action = 'create';
        $company = false;

        if ( isset($request->id) && !empty($request->id)) {
            $company = Company::find($request->id);
            $this->action = 'update';
            $this->params['update']['submitRoute'] = $this->params['update']['submitRoute'].$request->id;

            $this->params['form']['name']['value'] = $company->name;
            $this->params['form']['fullname']['value'] = $company->fullname;
        }

        return view('companies.form', [
            'action' => $this->action,
            'company' => $company,
            'params' => $this->params
        ]);
    }


    public function store(Request $request)
    {
        $id = false;


        $props['user_id'] = 1; //Auth::id();

        if ( isset($request->id) && !empty($request->id)) {

            $validated = $request->validate([
                'name' => ['required', 'max:12'],
                'fullname' => ['required','max:128'],
            ]);



            // update
            $company = Company::find($request->id)->update(array_merge($props,$validated));

            $id = $request->id;
        } else {

            $validated = $request->validate([
                'name' => ['required', 'unique:companies', 'max:12'],
                'fullname' => ['required','max:128'],
            ]);



            // create
            $company = Company::create(array_merge($props,$validated));
            $id = $company->id;
        }

        return redirect('/companies/view/'.$id);
    }


    public function view(Request $request)
    {
        $this->action = 'read';

        return view('companies.view', [
            'action' => $this->action,
            'company' => Company::find($request->id),
            'params' => $this->params
        ]);
    }


    public function delete($id)
    {
        Project::find($id)->delete();
        return redirect('/companies');
    }
}
