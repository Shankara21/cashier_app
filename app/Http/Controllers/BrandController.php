<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Variant;
use RealRashid\SweetAlert\Facades\Alert;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Brand::all();
        return view('pages.brand.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.brand.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request)
    {
        try {
            $data = $request->validated();
            Brand::create($data);
            Alert::success('Success', 'Brand has been created');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        $categories = Category::all();
        return view('pages.brand.edit', compact('categories', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        try {
            $data = $request->validated();
            $brand->update($data);
            Alert::success('Success', 'Brand has been updated');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        try {
            $brand->delete();
            Alert::success('Success', 'Brand has been deleted');
            return redirect()->route('brands.index');
        } catch (\Throwable $th) {
            Alert::error($th->getMessage());
            return redirect()->back();
        }
    }

    public function byCategory($id)
    {
        $brands = Brand::where('category_id', $id)->get();
        $variants = Variant::where('category_id', $id)->get();
        return response()->json(compact('brands', 'variants'));
    }
}
