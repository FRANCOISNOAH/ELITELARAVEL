<?php

use Illuminate\Support\Facades\Route;

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


/**
 * Authentification Route
 */

Route::get('', [\App\Http\Controllers\AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('register', [\App\Http\Controllers\AuthController::class, 'register'])->middleware('guest')->name('register');
Route::post('register', [\App\Http\Controllers\AuthController::class, 'saveregister'])->middleware('guest')->name('post.register');
Route::get('confirmregister', [\App\Http\Controllers\AuthController::class, 'confirmregister'])->middleware('guest')->name('confirm.register');
Route::post('postlogin', [\App\Http\Controllers\AuthController::class, 'email'])->middleware('guest')->name('login.post');
Route::get('password', [\App\Http\Controllers\AuthController::class, 'loginpassword'])->middleware('guest')->name('password');
Route::post('password', [\App\Http\Controllers\AuthController::class, 'connect'])->middleware('guest')->name('password.post');
Route::get('forgot_password/{email}', [\App\Http\Controllers\AuthController::class, 'forgot_password'])->middleware('guest')->name('password.request');
Route::post('forget_password', [\App\Http\Controllers\AuthController::class, 'submitForgetPasswordForm'])->middleware('guest')->name('password.email');
Route::get('reset-password/{token}', [\App\Http\Controllers\AuthController::class, 'showResetPasswordForm'])->middleware('guest')->name('password.reset');
Route::post('reset-password', [\App\Http\Controllers\AuthController::class, 'submitResetPasswordForm'])->middleware('guest')->name('password.update');
Route::get('reset_confirmation', [\App\Http\Controllers\AuthController::class, 'confirm'])->middleware('guest')->name('password.confirm');
Route::delete('logout', [\App\Http\Controllers\AuthController::class, 'destroy'])->name('logout');


/**
 * Adminstration Route
 */
Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return redirect()->route('operation.index');
    });
    Route::resource('operation', \App\Http\Controllers\OperationController::class);
    Route::get("operation_first_step", [\App\Http\Controllers\OperationController::class, 'first_step'])->name("operation.first");
    Route::get('operation_second_step/{operation}', [\App\Http\Controllers\OperationController::class, 'second_step'])->name("operation.second");
    Route::get('operation_third_step/{operation}', [\App\Http\Controllers\OperationController::class, 'view_third_step'])->name("operation.third.view");
    Route::post('operation_third_step', [\App\Http\Controllers\OperationController::class, 'third_step'])->name("operation.third");
    Route::get('operation_third_step_back', [\App\Http\Controllers\OperationController::class, 'third_step_back'])->name("operation.third.back");
    Route::get("operation/{operation}", [\App\Http\Controllers\OperationController::class, 'show'])->name("operation.show");
    Route::get("operation_show/{operation}", [\App\Http\Controllers\OperationController::class, 'show2'])->name("operation.show2");
    Route::get("response_test/{operation}", [\App\Http\Controllers\OperationController::class, 'resp'])->name("operation.resp");
    Route::get("operation_start/{operation}", [\App\Http\Controllers\OperationController::class, 'start'])->name("operation.start");
    Route::get("operation_end/{operation}", [\App\Http\Controllers\OperationController::class, 'end'])->name("operation.end");
    Route::get('operation_sites/{operation}', [\App\Http\Controllers\OperationController::class, 'operation_sites'])->name("operation.sites");
    Route::get('operation_sites_json/{operation}', [\App\Http\Controllers\OperationController::class, 'operation_sites_json'])->name("operation.sites.json");

    Route::resource("site",\App\Http\Controllers\SiteController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::get("/user/activate/{id}", [\App\Http\Controllers\UserController::class, 'activate'])->name('activated');
    Route::get("/user/desactivate/{id}", [\App\Http\Controllers\UserController::class, 'desactivate'])->name('desactivate');
    Route::resource('company', \App\Http\Controllers\CompanyController::class);
    Route::get("operation_start/{operation}", [\App\Http\Controllers\OperationController::class, 'start'])->name("operation.start");
    Route::get("operation_end/{operation}", [\App\Http\Controllers\OperationController::class, 'end'])->name("operation.end");
    /**
     * Form Routes
     */
    Route::resource('forms',\App\Http\Controllers\FormController::class);
    Route::post('forms/{form}/draft',[\App\Http\Controllers\FormController::class,'draftForm'])->name('forms.draft');
    Route::get('forms/{form}/preview',[\App\Http\Controllers\FormController::class,'previewForm'])->name('forms.preview');
    Route::post('forms/{form}/open',[\App\Http\Controllers\FormController::class,'openFormForResponse'])->name('forms.open');
    Route::post('forms/{form}/close',[\App\Http\Controllers\FormController::class,'closeFormToResponse'])->name('forms.close');
    Route::get('forms/{form}/view', [\App\Http\Controllers\FormController::class,'viewForm'])->name('forms.view');
    Route::post('forms/{form}/responses', [\App\Http\Controllers\ResponseController::class,'store'])->name('forms.responses.store');
    Route::get('forms/conditional/{form}', [\App\Http\Controllers\FormController::class,'conditional'])->name('forms.conditional');
    Route::post('forms/conditional', [\App\Http\Controllers\FormController::class,'conditionalpost'])->name('forms.conditionalpost');
    Route::post('forms/{form}/fields/add', [\App\Http\Controllers\FieldResponseController::class,'store'])->name('forms.fields.store');
    Route::post('forms/{form}/fields/delete', [\App\Http\Controllers\FieldResponseController::class,'destroy'])->name('forms.fields.destroy');

    //Form Response Routes
    Route::get('forms/{form}/responses', [\App\Http\Controllers\ResponseController::class,'index'])->name('forms.responses.index');
    Route::get('forms/{form}/responses/download', [\App\Http\Controllers\ResponseController::class,'export'])->name('forms.response.export');
    Route::get('forms/{form}/responses/download/{country_id}', [\App\Http\Controllers\ResponseController::class,'exportcountry'])->name('forms.response.exportcountry');
    Route::get('forms/{form}/responses/downloadsite/{site_id}', [\App\Http\Controllers\ResponseController::class,'exportsite'])->name('forms.response.exportsite');
    Route::get('forms/{form}/responses/downloadville/{city_id}', [\App\Http\Controllers\ResponseController::class,'exportville'])->name('forms.response.exportville');
    Route::get('forms/{form}/responses/downloaduser/{user_id}', [\App\Http\Controllers\ResponseController::class,'exportuser'])->name('forms.response.exportuser');
    Route::delete('forms/{form}/responses', [\App\Http\Controllers\ResponseController::class,'destroyAll'])->name('forms.responses.destroy.all');
    Route::delete('forms/{form}/responses/{response}', [\App\Http\Controllers\ResponseController::class,'destroy'])->name('forms.responses.destroy.single');
    Route::get('addOperateurs',[\App\Http\Controllers\OperationController::class,'addOperateurs'])->name('operateur.add');
    Route::get('removeOperateurs/{user_id}/{operation_id}',[\App\Http\Controllers\OperationController::class,'removeOperateurs'])->name('operateur.remove');
    Route::get('addLecteurs',[\App\Http\Controllers\OperationController::class,'addLecteurs'])->name('lecteur.add');
    Route::get('removeLecteurs/{user_id}/{operation_id}',[\App\Http\Controllers\OperationController::class,'removeLecteurs'])->name('lecteur.remove');
    Route::get('getOperateursList/{id}',[\App\Http\Controllers\OperationController::class,'getOperateursList'])->name('operation.get.list');
    Route::get('getLecteursList/{id}',[\App\Http\Controllers\OperationController::class,'getLecteursList'])->name('lecteur.get.list');
    Route::get('json_response/{question}',[\App\Http\Controllers\FormController::class,'getResponse'])->name('form.get.response');

    Route::resource('role',\App\Http\Controllers\RoleController::class)->except('show');
    Route::resource('permission',\App\Http\Controllers\PermissionController::class)->except('show');
    Route::resource('countries',\App\Http\Controllers\CountryController::class);

    Route::resource('topic', \App\Http\Controllers\TopicController::class)->middleware(['auth']);
    Route::resource('template', \App\Http\Controllers\TemplateController::class)->middleware(['auth']);
    Route::get('/usetemplate/{id}/{code}', [\App\Http\Controllers\TemplateController::class,'use'])->name("usetemplate")->middleware(['auth']);
    Route::get('/json-templates', 'TemplateController@alltemplates')->middleware(['auth']);
    Route::get('/json-templates2', [\App\Http\Controllers\TemplateController::class,'alltemplates2'])->middleware(['auth']);
});



