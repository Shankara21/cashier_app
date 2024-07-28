<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModalRequest;
use App\Http\Requests\UpdateModalRequest;
use App\Models\Modal;
use RealRashid\SweetAlert\Facades\Alert;

class ModalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Modal::all();
        return view('pages.modal.index', compact('datas'));
    }

    public function modalToday()
    {
        $datas = Modal::whereDate('created_at', date('Y-m-d'))->where('user_id', auth()->user()->id)->first();
        if ($datas) {
            return response()->json([
                'data' => $datas,
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
        return view('pages.modal.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    function convertToInteger($formattedCurrency)
    {
        return (int) preg_replace('/[^0-9]/', '', $formattedCurrency);
    }
    public function store(StoreModalRequest $request)
    {
        try {
            $data = $request->validated();
            $data['total_modal'] = $this->convertToInteger($data['total_modal']);
            Modal::create($data);
            Alert::success('Success', 'Modal created successfully');
            return redirect()->route('modals.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Modal $modal)
    {
        return view('pages.modal.show', compact('modal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modal $modal)
    {
        return view('pages.modal.edit', compact('modal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateModalRequest $request, Modal $modal)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modal $modal)
    {
        try {
            $modal->modal_details()->delete();
            $modal->delete();
            Alert::success('Success', 'Modal deleted successfully');
            return redirect()->route('modals.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
        }
    }
}
