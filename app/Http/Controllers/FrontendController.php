<?php

namespace App\Http\Controllers;

use App\Models\Hero;

use App\Models\Creativity;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $heros=Hero::all();
        $creatives=Creativity::all();

        return view('welcome',compact('heros','creatives'));
    }
}
