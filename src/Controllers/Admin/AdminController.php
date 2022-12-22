<?php

namespace Ophim\Core\Controllers\Admin;

use Illuminate\Routing\Controller;
use Ophim\Core\Models\Movie;
use Ophim\Core\Models\Episode;
use Ophim\Core\Models\Theme;
use Ophim\Core\Models\User;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(backpack_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('backpack::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('backpack::crud.admin')     => backpack_url('dashboard'),
            trans('backpack::base.dashboard') => false,
        ];
        $this->data['count_movies'] = Movie::count();
        $this->data['count_episodes'] = Episode::count();
        $this->data['count_episodes_error'] = Episode::where('has_report', true)->count();
        $this->data['count_themes'] = Theme::count();
        $this->data['count_users'] = User::count();
        $this->data['top_view_day'] = Movie::orderBy('view_day', 'desc')->limit(15)->get();
        $this->data['top_view_week'] = Movie::orderBy('view_week', 'desc')->limit(15)->get();
        $this->data['top_view_month'] = Movie::orderBy('view_month', 'desc')->limit(15)->get();
        return view(backpack_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(backpack_url('dashboard'));
    }
}
