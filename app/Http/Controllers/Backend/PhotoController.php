<?php

namespace App\Http\Controllers\Backend;

use App\Models\Album;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Photo;

class PhotoController extends Controller
{
  public function create()
{

    return view('backend.pages.gallery.photo.create');
}

    public function store(Request $request)
    {
        $rules = [
            'photo_name' => 'required|max:255',
            'photo_description' => 'nullable|max:255',
            'photo_path' => 'required | mimes:jpg,jpeg,png | max:1000',
        ];
        $message = [
            'photo_name.required' => 'Photo  name is required',
        ];
        $request->validate($rules, $message);

        // Upload Image
        if ($request->hasFile('photo_path')) {
            $file = $request->file('photo_path');
            $ext = strtolower($file->getClientOriginalExtension());
            $file_name = 'photos_' . md5(uniqid()) . time() . '.' . $ext;
            $file->move(public_path('assets/uploads/photos/'), $file_name);
        }

         // dd($request->all());

        // Store Data
        Photo::create([
            'album_id' => $request->album_id,
            'photo_name' => $request->photo_name,
            'photo_description' => $request->content_details,
            'photo_path' => 'assets/uploads/photos/' . $file_name,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Album Created Successfully');

        return redirect()->back()->with('success', 'Photo Created Successfully');
    }

    public function index($id) {
        $album = Album::findorFail($id);
        return view('backend.pages.gallery.photo.index', compact('album'));
    }

}
