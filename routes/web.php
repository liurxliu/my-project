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

Route::get('/', 'HomeController@index')->name('home');

// About questions
Route::get('/questions', 'QuestionController@index')->name('question');
Route::post('/questions', 'QuestionController@store');


Route::get('/questions/{question}', 'QuestionController@show');
Route::patch('/questions/{question}', 'QuestionController@update')->name('question.update');
Route::delete('/questions/{question}', 'QuestionController@destroy');
Route::post('/questions/{question}/answer', 'AnswerController@store');
Route::patch('/answers/{answer}', 'AnswerController@update');
Route::delete('/answers/{answer}', 'AnswerController@destroy');

// Like answer
Route::post('/answers/{answer}/likes', 'LikeController@store');
Route::delete('/answers/{answer}/likes', 'LikeController@destroy');

// subscribe question
Route::post('/questions/{question}/subscribe', 'QuestionSubscribeController@store')->middleware('auth');
Route::delete('/questions/{question}/subscribe', 'QuestionSubscribeController@destroy')->middleware('auth');

// notification
Route::get('/profile/{user}/notifications', 'UserNotificationController@index')->middleware('auth');

Route::delete('/profile/{user}/notifications/{notification}', 'UserNotificationController@destroy')->middleware('auth');

// Profile

Route::get('/profile/{user}', 'ProfileController@show');

Route::post('/api/users/{user}/avatar', 'Api\UploadAvatarController@store')->middleware('auth');

Auth::routes();

// about topic
Route::get('/topics', 'TopicController@index');
Route::get('/topics/{topic}', 'TopicController@show');
Route::post('/questions/{question}/topics', 'TopicController@store');
Route::delete('/questions/{question}/topics/{topic}', 'TopicController@destroy');

Route::post('/{user}/topics', 'UserTopicController@store');
Route::delete('/{user}/topics/{topic}', 'UserTopicController@destroy');


// search
Route::get('/search', 'SearchController@show');

// social login

Route::get('login/{service}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{service}/callback', 'Auth\LoginController@handleProviderCallback');



