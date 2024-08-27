<?php

namespace App\Http\Controllers;

use App\Models\Creativity;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class CreativityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creativies=Creativity::all();
        return view('admin.creativity.index',compact('creativies'));
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
                'title' => 'nullable|min:2|max:255|unique:creativities,title',
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

            Creativity::create($requestData);
            return redirect()->back()->with('success_message', $request->title . ' Creative work Section created Successfully!');
        } else {
                return redirect()->back()->with('message', $request->title . ' Image Missing!');

            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Creativity $creativity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Creativity $creativity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Creativity $creativity)
    {
        $request->validate([
                'title' => 'nullable|min:2|max:255|unique:creativities,title',
                'image' => 'required|mimes:png,jpg,jpeg',
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
                if($creativity->image){
                    $relativePath = str_replace('storage/', '', $creativity->image);

                    $imagePath = 'public/' . $relativePath;


                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                }
                $fileName = $this->uploadImage($request->File('image'),$request->title);
                $requestData['image']=$fileName;


            }
        $creativity->update($requestData);
        return redirect()->back()->with('success_message', $request->title . ' Creative Work Edited Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Creativity $creativity)
    {

    if ($creativity->image) {
        $relativePath = str_replace('storage/', '', $creativity->image);

        $imagePath = 'public/' . $relativePath;
        var_dump($imagePath);

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
    $creativity->delete();

    return redirect()->route('creativity.index')->with('success', 'Creative Work and associated image deleted successfully!');
    }

    public function uploadImage($image,$title)
    {
        $manager = new ImageManager(new Driver());


        $fileName = $title.date('Y-m-d') . time() . '.' . $image->getClientOriginalExtension();


        $savePath = storage_path('app/public/creativityImg/' . $fileName);

        $img=$manager->read($image);
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($savePath, 80);


        $save_url = 'storage/creativityImg/' . $fileName;
        return $save_url;
    }
    public function active($id)
    {
        $creativity = Creativity::find($id);
        $creativity->status = 1;
        $creativity->update();
        return back();
    }
    public function inactive($id)
    {
        $creativity = Creativity::find($id);
        $creativity->status = 0;
        $creativity->update();
        return back();
    }
}
