<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\Company;
use App\Models\Endproduct;
use App\Models\Project;
use App\Models\User;



class ProductSelector extends Controller
{

    public $companies;
    public $endproducts;
    public $projects;
    public $redirect_to;



    public function products(Request $request)
    {
        $this->getProductsList();

        return view('pselector.product-selector', [
            'redirect_to' => $this->getRedirectLink(),
            'projects' => $this->projects,
            'endproducts' => $this->endproducts
        ]);
    }



    function getRedirectLink() {

        switch (request('pageBackIdentifier')) {
            case 'rl':
                $this->redirect_to = '/requirements/list';
                break;
            
            default:
                $this->redirect_to = '/';
                break;
        }
    }


    function getProductsList() {

        $usr = Auth::user();

        $usr->is_admin = false;
        $usr->is_company_admin = false;

        if ($usr->hasRole('admin')) {
            $usr->is_admin = true;
        }



        switch (request('pageBackIdentifier')) {
            case 'rl':
                $this->redirect_to = '/requirements/list';
                break;
            
            default:
                $this->redirect_to = '/';
                break;
        }
    }



}
