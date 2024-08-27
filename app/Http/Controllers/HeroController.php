<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;



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
            if ($request->file('image')) {
                $fileName = $this->uploadImage($request->File('image'),$request->title);
                $requestData = [
                'title' => $request->title,
                'image' => $fileName,
                'description' => $request->description,
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
            ];

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
        $request->validate([
                'title' => 'required|min:2|max:255|unique:heroes,title',
                'image' => 'nullable|mimes:png,jpg,jpeg',
                'description' => 'nullable',
                'status' => 'nullable',
                'meta_title' => 'required',
                'meta_keyword' => 'required|min:2|max:255',
                'meta_description' => 'required|min:2|max:255',
            ]);
            $requestData = [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status == true ? '1' : '0',
                'meta_title' => $request->meta_title,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description,
            ];
            if ($request->file('image')) {
                if($hero->image){
                    $relativePath = str_replace('storage/', '', $hero->image);

                    $imagePath = 'public/' . $relativePath;
                    var_dump($imagePath);

                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                }
                $fileName = $this->uploadImage($request->File('image'),$request->title);
                $requestData['image']=$fileName;


            }
        $hero->update($requestData);
        return redirect()->back()->with('success_message', $request->title . ' Hero created Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
{
    $hero = Hero::findOrFail($id);

    if ($hero->image) {
        $relativePath = str_replace('storage/', '', $hero->image);

        $imagePath = 'public/' . $relativePath;
        var_dump($imagePath);

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
    $hero->delete();

    return redirect()->route('hero.index')->with('success', 'Hero and associated image deleted successfully!');
}


    public function uploadImage($image,$title)
    {
        $manager = new ImageManager(new Driver());


        $fileName = $title.date('Y-m-d') . time() . '.' . $image->getClientOriginalExtension();


        $savePath = storage_path('app/public/heroImg/' . $fileName);

        $img=$manager->read($image);
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($savePath, 80);


        $save_url = 'storage/heroImg/' . $fileName;
        return $save_url;
    }
    public function active($id)
    {
        $hero = Hero::find($id);
        $hero->status = 1;
        $hero->update();
        return back();
    }
    public function inactive($id)
    {
        $hero = Hero::find($id);
        $hero->status = 0;
        $hero->update();
        return back();
    }





}
