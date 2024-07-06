<?php

namespace App\Exports;

use App\Models\OrderDetails;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class OrderExport implements FromView
{
    use RegistersEventListeners;

    protected $data;
    protected $sum;
    public function __construct($data, $sum)
    {
        $this->data = $data;
        $this->sum = $sum;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('pages.order.monthly-report', [
            'data' => $this->data,
            'sum' => $this->sum
        ]);
    }
}
