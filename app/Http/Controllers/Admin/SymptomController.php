<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Symptom;
use App\Models\SymptomCategory;
use Illuminate\Http\Request;

class SymptomController extends Controller
{
    public function index()
    {
        $symptoms = Symptom::with('category')->paginate(10);
        return view('admin.symptoms.index', compact('symptoms'));
    }

    public function create()
    {
        $categories = SymptomCategory::all();
        return view('admin.symptoms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:symptom_categories,id',
            'code' => 'required|string|max:10|unique:symptoms,code',
            'name' => 'required|string|max:255',
            'question' => 'required|string',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
            'cf_expert' => 'required|numeric|min:0|max:1',
        ]);

        Symptom::create($request->all());

        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil ditambahkan.');
    }

    public function edit(Symptom $symptom)
    {
        $categories = SymptomCategory::all();
        return view('admin.symptoms.edit', compact('symptom', 'categories'));
    }

    public function update(Request $request, Symptom $symptom)
    {
        $request->validate([
            'category_id' => 'required|exists:symptom_categories,id',
            'code' => 'required|string|max:10|unique:symptoms,code,' . $symptom->id,
            'name' => 'required|string|max:255',
            'question' => 'required|string',
            'mb' => 'required|numeric|min:0|max:1',
            'md' => 'required|numeric|min:0|max:1',
            'cf_expert' => 'required|numeric|min:0|max:1',
        ]);

        $symptom->update($request->all());

        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil diperbarui.');
    }

    public function destroy(Symptom $symptom)
    {
        $symptom->delete();
        return redirect()->route('admin.symptoms.index')->with('success', 'Gejala berhasil dihapus.');
    }
}
