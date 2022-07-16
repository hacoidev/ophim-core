<?php

use Illuminate\Support\Facades\Route;
use CKSource\CKFinderBridge\Controller\CKFinderController;
use Ophim\Core\Controllers\MovieSiteController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
    ),
], function () {
    Route::get('/', [MovieSiteController::class, 'index']);
    Route::get(sprintf('/%s', config('ophim.routes.category', 'the-loai')), [MovieSiteController::class, 'category']);
    Route::get(sprintf('/%s/{category}', config('ophim.routes.category', 'the-loai')), [MovieSiteController::class, 'getMovieOfCategory']);
    Route::get(sprintf('/%s/{region}', config('ophim.routes.region', 'khu-vuc')), [MovieSiteController::class, 'getMovieOfRegion']);
    Route::get(sprintf('/%s/{movie}', config('ophim.routes.movie', 'phim')), [MovieSiteController::class, 'getMovieOverview']);
    Route::get(sprintf('/%s/{movie}/{episode}', config('ophim.routes.movie', 'phim')), [MovieSiteController::class, 'getEpisode']);
});
