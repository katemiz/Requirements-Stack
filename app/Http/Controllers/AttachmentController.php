<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class AttachmentController extends Controller
{






    public function upload(Request $request)
    {
        if ($request->has('dosyalar')) {

            //dd($request->file('dosyalar'));

            foreach ($request->file('dosyalar') as $dosya) {

                $props['user_id'] = Auth::id();
                $props['model_name'] = $request->itemName;
                $props['model_item_id'] = $request->itemId;
                $props['original_file_name'] = $dosya->getClientOriginalName();
                $props['mime_type'] = $dosya->getMimeType();
                $props['file_size'] = $dosya->getSize();

                $path = $props['model_name'].'/'.$props['model_item_id'];

                $stored_file_as = Storage::disk('local')->put($path, $dosya);

                $props['stored_file_as'] = $stored_file_as;

                Attachment::create($props);

                dd($props);



            }
        }
    }











}
