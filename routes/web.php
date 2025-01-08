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

Route::pattern('statename', '[a-z_]+');
Route::pattern('cityname', '[a-z|_]+');
Route::pattern('filename', '.+');
Route::pattern('id', '\d+');

Route::get('/', 'App\Http\Controllers\IndexController@index');
Route::get('/search', 'App\Http\Controllers\IndexController@search');
Route::post('/search', 'App\Http\Controllers\IndexController@search_results');
Route::get('/{statename}_activities.html', 'App\Http\Controllers\AfterschoolController@state');
Route::get('/{statename}-city/{cityname}-care.html', 'App\Http\Controllers\AfterschoolController@city');
Route::get('/program-{id}-{filename}.html', 'App\Http\Controllers\AfterschoolController@show');
Route::get('/programs/new', 'App\Http\Controllers\AfterschoolController@create');
Route::post('/programs/new', 'App\Http\Controllers\AfterschoolController@create');
Route::get('/program/edit/id/{id}', 'App\Http\Controllers\AfterschoolController@edit');
Route::post('/program/edit/id/{id}', 'App\Http\Controllers\AfterschoolController@edit');
Route::get('/program/imageupload', 'App\Http\Controllers\AfterschoolController@upload_image');
Route::post('/program/imageupload', 'App\Http\Controllers\AfterschoolController@upload_image');
Route::get('/program/imagedelete', 'App\Http\Controllers\AfterschoolController@delete_image');
Route::get('/martial-arts', 'App\Http\Controllers\ActivityController@martialArts');
Route::get('/{statename}_martial-arts.html', 'App\Http\Controllers\ActivityController@martialArts_state');
Route::get('/{statename}-martial-arts/{cityname}.html', 'App\Http\Controllers\ActivityController@martialArts_city');
Route::get('/activity-{id}-{filename}.html', 'App\Http\Controllers\ActivityController@martialArts_show');
Route::get('/youth-sports', 'App\Http\Controllers\ActivityController@youthSports');
Route::get('/{statename}_youth-sports.html', 'App\Http\Controllers\ActivityController@youthSports_state');
Route::get('/{statename}-youth-sports/{cityname}.html', 'App\Http\Controllers\ActivityController@youthSports_city');
Route::get('/sportclub-{id}-{filename}.html', 'App\Http\Controllers\ActivityController@youthSports_show');
Route::get('/{category}/new', 'App\Http\Controllers\ActivityController@activity_create')->where('category', 'martial-arts|youth-sports');
Route::post('/{category}/new', 'App\Http\Controllers\ActivityController@activity_create')->where('category', 'martial-arts|youth-sports');
Route::get('/activity/edit/id/{id}', 'App\Http\Controllers\ActivityController@activity_edit');
Route::post('/activity/edit/id/{id}', 'App\Http\Controllers\ActivityController@activity_edit');
Route::get('/activity/imageupload', 'App\Http\Controllers\ActivityController@upload_image');
Route::post('/activity/imageupload', 'App\Http\Controllers\ActivityController@upload_image');
Route::get('/activity/imagedelete', 'App\Http\Controllers\ActivityController@delete_image');
Route::get('/review/new', 'App\Http\Controllers\ReviewController@comment');
Route::post('/review/new', 'App\Http\Controllers\ReviewController@comment');
Route::post('/review/verify/{id}/{commentableId}', 'App\Http\Controllers\ReviewController@verify');
Route::get('/contact', 'App\Http\Controllers\ContactController@index');
Route::post('/contact', 'App\Http\Controllers\ContactController@index');
Route::get('/send_question', 'App\Http\Controllers\QuestionController@send_question');
Route::post('/send_question', 'App\Http\Controllers\QuestionController@send_question');
Route::get('/send_answer', 'App\Http\Controllers\QuestionController@send_answer');
Route::post('/send_answer', 'App\Http\Controllers\QuestionController@send_answer');

Route::get('/user/login', 'App\Http\Controllers\LoginController@login');
Route::post('/user/login', 'App\Http\Controllers\LoginController@login');
Route::get('/user/logout', 'App\Http\Controllers\LoginController@logout');
Route::get('/user/new', 'App\Http\Controllers\RegisterController@index');
Route::post('/user/new', 'App\Http\Controllers\RegisterController@index');
Route::get('/user/activate', 'App\Http\Controllers\RegisterController@activate');
Route::get('/user/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::post('/user/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/user/pwdreset', 'App\Http\Controllers\Auth\ResetPasswordController@reset');
Route::post('/user/pwdreset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

Route::get('/admin', 'App\Http\Controllers\Admin\IndexController@index');
Route::post('/admin/afterschool/approve', 'App\Http\Controllers\Admin\AfterschoolController@approve');
Route::post('/admin/afterschool/disapprove', 'App\Http\Controllers\Admin\AfterschoolController@disapprove');
Route::post('/admin/afterschool/delete', 'App\Http\Controllers\Admin\AfterschoolController@delete');
Route::post('/admin/activity/approve', 'App\Http\Controllers\Admin\ActivityController@approve');
Route::post('/admin/activity/disapprove', 'App\Http\Controllers\Admin\ActivityController@disapprove');
Route::post('/admin/activity/delete', 'App\Http\Controllers\Admin\ActivityController@delete');
Route::post('/admin/image/approve', 'App\Http\Controllers\Admin\ImageController@approve');
Route::post('/admin/image/disapprove', 'App\Http\Controllers\Admin\ImageController@disapprove');
Route::post('/admin/image/delete', 'App\Http\Controllers\Admin\ImageController@delete');
Route::get('/admin/afterschool-log/show/id/{id}', 'App\Http\Controllers\Admin\AfterschoolLogController@show');
Route::post('/admin/afterschool-log/approve', 'App\Http\Controllers\Admin\AfterschoolLogController@approve');
Route::post('/admin/afterschool-log/disapprove', 'App\Http\Controllers\Admin\AfterschoolLogController@disapprove');
Route::post('/admin/afterschool-log/delete', 'App\Http\Controllers\Admin\AfterschoolLogController@delete');
Route::get('/admin/activity-log/show/id/{id}', 'App\Http\Controllers\Admin\ActivityLogController@show');
Route::post('/admin/activity-log/approve', 'App\Http\Controllers\Admin\ActivityLogController@approve');
Route::post('/admin/activity-log/disapprove', 'App\Http\Controllers\Admin\ActivityLogController@disapprove');
Route::post('/admin/activity-log/delete', 'App\Http\Controllers\Admin\ActivityLogController@delete');
Route::get('/admin/review', 'App\Http\Controllers\Admin\ReviewController@index');
Route::post('/admin/review/approve', 'App\Http\Controllers\Admin\ReviewController@approve');
Route::post('/admin/review/disapprove', 'App\Http\Controllers\Admin\ReviewController@disapprove');
Route::post('/admin/review/delete', 'App\Http\Controllers\Admin\ReviewController@delete');
Route::get('/admin/visitor_counts', 'App\Http\Controllers\Admin\VisitorController@visitor_counts');
Route::get('/admin/visitor_delete', 'App\Http\Controllers\Admin\VisitorController@delete_visitor');
Route::get('/admin/question', 'App\Http\Controllers\Admin\QuestionController@index')->name('admin.question');
Route::get('/admin/question_editor', 'App\Http\Controllers\Admin\QuestionController@question_editor');
Route::post('/admin/question_update', 'App\Http\Controllers\Admin\QuestionController@question_update');
Route::get('/admin/answer_editor', 'App\Http\Controllers\Admin\QuestionController@answer_editor');
Route::post('/admin/answer_update', 'App\Http\Controllers\Admin\QuestionController@answer_update');
Route::post('/admin/question/approve', 'App\Http\Controllers\Admin\QuestionController@approve_question');
Route::post('/admin/question/disapprove', 'App\Http\Controllers\Admin\QuestionController@disapprove_question');
Route::post('/admin/question/delete', 'App\Http\Controllers\Admin\QuestionController@delete_question');
Route::post('/admin/answer/approve', 'App\Http\Controllers\Admin\QuestionController@approve_answer');
Route::post('/admin/answer/disapprove', 'App\Http\Controllers\Admin\QuestionController@disapprove_answer');
Route::post('/admin/answer/delete', 'App\Http\Controllers\Admin\QuestionController@delete_answer');

Route::get('/admin/afterschool/search', 'App\Http\Controllers\Admin\AfterschoolController@search');
Route::post('/admin/afterschool/search', 'App\Http\Controllers\Admin\AfterschoolController@search');
Route::get('/admin/activity/search', 'App\Http\Controllers\Admin\ActivityController@search');
Route::post('/admin/activity/search', 'App\Http\Controllers\Admin\ActivityController@search');
Route::get('/admin/afterschool/edit', 'App\Http\Controllers\Admin\AfterschoolController@edit');
Route::post('/admin/afterschool/edit', 'App\Http\Controllers\Admin\AfterschoolController@edit');
Route::get('/admin/activity/edit', 'App\Http\Controllers\Admin\ActivityController@edit');
Route::post('/admin/activity/edit', 'App\Http\Controllers\Admin\ActivityController@edit');