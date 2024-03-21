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

use Illuminate\Support\Facades\File;

Route::get('/', function () {
    return File::get(public_path('pages/home.html'));
})->name('home');

Route::get('/servicos', function () {
    return File::get(public_path('pages/servicos.html'));
})->name('servicos');

Route::get('/sobre', function () {
    return File::get(public_path('pages/sobre-nos.html'));
})->name('sobre');

Route::get('/contato', function () {
    return File::get(public_path('pages/contato.html'));
})->name('contato');

Route::get('/desentupidora-hauer', function () {
    return File::get(public_path('pages/desentupidora-hauer.html'));
})->name('desentupidora-hauer');

Route::get('/desentupidora-boqueirao', function () {
    return File::get(public_path('pages/desentupidora-boqueirao.html'));
})->name('desentupidora-boqueirao');

Route::get('/desentupidora-vista-alegre', function () {
    return File::get(public_path('pages/desentupidora-vista-alegre.html'));
})->name('desentupidora-vista-alegre');

Route::get('/desentupidora-guabirotuba', function () {
    return File::get(public_path('pages/desentupidora-guabirotuba.html'));
})->name('desentupidora-guabirotuba');

Route::get('/desentupidora-jardim-botanico', function () {
    return File::get(public_path('pages/desentupidora-jardim-botanico.html'));
})->name('desentupidora-jardim-botanico');

Route::get('/desentupidora-taruma', function () {
    return File::get(public_path('pages/desentupidora-taruma.html'));
})->name('desentupidora-taruma');

Route::get('/desentupidora-bairro-alto', function () {
    return File::get(public_path('pages/desentupidora-bairro-alto.html'));
})->name('desentupidora-bairro-alto');

Route::get('/desentupidora-alto-da-xv', function () {
    return File::get(public_path('pages/desentupidora-alto-da-xv.html'));
})->name('desentupidora-alto-da-xv');

Route::get('/desentupidora-cristo-rei', function () {
    return File::get(public_path('pages/desentupidora-cristo-rei.html'));
})->name('desentupidora-cristo-rei');

Route::get('/desentupidora-hugo-lange', function () {
    return File::get(public_path('pages/desentupidora-hugo-lange.html'));
})->name('desentupidora-hugo-lange');

Route::get('/desentupidora-jardim-social', function () {
    return File::get(public_path('pages/desentupidora-jardim-social.html'));
})->name('desentupidora-jardim-social');

Route::get('/desentupidora-santa-candida', function () {
    return File::get(public_path('pages/desentupidora-santa-candida.html'));
})->name('desentupidora-santa-candida');

Route::get('/desentupidora-boa-vista', function () {
    return File::get(public_path('pages/desentupidora-boa-vista.html'));
})->name('desentupidora-boa-vista');

Route::get('/desentupidora-agua-verde', function () {
    return File::get(public_path('pages/desentupidora-agua-verde.html'));
})->name('desentupidora-agua-verde');

Route::get('/desentupidora-xaxim', function () {
    return File::get(public_path('pages/desentupidora-xaxim.html'));
})->name('desentupidora-xaxim');

Route::get('/desentupidora-prado-velho', function () {
    return File::get(public_path('pages/desentupidora-prado-velho.html'));
})->name('desentupidora-prado-velho');

Route::get('/desentupidora-reboucas', function () {
    return File::get(public_path('pages/desentupidora-reboucas.html'));
})->name('desentupidora-reboucas');

Route::get('/desentupidora-sao-jose-dos-pinhais-cidade-jardim', function () {
    return File::get(public_path('pages/desentupidora-sao-jose-dos-pinhais-cidade-jardim.html'));
})->name('desentupidora-sao-jose-dos-pinhais-cidade-jardim');

Route::get('/desentupidora-alto-da-gloria', function () {
    return File::get(public_path('pages/desentupidora-alto-da-gloria.html'));
})->name('desentupidora-alto-da-gloria');

Route::get('/desentupidora-centro-civico', function () {
    return File::get(public_path('pages/desentupidora-centro-civico.html'));
})->name('desentupidora-centro-civico');

Route::get('/desentupidora-tingui', function () {
    return File::get(public_path('pages/desentupidora-tingui.html'));
})->name('desentupidora-tingui');

Route::get('/desentupidora-cabral', function () {
    return File::get(public_path('pages/desentupidora-cabral.html'));
})->name('desentupidora-cabral');

Route::get('/desentupidora-juveve', function () {
    return File::get(public_path('pages/desentupidora-juveve.html'));
})->name('desentupidora-juveve');

Route::get('/desentupidora-uberaba', function () {
    return File::get(public_path('pages/desentupidora-uberaba.html'));
})->name('desentupidora-uberaba');

Route::get('/desentupidora-ahu', function () {
    return File::get(public_path('pages/desentupidora-ahu.html'));
})->name('desentupidora-ahu');

Route::get('/desentupidora-atuba', function () {
    return File::get(public_path('pages/desentupidora-atuba.html'));
})->name('desentupidora-atuba');

Route::get('/desentupidora-centenario', function () {
    return File::get(public_path('pages/desentupidora-centenario.html'));
})->name('desentupidora-centenario');

Route::get('/desentupidora-capao-da-imbuia', function () {
    return File::get(public_path('pages/desentupidora-capao-da-imbuia.html'));
})->name('desentupidora-capao-da-imbuia');

Route::get('/desentupidora-barreirinha', function () {
    return File::get(public_path('pages/desentupidora-barreirinha.html'));
})->name('desentupidora-barreirinha');

Route::get('/desentupidora-abranches', function () {
    return File::get(public_path('pages/desentupidora-abranches.html'));
})->name('desentupidora-abranches');

Route::get('/desentupidora-parolin', function () {
    return File::get(public_path('pages/desentupidora-parolin.html'));
})->name('desentupidora-parolin');

Route::get('/desentupidora-guaira', function () {
    return File::get(public_path('pages/desentupidora-guaira.html'));
})->name('desentupidora-guaira');

Route::get('/desentupidora-portao', function () {
    return File::get(public_path('pages/desentupidora-portao.html'));
})->name('desentupidora-portao');

Route::get('/desentupidora-pinhais-weissopolis', function () {
    return File::get(public_path('pages/desentupidora-pinhais-weissopolis.html'));
})->name('desentupidora-pinhais-weissopolis');

Route::get('/desentupidora-pinhais-alto-taruma', function () {
    return File::get(public_path('pages/desentupidora-pinhais-alto-taruma.html'));
})->name('desentupidora-pinhais-alto-taruma');


/////

Route::redirect('/login', '/admin/login')
    ->name('login');

Route::redirect('/register', '/admin/register')
    ->name('register');