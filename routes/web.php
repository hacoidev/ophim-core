<?php

use Illuminate\Support\Facades\Route;
use CKSource\CKFinderBridge\Controller\CKFinderController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
    'namespace'  => 'Ophim\Core\Controllers',
], function () {
    Route::get('/', 'MovieSiteController', 'index');
    Route::get(sprintf('/%s', config('ophim.routes.category', 'the-loai')), 'MovieSiteController', 'category');
    Route::get(sprintf('/%s/{category}', config('ophim.routes.category', 'the-loai')), 'MovieSiteController', 'getMovieOfCategory');
    Route::get(sprintf('/%s/{region}', config('ophim.routes.region', 'khu-vuc')), 'MovieSiteController', 'getMovieOfRegion');
    Route::get(sprintf('/%s/{movie}', config('ophim.routes.movie', 'phim')), 'MovieSiteController', 'getMovieOverview');
    Route::get(sprintf('/%s/{movie}/{episode}', config('ophim.routes.movie', 'phim')), 'MovieSiteController', 'getEpisode');
});
