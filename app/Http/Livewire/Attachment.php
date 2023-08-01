<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Attachment extends Component
{

    public $item;
    public $itemId;
    public $headers;

    public function render()
    {

        switch (request('item')) {
            case 'requirement':
                $this->headers = [
                    'title' => 'Add Attachment',
                    'subtitle' => 'Add Attachment to Requirement Item'
                ];
                break;

            default:
                # code...
                break;
        }

        // dd(request('item'));

        return view('attachment.form');
    }
}
