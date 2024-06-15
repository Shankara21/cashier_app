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
        $reqMonth = request('bulan');
        $reqYear = request('tahun');
        $reqDate = request('tanggal');

        $month = date('F');
        $selectedYear = date('Y');
        $monthNumber = date('m');
        $formattedMonth = $this->translateMonth($month);
        $date = $this->translateMonth($month) . ' ' . date('Y');

        $orderDetails = OrderDetails::query();

        $reqMonth = $this->convertToInteger($reqMonth);

        if ($reqMonth && $reqYear && $reqDate) {
            $orderDetails->whereDate('created_at', $reqYear . '-' . $reqMonth . '-' . $reqDate);
            $selectedYear = $reqYear;
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqMonth && $reqYear) {
            $orderDetails->whereYear('created_at', $reqYear)->whereMonth('created_at', $reqMonth);
            $selectedYear = $reqYear;
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqDate) {
            $orderDetails->whereDate('created_at', $reqDate);
        } elseif ($reqMonth) {
            $orderDetails->whereMonth('created_at', $reqMonth);
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqYear) {
            $orderDetails->whereYear('created_at', $reqYear);
            $selectedYear = $reqYear;
        } else {
            $orderDetails->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $monthNumber);
        }

        $orderDetails = $orderDetails->get();

        $years = [];
        $monthNames = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        $allDatas = OrderDetails::all();
        foreach ($allDatas as $data) {
            $year = date('Y', strtotime($data->created_at));
            if (!in_array($year, $years)) {
                array_push($years, $year);
            }
        }
        $orderAmount = 0;
        $total = 0;
        $capital = 0;
        $profit = 0;
        foreach ($orderDetails as $orderDetail) {
            $orderAmount += $orderDetail->qty;
            $capital += $orderDetail->product->buying_price;
            $total += $orderDetail->total;
        }
        $profit = $total - $capital;
        $selectedDate = '';
        if($reqDate){
            $selectedDate = $reqDate;
        }

        return view('pages.order.index', compact(
            'orderDetails',
            'date',
            'years',
            'formattedMonth',
            'monthNames',
            'orderAmount',
            'capital',
            'total',
            'profit',
            'selectedYear',
            'selectedDate'
        ));
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
        dd($request->all());
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

    function convertToInteger($month)
    {
        switch ($month) {
            case 'Januari':
                return 1;
            case 'Februari':
                return 2;
            case 'Maret':
                return 3;
            case 'April':
                return 4;
            case 'Mei':
                return 5;
            case 'Juni':
                return 6;
            case 'Juli':
                return 7;
            case 'Agustus':
                return 8;
            case 'September':
                return 9;
            case 'Oktober':
                return 10;
            case 'November':
                return 11;
            case 'Desember':
                return 12;
            default:
                return $month;
        }
    }

    function convertToMonth($month)
    {
        switch ($month) {
            case 1:
                return 'Januari';
            case 2:
                return 'Februari';
            case 3:
                return 'Maret';
            case 4:
                return 'April';
            case 5:
                return 'Mei';
            case 6:
                return 'Juni';
            case 7:
                return 'Juli';
            case 8:
                return 'Agustus';
            case 9:
                return 'September';
            case 10:
                return 'Oktober';
            case 11:
                return 'November';
            case 12:
                return 'Desember';
            default:
                return $month;
        }
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
