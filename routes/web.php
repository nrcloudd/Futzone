<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/contacts', [contactcontroller::class, 'index'])

    // $contacts = getContacts();
    // //return view('/contacts.index');
    // return view ('contacts.index', ['contacts' => $contacts]);})
    ->name('contacts.index');

Route::get('/contacts/create', [contactcontroller::class, 'create'])

    //return "<h1>Add new contact</h1>";}) 
    ->name('contacts.create');

Route::get('/contacts/{id}', [contactcontroller::class, 'show'])

    // $contacts = getContacts();
    // abort_unless(isset($contacts[$id]), 404);
    // $contact = $contacts[$id];
    // return view("contacts.show") -> with('contacts', $contacts);}) 
    ->name('contacts.show');
// function getContacts()
// {
//     return[
//         1 => ['name' => 'Name 1', 'phone' => '1234567890'],
//         2 => ['name' => 'Name 2', 'phone' => '2345678901'],
//         3 => ['name' => 'Name 3', 'phone' => '3456789012']
//     ];
// }
Route::controller(ContactController::class)->name('contacts.')->group(function () { 
 Route::get('/contacts', 'index')->name('index'); 
 Route::get('/contacts/create', 'create')->name('create'); 
 Route::get('/contacts/{id}', 'show')->name('show'); 
});
