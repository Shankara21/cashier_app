<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Exports\ReportExport;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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

        $orderDetailsQuery = OrderDetails::with(['product.variant', 'product.brand', 'product.category']);

        $reqMonth = $this->convertToInteger($reqMonth);

        if ($reqMonth && $reqYear && $reqDate) {
            $orderDetailsQuery->whereDate('created_at', $reqYear . '-' . $reqMonth . '-' . $reqDate);
            $selectedYear = $reqYear;
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqMonth && $reqYear) {
            $orderDetailsQuery->whereYear('created_at', $reqYear)->whereMonth('created_at', $reqMonth);
            $selectedYear = $reqYear;
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqDate) {
            $orderDetailsQuery->whereDate('created_at', $reqDate);
        } elseif ($reqMonth) {
            $orderDetailsQuery->whereMonth('created_at', $reqMonth);
            $formattedMonth = $this->convertToMonth($reqMonth);
        } elseif ($reqYear) {
            $orderDetailsQuery->whereYear('created_at', $reqYear);
            $selectedYear = $reqYear;
        } else {
            $orderDetailsQuery->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $monthNumber);
        }

        $orderDetails = $orderDetailsQuery->get();

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
            $capital += $orderDetail->buying_price;
            $total += $orderDetail->total;
        }
        $profit = $total - $capital;
        $selectedDate = '';
        if ($reqDate) {
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
                'payment_method' => $paymentMethod,
                'total_price' => $total_price,
                'total_discount' => $total_discount,
                'final_price' => $final_price,
                'change' => $change,
                'payment_amount' => $paymentAmount,
            ]);
            if (count($datas) > 0) {
                foreach ($datas as $data) {
                    $processedData = [
                        'order_id' => $order->id,
                        'product_id' => $data['id'],
                        'qty' => $data['amount'],
                        'discount' => $data['discount'],
                        'buying_price' =>  $data['buying_price'] * $data['amount'],
                        'selling_price' =>  $data['selling_price'],
                        'total' => $data['final_price'],
                    ];
                    OrderDetails::create($processedData);
                    $product = Product::find($data['id']);
                    $product->stock -= $data['amount'];
                    $product->save();
                }
                Alert::success('Success', 'Order berhasil ditambahkan');
                return response()->json([
                    'success' => true,
                    'redirect' => '/invoice/' . $order->id,
                    'order' => $order
                ]);
            }
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
        $setting = Setting::first();
        $order = Order::find($id);
        return view('pages.cashier.invoice', compact('order', 'setting'));
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

    public function export(Request $request)
    {
        $mpdf = new \Mpdf\Mpdf();
        $orderAmount = $request->input('orderAmount');
        $capital = $request->input('capital');
        $total = $request->input('total');
        $profit = $request->input('profit');
        $type = $request->input('type');
        $data = json_decode($request->input('data'), true);
        $sum = array_sum(array_column($data, 'total'));
        $month = $request->input('month');
        if ($type == 'daily') {
            $month = $request->input('month');
            $month = date('d F Y', strtotime($month));
        }
        // return view('pages.order.report', [
        //     'data' => $data,
        //     'capital' => $capital,
        //     'total' => $total,
        //     'orderAmount' => $orderAmount,
        //     'profit' => $profit,
        // ]);
        $html = view('pages.order.report', [
            'data' => $data,
            'capital' => $capital,
            'total' => $total,
            'orderAmount' => $orderAmount,
            'profit' => $profit,
        ])->render();
        $mpdf->WriteHTML($html);
        $mpdf->Output('Report-' . $month . '.pdf', 'D');
        // if ($type == 'month') {
        //     return Excel::download(new OrderExport($data, $sum), 'Report-' . $month . '.xlsx');
        // } else {
        //     return Excel::download(new ReportExport($data, $sum), 'Report-' . $month . '.xlsx');
        // }
    }
}
