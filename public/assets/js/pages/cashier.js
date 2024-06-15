let datas = JSON.parse(localStorage.getItem("datas")) || [];
let total = 0;
let discount = 0;
let final_price = 0;
let selectedPaymentMethod = "";
let bankName = "";

document.addEventListener("DOMContentLoaded", function () {
    if (datas.length > 0) {
        updateTable(datas);
    } else {
        displayNoDataMessage();
    }
});

document
    .getElementById("confirmPaymentButton")
    .addEventListener("click", function (event) {
        event.preventDefault();

        if (document.getElementById("valueAmount").value == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Pembayaran tidak boleh 0!",
            });
            return;
        }
        if (document.getElementById("valueAmount").value < final_price) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Jumlah pembayaran kurang dari total bayar!",
            });
            return;
        }
        let datas = JSON.parse(localStorage.getItem("datas")) || [];
        document.getElementById("datas").value = JSON.stringify(datas);
        let paymentAmount = document.getElementById("paymentAmount").value;
        fetch('{{ route("orders.store") }}', {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector("input[name=_token]").value,
            },
            body: JSON.stringify({
                datas: datas,
                paymentAmount: currencyToInt(paymentAmount),
                paymentMethod: selectedPaymentMethod,
                total_discount: discount,
                final_price: final_price,
                total_price: total,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    console.log(response);
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                localStorage.removeItem("datas");
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: "Order has been placed successfully!",
                });
                window.location.href = data.redirect;
            })
            .catch((error) => {
                console.error("Error:", error);
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Something went wrong!",
                });
            });
    });

function submitQris(event) {
    event.preventDefault();
    console.log({
        bankName,
        discount,
        total,
        final_price,
    });
    let datas = JSON.parse(localStorage.getItem("datas")) || [];
    let paymentAmount = final_price;
    let paymentMethod = bankName;
    let total_discount = discount;
    let total_price = total;

    fetch('{{ route("orders.store") }}', {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector("input[name=_token]").value,
        },
        body: JSON.stringify({
            datas: datas,
            paymentAmount: paymentAmount,
            paymentMethod,
            total_discount: discount,
            final_price,
            total_price: total,
        }),
    })
        .then((response) => {
            if (!response.ok) {
                console.log(response);
                throw new Error("Network response was not ok");
            }
            return response.json();
        })
        .then((data) => {
            localStorage.removeItem("datas");
            Swal.fire({
                icon: "success",
                title: "Success",
                text: "Order has been placed successfully!",
            });
            window.location.href = data.redirect;
        })
        .catch((error) => {
            console.error("Error:", error);
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
            });
        });
}

document
    .getElementById("paymentAmount")
    .addEventListener("input", function (e) {
        let value = e.target.value;

        value = value.replace(/[^0-9]/g, "");
        realValue = value;

        if (value) {
            value = formatIDR(value);
        }
        e.target.value = value;
        document.getElementById("valueAmount").value = realValue;
    });

function formatIDR(value) {
    const number = parseInt(value, 10);
    return number.toLocaleString("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    });
}
function currencyToInt(currency) {
    // Hapus karakter non-digit
    let value = currency.replace(/\D/g, "");
    // Ubah ke integer
    return parseInt(value);
}

document
    .getElementById("productForm")
    .addEventListener("submit", function (event) {
        event.preventDefault();
        const code = document.getElementById("input1").value;

        const requestOptions = {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN":
                    document.querySelector("input[name=_token]").value,
            },
            body: JSON.stringify({ code: code }),
        };

        fetch('{{ route("products.code") }}', requestOptions)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("input1").value = "";
                if (!data.success) {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Product not found!",
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
            .catch((error) => {
                console.error("Error:", error);
            });
    });

function findProductIndex(productId) {
    return datas.findIndex((product) => product.id === productId);
}
let selectedData = null;
function selectData(data) {
    selectedData = data; // Langsung gunakan objek data
    console.log(selectedData);

    // Tambahkan kelas "active" pada tombol yang dipilih
    document.querySelectorAll(".variant-button").forEach((button) => {
        button.classList.remove("active");
    });

    // Gunakan `data-id` untuk menargetkan tombol yang benar
    const button = document.querySelector(
        `.variant-button[data-id="${selectedData.id}"]`
    );
    if (button) {
        button.classList.add("active");
    }
}
function updateTable(datas) {
    const prevDataLength = datas.length; // Simpan jumlah data sebelum operasi
    console.log(selectedData);
    const tableBody = document.getElementById("productTableBody");
    tableBody.innerHTML = "";

    total = 0;
    discount = 0;
    final_price = 0;

    datas.forEach((product, index) => {
        const productDiscount = product.discount || 0;
        const productTotal = product.amount * product.selling_price;
        const productFinal = calculateTotal(
            product.amount,
            product.selling_price,
            productDiscount
        );

        total += productTotal;
        discount += productTotal - productFinal;
        final_price += productFinal;

        product.final_price = productFinal;
        const details = product.details;

        const discountText = productDiscount ? `${productDiscount}%` : "0%";
        const row = `
                <tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${product.name}</td>
                    <td class="text-center">
                        ${
                            details.length
                                ? `
                        <div class="btn-group" role="group">
                            ${details
                                .map(
                                    (detail) => `
                            <button type="button" class="btn btn-sm btn-outline-primary variant-button ${
                                selectedData && selectedData.id === detail.id
                                    ? " active"
                                    : ""
                            }" data-id="${
                                        detail.id
                                    }" onclick='selectData(${JSON.stringify(
                                        detail
                                    )})'>
                                ${detail.variant}
                            </button>`
                                )
                                .join("")}
                        </div>
                        `
                                : "-"
                        }
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" onclick="decreaseAmount(${index})">-</button>
                            <button type="button" class="btn btn-outline-primary" disabled>${
                                product.amount
                            }</button>
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
        tableBody.insertAdjacentHTML("beforeend", row);
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

function updateSummary() {
    document.getElementById(
        "total-price"
    ).innerText = `Rp. ${total.toLocaleString()}`;
    document.getElementById(
        "total-discount"
    ).innerText = `Rp. ${discount.toLocaleString()}`;
    document.getElementById(
        "final-price"
    ).innerText = `Rp. ${final_price.toLocaleString()}`;
    const paymentInput = document.getElementById("paymentInput");
    const paymentButton = document.getElementById("paymentButton");
    const optionBca = document.getElementById("bca-option");
    const optionMandiri = document.getElementById("mandiri-option");
    if (selectedPaymentMethod === "cash") {
        paymentInput.style.display = "block";
        paymentButton.style.display = "none";
        optionBca.classList.remove("selected");
        optionMandiri.classList.remove("selected");
        bankName = "";
    } else if (selectedPaymentMethod === "qris") {
        paymentInput.style.display = "none";
        paymentButton.style.display = "flex";
    } else {
        paymentInput.style.display = "none";
    }
}

function removeRow(index) {
    datas.splice(index, 1);
    updateTable(datas);
    saveToLocalStorage();
}

function saveToLocalStorage() {
    localStorage.setItem("datas", JSON.stringify(datas));
}

document
    .getElementById("removeAllButton")
    .addEventListener("click", function () {
        datas = [];
        updateTable(datas);
        localStorage.removeItem("datas");
        window.location.reload();
    });

function updateRemoveAllButton() {
    const removeAllButton = document.getElementById("removeAllButton");
    if (datas.length > 0) {
        removeAllButton.style.display = "block";
    } else {
        removeAllButton.style.display = "none";
    }
}

function selectPaymentMethod(method) {
    selectedPaymentMethod = method;
    document.getElementById("cash-option").classList.remove("selected");
    document.getElementById("qris-option").classList.remove("selected");

    if (method === "cash") {
        document.getElementById("cash-option").classList.add("selected");
    } else if (method === "qris") {
        document.getElementById("qris-option").classList.add("selected");
    }
    updateSummary();
}

function selectBank(bank) {
    bankName = bank;
    document.getElementById("bca-option").classList.remove("selected");
    document.getElementById("mandiri-option").classList.remove("selected");

    if (bank === "bca") {
        document.getElementById("bca-option").classList.add("selected");
    } else if (bank === "mandiri") {
        document.getElementById("mandiri-option").classList.add("selected");
    }
    updateSummary();
}

function displayNoDataMessage() {
    const tableBody = document.getElementById("productTableBody");
    tableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
        `;
}

function increaseAmount(index, maxStock) {
    if (datas[index].amount < maxStock) {
        datas[index].amount += 1;
        updateTable(datas);
    } else {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Stok tidak mencukupi!",
        });
    }
}

function decreaseAmount(index) {
    if (datas[index].amount > 1) {
        datas[index].amount -= 1;
    } else {
        Swal.fire({
            icon: "warning",
            title: "Peringatan",
            text: "Jumlah produk tidak boleh kurang dari 1. Anda dapat menghapus produk jika tidak ingin membelinya.",
        });
    }
    updateTable(datas);
    saveToLocalStorage();
}

