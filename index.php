<?php include 'config/database.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Smart Vending Touch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="vending-wrapper">
    <header>
        <h2 class="mb-0 fw-bold"><i class="bi bi-cpu"></i> TECH VENDING MACHINE</h2>
    </header>

    <div class="main-content">
        <div class="product-section">
            <div class="row g-4">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM products");
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)):
                ?>
                <div class="col-md-3 col-sm-6">
                    <div class="card product-card h-100 p-2 text-center" 
                         onclick="pilihProduk(<?= $row['id'] ?>, '<?= htmlspecialchars($row['name']) ?>', <?= $row['price'] ?>, <?= $row['stock'] ?>)">
                        <span class="slot-badge"><?= $row['slot_code'] ?></span>
                        <img src="assets/img/<?= $row['image'] ?>" onerror="this.src='https://via.placeholder.com/150?text=No+Image'">
                        <div class="card-body">
                            <h5 class="fw-bold mb-1"><?= $row['name'] ?></h5>
                            <h4 class="text-primary fw-bold">Rp <?= number_format($row['price'], 0, ',', '.') ?></h4>
                            <small class="text-muted">Tersedia: <?= $row['stock'] ?></small>
                        </div>
                    </div>
                </div>
                <?php endwhile; 
                } else {
                    echo "<div class='alert alert-info'>Belum ada produk. Silakan tambah di Dashboard Admin.</div>";
                } ?>
            </div>
        </div>

        <div class="control-section shadow-lg">
            <h5 class="fw-bold mb-3 text-uppercase">Status Transaksi</h5>
            
            <div class="status-display shadow-inner" id="display-text">
                <div class="animate-pulse">SISTEM SIAP...</div>
                <div class="small mt-2">> Silakan pilih produk di layar kiri</div>
            </div>

            <div id="payment-area" style="display: none;">
                <p class="small text-muted mb-2 text-uppercase fw-bold">Instruksi Pembayaran</p>
                
                <div class="alert alert-warning border-0 py-2 mb-3">
                    <i class="bi bi-qr-code-scan me-2"></i> Scan QR untuk membayar
                </div>
                
                <button type="button" class="btn btn-success w-100 py-3 fw-bold mb-3" onclick="prosesBeli()">
                    KONFIRMASI PEMBAYARAN
                </button>

                <button type="button" class="btn btn-outline-danger w-100 py-2" onclick="resetSistem()">
                    BATALKAN
                </button>
            </div>
            
            <div class="mt-auto pt-3 text-center">
                <a href="admin/index.php" class="text-decoration-none text-muted small">
                    <i class="bi bi-gear-fill"></i> Panel Admin
                </a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalProses" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered text-center">
        <div class="modal-content p-5">
            <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
            <h4>Sedang Memproses...</h4>
            <p class="text-muted">Jangan tinggalkan mesin</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/js/script.js"></script>

</body>
</html>