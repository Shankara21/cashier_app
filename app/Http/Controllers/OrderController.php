<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $month = date('F');
        $date = $this->translateMonth($month) . ' ' . date('Y');
        $orderDetails = OrderDetails::where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        return view('pages.order.index', compact('orderDetails', 'date'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $datas = $request['datas'];
        $final_price = $request['final_price'];
        $paymentAmount = $request['paymentAmount'];
        $paymentMethod = $request['paymentMethod'];
        $total_discount = $request['total_discount'];
        $total_price = $request['total_price'];
        $amount = 0;
        foreach ($datas as $data) {
            $amount += $data['amount'];
        }
        $change = $paymentAmount - $final_price;
        try {
            $order =   Order::create([
                'user_id' => auth()->user()->id,
                'qty' => $amount,
                'final_price' => $final_price,
                'payment_method' => $paymentMethod,
                'total_discount' => $total_discount,
                'total_price' => $total_price,
                'payment_amount' => $paymentAmount,
                'change' => $change,
            ]);

            foreach ($datas as $data) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $data['id'],
                    'qty' => $data['amount'],
                    'discount' => $data['discount'],
                    'total' => $data['final_price'],
                ]);
            }

            Alert::success('Success', 'Order berhasil ditambahkan');
            return response()->json([
                'success' => true,
                'redirect' => route('invoice', $order->id)
            ]);
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function invoice($id)
    {
        $order = Order::find($id);
        return view('pages.cashier.invoice', compact('order'));
    }

    function translateMonth($month)
    {
        switch ($month) {
            case 'January':
                return 'Januari';
            case 'February':
                return 'Februari';
            case 'March':
                return 'Maret';
            case 'April':
                return 'April';
            case 'May':
                return 'Mei';
            case 'June':
                return 'Juni';
            case 'July':
                return 'Juli';
            case 'August':
                return 'Agustus';
            case 'September':
                return 'September';
            case 'October':
                return 'Oktober';
            case 'November':
                return 'November';
            case 'December':
                return 'Desember';
            default:
                return $month;
        }
    }
}
