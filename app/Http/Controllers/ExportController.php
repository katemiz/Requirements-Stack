<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Endproduct;
use App\Models\Requirement;
use App\Models\Verification;
use App\Models\Gate;
use App\Models\Poc;
use App\Models\Test;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CMExport;

class ExportController extends Controller
{

    public function __construct() {
        $this->checkCurrentProduct();
    }

    public function allreqs() {

        return view('export.all-reqs', [
            'allreqs' => $this->getProductRequirements(),
            'endproducts' => $this->getEndProductsList(),
        ]);
    }


    public function getProductRequirements() {

        $technical_requirements = [];
        $general_requirements = [];

        $reqs = Requirement::where('project_id', session('current_project_id'))
        ->when(session('current_eproduct_id'), function ($query) {
            $query->where('endproduct_id', session('current_eproduct_id'));
        })
        ->orderBy('chapter_id')
        ->where('is_latest', true)
        ->get();


        foreach ( $reqs as $r) {

            if ($r->rtype == 'TR') {
                array_push($technical_requirements,$r);
            }

            if ($r->rtype == 'GR') {
                array_push($general_requirements,$r);
            }
        }

        return ['GR' => $general_requirements,'TR' => $technical_requirements];
    }


    public function getEndProductsList()  {

        if (session('current_project_id')) {
            return Endproduct::where('project_id',session('current_project_id'))->get();
        }
    }




    public function pocsvsreqs() {

        $matrix = [];
        $pocnames = [];

        $product_reqs = $this->getProductRequirements();

        foreach ($product_reqs as $rtpye => $gr_tr) {

            foreach ($gr_tr as $preq) {

                // all verification for single req
                $req_vers = Verification::where('requirement_id',$preq->id)->get();

                foreach ($req_vers as $verification) {
                    $poc = Poc::find($verification->poc_id);

                    $pocnames[$poc->code] = $poc->name;
                    $matrix[$rtpye][$poc->code][] = ['id' => $preq->id,'no' => $preq->rtype.'-'.$preq->requirement_no.' R'.$preq->revision];
                }

                ksort($matrix);
            }
        }

        return view('export.pocs-vs-reqs', [
            'matrix' => $matrix,
            'pocnames' => $pocnames
        ]);
    }


    public function dgatesvspocs() {

        $pocs = Poc::where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })
            ->get();

        $pocsDizin = [];

        foreach ($pocs as $poc) {
            $pocsDizin[$poc['id']] = ['code'=>$poc->code,'name'=>$poc->name];
        }

        $dgates = Gate::where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })
            ->orderBy('code')
            ->get();

        $product_reqs = $this->getProductRequirements();

        $usedPocs = [];
        $matrix = [];

        foreach ($product_reqs as $gr_tr) {

            foreach ($gr_tr as $preq) {

                // all verification for single req
                $req_vers = Verification::where('requirement_id',$preq->id)->get();

                foreach ($req_vers as $verification) {

                    array_push($usedPocs,$verification->poc_id);

                    if ( !isset($matrix[$verification->gate_id]) || !in_array($verification->poc_id,$matrix[$verification->gate_id]) ) {
                        $matrix[$verification->gate_id][] = $verification->poc_id;
                    }
                }
            }
        }

        return view('export.dgates-vs-pocs', [
            'matrix' => $matrix,
            'pocs' => $pocsDizin,
            'dgates' => $dgates
        ]);
    }




    public function getTestsList()  {

        if (session('current_project_id')) {

            return Test::where('project_id', session('current_project_id'))

                // ->when(session('current_eproduct_id'), function ($query) {
                //     $query->where('endproduct_id', session('current_eproduct_id'));
                // })

                ->where('is_latest', true)
                ->get();

        }

        return collect([]);
    }




    public function testsvsreqs() {

        $tests = $this->getTestsList();

        $requirements = Requirement::where('project_id', session('current_project_id'))
            ->when(session('current_eproduct_id'), function ($query) {
                $query->where('endproduct_id', session('current_eproduct_id'));
            })
            ->whereHas('tests')
            ->get();

        $tests_array = [];
        $tests_vs_reqs_array = [];

        foreach ($tests as $tt) {
            $tests_array[$tt->id] = $tt;
        }

        //dd($tests_array);



        foreach ($requirements as $requirement) {

            // dd($requirement->tests);

            foreach ($requirement->tests as $t) {
                $tests_vs_reqs_array[$t->id][] = $requirement;
            }
        }

        // dd([$tests_vs_reqs_array,$tests]);

        return view('export.tests-vs-requirements', [
            'tests_array' => $tests_array,
            'tests_vs_reqs_array' => $tests_vs_reqs_array,
        ]);
    }



    public function compliancematrix() {

        $product_reqs = $this->getProductRequirements();

        return view('export.compliance-matrix', [
            'requirements' => $product_reqs
        ]);
    }


    public function excelCMExport()
    {
        return Excel::download(new CMExport, 'CM.xlsx');
    }


    public function checkCurrentProduct() {

        /*
        session('current_project_id');
        session('current_project_name');

        session('current_eproduct_id');
        session('current_eproduct_name');
        */

        if (!session('current_project_id') && !session('current_product_id')) {
            return redirect(url()->previous());
        }
    }
}
