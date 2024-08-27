<?php

namespace App\Http\Controllers;

use App\Models\Fashion;
use Illuminate\Http\Request;


use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;


class FashionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fashions=Fashion::all();
        return view('admin.fashion.index',compact('fashions'));
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
                'title' => 'nullable|min:2|max:255|unique:fashions,title',
                'image' => 'required|mimes:png,jpg,jpeg',
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

            Fashion::create($requestData);
            return redirect()->back()->with('success_message', $request->title . ' Fashion created Successfully!');
        } else {
                return redirect()->back()->with('message', $request->title . ' Image Missing!');

            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Fashion $fashion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fashion $fashion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fashion $fashion)
    {
        $request->validate([
                'title' => 'nullable|min:2|max:255|unique:fashions,title',
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
                if($fashion->image){
                    $relativePath = str_replace('storage/', '', $fashion->image);

                    $imagePath = 'public/' . $relativePath;


                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                }
                $fileName = $this->uploadImage($request->File('image'),$request->title);
                $requestData['image']=$fileName;


            }
        $fashion->update($requestData);
        return redirect()->back()->with('success_message', $request->title . ' Fashion Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fashion $fashion)
    {

        if ($fashion->image) {
            $relativePath = str_replace('storage/', '', $fashion->image);

            $imagePath = 'public/' . $relativePath;
            var_dump($imagePath);

            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }
        $fashion->delete();

        return redirect()->route('fashion.index')->with('success', 'Fashion and associated image deleted successfully!');
    }

    public function uploadImage($image,$title)
    {
        $manager = new ImageManager(new Driver());


        $fileName = $title.date('Y-m-d') . time() . '.' . $image->getClientOriginalExtension();


        $savePath = storage_path('app/public/fashionImg/' . $fileName);

        $img=$manager->read($image);
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($savePath, 80);


        $save_url = 'storage/fashionImg/' . $fileName;
        return $save_url;
    }
    public function active($id)
    {
        $fashion = Fashion::find($id);
        $fashion->status = 1;
        $fashion->update();
        return back();
    }
    public function inactive($id)
    {
        $fashion = Fashion::find($id);
        $fashion->status = 0;
        $fashion->update();
        return back();
    }
}
