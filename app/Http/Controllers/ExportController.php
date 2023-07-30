<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Requirement;
use App\Models\Verification;
use App\Models\Poc;




class ExportController extends Controller
{
    public function allreqs() {

        $all = Requirement::all();

        foreach ($all as $requirement) {
            $allreqs[$requirement->rtype][] = $requirement;
        }

        return view('export.all-reqs', [
            'allreqs' => $allreqs
        ]);
    }


    public function pocsvsreqs() {

        $allvers = Verification::all();

        foreach ($allvers as $verification) {
            $req = Requirement::find($verification->requirement_id);
            $poc = Poc::find($verification->poc_id);

            $pocnames[$poc->code] = $poc->name;

            $matrix[$poc->code][] = $req->rtype.'-'.$req->id;
        }

        return view('export.pocs-vs-reqs', [
            'matrix' => $matrix,
            'pocnames' => $pocnames
        ]);
    }



    





}
