<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Developer;

class DeveloperController extends Controller
{

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
            $imagePath = $request->file('image')->store('developers', 'public');
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
            if ($developer->image && Storage::disk('public')->exists($developer->image)) {
                Storage::disk('public')->delete($developer->image);
            }

            $imagePath = $request->file('image')->store('developers', 'public');
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

        if ($developer->image && Storage::disk('public')->exists($developer->image)) {
            Storage::disk('public')->delete($developer->image);
        }

        $developer->delete();

        return redirect()->route('admin.developers.list')->with('success', 'Developer deleted successfully.');
    }
}
