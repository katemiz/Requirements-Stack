<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Attachment;


class FileList extends Component
{
    public $idAttach;

    public $model;
    public $modelId;
    public $tag = false;

    public $showMime = true;
    public $showSize = true;

    public $canDelete = false;


    #[On('refreshFileList')]
    public function render() {

        return view('components.elements.file-list',[
            'attachments' => $this->getAttachments()
        ]);
    }


    public function getAttachments() {

        if ($this->modelId) {
            if ($this->tag) {
                $attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->where('tag',$this->tag)
                ->get();
            } else {
                $attachments = Attachment::where('model_name',$this->model)
                ->where('model_item_id',$this->modelId)
                ->get();
            }

            return $attachments;
        }

        return [];
    }


    public function downloadFile($idAttach) {

        $d = Attachment::find($idAttach);

        if (!$this->checkPermission()) {
            abort(404, 'No permission!');
        }

        $dosya = Storage::path($d->stored_file_as);

        if (file_exists($dosya)) {
            $headers = [
                'Content-Type' => $d->mime_type,
            ];

            return response()->download(
                $dosya,
                $d->original_file_name,
                $headers,
                'inline'
            );
        } else {
            abort(404, 'File not found!');
        }
    }


    public function startAttachDelete($idAttach) {
        $this->idAttach = $idAttach;
        $this->dispatch('ConfirmDelete', type:'attach');
    }


    #[On('deleteAttach')]
    public function deleteAttach() {
        Attachment::find($this->idAttach)->delete();
        $this->dispatch('attachDeleted');
    }


    public function checkPermission()
    {
        if ( Auth::id() ) {
            return true;
        } else {
            return false;
        }
    }

}


