<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ReportExport implements FromView
{
    use RegistersEventListeners;

    protected $data;
    protected $sum;
    public function __construct($data, $sum)
    {
        $this->data = $data;
        $this->sum = $sum;
    }

    public function view(): View
    {
        return view('pages.order.daily-report', [
            'data' => $this->data,
            'sum' => $this->sum
        ]);
    }
}
