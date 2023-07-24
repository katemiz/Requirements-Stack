<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;


use App\Models\Company;
use App\Models\Endproduct;
use App\Models\Meeting;
use App\Models\Moc;
use App\Models\Poc;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Witness;

use App\Rules\EditorRule;
use App\Rules\SelectRule;




class RequirementController extends Controller
{
    public $action;

    public function __construct () {

        $projects = Project::all()->sortBy("code");

        if ( $projects->count() < 1) {

            return view('warning', [
                'warning' => config('warnings.110')
            ]);
        }

    }





    public function getEndProducts($idReq) {

        $req = Requirement::find($idReq);
        return Project::find($req->project_id)->endproducts()->get();
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'project' => 'required|numeric',
            'rtype' => ['required', 'string', new SelectRule],
            'text' => 'required|min:25',
        ]);

        $props['user_id'] = Auth::id();
        $props['project_id'] = $validated['project'];
        $props['rtype'] = $validated['rtype'];
        $props['cross_ref_no'] = $request->input('cross_ref_no');
        $props['text'] = $validated['text'];
        $props['remarks'] = $request->input('remarks');

        if ( isset($request->id) && !empty($request->id)) {
            // update
            Requirement::find($request->id)->update($props);
            $id = $request->id;

            $requirement = Requirement::find($id);
        } else {
            // create
            $requirement = Requirement::create($props);
            $id = $requirement->id;
        }


        // END PRODUCTS
        $endproducts = $this->getEndProducts($id);

        $dizin = [];
        foreach ($endproducts as $endproduct) {

            $varname  = "endproduct".$endproduct->id;

            if ( $request->input($varname) ) {
                array_push($dizin,$endproduct->id);
            }
        }

        $requirement->endproducts()->sync($dizin);

        return redirect('/requirements/view/'.$id);
    }


    public function view(Request $request)
    {
        $this->action = 'read';

        return view('requirement.view', [
            'action' => $this->action,
            'requirement' => Requirement::find($request->id)
        ]);
    }


    public function delete($id)
    {
        Requirement::find($id)->delete();
        return redirect('/requirements');
    }



    public function verform(Request $request)
    {
        $ver = false;
        $action = 'create';

        if ($request->has('id'))  {
            $ver = Verification::find($request->id);
            $action = 'update';
        }

        $requirement = Requirement::find($request->rid);


        return view('requirement.verform', [
            'requirement' => $requirement,
            'verification' => $ver,
            'action' => $action,
            'dgates' => Meeting::where('project_id',$requirement->project->id),
            'mocs' => Moc::where('project_id',$requirement->project->id),
            'pocs' => Poc::where('project_id',$requirement->project->id),
            'witnesses' => Witness::where('project_id',$requirement->project->id)

        ]);
    }




}
