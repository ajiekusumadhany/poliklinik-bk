<?php

// Konfigurasi timeout (dalam detik)
$timeout = 7200; // 2 jam

// Pengecekan apakah pengguna sudah login dan session timeout
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php?page=loginUser"); // Redirect ke halaman login jika belum login
    exit;
} else {
    // Periksa apakah ada timestamp aktivitas terakhir
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
        // Jika sudah melewati batas timeout, redirect ke logout.php
        header("Location: logout.php");
        exit;
    }
    // Update timestamp aktivitas terakhir
    $_SESSION['last_activity'] = time();
}
// Regenerasi ID session secara periodik
if (!isset($_SESSION['created'])) {
    $_SESSION['created'] = time();
} else if (time() - $_SESSION['created'] > 7200) {
    session_regenerate_id(true);
    $_SESSION['created'] = time();
}

//hapus data periksa
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    $delete_query = "DELETE FROM periksa WHERE id = ?";
    $delete_stmt = $mysqli->prepare($delete_query);
    
    if ($delete_stmt) {
        $delete_stmt->bind_param("i", $id);
        
        if ($delete_stmt->execute()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Data berhasil dihapus'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal menghapus data: ' . $delete_stmt->error];
        }
        
        $delete_stmt->close();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal menyiapkan query: ' . $mysqli->error];
    }
    
    header('Location: index.php?page=periksa');
    exit;
}

// Cek apakah ada ID yang dikirimkan melalui GET untuk edit
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    $id = (int)$_GET['id']; // Ambil ID dari GET

    // Query untuk mengambil data periksa berdasarkan ID
    $ambil = mysqli_query($mysqli, "SELECT * FROM periksa WHERE id='" . $id . "'");

    // Cek apakah query berhasil
    if ($ambil) {
        $data = mysqli_fetch_assoc($ambil);
        $id_pasien = $data['id_pasien'];
        $id_dokter = $data['id_dokter'];
        $tgl_periksa = $data['tgl_periksa'];
        $catatan = $data['catatan'];
        $obat = $data['obat'];
    } else {
        echo "Error: " . mysqli_error($mysqli); 
    }
}

// Proses penyimpanan atau update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $id_pasien = isset($_POST['id_pasien']) ? $_POST['id_pasien'] : '';
    $id_dokter = isset($_POST['id_dokter']) ? $_POST['id_dokter'] : '';
    $tgl_periksa = isset($_POST['tgl_periksa']) ? $_POST['tgl_periksa'] : '';
    $catatan = isset($_POST['catatan']) ? $_POST['catatan'] : '';
    $obat = isset($_POST['obat']) ? $_POST['obat'] : '';

    // Validasi data
    if (empty($id_pasien) || empty($id_dokter) || empty($tgl_periksa) || empty($catatan) || empty($obat)) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Harap isi semua kolom!'];
    } else {
        // Proses penyimpanan data
        if ($id) {
            // Update
            $sql = "UPDATE periksa SET id_pasien = ?, id_dokter = ?, tgl_periksa = ?, catatan = ?, obat = ? WHERE id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iisssi", $id_pasien, $id_dokter, $tgl_periksa, $catatan, $obat, $id);
        } else {
            // Insert
            $sql = "INSERT INTO periksa (id_pasien, id_dokter, tgl_periksa, catatan, obat) VALUES (?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("iisss", $id_pasien, $id_dokter, $tgl_periksa, $catatan, $obat);
        }

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Data berhasil disimpan'];
        } else {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal menyimpan data: ' . $mysqli->error];
        }
        $stmt->close();
    }
    
    header('Location: index.php?page=periksa');
    exit;
}

// Konfigurasi pagination
$per_page = 5; // Jumlah data per halaman
$page = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
$start = ($page - 1) * $per_page;
$start_number = $start + 1;

// Query untuk mendapatkan total data periksa
$total_query = "SELECT COUNT(*) as total FROM periksa";
$total_result = $mysqli->query($total_query);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];

// Menghitung total halaman
$pages = ceil($total / $per_page);

// Query untuk menampilkan data periksa
$query = "SELECT 
    periksa.id, 
    periksa.id_pasien,
    periksa.id_dokter,
    pasien.nama as nama_pasien, 
    dokter.nama as nama_dokter, 
    DATE_FORMAT(periksa.tgl_periksa, '%Y-%m-%d %H:%i') as tgl_periksa,
    periksa.catatan, 
    periksa.obat 
FROM periksa 
JOIN pasien ON periksa.id_pasien = pasien.id 
JOIN dokter ON periksa.id_dokter = dokter.id 
ORDER BY periksa.tgl_periksa DESC
LIMIT ?, ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("ii", $start, $per_page);
$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Error: " . $mysqli->error);
}

// Query untuk mengambil data pasien
$query_pasien = "SELECT id, nama FROM pasien ORDER BY nama";
$result_pasien = $mysqli->query($query_pasien);

// Query untuk mengambil data dokter
$query_dokter = "SELECT id, nama FROM dokter ORDER BY nama";
$result_dokter = $mysqli->query($query_dokter);

?>    


<div class="container container-periksa">
<button class="mb-3 btn btn-primary" onclick="showPeriksaForm('add', null, '', '', '', '', '');">
  <i class="bi bi-person-plus-fill"></i> Tambah Periksa
</button> 
<div class="table-responsive">
<table class="table table-striped table-hover">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Dokter</th>
                <th>Tanggal Periksa</th>
                <th>Catatan</th>
                <th>Obat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $start_number++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_pasien']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_dokter']) . "</td>";
        echo "<td>" . htmlspecialchars($row['tgl_periksa']) . "</td>";
        echo "<td>" . htmlspecialchars($row['catatan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['obat']) . "</td>";
        echo "<td>
        <button class='btn btn-sm btn-success' onclick='showPeriksaForm(\"edit\", 
    \"" . $row['id'] . "\", 
    \"" . $row['id_pasien'] . "\", 
    \"" . $row['id_dokter'] . "\", 
    \"" . $row['tgl_periksa'] . "\", 
    \"" . addslashes($row['catatan']) . "\", 
    \"" . addslashes($row['obat']) . "\")'><i class='bi bi-pencil-square'></i> Edit</button>
        <button class='btn btn-sm btn-danger' onclick='deletePeriksa(" . $row['id'] . ")'><i class='bi bi-trash-fill'></i> Hapus</button>
    </td>";
    echo "</tr>";
    
    }
    ?>
</tbody>
</table>
</div>
    <!-- Pagination -->
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <!-- Previous button -->
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=dokter&hal=<?php echo $page - 1; ?>" <?php echo ($page <= 1) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Previous</a>
            </li>
            
            <?php
            $start_page = max(1, $page - 1);
            $end_page = min($pages, $start_page + 2);
            
            if ($end_page - $start_page < 2) {
                $start_page = max(1, $end_page - 2);
            }
            
            for ($i = $start_page; $i <= $end_page; $i++) {
            ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=periksa&hal=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
            
            <!-- Next button -->
            <li class="page-item <?php echo ($page >= $pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=periksa&hal=<?php echo $page + 1; ?>" <?php echo ($page >= $pages) ? 'tabindex="-1" aria-disabled="true"' : ''; ?>>Next</a>
            </li>
        </ul>
    </nav>
</div>
<script>
function showPeriksaForm(action, id = null, id_pasien = null, id_dokter = null, tgl_periksa = '', catatan = '', obat = '') {
    const title = action === 'add' ? 'Tambah Data Periksa' : 'Edit Data Periksa';
    const buttonText = action === 'add' ? 'Simpan' : 'Update';
   
    // format tanggal
    let formattedDateTime = '';
    if (tgl_periksa) {
        const [datePart, timePart] = tgl_periksa.split(' ');
        formattedDateTime = `${datePart}T${timePart}`;
    }

    id_pasien = id_pasien || '';
    id_dokter = id_dokter || '';
    tgl_periksa = tgl_periksa || '';
    catatan = catatan || '';
    obat = obat || '';

    if (action === 'edit') {
        const newUrl = `index.php?page=periksa&action=edit&id=${id}`;
        window.history.pushState({ id: id }, '', newUrl);
    }

    Swal.fire({
        title: title,
        html: `
            <form id="periksaForm" method="POST">
                ${action === 'edit' ? `<input type="hidden" name="id" value="${id}">` : ''}
                <select id="id_pasien" name="id_pasien" class="swal2-select" required>
                    <option value="">Pilih Pasien</option>
                    <?php
                    $result_pasien->data_seek(0);
                    while ($row_pasien = $result_pasien->fetch_assoc()) {
                        echo "<option value='" . $row_pasien['id'] . "'>" . htmlspecialchars($row_pasien['nama']) . "</option>";
                    }
                    ?>
                </select>
                <select id="id_dokter" name="id_dokter" class="swal2-select" required>
                    <option value="">Pilih Dokter</option>
                    <?php
                    $result_dokter->data_seek(0);
                    while ($row_dokter = $result_dokter->fetch_assoc()) {
                        echo "<option value='" . $row_dokter['id'] . "'>" . htmlspecialchars($row_dokter['nama']) . "</option>";
                    }
                    ?>
                </select>
                <input type="datetime-local" id="tgl_periksa" name="tgl_periksa" class="swal2-input" value="${formattedDateTime}" required>
                <input type="text" id="catatan" name="catatan" class="swal2-input" value="${catatan}" placeholder="Catatan" required>
                <input type="text" id="obat" name="obat" class="swal2-input" value="${obat}" placeholder="Obat" required>
            </form>
        `,
        showCancelButton: true,
        confirmButtonText: buttonText,
        cancelButtonText: 'Batal',
        focusConfirm: false,
        confirmButtonColor: '#007bff',
        cancelButtonColor: '#6B7280',
        preConfirm: () => {
            const form = document.getElementById('periksaForm');
            if (!form.checkValidity()) {
                Swal.showValidationMessage('Harap isi semua kolom!');
                return false;
            }
            return true;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById('periksaForm');
            form.action = 'index.php?page=periksa';
            form.submit();
        }
    });

    if (action === 'edit') {
        setTimeout(() => {
            document.getElementById('id_pasien').value = id_pasien;
            document.getElementById('id_dokter').value = id_dokter;
        }, 100);
    }
}

    function deletePeriksa(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data periksa akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#007bff',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "index.php?page=periksa&action=delete&id=" + id;
        }
    });
}
<?php
if (isset($_SESSION['flash_message'])) {
    $type = $_SESSION['flash_message']['type'];
    $message = $_SESSION['flash_message']['message'];
    
    $buttonColor = '#3085d6';
    if ($type === 'success') {
        $buttonColor = '#28a745';
    } elseif ($type === 'error') {
        $buttonColor = '#dc3545'; 
    } elseif ($type === 'warning') {
        $buttonColor = '#ffc107'; 
    }
    echo "
    Swal.fire({
        title: '" . ucfirst($type) . "',
        text: '$message',
        icon: '$type',
        confirmButtonColor: '$buttonColor'
    });
    ";

    unset($_SESSION['flash_message']);
}
?>
    </script>