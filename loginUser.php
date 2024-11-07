<?php

if(isset($_POST['login'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    
    // Query untuk memeriksa user
    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = $mysqli->query($query);

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verifikasi password
        if(password_verify($password, $row['password'])) {
            // Mengatur session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['loggedin'] = true;
            $_SESSION['last_activity'] = time();      

            echo "<script>
            Swal.fire({
                title: 'Login berhasil!',
                text: 'Selamat datang " . $row['username'] . "!',
                icon: 'success',
                iconColor: '#28a745',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'index.php';
                }
            });
            </script>";
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
if (isset($mysqli)) {
    $mysqli->close();
}
?>

<div class="login-container">
    <div class="login-box">
        <h2>Login</h2>
        <?php 
        // Pesan error login
        if(isset($error)) { 
            echo "<div class='alert alert-danger'>$error</div>";
        }
        ?>
        <form method="POST" action="">
            <div class="input-group">
                <div class="username-container">
                    <input type="text" name="username" id="username" placeholder="Username" required>
                    <div class="icon-username">😊</div>
                </div>
            </div>
            <div class="input-group">
                <div class="password-container">
                    <input type="password" name="password" id="password" placeholder="Password" required>
                    <div id="togglePassword">
                        <i class="eye-icon" id="eyeIcon">🙈</i>
                    </div>
                </div>
            </div>
            <button type="submit" name="login" class="login-btn btn btn-primary mt-3">Login</button>
        </form>
        <p class="register">Don't have an account? <a class="text-primary" href="index.php?page=registrasiUser">Register</a></p>
    </div>
</div>