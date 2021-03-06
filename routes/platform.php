<?php

declare(strict_types=1);

use App\Orchid\Screens\Examples\ExampleFieldsScreen;
use App\Orchid\Screens\Examples\ExampleLayoutsScreen;
use App\Orchid\Screens\Examples\ExampleScreen;
use App\Orchid\Screens\PlatformScreen;
use App\Orchid\Screens\Role\RoleEditScreen;
use App\Orchid\Screens\Role\RoleListScreen;
use App\Orchid\Screens\User\UserEditScreen;
use App\Orchid\Screens\User\UserListScreen;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\EmailSenderScreen;
use App\Orchid\Screens\Idea;
use App\Orchid\Screens\PostEditScreen;
use App\Orchid\Screens\PostListScreen;
use App\Orchid\Screens\VideoEditScreen;
use App\Orchid\Screens\VideoListScreen;
use App\Orchid\Screens\VidEditScreen;
use App\Orchid\Screens\VidListScreen;
use App\Orchid\Screens\AssortedEditScreen;
use App\Orchid\Screens\AssortedListScreen;


/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the need "dashboard" middleware group. Now create something great!
|
*/


//$this->router->screen('email', EmailSenderScreen::class)->name('platform.email');

Route::screen('email', EmailSenderScreen::class)->name('platform.email');

// Main
Route::screen('/main', PlatformScreen::class)->name('platform.main');

// Users...
Route::screen('users/{users}/edit', UserEditScreen::class)->name('platform.systems.users.edit');
Route::screen('users', UserListScreen::class)->name('platform.systems.users');

// Roles...
Route::screen('roles/{roles}/edit', RoleEditScreen::class)->name('platform.systems.roles.edit');
Route::screen('roles/create', RoleEditScreen::class)->name('platform.systems.roles.create');
Route::screen('roles', RoleListScreen::class)->name('platform.systems.roles');

// Example...
Route::screen('example', ExampleScreen::class)->name('platform.example');
Route::screen('example-fields', ExampleFieldsScreen::class)->name('platform.example.fields');
Route::screen('example-layouts', ExampleLayoutsScreen::class)->name('platform.example.layouts');
//Route::screen('/dashboard/screen/idea', 'Idea::class','platform.screens.idea');

$this->router->screen('post/{post?}', PostEditScreen::class)
    ->name('platform.post.edit');

$this->router->screen('posts', PostListScreen::class)
    ->name('platform.post.list');

$this->router->screen('video/{video?}', VideoEditScreen::class)
    ->name('platform.video.edit');

$this->router->screen('videos', VideoListScreen::class)
    ->name('platform.video.list');

$this->router->screen('vid/{vid?}', VidEditScreen::class)
    ->name('platform.vid.edit');

$this->router->screen('vids', VidListScreen::class)
    ->name('platform.vid.list');
    
$this->router->screen('assorted/{assorted?}', AssortedEditScreen::class)
    ->name('platform.assorted.edit');

$this->router->screen('assorteds', AssortedListScreen::class)
    ->name('platform.assorted.list');    




