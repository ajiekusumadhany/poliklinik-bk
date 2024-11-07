<?php 
session_start();
require_once 'koneksi.php'; 
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yclinic | Memberikan Yang Terbaik untuk Kesehatan Anda</title>
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="d-flex flex-column min-vh-100">
<nav class="navbar navbar-expand-lg position-fixed ">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/logo.png" alt="Logo" width="30" height="30">
            <span class="m-0 ms-2 fw-bold text-primary">Yclinic</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 gap-3 fw-semibold">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data Master
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php?page=dokter">Dokter</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php?page=pasien">Pasien</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=periksa">Periksa</a>
                </li>
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=registrasiUser">Register</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary" href="index.php?page=loginUser">Login</a>
                </li>
                <?php else : ?>
                <li class="nav-item">
                    <a class="btn btn-primary" href="index.php?page=logout">Logout</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


<main role="main" class="container flex-grow-1">
    <?php
    if (isset($_GET['page'])) {
    ?>
        <?php if (!in_array($_GET['page'], ['loginUser', 'registrasiUser'])) : ?>
            <h2 class="judul-page"><?php echo ucwords($_GET['page']) ?></h2>
        <?php endif; ?>
    <?php
        include($_GET['page'] . ".php");
   } else {
    ?>
    <div class="container-lp d-flex flex-column flex-md-row justify-content-center align-items-center">
        <div class="container-left col-12 col-md-6 d-flex flex-column justify-content-center gap-3 mt-4 pt-0 mt-md-5 pt-md-5 p-3 p-md-5 order-2 order-md-1">
            <h2>Poliklinik <span class="text-primary">Terpercaya</span> Untuk Anda!</h2>
            <p>Melayani Anda dengan perawatan medis yang berkualitas, tenaga profesional, dan fasilitas modern. Temukan solusi kesehatan Anda di tempat yang aman dan nyaman.</p>
            <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) : ?>
                <a href="index.php?page=loginUser " class="btn btn-primary btn-login">Login</a>
            <?php else : ?>
                <a href="index.php?page=logout" class="btn btn-primary btn-login">Logout</a>
            <?php endif; ?>
        </div>
        <div class="container-right col-12 col-md-6 d-flex flex-column justify-content-center align-items-center mt-5 pt-5 pb-0 ps-3 pe-3 md-mt-0 md-pt-0 md-pb-0 md-ps-0 md-pe-0 order-1 order-md-2">
            <img src="assets/img/image-lp.svg" alt="dokter image" class="img-fluid">
        </div>
    </div>

    <!-- Layanan Kami -->
    <section class="layanan-kami py-5 mt-5 mt-md-3">
        <div class="container">
            <h2 class="text-center mb-5">Layanan Kami</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Konsultasi Dokter</h5>
                            <p class="card-text">Konsultasikan masalah kesehatan Anda dengan dokter ahli kami.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Pemeriksaan Rutin</h5>
                            <p class="card-text">Lakukan pemeriksaan kesehatan rutin untuk menjaga kesehatan Anda.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Laboratorium</h5>
                            <p class="card-text">Fasilitas laboratorium modern untuk berbagai jenis pemeriksaan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section class="tentang-kami py-5 bg-light">
        <div class="container">
            <div class="row align-items-center d-flex flex-column flex-md-row justify-content-around">
                <div class="col-md-6">
                    <h2 class="mb-4">Tentang <span class="text-primary">Yclinic</span></h2>
                    <p>Yclinic adalah poliklinik terpercaya yang berkomitmen untuk memberikan pelayanan kesehatan terbaik bagi masyarakat. Dengan tim dokter berpengalaman dan fasilitas modern, kami siap membantu Anda mencapai kesehatan optimal.</p>
                </div>
                <div class="img-about-container col-md-6 bg-white p-5 rounded mt-5 mt-md-0">
                    <img src="assets/img/logo.png" alt="Tentang Yclinic" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

<!-- Kontak -->
<section class="kontak py-5">
    <div class="container">
        <h2 class="text-center mb-5">Hubungi Kami</h2>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form id="kontakForm" onsubmit="kirimPesan(event)">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="nama" placeholder="Nama Anda" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Email Anda" required>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="pesan" rows="5" placeholder="Pesan Anda" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Kirim Pesan WhatsApp</button>
                </form>
            </div>
        </div>
    </div>
</section>
    <?php
}
?>
</main>
<!-- Footer -->
<footer class="text-light py-4 mt-5 p-3">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/logo.png" alt="Logo" width="30" height="30">
            <span class="m-0 ms-2 fw-bold text-primary fs-4">Yclinic</span>
        </a>
                <p class="mt-3">Memberikan Yang Terbaik untuk Kesehatan Anda</p>
                <div class="d-flex">
                    <a href="https://www.facebook.com/" class="text-light me-3"><i class="bi bi-facebook"></i></a>
                    <a href="https://twitter.com/" class="text-light me-3"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.instagram.com/" class="text-light me-3"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.linkedin.com/" class="text-light"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5>More Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-light">Home</a></li>
                    <li><a href="index.php?page=dokter" class="text-light">Dokter</a></li>
                    <li><a href="index.php?page=pasien" class="text-light">Pasien</a></li>
                    <li><a href="index.php?page=periksa" class="text-light">Periksa</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Hubungi Kami</h5>
                <address>
                    <p><i class="bi bi-geo-alt-fill me-2"></i> Jl. Nakula No. 123, Semarang, Indonesia</p>
                    <p><i class="bi bi-telephone-fill me-2"></i> (123) 456-7890</p>
                    <p><i class="bi bi-envelope-fill me-2"></i> info@yclinic.com</p>
                </address>
            </div>
        </div>
    </div>
</footer>
<hr class="pembatas-footer m-0 p-0"/>
<div class="copyright text-center text-light py-3">
    <small>&copy; <?php echo date('Y'); ?> Yclinic. All rights reserved.</small>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js
"></script>
<script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("password");
    const eyeIcon = document.getElementById("eyeIcon");
  
    if (passwordInput.type === "password") {
      passwordInput.type = "text"; 
      eyeIcon.textContent = "👁️"; 
    } else {
      passwordInput.type = "password"; 
      eyeIcon.textContent = "🙈"; 
    }
  });
  
  document.getElementById("toggleKonfirmasiPassword").addEventListener("click", function () {
    const konfirmasiPasswordInput = document.getElementById("password-konfirmasi");
    const eyeIconKonfirmasi = document.getElementById("eyeIconKonfirmasi");
  
    if (konfirmasiPasswordInput.type === "password") {
      konfirmasiPasswordInput.type = "text"; 
      eyeIconKonfirmasi.textContent = "👁️"; 
    } else {
      konfirmasiPasswordInput.type = "password"; 
      eyeIconKonfirmasi.textContent = "🙈"; 
    }
  });
  
  
  function kirimPesan(e) {
    e.preventDefault();
    
    const nama = document.getElementById('nama').value;
    const email = document.getElementById('email').value;
    const pesan = document.getElementById('pesan').value;
    
    const nomorWhatsApp = '6282241929544';

    const pesanTemplate = `Halo, saya ingin berkonsultasi
    
    Nama: ${nama}
    Email: ${email}
    Pesan: ${pesan}`;
    
    const pesanEncoded = encodeURIComponent(pesanTemplate);
    
    const urlWhatsApp = `https://wa.me/${nomorWhatsApp}?text=${pesanEncoded}`;
    
    // Tampilkan konfirmasi sebelum mengirim
    Swal.fire({
        title: 'Kirim pesan via WhatsApp?',
        text: "Anda akan diarahkan ke WhatsApp",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Kirim!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.open(urlWhatsApp, '_blank');
            
            document.getElementById('kontakForm').reset();
            Swal.fire({
                title: 'Berhasil!',
                text: 'Silakan lanjutkan di WhatsApp',
                icon: 'success',
                confirmButtonColor: '#28a745'
            });
        }
    });
}

</script>
</body>
</html>

