<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapaLojasController extends Controller
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
     * Show the stores map page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('lojas-mapa');
    }
}