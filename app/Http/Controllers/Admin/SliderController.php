<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller {
    public function index() {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function create() {
        return view('admin.slider.create');
    }

    public function store(Request $request) {
        $request->validate([
            'image' => 'required|image',
        ]);

        $imagePath = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'title' => $request->title,
            'link' => $request->link,
            'is_active' => $request->has('is_active'),
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.slider.index')->with('success', 'Slider added');
    }

    // Edit form
    public function edit(Slider $slider) {
        return view('admin.slider.edit', compact('slider'));
    }

    // Update slider
    public function update(Request $request, Slider $slider) {
        $request->validate([
            'image' => 'nullable|image',
        ]);

        $data = [
            'title' => $request->title,
            'link' => $request->link,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            // Delete old image file if needed
            if ($slider->image && Storage::disk('public')->exists($slider->image)) {
                Storage::disk('public')->delete($slider->image);
            }
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update($data);

        return redirect()->route('admin.slider.index')->with('success', 'Slider updated');
    }

    // Delete slider
    public function destroy(Slider $slider) {
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('admin.slider.index')->with('success', 'Slider deleted');
    }
}
