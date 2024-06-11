@extends('layouts.app')
@section('title', 'Cashier')
@section('content')
<div class="row">
    <div class="col-8">
        <div class="card p-3">
            <div class="d-flex justify-content-end">
                <button id="removeAllButton" class="btn btn-danger my-3" style="display: none;">Hapus semua</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 7%">No</th>
                            <th class="text-center">Nama Produk</th>
                            <th class="text-center" style="width: 10%">Jumlah</th>
                            <th class="text-center" style="width: 30%">Total</th>
                            <th class="text-center" style="width: 10%">Diskon</th>
                            <th class="text-center" style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-4 card p-3">
        <h5 class="mt-3">Masukkan Kode Produk</h5>
        <form id="productForm" class="row align-items-end my-3">
            @csrf
            <div class="col-10">
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="input1"
                    placeholder="Kode produk" name="code" value="{{ old('code') }}" autofocus>
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-2">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-search me-0'></i>
                </button>
            </div>
        </form>
        <div class="mt-4">
            <hr>
        </div>
        <div class="mt-4">
            <table class="table mb-0">
                <tbody>
                    <tr>
                        <td class="text-start">Total</td>
                        <th scope="row" class="text-end" id="total-price">Rp. 0</th>
                    </tr>
                    <tr>
                        <td class="text-start">Diskon</td>
                        <th scope="row" class="text-end" id="total-discount">Rp. 0</th>
                    </tr>
                    <tr>
                        <td class="text-start">Total Bayar</td>
                        <th scope="row" class="text-end" id="final-price" style="font-size: 20px">Rp. 0</th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <h5>Pilih metode pembayaran</h5>
            <div class="payment-options">
                <div id="cash-option" class="payment-card" onclick="selectPaymentMethod('cash')">
                    <img src="{{ asset('assets/images/cash.png') }}" alt="" style="width: 100px">
                    <h5>Tunai</h5>
                </div>
                <div id="qris-option" class="payment-card" onclick="selectPaymentMethod('qris')">
                    <img src="{{ asset('assets/images/qr.png') }}" alt="" style="width: 100px">
                    <h5>QRIS</h5>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <form action="{{ route('orders.store') }}" method="POST" id="paymentForm">
                @csrf
                <div id="paymentInput" style="display: none;">
                    <label for="paymentAmount">Masukkan Jumlah Pembayaran</label>
                    <input type="text" id="paymentAmount" class="form-control" min="0" required>
                    <input type="text" id="valueAmount" class="form-control d-none" min="0" name="valueAmount">
                    <input type="hidden" id="datas" name="datas">
                    <button id="confirmPaymentButton" type="submit" class="btn btn-primary mt-3 w-100"
                        style="height: 50px">Konfirmasi
                        Pembayaran</button>
                </div>
            </form>
            <button id="paymentButton" type="button" class="btn btn-primary mt-3 w-100" data-bs-toggle="modal"
                data-bs-target="#exampleVerticallycenteredModal" style="height: 50px; display: none">Konfirmasi
                Pembayaran</button>
            <!-- Modal -->
            <div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pembayaran QRIS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-center">
                                <img src="https://cms.dailysocial.id/wp-content/uploads/2023/03/QRIS.png" alt="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary">Selesaikan Pembayaran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let datas = JSON.parse(localStorage.getItem('datas')) || [];
    let total = 0;
    let discount = 0;
    let final_price = 0;
    let selectedPaymentMethod = '';

    document.addEventListener('DOMContentLoaded', function() {
        if (datas.length > 0) {
            updateTable(datas);
        } else {
            displayNoDataMessage();
        }
    });
    document.getElementById('confirmPaymentButton').addEventListener('click', function(event) {
        event.preventDefault();

        if (document.getElementById('valueAmount').value == 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Pembayaran tidak boleh 0!'
            });
            return;
        }
        if (document.getElementById('valueAmount').value < final_price) {
            Swal.fire({
                icon: 'error' ,
                title: 'Oops...' ,
                text: 'Jumlah pembayaran kurang dari total bayar!'
            });
            return;
        }
        let datas=JSON.parse(localStorage.getItem('datas')) || []; document.getElementById('datas').value=JSON.stringify(datas);
        let paymentAmount=document.getElementById('paymentAmount').value;
        fetch('{{ route("orders.store") }}', {
            method: 'POST' , headers:
            {
                'Content-Type' : 'application/json' ,
                'X-CSRF-TOKEN' : document.querySelector('input[name=_token]').value
            },
            body: JSON.stringify({
                datas: datas,
                paymentAmount: currencyToInt(paymentAmount),
                paymentMethod: selectedPaymentMethod,
                total_discount: discount,
                final_price: final_price,
                total_price: total
            })
        }).then(response=> {
            if (!response.ok) {
                console.log(response);
                throw new Error('Network response was not ok');
            }
            return response.json();
        }).then(data => {
            localStorage.removeItem('datas');
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Order has been placed successfully!'
            });
            window.location.href = data.redirect;
        }).catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!'
            });
        });
    });
    document.getElementById('paymentAmount').addEventListener('input', function(e) {
        let value = e.target.value;

        value = value.replace(/[^0-9]/g, '');
        realValue = value

        if (value) {
            value = formatIDR(value);
            }
            e.target.value = value;
            document.getElementById('valueAmount').value = realValue;
    });

    function formatIDR(value) {
        const number = parseInt(value, 10);
        return number.toLocaleString('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
    }
    function currencyToInt(currency) {
    // Hapus karakter non-digit
    let value = currency.replace(/\D/g, '');
    // Ubah ke integer
    return parseInt(value);
    }

    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const code = document.getElementById('input1').value;

        const requestOptions = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
            },
            body: JSON.stringify({ code: code })
        };

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
                    const existingProductIndex = findProductIndex(data.data.id);
                    if (existingProductIndex !== -1) {
                        datas[existingProductIndex].amount += 1;
                    } else {
                        datas.push({ ...data.data, amount: 1 });
                    }
                    updateTable(datas);
                    saveToLocalStorage();
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });

    function findProductIndex(productId) {
        return datas.findIndex(product => product.id === productId);
    }

    function updateTable(datas) {
        const prevDataLength = datas.length; // Simpan jumlah data sebelum operasi

        const tableBody = document.getElementById('productTableBody');
        tableBody.innerHTML = '';

        total = 0;
        discount = 0;
        final_price = 0;

        datas.forEach((product, index) => {
            const productDiscount = product.discount || 0;
            const productTotal = product.amount * product.selling_price;
            const productFinal = calculateTotal(product.amount, product.selling_price, productDiscount);

            total += productTotal;
            discount += productTotal - productFinal;
            final_price += productFinal;

            product.final_price = productFinal;

            const discountText = productDiscount ? `${productDiscount}%` : '0%';
            const row = `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${product.name}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="decreaseAmount(${index})">-</button>
                            <button type="button" class="btn btn-outline-primary" disabled>${product.amount}</button>
                            <button type="button" class="btn btn-outline-primary" onclick="increaseAmount(${index})">+</button>
                        </div>
                    </td>
                    <td class="text-center" id="total-${index}">Rp. ${productFinal.toLocaleString()}</td>
                    <td class="text-center">${discountText}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger" onclick="removeRow(${index})"><i class='bx bx-trash me-0'></i></button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });

        if (datas.length === 0) {
            displayNoDataMessage();
        }

        updateRemoveAllButton();
        saveToLocalStorage();
        updateSummary();
    }

    function calculateTotal(amount, price, discount) {
        const subtotal = amount * price;
        const total = discount ? subtotal * (1 - discount / 100) : subtotal;
        return total;
    }

    function updateTotal(index) {
        const product = datas[index];
        const productFinal = calculateTotal(product.amount, product.selling_price, product.discount || 0);

        total = datas.reduce((sum, product) => sum + (product.amount * product.selling_price), 0);
        discount = datas.reduce((sum, product) => sum + ((product.amount * product.selling_price) -
            calculateTotal(product.amount, product.selling_price, product.discount || 0)), 0);
        final_price = datas.reduce((sum, product) => sum + calculateTotal(product.amount, product.selling_price,
            product.discount || 0), 0);

        document.getElementById(`total-${index}`).innerText = `Rp. ${productFinal.toLocaleString()}`;
        updateSummary();
        saveToLocalStorage();
        updateRemoveAllButton(); // Memperbarui tampilan tombol "Remove All"
    }

    function updateSummary() {
        document.getElementById('total-price').innerText = `Rp. ${total.toLocaleString()}`;
        document.getElementById('total-discount').innerText = `Rp. ${discount.toLocaleString()}`;
        document.getElementById('final-price').innerText = `Rp. ${final_price.toLocaleString()}`;
        const paymentInput = document.getElementById('paymentInput');
        const paymentButton = document.getElementById('paymentButton');
        if (selectedPaymentMethod === 'cash') {
            paymentInput.style.display = 'block';
            paymentButton.style.display = 'none';
        } else if (selectedPaymentMethod === 'qris') {
            paymentInput.style.display = 'none';
            paymentButton.style.display = 'block';
        }else {
            paymentInput.style.display = 'none';
        }
    }

    function removeRow(index) {
        datas.splice(index, 1);
        updateTable(datas);
        saveToLocalStorage();
    }

    function saveToLocalStorage() {
        localStorage.setItem('datas', JSON.stringify(datas));
    }

    document.getElementById('removeAllButton').addEventListener('click', function() {
        datas = [];
        updateTable(datas);
        localStorage.removeItem('datas');
        window.location.reload();
    });

    function updateRemoveAllButton() {
        const removeAllButton = document.getElementById('removeAllButton');
        if (datas.length > 0) {
            removeAllButton.style.display = 'block';
        } else {
            removeAllButton.style.display = 'none';
        }
    }

    function selectPaymentMethod(method) {
        selectedPaymentMethod = method;
        document.getElementById('cash-option').classList.remove('selected');
        document.getElementById('qris-option').classList.remove('selected');

        if (method === 'cash') {
            document.getElementById('cash-option').classList.add('selected');
        } else if (method === 'qris') {
            document.getElementById('qris-option').classList.add('selected');
        }
        updateSummary();
    }

    function displayNoDataMessage() {
        const tableBody = document.getElementById('productTableBody');
        tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
        `;
    }

    function increaseAmount(index) {
        datas[index].amount += 1;
        updateTable(datas);
    }

    function decreaseAmount(index) {
        if (datas[index].amount > 1) {
            datas[index].amount -= 1;
            updateTable(datas);
        }
    }
</script>
@endsection
