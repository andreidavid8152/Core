<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('home.index');
    }

    public function recomendaciones(){
        return view('home.recomendaciones');
    }

    public function favoritos(){
        return view('home.favoritos');
    }

}
