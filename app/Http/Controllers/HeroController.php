<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
// use Intervention\Image\Laravel\Facades\Image;


use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Imagick\Driver;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heros=Hero::all();
        return view('admin.hero.index',compact('heros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
                'title' => 'required|min:2|max:255|unique:heroes,title',
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'description' => 'nullable',
                'status' => 'nullable',
                'meta_title' => 'required',
                'meta_keyword' => 'required|min:2|max:255',
                'meta_description' => 'required|min:2|max:255',
            ]);
            // dd($request->image);
            if ($request->file('image')) {
                $fileName = $this->uploadImage($request->File('image'), $request->title);
                $requestData = [
                'title' => $request->title,
                'image' => $fileName,
                'description' => $request->description,
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
            ];

            // dd($requestData);
            Hero::create($requestData);
            return redirect()->back()->with('success_message', $request->title . ' Hero created Successfully!');
        } else {
                return redirect()->back()->with('message', $request->title . ' Image Missing!');

            }

    }

    /**
     * Display the specified resource.
     */
    public function show(Hero $hero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hero $hero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hero $hero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hero $hero)
    {
        //
    }


    public function uploadImage($image, $name)
{
    $fileName = $name . date('Y-m-d') . time() . '.' . $image->getClientOriginalExtension();

    // Create an instance of ImageManager with a specific driver
    $manager = new ImageManager('gd'); // or 'imagick' if you prefer

    // Create an image instance and resize it
    $manager->make($image->getRealPath())
        ->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save(storage_path('app/public/heroImg/' . $fileName));

    return $fileName;
}
}
