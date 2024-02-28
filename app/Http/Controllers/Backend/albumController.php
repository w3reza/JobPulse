<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;

class albumController extends Controller
{
    // Create page  Of Album
    public function create()
    {
        return view('backend.pages.gallery.album.create');
    }

    // Store Operation Of Album
    public function store(Request $request)
    {
        //  $this->validate($request, [
        //             'name' => 'required|max:255',
        //             'desctiption' => 'nullable|max:255',
        //             'cover_photo' => 'required | mimes:jpg,jpeg,png | max:1000',
        //         ]   );

        // Custom Messages
        $rules = [
            'name' => 'required|max:255',
            'desctiption' => 'nullable|max:255',
            'cover_photo' => 'required | mimes:jpg,jpeg,png | max:1000',
        ];
        $message = [
            'name.required' => 'Album  name is required',
        ];
        $request->validate($rules, $message);

        // Upload Image
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $ext = strtolower($file->getClientOriginalExtension());
            $file_name = 'album_cover_' . md5(uniqid()) . time() . '.' . $ext;
            $file->move(public_path('assets/uploads/albums/'), $file_name);
        }

        //  dd($request->all());

        // Store Data
        Album::create([
            'name' => $request->name,
            'desctiption' => $request->content_details,
            'cover_photo' => 'assets/uploads/albums/' . $file_name,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Album Created Successfully');
    }

    // SHow Album Page
    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->get();
        return view('backend.pages.gallery.album.index', compact('albums'));
    }

    // Edit Operation Album
    public function edit($id)
    {
        $album = Album::findOrFail($id);

        return view('backend.pages.gallery.album.edit', compact('album'));
    }

    // Update Operation Album
    public function update(Request $request, $id)
    {
        // Custom Messages

         //dd($request->all());


        $rules = [
            'name' => 'required|max:255',
            'desctiption' => 'nullable|max:255',
            'cover_photo' => 'nullable | mimes:jpg,jpeg,png | max:1000',
        ];
        $message = [
            'name.required' => 'Album  name is required',
        ];
        $request->validate($rules, $message);

        // Retrieve the album for updating
        $album = Album::findOrFail($id);

        // Check if a new image is provided
        if ($request->hasFile('cover_photo')) {
            // Delete the existing image file
            if ($album->cover_photo) {
                $imagePath = public_path($album->cover_photo);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Upload Image

            $file = $request->file('cover_photo');
            $ext = strtolower($file->getClientOriginalExtension());
            $file_name = 'album_cover_' . md5(uniqid()) . time() . '.' . $ext;
            $file->move(public_path('assets/uploads/albums/'), $file_name);
        }



        // Store Data
        Album::where('id', $request->id)->update([
            'name' => $request->name,
            'desctiption' => $request->content_details,

            'cover_photo' => $request->hasFile('cover_photo') ?  'assets/uploads/albums/' . $file_name : $album->cover_photo,
        ]);
        return redirect()
            ->route('album.show')
            ->with('success', 'Album Updated Successfully');
    }

    // Delete Operation Album
    public function destroy($id)
    {
        $album = Album::findOrFail($id);

        // Delete the existing image file
        if ($album->cover_photo) {
            $imagePath = public_path($album->cover_photo);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $album->delete();

        return redirect()
            ->route('album.show')
            ->with('success', 'Album Deleted Successfully');
    }
}
