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
    return view('welcome');
});

Auth::routes();

//USERS
Route::get('/users', 'UsersController@index');
Route::post('/users/{user}','UsersController@update');
Route::get('/users/{user}', 'UsersController@show');
Route::get('/users/{user}/show', 'UsersController@showfull');
Route::get('/users/{user}/edit', 'UsersController@edit');
Route::delete('/users/{user}/avatar', 'UsersController@destroy_avatar');



//CONVERSATIONS
Route::resource('/conversations', 'ConversationsController');
	Route::post('/conversations/{conversation}/message', 'ConversationMessagesController@store');
	Route::get('/conversations/{conversation}/getmessage', 'ConversationMessagesController@get');
	Route::delete('/conversations/{message}/destroy', 'ConversationMessagesController@destroy');
	
	Route::delete('/conversations/{conversation}/participant','ConversationsParticipantsController@destroy');
	Route::post('/conversations/{conversation}/participant','ConversationsParticipantsController@store');
	Route::post('/conversations/edit/search','ConversationsController@edit_search');
	Route::post('/conversations/create/search','ConversationsController@create_search');

	Route::get('/conversations/{user}/create','ConversationsController@messageUser');

Route::get('/favorites', 'FavoritesController@index');
Route::post('/favorites', 'FavoritesController@store');
Route::delete('/favorites/{favorite}', 'FavoritesController@destroy');


Route::get('/lists', 'ListsController@index');
Route::get('/lists/create', 'ListsController@create');
Route::get('/lists/{list}', 'ListsController@show');
Route::post('/lists', 'ListsController@store');
Route::delete('/lists/{list}', 'ListsController@destroy');
	Route::delete('/lists/{list}/items', 'ListItemsController@destroy');
	Route::post('/lists/{list}/items', 'ListItemsController@store');



Route::get('/friends', 'FriendsController@index');
Route::post('/friends', 'FriendsController@store');
Route::get('/friends/{friend}', 'FriendsController@show');
Route::delete('/friends/{friend}', 'FriendsController@destroy');
Route::patch('/friends/{friend}','FriendsController@update');






Route::get('/faq', 'FAQController@index');

Route::get('/documentation', 'DocumentationController@index');

Route::get('/about_contact', 'AboutContactController@index');


Route::resource('/forum', 'ForumController');
	Route::post('/forum/{thread}/replies','ForumRepliesController@store');
	Route::delete('/forum/{thread}/replies','ForumRepliesController@destroy');
	Route::get('/forum/{thread}/getreply', 'ForumRepliesController@get');
	Route::post('/forum/search','ForumController@search');

Route::resource('/offers', 'OffersController');
Route::post('/offers/search', 'OffersController@search');
	Route::post('/offers/{offer}/reviews','OfferReviewsController@store');
	Route::delete('/offers/{offer}/reviews','OfferReviewsController@destroy');

Route::resource('/orders', 'OrdersController');
	Route::post('/orders/search', 'OrdersController@search');
	Route::get('/orders/{offer}/create','OrdersController@create');
	Route::post('/orders/cart', 'OrdersController@store_cart');



Route::get('/home', 'HomeController@index')->name('home');

//consumer chart
Route::get('/home/names', 'HomeController@chart_names');
Route::get('/home/counts', 'HomeController@chart_counts');

//business charts
Route::get('/home/customers', 'HomeController@chart_customers');
Route::get('/home/orders', 'HomeController@chart_orders');

Route::get('/home/offers', 'HomeController@chart_offers');
Route::get('/home/qtys', 'HomeController@chart_offers_qtys');

Route::get('/home/months', 'HomeController@chart_months');
Route::get('/home/months_orders', 'HomeController@chart_months_orders');


// Route::resource('/users', 'UsersController');
// //Route::post('/users', 'UsersController@show');

Route::get('/requests', 'RequestsController@index'); 
Route::get('/requests/{request}', 'RequestsController@show');
Route::get('/requests/{request}/edit', 'RequestsController@edit');
Route::patch('/requests/{request}','RequestsController@update');
Route::post('/requests/search', 'RequestsController@search');

Route::post('/session/cart', 'SessionController@set_cart');
Route::delete('/session/cart', 'SessionController@remove_cart');
Route::get('/session/cart', 'SessionController@clear_cart');

Route::post('/session/compare', 'SessionController@set_compare');
Route::delete('/session/compare', 'SessionController@remove_compare');
Route::get('/session/compare', 'SessionController@clear_compare');