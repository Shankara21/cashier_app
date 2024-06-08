@extends('layouts.app')
@section('title', 'Cashier')
@section('content')
<div class="row ">
    <div class="col-8">
        <div class="card p-3">
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10%">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center" style="width: 15%">Amount</th>
                            <th class="text-center" style="width: 30%">Total</th>
                            <th class="text-center" style="width: 10%">Discount</th>
                            <th class="text-center" style="width: 10%">Action</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4 card p-3 " style="height: 50vh">
        <h5 class="mt-3">Insert product code</h5>
        <form id="productForm" class="row align-items-end my-3">
            @csrf
            <div class="col-10">
                <input type="text" class="form-control @error('code')
                                                    is-invalid
                                                    @enderror" id="input1" placeholder="Code" name="code"
                    value="{{ old('code') }}" autofocus>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-2 ">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-search me-0'></i>
                </button>
            </div>
        </form>
        <div class="mt-4">
            <hr>
        </div>
    </div>
</div>

<script>
    let datas = [];
    document.getElementById('productForm').addEventListener('submit', function(event) {
    event.preventDefault();
    // Ambil nilai dari input
    const code = document.getElementById('input1').value;

    // Buat request options
    const requestOptions = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value // CSRF token
        },
        body: JSON.stringify({ code: code })
    };

    // Kirim request ke server
    fetch('{{ route("products.code") }}', requestOptions)
        .then(response => response.json())
        .then(data => {
            document.getElementById('input1').value = '';
            if (!data.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Product not found!'
                });
            } else {
                datas.push(data.data);
                updateTable(datas);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

function updateTable(datas) {
    const tableBody = document.getElementById('productTableBody');
    tableBody.innerHTML = ''; // Bersihkan tabel sebelum memperbarui

    datas.forEach((product, index) => {
        const amount = 1; // Default amount
        const total = amount * product.selling_price; // Total price
        const discount = '0%'; // Default discount
        console.log({ product: product });
        const row = `
            <tr>
                <td class="text-center">${index + 1}</td>
                <td class="text-center">${product.name}</td>
                <td class="text-center">
                    <input type="number" class="form-control amount-input" value="${amount}" min="1" data-price="${product.selling_price}" data-index="${index}">
                </td>
                <td class="text-center" id="total-${index}">Rp. ${total.toLocaleString()}</td>
                <td class="text-center">${discount}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger" onclick="removeRow(${index})"><i class='bx bx-trash me-0'></i></button>
                </td>
            </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
    });

    // Tambahkan event listener untuk input jumlah
    document.querySelectorAll('.amount-input').forEach(input => {
        input.addEventListener('input', function() {
            const index = this.dataset.index;
            const price = this.dataset.price;
            updateTotal(this.value, price, index);
        });
    });
}

function updateTotal(amount, price, index) {
    const total = amount * price;
    document.getElementById(`total-${index}`).innerText = `Rp. ${total.toLocaleString()}`;
}

function removeRow(index) {
    const tableBody = document.getElementById('productTableBody');
    tableBody.deleteRow(index);
    // Update row numbers
    Array.from(tableBody.rows).forEach((row, i) => {
        row.cells[0].innerText = i + 1;
        row.cells[3].id = `total-${i}`;
        row.cells[2].querySelector('input').setAttribute('data-index', i);
        row.cells[2].querySelector('input').setAttribute('oninput', `updateTotal(this.value, ${row.cells[2].querySelector('input').dataset.price}, ${i})`);
        row.cells[5].querySelector('button').setAttribute('onclick', `removeRow(${i})`);
    });
}
</script>
@endsection
