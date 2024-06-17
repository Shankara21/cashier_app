@extends('layouts.app')
@section('content')

<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total products</p>
                        <h4 class="my-1">{{ $amount_product }}</h4>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Categories</p>
                        <h4 class="my-1">{{ $amount_category }}</h4>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="mb-0 text-secondary">Total Penjualan Minggu Ini</p>
                        <h4 class="my-1">
                            {{ $penjualan['orderMingguIni'] }}
                        </h4>
                        <p
                            class="mb-0 font-13 {{ $penjualan['status'] == 'Naik' ? 'text-success' : ($penjualan['status'] == 'Turun' ? 'text-danger' : 'text-secondary') }}">
                            @if ($penjualan['status'] == 'Tidak ada')
                            Penjualan minggu ini sama dengan minggu lalu
                            @else
                            <i class='bx {{ $penjualan['status'] == 'Naik' ? 'bxs-up-arrow' : 'bxs-down-arrow' }} align-middle'></i>{{ $penjualan['persentase'] }}%
                            Sejak minggu lalu
                            @endif
                        </p>
                    </div>
                    <div class="widgets-icons bg-light-success text-success ms-auto"><i class='bx bxs-wallet'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-flex gap-3">
    <div class=" card" style="width: 75%">
        <div class="card-body" id="chart"></div>
    </div>
    <div class="card" style="width: 25%">
        <div class="card-body" id="barchart"></div>
    </div>
</div>
<div class="row row-cols-2">
    @foreach ($categories as $category)
    <div class="col">
        <div class="card radius-10">
            <div class="card-body">
                <h5 class="card-title ">{{ $category->name }}</h5>
                <hr>
                <div class="table-responsive">
                    <table id="table{{ $loop->iteration }}" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Merk</th>
                                <th class="text-center">Diskon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->products as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $data->name }}</td>
                                <td class="text-center">{{ $data->brand }}</td>
                                <td class="text-center">{{ $data->discount }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>



@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.49.1/apexcharts.min.js"
    integrity="sha512-qiVW4rNFHFQm0jHli5vkdEwP4GPSzCSp85J7JRHdgzuuaTg31tTMC8+AHdEC5cmyMFDByX639todnt6cxEc1lQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {
      @foreach ($categories as $category)
      $('#table{{ $loop->iteration }}').DataTable();
      @endforeach
    });
</script>
<script>
    const amountOrderJson = {{ $amountOrder }};
    console.log(amountOrderJson);
    var options = {
    series: [{
    name: "Jumlah Penjualan",
    data: amountOrderJson
    }],
    chart: {
    height: 350,
    type: 'line',
    zoom: {
    enabled: false
    }
    },
    dataLabels: {
    enabled: false
    },
    stroke: {
    curve: 'straight'
    },
    title: {
    text: 'Penjualan Minggu Ini',
    align: 'left'
    },
    grid: {
    // row: {
    // colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
    // opacity: 0.5
    // },
    },
    xaxis: {
    categories: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
    }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    const orderThisWeek = {{ $orderThisWeek }};
    var options = {
    series: [{
    data: orderThisWeek
    }],
    chart: {
    height: 350,
    type: 'bar',
    events: {
    click: function(chart, w, e) {

    }
    }
    },
    colors: ['#00E396'],
    plotOptions: {
    bar: {
    columnWidth: '45%',
    distributed: true,
    }
    },
    dataLabels: {
    enabled: false
    },
    legend: {
    show: false
    },
    xaxis: {
    categories: [
    'Cash',
    'QRIS BCA',
    'QRIS Mandiri',
    ],
    labels: {
    style: {
    colors: ['#000'],
    fontSize: '12px'
    }
    }
    }
    };

    var chart = new ApexCharts(document.querySelector("#barchart"), options);
    chart.render();
</script>
@endsection
