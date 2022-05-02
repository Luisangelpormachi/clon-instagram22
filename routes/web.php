<?php
/*
use App\Image;
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    /*
    $images = Image::all();

    foreach ($images as $image) {
        echo $image->image_path."<br>";
        echo $image->description."<br>";
        echo $image->user->name." ".$image->user->surname."<br>";

        echo "<br>".count($image->likes)." Likes";
        echo "<br>Comentarios:<br><br>";
        foreach ($image->comments as $item){
            echo " ".$item->user->nick.": ".$item->content."<br>";
        }

        echo "<hr>";
    }
    
    die();
    */
    return view('welcome');
});

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/config', 'UserController@config')->name('user.config');
Route::post('/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/upload-image', 'ImageController@create')->name('upload.image');
Route::post('/image-save', 'ImageController@save')->name('image.save');
Route::get('/image-file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image-detail/{id}', 'ImageController@detail')->name('image.detail');
Route::post('/comment-image-save', 'CommentController@save')->name('comment.image.save');
Route::get('/comment-image-delete/{id}', 'CommentController@delete')->name('comment.image.delete');
Route::get('/like/{image_id}', 'LikeController@save')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@delete')->name('like.delete');
Route::get('/like-favorites', 'LikeController@index')->name('like.index');

