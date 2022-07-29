<?php

namespace Ophim\Core\Controllers;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Http\Request;
use Ophim\Core\Models\Actor;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Director;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Region;
use Ophim\Core\Models\Tag;
use Ophim\Core\Theme;

class MovieSiteController
{
    public function index(Request $request, Theme $theme)
    {
        if ($request['search'] || $request['filter']) {
            $data = Movie::when(!empty($request['filter']['category']), function ($movie) {
                $movie->whereHas('categories', function ($categories) {
                    $categories->where('id', request('filter')['category']);
                });
            })->when(!empty($request['filter']['region']), function ($movie) {
                $movie->whereHas('regions', function ($regions) {
                    $regions->where('id', request('filter')['region']);
                });
            })->when(!empty($request['filter']['year']), function ($movie) {
                $movie->where('publish_year', request('filter')['year']);
            })->when(!empty($request['filter']['type']), function ($movie) {
                $movie->where('type', request('filter')['type']);
            })->when(!empty($request['search']), function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . request('search') . '%')
                        ->orWhere('origin_name', 'like', '%' . request('search')  . '%');
                });
            })->when(!empty($request['filter']['sort']), function ($movie) {
                if (request('filter')['sort'] == 'create') {
                    return $movie->orderBy('created_at', 'desc');
                }
                if (request('filter')['sort'] == 'update') {
                    return $movie->orderBy('updated_at', 'desc');
                }
                if (request('filter')['sort'] == 'year') {
                    return $movie->orderBy('publish_year', 'desc');
                }
                if (request('filter')['sort'] == 'view') {
                    return $movie->orderBy('view_total', 'desc');
                }
            })->paginate();

            return $theme->render('catalog', [
                'data' => $data,
                'search' => $request['search'],
            ]);
        }
        return $theme->render('index', [
            'title' => Setting::get('site.homepage.title')
        ])->render();
    }

    public function getMovieOverview(Request $request, Theme $theme, $movie)
    {
        $movie = Movie::fromCache()->find($movie);

        if (is_null($movie)) abort(404);

        return $theme->render('single', [
            'movie' => $movie,
            'title' => $movie->getTitle()
        ]);
    }

    public function getEpisode(Request $request, Theme $theme, $movie, $slug)
    {
        $movie = Movie::fromCache()->find($movie)->load('episodes');

        if (is_null($movie)) abort(404);

        $episode = $movie->episodes->when(request('id'), function ($collection) {
            return $collection->where('id', request('id'));
        })->firstWhere('slug', $slug);

        if (is_null($episode)) abort(404);

        $movie->increment('view_total', 1);
        $movie->increment('view_day', 1);
        $movie->increment('view_week', 1);
        $movie->increment('view_month', 1);

        return $theme->render('episode', [
            'movie' => $movie,
            'episode' => $episode,
            'title' => $episode->getTitle()
        ]);
    }

    public function reportEpisode(Request $request, Theme $theme, $movie, $slug)
    {
        $movie = Movie::fromCache()->find($movie)->load('episodes');

        $episode = $movie->episodes->when(request('id'), function ($collection) {
            return $collection->where('id', request('id'));
        })->firstWhere('slug', $slug);

        $episode->update([
            'report_message' => request('message', ''),
            'has_report' => true
        ]);

        return response([], 204);
    }

    public function rateMovie(Request $request, Theme $theme, $movie, $slug)
    {
        $movie = Movie::fromCache()->find($movie)->load('episodes');

        $movie->refresh()->increment('rating_count', 1, [
            'rating_star' => $movie->rating_star +  ((int) request('rating') - $movie->rating_star) / ($movie->rating_count + 1)
        ]);

        return response([], 204);
    }

    public function getMovieOfCategory(Request $request, Theme $theme, $slug)
    {
        $category = Category::fromCache()->find($slug);

        if (is_null($category)) abort(404);

        $movies = $category->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'category' => $category,
        ]);
    }

    public function getMovieOfRegion(Request $request, Theme $theme, $slug)
    {
        $region = Region::fromCache()->find($slug);

        if (is_null($region)) abort(404);

        $movies = $region->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'region' => $region
        ]);
    }

    public function getMovieOfActor(Request $request, Theme $theme, $slug)
    {
        $actor = Actor::fromCache()->find($slug);

        if (is_null($actor)) abort(404);

        $movies = $actor->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'person' => $actor
        ]);
    }

    public function getMovieOfDirector(Request $request, Theme $theme, $slug)
    {
        $director = Director::fromCache()->find($slug);

        if (is_null($director)) abort(404);

        $movies = $director->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'person' => $director
        ]);
    }

    public function getMovieOfTag(Request $request, Theme $theme, $slug)
    {
        $tag = Tag::fromCache()->find($slug);

        if (is_null($tag)) abort(404);

        $movies = $tag->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'tag' => $tag
        ]);
    }

    public function getMovieOfType(Request $request, Theme $theme, $slug)
    {
        $type = $slug == 'phim-le' ? 'single' : 'series';

        $movies = Movie::where('type', $type)->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
        ]);
    }
}
