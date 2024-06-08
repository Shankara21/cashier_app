@extends('layouts.app')
@section('title', 'Cashier')
@section('content')
<div class="row">
    <div class="col-8">
        <div class="card p-3">
            <div class="d-flex justify-content-end">
                <button id="removeAllButton" class="btn btn-danger my-3" style="display: none;">Remove All</button>
            </div>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 7%">No</th>
                            <th class="text-center">Name</th>
                            <th class="text-center" style="width: 10%">Amount</th>
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
    <div class="col-4 card p-3">
        <h5 class="mt-3">Insert product code</h5>
        <form id="productForm" class="row align-items-end my-3">
            @csrf
            <div class="col-10">
                <input type="text" class="form-control @error('code') is-invalid @enderror" id="input1"
                    placeholder="Code" name="code" value="{{ old('code') }}" autofocus>
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
            <p>Total: <span id="total-price">Rp. 0</span></p>
            <p>Discount: <span id="total-discount">Rp. 0</span></p>
            <p>Final Price: <span id="final-price">Rp. 0</span></p>

        </div>
        <div class="mt-4">
            <h5>Choose Payment Method:</h5>
            <div class="payment-options">
                <div id="cash-option" class="payment-card" onclick="selectPaymentMethod('cash')">
                    <img src="{{ asset('assets/images/cash.png') }}" alt="" style="width: 100px">
                    <h5>Cash</h5>
                </div>
                <div id="qris-option" class="payment-card" onclick="selectPaymentMethod('qris')">
                    <img src="{{ asset('assets/images/qr.png') }}" alt="" style="width: 100px">
                    <h5>QRIS</h5>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div id="paymentInput" style="display: none;">
                <label for="paymentAmount">Enter Payment Amount:</label>
                <input type="number" id="paymentAmount" class="form-control" autofocus>
                <button id="confirmPaymentButton" class="btn btn-primary mt-3 w-100" style="height: 50px">Confirm
                    Payment</button>
            </div>
            <button id="paymentButton" class="btn btn-primary mt-3 w-100" style="height: 50px; display: none">Confirm
                Payment</button>
        </div>
    </div>
</div>

<style>
    .payment-options {
        display: flex;
        gap: 10px;
        margin-top: 10px;
    }

    .payment-card {
        flex: 1;
        padding: 15px;
        text-align: center;
        border: 1px solid #ddd;
        cursor: pointer;
        border-radius: 5px;
    }

    .payment-card.selected {
        border: 2px solid #ec1271;
        background-color: #fce4ec;
    }
</style>

<script>
    let datas = JSON.parse(localStorage.getItem('datas')) || [];
    let total = 0;
    let discount = 0;
    let final_price = 0;
    let selectedPaymentMethod = '';

    document.addEventListener('DOMContentLoaded', function() {
        if (datas.length > 0) {
            updateTable(datas);
        }
    });

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

            const discountText = productDiscount ? `${productDiscount}%` : '0%';
            const row = `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${product.name}</td>
                    <td class="text-center">
                        <input type="number" class="form-control amount-input" value="${product.amount}" min="1" data-price="${product.selling_price}" data-index="${index}" data-discount="${productDiscount}">
                    </td>
                    <td class="text-center" id="total-${index}">Rp. ${productFinal.toLocaleString()}</td>
                    <td class="text-center">${discountText}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-outline-danger" onclick="removeRow(${index})"><i class='bx bx-trash
me-0'></i></button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', row);
        });

        document.querySelectorAll('.amount-input').forEach(input => {
            input.addEventListener('input', function() {
                const index = this.dataset.index;
                const price = this.dataset.price;
                const discount = this.dataset.discount;
                updateTotal(this.value, price, discount, index);
            });
        });

        updateRemoveAllButton();
        saveToLocalStorage();
        updateSummary();
    }

    function calculateTotal(amount, price, discount) {
        const subtotal = amount * price;
        const total = discount ? subtotal * (1 - discount / 100) : subtotal;
        return total;
    }

    function updateTotal(amount, price, discount, index) {
        const productTotal = amount * price;
        const productFinal = calculateTotal(amount, price, discount);

        datas[index].amount = parseInt(amount);

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
</script>
@endsection
