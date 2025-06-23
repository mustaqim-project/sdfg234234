<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use App\Http\Controllers\Controller;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use FileUploadTrait;

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $relativeImagePath = $this->handleFileUpload($request, 'image');

        $relativeImagePath = str_replace('uploads/', '', $relativeImagePath);

        if ($relativeImagePath) {
            $baseUrl = 'https://image.miluv.app/';
            $imagePath = $baseUrl . $relativeImagePath;

            $image = new Image();
            $image->title = $request->title;
            $image->path = $imagePath;
            $image->save();
        }

        return redirect()->route('admin.image.index')->with('success', 'Image uploaded successfully!');
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            $oldPath = str_replace('https://image.miluv.app/', '', $image->path);
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            // Handle new image upload
            $newImagePath = $this->handleFileUpload($request, 'image');
            if ($newImagePath) {
                $baseUrl = 'https://image.miluv.app/';
                $image->path = $baseUrl . $newImagePath;
            }
        }

        $image->title = $request->input('title');
        $image->save();

        return redirect()->route('admin.image.index')->with('success', 'Image updated successfully!');
    }

    public function index()
    {
        $images = Image::all();
        return view('admin.image.index', compact('images'));
    }

    public function destroy(Image $image)
    {
        // Delete image file
        $path = str_replace('https://image.miluv.app/', '', $image->path);
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // Delete record from database
        $image->delete();

        return redirect()->route('admin.image.index')->with('success', 'Image deleted successfully!');
    }
}
