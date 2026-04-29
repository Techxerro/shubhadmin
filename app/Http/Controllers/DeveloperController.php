<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Services\FileUploadService;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function list()
    {
        $developers = Developer::latest()->paginate(10);

        return view('admin.developers.list', compact('developers'));
    }

    public function add()
    {
        return view('admin.developers.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $this->fileUploadService->upload($request->file('image'), 'developers');
        }

        Developer::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('admin.developers.list')->with('success', 'Developer added successfully.');
    }

    public function edit($id)
    {
        $developer = Developer::findOrFail($id);

        return view('admin.developers.edit', compact('developer'));
    }

    public function update(Request $request, $id)
    {
        $developer = Developer::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $imagePath = $developer->image;

        if ($request->hasFile('image')) {
            if ($developer->image && $this->fileUploadService->exists($developer->image)) {
                $this->fileUploadService->delete($developer->image);
            }

            $imagePath = $this->fileUploadService->upload($request->file('image'), 'developers');
        }

        $developer->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'is_featured' => $request->is_featured,
        ]);

        return redirect()->route('admin.developers.list')->with('success', 'Developer updated successfully.');
    }

    public function delete($id)
    {
        $developer = Developer::findOrFail($id);

        if ($developer->image && $this->fileUploadService->exists($developer->image)) {
            $this->fileUploadService->delete($developer->image);
        }

        $developer->delete();

        return redirect()->route('admin.developers.list')->with('success', 'Developer deleted successfully.');
    }
}
