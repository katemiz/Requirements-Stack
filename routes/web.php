<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Livewire\Attachment;
use App\Livewire\ListRequirements;
use App\Livewire\RequirementLivewire;

use App\Livewire\LwCompany;
use App\Livewire\LwChapter;
use App\Livewire\ChangePassword;
use App\Livewire\LwEndProduct;
use App\Livewire\LwGate;
use App\Livewire\LwMoc;
use App\Livewire\LwPermission;
use App\Livewire\LwPhase;
use App\Livewire\LwPoc;
use App\Livewire\LwProductSelector;
use App\Livewire\LwProject;
use App\Livewire\LwRole;
use App\Livewire\LwRequirement;
use App\Livewire\LwUser;
use App\Livewire\LwTest;
use App\Livewire\LwWitness;
use App\Livewire\LwVerification;

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\CurrentProjectController;
use App\Http\Controllers\RolesPermissionsController;
use App\Http\Controllers\CkImgController;


use App\Http\Controllers\CopyFromProject;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/help', function () {
    return view('help');
});

Route::get('lang/{lang}', [
    'as' => 'lang.switch',
    'uses' => 'App\Http\Controllers\LanguageController@switchLang',
]);





Route::middleware('auth')->group(function () {

    // CK IMG UPLOAD
    Route::post('/ckimages', [CkImgController::class, 'store'])->name('ckimages');

    // ADMIN
    // ************************************************************
    Route::get('/convertOldToNew', [RolesPermissionsController::class, 'convertOldToNew']);

    Route::get('/admin-users/{action}/{id?}', LwUser::class);
    Route::get('/admin-roles/{action}/{id?}', LwRole::class);
    Route::get('/admin-permissions/{action}/{id?}', LwPermission::class);
    Route::get('/admin-companies/{action}/{id?}', LwCompany::class);

    Route::get('/profile', ChangePassword::class);


    // ADMIN / COMPANY-ADMIN
    // ************************************************************
    Route::get('/projects-projects/{action}/{id?}', LwProject::class);
    Route::get('/projects-eproducts/{action}/{id?}', LwEndProduct::class);
    Route::get('/projects-gates/{action}/{id?}', LwGate::class);
    Route::get('/projects-phases/{action}/{id?}', LwPhase::class);
    Route::get('/projects-witnesses/{action}/{id?}', LwWitness::class);
    Route::get('/projects-mocs/{action}/{id?}', LwMoc::class);
    Route::get('/projects-pocs/{action}/{id?}', LwPoc::class);
    Route::get('/projects-tests/{action}/{id?}', LwTest::class);
    Route::get('/projects-chapters/{action}/{id?}', LwChapter::class);

    // PRODUCT SELECTOR
    // ************************************************************
    Route::get('/product-selector/{pageBackIdentifier?}', LwProductSelector::class);


    // REQUIREMENTS
    // ************************************************************
    Route::get('/requirements/{action}/{id?}', LwRequirement::class);
    Route::get('/verifications/{rid}/{action}/{id?}', LwVerification::class);

    Route::get('/requirements/export', [RequirementController::class, 'excelExport']);

    // Attachment
    Route::get('/add-attach/{item}/{itemId}',  Attachment::class);
    Route::get('/attach-view/{id}',  [AttachmentController::class, 'attachview']);
    Route::get('/attach-delete/{model}/{modelId}/{id}',  [AttachmentController::class, 'attachdelete']);
    Route::post('/upload-attach/{itemName}/{itemId}',  [AttachmentController::class, 'upload']);

    // Current Project
    Route::get('/selectcurrentproject', [CurrentProjectController::class, 'selectCurrent']);
    Route::get('/setcurrentproject/{id}', [CurrentProjectController::class, 'setCurrent']);

    // Excel Import-Export
    Route::get('file-import-export', [UserController::class, 'fileImportExport']);
    Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
    Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');

    Route::get('/all-requirements', [ExportController::class, 'allreqs']);
    Route::get('/pocs-vs-requirements', [ExportController::class, 'pocsvsreqs']);
    Route::get('/dgates-vs-pocs', [ExportController::class, 'dgatesvspocs']);
    Route::get('/tests-vs-reqs', [ExportController::class, 'testsvsreqs']);
    Route::get('/compliance-matrix', [ExportController::class, 'compliancematrix']);
    Route::get('/compliance-matrix-export', [ExportController::class, 'excelCMExport']);


    Route::get('/copy-from', [CopyFromProject::class, 'run']);



});

require __DIR__.'/auth.php';
