<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserGalleryController extends Controller
{
    // Show gallery page with images
    public function index()
    {
        $user = Auth::guard('web')->user();
        $images = UserGallery::where('user_id', $user->id)->where('is_pdf', false)->latest()->paginate(12);

        $pdf = UserGallery::where('user_id', $user->id)->where('is_pdf', true)->latest()->paginate(12);
        $p_name = UserGallery::distinct()->pluck('p_name');
        $s_name = UserGallery::distinct()->pluck('s_name');
        return view('user.gallery.index', compact('images', 'pdf', 'p_name', 's_name'));
    }

    public function store(Request $request)
    {
        $user = Auth::guard('web')->user();

        // Validate the request
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,pdf', // Allow both images and PDFs
            'alt_text' => 'nullable|string|max:255',
            's_name' => 'nullable|string|max:20',
            'p_name' => 'nullable|string|max:20',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension(); // Get file extension
            $filename = time() . '.' . $extension; // Generate a unique filename

            // Determine the directory based on file type
            $directory = $extension === 'pdf'
                ? public_path('assets/user/files/') // PDF directory
                : public_path('assets/user/img/galleries/'); // Image directory

            // Ensure the directory exists
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true); // Create directory with full permissions
            }

            // Move the file to the appropriate directory
            $file->move($directory, $filename);
            // dd($file, $extension, $filename, $directory);
            UserGallery::create([
                'user_id' => $user->id,
                'image' => $filename, // Store the filename in the `image` column
                'is_pdf' => $extension === 'pdf', // Set `is_pdf` to true if the file is a PDF
                'alt_text' => $request->alt_text,
                's_name' => $request->s_name,
                'p_name' => $request->p_name
            ]);

            return back()->with('success', ucfirst($extension) . ' uploaded successfully');
        }

        return back()->with('error', 'Upload failed');
    }


    public function destroy($id)
    {
        $user = Auth::guard('web')->user();
        $file = UserGallery::where('user_id', $user->id)->findOrFail($id);

        if ($file->is_pdf) {
            $path = public_path('assets/user/files/' . $file->image);
        } else {
            $path = public_path('assets/user/img/galleries/' . $file->image);
        }

        if (file_exists($path)) {
            unlink($path);
        }

        $file->delete();
        return back()->with('success', 'File deleted');
    }

}