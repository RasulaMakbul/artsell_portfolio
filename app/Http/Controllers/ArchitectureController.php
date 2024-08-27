<?php

namespace App\Http\Controllers;

use App\Models\Architecture;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;

class ArchitectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $architectures=Architecture::all();
        return view('admin.architecture.index',compact('architectures'));
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
                'title' => 'nullable|max:255|unique:architectures,title',
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

            Architecture::create($requestData);
            return redirect()->back()->with('success_message', $request->title . ' Architecture created Successfully!');
        } else {
                return redirect()->back()->with('message', $request->title . ' Image Missing!');

            }
    }

    /**
     * Display the specified resource.
     */
    public function show(Architecture $architecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Architecture $architecture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Architecture $architecture)
    {
        $request->validate([
                'title' => 'nullable|max:255|unique:architectures,title',
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
                if($architecture->image){
                    $relativePath = str_replace('storage/', '', $architecture->image);

                    $imagePath = 'public/' . $relativePath;


                    if (Storage::exists($imagePath)) {
                        Storage::delete($imagePath);
                    }
                }
                $fileName = $this->uploadImage($request->File('image'),$request->title);
                $requestData['image']=$fileName;


            }
        $architecture->update($requestData);
        return redirect()->back()->with('success_message', $request->title . ' Architecture Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Architecture $architecture)
    {
        if ($architecture->image) {
            $relativePath = str_replace('storage/', '', $architecture->image);

            $imagePath = 'public/' . $relativePath;

            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }
        $architecture->delete();

        return redirect()->back()->with('success', 'Architecture and associated image deleted successfully!');
    }

    public function uploadImage($image,$title)
    {
        $manager = new ImageManager(new Driver());


        $fileName = $title.date('Y-m-d') . time() . '.' . $image->getClientOriginalExtension();


        $savePath = storage_path('app/public/architectureImg/' . $fileName);

        $img=$manager->read($image);
        $img->resize(800, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($savePath, 80);


        $save_url = 'storage/architectureImg/' . $fileName;
        return $save_url;
    }
    public function active($id)
    {
        $architecture = Architecture::find($id);
        $architecture->status = 1;
        $architecture->update();
        return back();
    }
    public function inactive($id)
    {
        $architecture = Architecture::find($id);
        $architecture->status = 0;
        $architecture->update();
        return back();
    }
}
