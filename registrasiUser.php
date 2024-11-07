<?php
require_once 'koneksi.php';

$error_message = '';
$success_message = 'User berhasil ditambahkan!';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error_message = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error_message = "Password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $check_query = "SELECT * FROM user WHERE username = ?";
        $check_stmt = $mysqli->prepare($check_query);
        $check_stmt->bind_param("s", $username);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Username sudah digunakan!";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user baru
            $insert_query = "INSERT INTO user (username, password) VALUES (?, ?)";
            $insert_stmt = $mysqli->prepare($insert_query);
            $insert_stmt->bind_param("ss", $username, $hashed_password);

            if ($insert_stmt->execute()) {
                echo "<script>
                Swal.fire({
                    title: 'Selamat!',
                    text: '$success_message',
                    icon: 'success',
                    iconColor: '#28a745',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'index.php?page=loginUser';
                    }
                });
                </script>";
            } else {
                $error_message = "Error: " . $insert_stmt->error;
            }

            $insert_stmt->close();
        }

        $check_stmt->close();
    }
}

$mysqli->close();
?>

<div class="register-container">
    <div class="register-box">
        <h2>Register</h2>
        <?php
        if (!empty($error_message)) {
            echo "<div class='alert alert-danger'>" . $error_message . "</div>";
        }
        ?>
        <form method="POST" onsubmit="return validateForm()">
            <div class="input-group">
                <div class="username-container">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <div class="icon-username">😊</div>
                </div>
            </div>
            <div class="input-group">
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required/>
                    <div id="togglePassword">
                        <i class="eye-icon" id="eyeIcon">🙈</i>
                    </div>
                </div>
            </div>
            <div class="input-group">
                <div class="password-container">
                    <input type="password" name="confirm_password" id="password-konfirmasi" placeholder="Konfirmasi Password" required/>
                    <div id="toggleKonfirmasiPassword">
                        <i class="eye-icon" id="eyeIconKonfirmasi">🙈</i>
                    </div>
                </div>
            </div>

            <button type="submit" class="register-btn btn btn-primary mt-3">Register</button>
        </form>
        <p class="login">Already have an account? <a class="text-primary" href="index.php?page=loginUser">Login</a></p>
    </div>
</div>
