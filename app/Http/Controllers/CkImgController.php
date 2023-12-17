<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

use App\Models\CkFile;

class CkImgController extends Controller
{
    public function store(Request $request) {

        $m = new CkFile();
        $m->id = 0;
        $m->exists = true;
        $image = $m->addMediaFromRequest('upload')->toMediaCollection('images');

        // Return JSON response
        return response()->json([
            'url' => $image->getUrl()
        ]);
    }
}
