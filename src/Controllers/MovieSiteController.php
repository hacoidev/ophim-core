<?php

namespace Ophim\Core\Controllers;

use Illuminate\Http\Request;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
use Ophim\Core\Theme;

class MovieSiteController
{
    public function index(Request $request, Theme $theme)
    {
        if ($request['search']) {
            $data = Movie::where('name', 'like', '%' . $request('search') . '%')->paginate();
            return $theme->render('catalog', [
                'data' => $data,
                'pageName' => 'Search'
            ]);
        }

        return $theme->render('index');
    }

    public function getMovieOverview(Request $request, Theme $theme, $movie)
    {
        $movie = Movie::fromCache()->find($movie);

        return $theme->render('single', [
            'movie' => $movie
        ]);
    }

    public function getEpisode(Request $request, Theme $theme, $movie, $episode)
    {
        $movie = Movie::fromCache()->find($movie);

        return $theme->render('single', [
            'movie' => $movie,
            'episode' => $episode
        ]);
    }

    public function getMovieOfCategory(Request $request, Theme $theme, $slug)
    {
        $category = Category::fromCache()->find($slug);

        if (is_null($category)) abort(404);

        $movies = Movie::whereHas('categories', function ($categories) use ($category) {
            $categories->where('id', $category->id);
        });

        return $theme->render('catalog', [
            'movies' => $movies
        ]);
    }

    public function getMovieOfRegion(Request $request, Theme $theme, $slug)
    {
        $region = Region::fromCache()->find($slug);

        if (is_null($region)) abort(404);

        $movies = Movie::whereHas('regions', function ($regions) use ($region) {
            $regions->where('id', $region->id);
        });

        return $theme->render('catalog', [
            'movies' => $movies
        ]);
    }
}
