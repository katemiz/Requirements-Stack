<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Requirement;
use App\Models\Verification;
use App\Models\Meeting;
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

            $matrix[$poc->code][] = ['id' => $req->id,'no' => $req->rtype.'-'.$req->id];
        }

        return view('export.pocs-vs-reqs', [
            'matrix' => $matrix,
            'pocnames' => $pocnames
        ]);
    }


    public function dgatesvspocs() {

        $allvers = Verification::all();
        $pocs = Poc::all();
        $dgates = Meeting::all();

        // foreach (Poc::all()->toArray() as $poc) {
        //     $pocs[$poc['id']][] = $poc;
        // }

        //dd($pocs);

        foreach ($allvers as $verification) {
            $matrix[$verification->meeting_id][] = 1;//$pocs[$verification->poc_id]['code'];
        }

        // foreach ($matrix as $key => $value) {
        //     $matrix[$key] = array_unique($value);
        // }

        return view('export.dgates-vs-pocs', [
            'matrix' => $matrix,
            // 'pocs' => $pocs,
            'dgates' => $dgates
        ]);
    }

    





}
