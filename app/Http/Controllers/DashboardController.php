<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use DateTime;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $amount_category = Category::count();
        $amount_product = Product::count();
        $categories = Category::all();
        $senin = date('Y-m-d 00:01:00', strtotime('monday this week'));
        $minggu = date('Y-m-d 23:59:59', strtotime('sunday this week'));

        $seninLalu = date('Y-m-d 00:01:00', strtotime('-1 week', strtotime($senin)));
        $mingguLalu = date('Y-m-d 23:59:59', strtotime('-1 week', strtotime($minggu)));

        $orderMingguIni = Order::whereBetween('created_at', [$senin, $minggu])->count();
        $orderMingguLalu = Order::whereBetween('created_at', [$seninLalu, $mingguLalu])->count();
        $orderSelisih = $orderMingguIni - $orderMingguLalu;

        if ($orderMingguLalu > 0) {
            $persentase = ($orderSelisih / $orderMingguLalu) * 100;
        } else {
            if ($orderMingguIni > 0) {
                $persentase = 100;
            } else {
                $persentase = 0;
            }
        }

        if ($orderSelisih > 0) {
            $status = "Naik";
        } else if ($orderSelisih < 0) {
            $status = "Turun";
            if ($orderMingguLalu > 0) {
                $persentase = (abs($orderSelisih) / $orderMingguLalu) * 100;
            } else {
                $persentase = 100;
            }
        } else {
            $status = "Tidak ada";
            $persentase = 0;
        }

        // Buatkan list tanggal senin sampai minggu ini kemudian cari satu persatu jumlah order dari setiap tanggal kemudian masukkan ke dalam sebuah array
        $orders = [];

        $startDate = new DateTime($senin);
        $endDate = new DateTime($minggu);

        // Iterate from $senin to $minggu
        while ($startDate <= $endDate) {
            $currentDateStart = $startDate->format('Y-m-d 00:00:00');
            $currentDateEnd = $startDate->format('Y-m-d 23:59:59');

            $orders[] = [
                'day' =>
                $this->translateDayToIndonesian(date('l', strtotime($currentDateStart))),
                'jumlah' => Order::whereBetween('created_at', [$currentDateStart, $currentDateEnd])->count(),
            ];

            // Move to the next day
            $startDate->modify('+1 day');
        }

        // filter data order berdasarkan payment_method pada minggu ini jadi terdapat 3 payment_method yaitu cash, bca, dan mandiri
        $ordersThisWeek = Order::whereBetween('created_at', [$senin, $minggu])->get();
        $ordersCash = $ordersThisWeek->where('payment_method', 'cash')->count();
        $ordersQris = $ordersThisWeek->where('payment_method', 'bca')->count();
        $ordersMandiri = $ordersThisWeek->where('payment_method', 'mandiri')->count();
        $dataPayment[] = [
            ['payment_method' => 'Cash', 'total' => $ordersCash],
            ['payment_method' => 'BCA', 'total' => $ordersQris],
            ['payment_method' => 'Mandiri', 'total' => $ordersMandiri]
        ];
        return view('welcome', [
            'categories' => $categories,
            'amount_product' => $amount_product,
            'amount_category' => $amount_category,
            'penjualan' => [
                'orderMingguIni' => $orderMingguIni,
                'persentase' => $persentase,
                'status' => $status
            ],
            'orders' => $orders,
            'dataPayment' => $dataPayment
        ]);
    }
    function translateDayToIndonesian($englishDay)
    {
        switch ($englishDay) {
            case 'Monday':
                return 'Senin';
            case 'Tuesday':
                return 'Selasa';
            case 'Wednesday':
                return 'Rabu';
            case 'Thursday':
                return 'Kamis';
            case 'Friday':
                return 'Jumat';
            case 'Saturday':
                return 'Sabtu';
            case 'Sunday':
                return 'Minggu';
            default:
                return $englishDay; // Jika nama hari tidak dikenali, kembalikan asalnya
        }
    }
}
