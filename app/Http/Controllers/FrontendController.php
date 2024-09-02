<?php

namespace App\Http\Controllers;

use App\Models\Hero;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $heros=Hero::all();

        return view('welcome',compact('heros'));
    }
}
