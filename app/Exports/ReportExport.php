<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class ReportExport implements FromView
{
   use RegistersEventListeners;

   protected $data;

   public function __construct($data)
   {
      $this->data = $data;
   }

   public function view():View
   {
    return view('pages.order.report', $this->data);
   }
}
