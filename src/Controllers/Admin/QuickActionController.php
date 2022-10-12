<?php

namespace Ophim\Core\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Prologue\Alerts\Facades\Alert;

class QuickActionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_cache()
    {
        Artisan::call('optimize:clear');
        Alert::success("Xóa cache thành công")->flash();
        return back();
    }
}
