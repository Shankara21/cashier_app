<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Variant;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Category::all();
        return view('pages.category.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.category.create');
    }

    /**
     * Store a newly created resource in storasge.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $variants = json_decode($request->input('variants'), true);
        try {
            $category =  Category::create($data);
            if ($variants) {
                foreach ($variants as $key => $value) {
                    Variant::create([
                        'category_id' => $category->id,
                        'name' => $value,
                    ]);
                }
            }
            Alert::success('Success', 'Kategori berhasil ditambahkan');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $variants = json_decode($request->input('variants'), true);
        try {
            $category->update($data);
            foreach ($variants as $key => $value) {
                Variant::create([
                    'category_id' => $category->id,
                    'name' => $value,
                ]);
            }
            Alert::success('Success', 'Kategori berhasil diubah');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->variants()->delete();
            $category->delete();
            Alert::success('Success', 'Kategori berhasil dihapus');
            return redirect()->route('categories.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
