// 1. LOGIKA FEEDBACK LOGIN
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.querySelector('#loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function() {
            const btn = this.querySelector('button');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
            btn.disabled = true;
        });
    }
});

// 2. LOGIKA VENDING MACHINE (CUSTOMER)
let produkTerpilih = null;

function pilihProduk(id, nama, harga, stok) {
    if (stok <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Maaf...',
            text: 'Stok ' + nama + ' sedang kosong!',
            confirmButtonColor: '#2c3e50'
        });
        return;
    }

    produkTerpilih = { id, nama, harga };
    
    const display = document.getElementById('display-text');
    display.innerHTML = `
        <div class="text-info fw-bold mb-1">PRODUK TERPILIH:</div>
        <div class="fs-5 text-white">${nama}</div>
        <div class="text-warning mt-1">Rp ${harga.toLocaleString('id-ID')}</div>
        <div class="small mt-2 animate-flicker">> Menunggu Pembayaran...</div>
    `;
    
    document.getElementById('payment-area').style.display = 'block';
}

function prosesBeli() {
    if (!produkTerpilih) return;

    const modalElement = document.getElementById('modalProses');
    const modal = new bootstrap.Modal(modalElement);
    modal.show();

    const formData = new URLSearchParams();
    formData.append('product_id', produkTerpilih.id);

    fetch('api/order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        setTimeout(() => {
            modal.hide();
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Pembayaran Sukses!',
                    text: 'Silakan ambil ' + produkTerpilih.name + ' di laci bawah.',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(); 
                });
            } else {
                Swal.fire('Gagal!', data.message, 'error');
            }
        }, 2000);
    })
    .catch(error => {
        modal.hide();
        Swal.fire('Error', 'Gagal menghubungi server', 'error');
    });
}

function resetSistem() {
    location.reload();
}

// 3. LOGIKA ADMIN (EDIT MODAL)
// Fungsi ini harus berada di luar agar bisa dipanggil oleh onclick HTML
function isiModalEdit(data) {
    // Pastikan ID elemen ini (edit_id, dsb) SAMA dengan atribut ID di dashboard.php
    if(document.getElementById('edit_id')) {
        document.getElementById('edit_id').value = data.id;
        document.getElementById('edit_slot').value = data.slot_code;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_price').value = data.price;
        document.getElementById('edit_stock').value = data.stock;
    }
}