<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect("/home");
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/**
 * Subir evidencias
 */

Route::get('/{tipo}/evidencias/periodo/{periodo}/{carrera}/{md5}','HomeController@uploadView');

/**
 * Subir evidencias post
 */
Route::post('/upload/evidencias','HomeController@uploadFile');

/**
 * Links generados
 */

Route::get('/desercion/ciclo/{code}','HomeController@linkDesercion');
Route::get('/reprobados/ciclo/{code}','HomeController@linkReprobados');
Route::get('/eficiencia/ciclo/{code}','HomeController@linkEficiencia');
Route::get('/titulacion/ciclo/{code}','HomeController@linkTitulacion');
Route::get('/matricula/ciclo/{code}','HomeController@linkMatricula');


Route::get('/desercion/periodo/{code}','HomeController@linkDesercion');
Route::get('/reprobados/periodo/{code}','HomeController@linkReprobados');
Route::get('/eficiencia/periodo/{code}','HomeController@linkEficiencia');
Route::get('/titulacion/periodo/{code}','HomeController@linkTitulacion');
Route::get('/matricula/periodo/{code}','HomeController@linkMatricula');


Route::get('/desercion/link-compartido/{code}','LinkController@linkCompartidoDesercion');
Route::get('/reprobados/link-compartido/{code}','LinkController@linkCompartidoReprobados');
Route::get('/eficiencia/link-compartido/{code}','LinkController@linkCompartidoEficiencia');
Route::get('/titulacion/link-compartido/{code}','LinkController@linkCompartidoTitulacion');
Route::get('/matricula/link-compartido/{code}','LinkController@linkCompartidoMatricula');





/**
 * Rutas admin
 */
Route::get('/administrador','AdminController@index');
Route::put('/administrador/update-rol/{id}','AdminController@updateRol');
Route::put('/administrador/update-status-matricula/{id}','AdminController@updateMatricula');
Route::put('/administrador/update-status/{id}','AdminController@updateStatus');

Route::post('/administrador/agregar-periodo','AdminController@addPeriodo');

Route::put('/alumnos/desercion/update/{id}','HomeController@updateDesercion');
Route::put('/alumnos/eficiencia/update/{id}','HomeController@updateEficiencia');
Route::put('/alumnos/titulacion/update/{id}','HomeController@updateTitulacion');
Route::put('/alumnos/titulacion-egresados/update/{id}','HomeController@updateTitulacionEgre');

Route::post('/jefe/agregar/materia','HomeController@addMateria');


Route::get('/evidencias/{periodo}/{carrera}/{filename}',function($periodo,$carrera,$filename){

    $path = storage_path("app/evidencias/$periodo/$carrera/$filename");

    if (!\File::exists($path)) abort(404);

    $file = \File::get($path);

    $type = \File::mimeType($path);

    $response = Response::make($file,200);

    $response->header("Content-Type",$type);

    return $response;


});


Route::get('/evidencias/{periodo}/{carrera}/{tipo}/{filename}',function($periodo,$carrera,$tipo,$filename){

    $path = storage_path("app/evidencias/$periodo/$carrera/$tipo/$filename");

    if (!\File::exists($path)) abort(404);

    $file = \File::get($path);

    $type = \File::mimeType($path);

    $response = Response::make($file,200);

    $response->header("Content-Type",$type);

    return $response;


});