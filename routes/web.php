
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
    return view('home');
})->name('home');

Route::get('/create_email', 'EmailController@createEmail')->name('create_email');
Route::post('/submit_email', 'EmailController@submitEmail')->name('submit_email');
Route::get('/list_emails', 'EmailController@listEmails')->name('list_emails');
Route::get('/get_emails', 'EmailController@getEmails')->name('get_emails');
Route::get('/show_email/{id}', 'EmailController@showEmail')->name('show_email');
Route::get('/download_attachment/{id}', 'EmailController@downloadAttachment')->name('download_attachment');
Route::get('/process_email_queue', 'EmailController@processEmailQueue')->name('process_email_queue');