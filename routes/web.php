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


Auth::routes();

Route::get('/', 'TicketController@index')->name('home');

Route::get('/tickets', 'TicketController@index')->name('tickets');

Route::get('/ticket/{id}', 'TicketController@show')->name('ticket');

Route::get('/createTicket', 'TicketController@create')->name('createTicket');

Route::get('/closeTicket/{id}', 'TicketController@closeTicket')->name('closeTicket');

Route::post('/storeMsg/{id}', 'TicketController@saveMsg' )->name('storeMsg');

Route::post('/storeTicket', 'TicketController@store' )->name('storeTicket');


