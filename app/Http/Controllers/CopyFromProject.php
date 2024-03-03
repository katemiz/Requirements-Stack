<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Poc;
use App\Models\Moc;
use App\Models\Chapter;
use App\Models\Test;
use App\Models\Requirement;

use App\Models\Counter;



class CopyFromProject extends Controller
{


    public function run() {


        $pocs = Poc::where('project_id',4)->get()->toArray();


        foreach($pocs as $kayit) {
            $props  = (array) $kayit;
            $props['project_id'] = 6;
            Poc::create($props);
        }


        $mocs = Moc::where('project_id',4)->get()->toArray();
        foreach($mocs as $kayit) {

            $props  = (array) $kayit;
            $props['project_id'] = 6;
            Moc::create($props);
        }



        $chapters = Chapter::where('project_id',4)->get()->toArray();
        foreach($chapters as $kayit3) {
            $kayit3['project_id'] = 6;
            Chapter::create($kayit3);
        }


        $tests = Test::where('project_id',4)->get()->toArray();
        foreach($tests as $kayit4) {
            $kayit4['project_id'] = 6;
            $kayit4['test_no'] = $this->getTestNo();

            Test::create($kayit4);
        }

        $requirements = Requirement::where('project_id',4)->get()->toArray();
        foreach($requirements as $kayit5) {

            $is_valid = false;
            $r = Requirement::find($kayit5['id']);

            foreach ($r->endproducts as $ep) {
                if ($ep->id == 5) {
                    $is_valid = true;
                }
            }

            if ($is_valid) {
                $kayit5['project_id'] = 6;
                $kayit5['requirement_no'] = $this->getRequirementNo();
                Requirement::create($kayit5);
            }
        }



    }




    public function getTestNo() {

        $parameter = 'test_no';
        $initial_no = config('appconstants.counters.test_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }



    public function getRequirementNo() {

        $parameter = 'requirement_no';
        $initial_no = config('appconstants.counters.requirement_no');
        $counter = Counter::find($parameter);

        if ($counter == null) {
            Counter::create([
                'counter_type' => $parameter,
                'counter_value' => $initial_no
            ]);

            return $initial_no;
        }

        $new_no = $counter->counter_value + 1;
        $counter->update(['counter_value' => $new_no]);         // Update Counter
        return $new_no;
    }

}
