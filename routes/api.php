<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

//  'middleware' => 'api',
 // 'namespace' => 'App\Http\Controllers',
  'prefix' => 'auth'

], function ($router) {

  Route::post('login', 'API\AuthenController@login');
  Route::post('logout', 'API\AuthenController@logout');
  Route::post('refresh', 'AuthenController@refresh');
  Route::post('me', 'AuthenController@me');
  Route::get('/me','API\AuthenController@me');
});
Route::get('/notif','API\ProjetController@notifications');
Route::get('/me','API\AuthenController@guard');
Route::post('/login','API\AuthenController@login');
Route::post('/userauth','API\AuthenController@userauth');
//Route::group(['middleware' => 'jwt.auth'], function ($router) {
//User
Route::apiResource('client' ,'API\UserController@dashbord');
Route::get('membrep','API\UserController@Membreprojet');
Route::get('/chef', 'API\UserController@chef');
Route::post('/ajouterChefDeProjet','API\UserController@ajouterChefDeProjet');
Route::post('user-login' ,'API\UserController@login');
Route::apiResource('membre','API\UserController');
Route::post('updateuserconnecte','API\UserController@updateuserconnecté');
Route::get('/chef','API\UserController@chefprojet');
Route::get('/chefwP','API\UserController@chefprojetwP');


//UserProjet
Route::apiResource('/userprojet' ,'API\UserProjetController');
Route::get('/membreid/{id}','API\UserProjetController@show');
Route::get('/projetsuser','API\UserProjetController@projetuser');
Route::post('/chefdeprojet','API\UserProjetController@storeChef');
Route::post('/chefdeprojetparchef','API\UserProjetController@storeChefparchef');

//Client
//Route::post('/api/clientpname','API\UserController@updatename');
Route::get('nameprojet' ,'API\UserController@nomdeprojet');
Route::get('clientp','API\UserController@clientprojet');
Route::post('/ajouterClient','API\UserController@ajouterClient');
Route::get('/afficheclient', 'API\UserController@client');
//Projet
Route::get('/getProjects', 'API\ProjetController@getProjects');
Route::apiResource('projet' ,'API\ProjetController');
Route::post('/role' ,'API\ProjetController@role');
Route::get('/role','API\ProjetController@getrole');
Route::get('/projetadmin','API\ProjetController@adminp');
Route::get('/getProjectsUserConnecte', 'API\ProjetController@getProjectsUserConnecte');

//Commentaire
Route::post('/comments/{key}', 'API\CommentController@store');
Route::get('/comments', 'API\CommentController@show');
Route::post('/commentsreponse/{key}', 'API\CommentController@storereply');
Route::post('/commentsreponset/{key}', 'API\CommentController@storereplyt');
Route::get('/commentreply', 'API\CommentController@showreply');
Route::post('/commentst/{key}', 'API\CommentController@storet');
Route::get('/commentst', 'API\CommentController@showt');

//calendar
Route::apiResource('/calendar', 'API\CalenderController');


//gantt



  Route::resource('/task', 'API\TaskController');
 Route::post('/task/{key}','API\TaskController@store');
Route::put('task/{id}','API\TaskController@update');
Route::delete('task/{id}','API\TaskController@destroy');


Route::post('link','API\LinkController@store');
Route::put('link/{id}','API\LinkController@update');
Route::delete('link/{id}','API\LinkController@destroy');
//Route::re}source('link', 'API\LinkController');
Route::get('/tasks','API\TaskController@getTask');
Route::get('/tasksdetail','API\TaskController@getTaskt');
//Task
Route::post('/taskassign/{id}/{membre}','API\TaskController@assign');
Route::get('/userTask','API\TaskController@user');
Route::get('/hasparent','API\TaskController@hasparent');
Route::get('membret/{id}','API\UserProjetController@showt');
Route::get('warn','API\TaskController@warning');
Route::get('membretask','API\TaskController@showmembre');

//reclamation
Route::resource('reclamation','API\ReclamationController');
Route::get('/complain','API\ReclamationController@complaints');
Route::post('/complainfile','API\ReclamationController@complaintsfile');
Route::get('/filesComplain/{id}','API\FileController@complaintsfile');
Route::get('/projetRec','API\ReclamationController@projets');
Route::post('/reclamationassign/{id}/{membre}','API\ReclamationController@assign');
Route::post('/type' ,'API\ReclamationController@type');
Route::get('/type','API\ReclamationController@gettype');
Route::post('/reclamationTerm/{id}','API\ReclamationController@terminerReclamation');
Route::post('/reclamationAlert/{id}','API\ReclamationController@alertReclamation');
//profil
Route::put('profile', 'API\UserController@updateProfile');
Route::get('membrechef','API\UserController@Membrechefprojet');
//File
Route::get('/file/{id}','API\FileController@files');
Route::post('formSubmit/{id}','API\FileController@formSubmit');
Route::get('/filet/{id}','API\FileController@filest');
Route::post('formSubmitt/{id}','API\FileController@formSubmitt');
Route::post('formSubmitR','API\FileController@formSubmitR');
//stata
Route::get('/Nprojects','API\StatController@Nprojects');
Route::get('/Nclients','API\StatController@Nclients');
Route::get('/Nusers','API\StatController@Nusers');
Route::get('/Nleaders','API\StatController@Nleaders');
Route::get('/stats','API\StatController@stats');
Route::get('/Uprojects','API\StatController@Uprojects');
Route::get('/Ustats','API\StatController@Ustats');
Route::get('/Utasks','API\StatController@Utasks');
Route::get('/Cprojets','API\StatController@Cprojets');
//});

Route::get('/data/{id}', 'API\GanttController@get');

Route::get('/data', 'GanttController@get');

