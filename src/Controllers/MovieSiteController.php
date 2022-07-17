<?php

namespace Ophim\Core\Controllers;

use Backpack\Settings\app\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
            })->where(function ($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                    ->orWhere('origin_name', 'like', '%' . request('search')  . '%');
            })->paginate();

            return $theme->render('catalog', [
                'data' => $data,
                'search' => $request['search'],
            ]);
        }

        return Cache::remember('index', 1, function () use ($theme) {
            $lists = explode('|', Setting::get('index_latest_update_lists'));

            $data = [];
            foreach ($lists as $list) {
                if (trim($list)) {
                    [$label, $relation, $field, $val, $limit, $link] = explode(':', $list);
                    try {
                        $data[] = [
                            'label' => $label,
                            'data' => Movie::when($relation, function ($query) use ($relation, $field, $val) {
                                $query->whereHas($relation, function ($rel) use ($field, $val) {
                                    $rel->where($field, $val);
                                });
                            })->when(!$relation, function ($query) use ($field, $val) {
                                $query->where($field, $val);
                            })->limit($limit)->orderBy('updated_at', 'desc')->get(),
                            'link' => $link ?: '#'
                        ];
                    } catch (\Throwable $th) {
                    }
                }
            }

            return $theme->render('index', [
                'data' => $data
            ])->render();
        });
    }

    public function getMovieOverview(Request $request, Theme $theme, $movie)
    {
        $movie = Movie::fromCache()->find($movie);

        return $theme->render('single', [
            'movie' => $movie
        ]);
    }

    public function getEpisode(Request $request, Theme $theme, $movie, $slug)
    {
        $movie = Movie::fromCache()->find($movie)->load('episodes');

        $episode = $movie->episodes->when(request('id'), function ($collection) {
            return $collection->where('id', request('id'));
        })->firstWhere('slug', $slug);

        // $episodes = $movie->episodes->sortBy('name', SORT_NATURAL);

        return $theme->render('episode', [
            'movie' => $movie,
            'episode' => $episode
        ]);
    }

    public function getMovieOfCategory(Request $request, Theme $theme, $slug)
    {
        $category = Category::fromCache()->find($slug);

        if (is_null($category)) abort(404);

        $movies = $category->movies()->paginate(20);

        return $theme->render('catalog', [
            'data' => $movies,
            'category' => $category
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
