<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Auth\RedirectToClient;

class HomeController extends Controller
{
    use RedirectToClient;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return App::isLocal() ? view('home') : redirect($this->redirectTo());
    }
}
