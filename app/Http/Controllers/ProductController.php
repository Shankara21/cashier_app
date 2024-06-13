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
        $datas = Product::all();
        return view('pages.product.index', compact('datas'));
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
    public function store(StoreProductRequest $request)
    {
        $variants = json_decode($request['variants_data'], true);
        $data = $request->validated();
        try {
            if (count($variants) == 0) {
                Alert::error('Error', 'Produk gagal ditambahkan, tambahkan minimal 1 variant');
                return redirect()->back();
            }
            $product = Product::create($data);
            foreach ($variants as $key => $value) {
                ProductDetail::create([
                    'product_id' => $product->id,
                    'variant' => $value['variant'],
                    'buying_price' => $this->convertCurrencyToNumber($value['buying_price']),
                    'selling_price' => $this->convertCurrencyToNumber($value['selling_price']),
                    'stock' => $value['stock'],
                ]);
            }
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
        $variants = json_decode($request['variants_data'], true);
        $data = $request->validated();
        // dd(count($variants), count($product->productDetails));
        dd($variants);
        // dd($request->all());
        try {
            $product->update($data);
            foreach ($variants as $key => $value) {
                $productDetail = ProductDetail::find($value['id']);
                $productDetail->update([
                    'product_id' => $product->id,
                    'variant' => $value['variant'],
                    'buying_price' => $this->convertCurrencyToNumber($value['buying_price']),
                    'selling_price' => $this->convertCurrencyToNumber($value['selling_price']),
                    'stock' => $value['stock'],
                ]);
            }
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
