<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = request()->query('category');
        $brand = request()->query('brand');
        $datas = Product::all();
        $categories = Category::all();
        if ($category) {
            $datas = Product::where('category_id', $category)->get();
        }
        if ($brand) {
            $datas = Product::where('brand_id', $brand)->get();
        }
        if ($category && $brand) {
            $datas = Product::where('category_id', $category)->where('brand_id', $brand)->get();
        }

        return view('pages.product.index', compact('datas', 'categories', 'brand'));
    }

    public function getProductByCode(Request $request)
    {
        $data = Product::where('code', $request->code)->first();
        if ($data) {
            return response()->json([
                'data' => new ProductResource($data),
                'success' => true
            ]);
        } else {
            return response()->json([
                'data' => null,
                'success' => false
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function convertCurrencyToNumber($currency)
    {
        $number = preg_replace("/[^0-9.]/", "", $currency);

        return (float) $number;
    }
    function convertToInteger($formattedCurrency)
    {
        return (int) preg_replace('/[^0-9]/', '', $formattedCurrency);
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $data['buying_price'] = $this->convertToInteger($request['buying_price']);
        $data['selling_price'] = $this->convertToInteger($request['selling_price']);
        try {
            Product::create($data);
            Alert::success('Success', 'Produk berhasil ditambahkan');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('pages.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        try {
            $product->update($data);
            Alert::success('Success', 'Produk berhasil diubah');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            Alert::success('Success', 'Produk berhasil dihapus');
            return redirect()->route('products.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}
