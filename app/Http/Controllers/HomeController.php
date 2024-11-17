<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
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
        if (in_array(auth()->user()->type, ['Administrator', 'Staff'])) {
            return redirect('/admin');
        }

        if (auth()->user()->type === 'Patient') {
            return redirect('/patient'); // Redirect patients to a separate page
        }
        return view('home');
    }
}
