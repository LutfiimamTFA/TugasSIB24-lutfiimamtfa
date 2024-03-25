<?php
session_start();

// Koneksi ke database (sesuaikan dengan pengaturan database Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'phpcrud';

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk memeriksa login
function login($username, $password, $koneksi) {
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);
    if (mysqli_num_rows($result) == 1) {
        return true;
    } else {
        return false;
    }
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (login($username, $password, $koneksi)) {
        $_SESSION['username'] = $username;
        header("Location: read.php"); // Redirect ke halaman CRUD setelah login berhasil
    } else {
        $error = "Username atau password salah.";
    }
}

// Proses logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php"); // Redirect ke halaman login setelah logout
}

mysqli_close($koneksi);
?>

<!-- Form login -->
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Memasukkan library Font Awesome -->
    <style>
        /* CSS untuk layout responsif menggunakan CSS Grid */

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-image: url('gambarlogin.avif'); /* Latar belakang dengan foto */
            background-size: cover;
            background-position: center;
        }

        .container {
            width: 400px;
            padding: 20px;
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.7); /* Transparan */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }

        .container h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px); /* Sesuaikan lebar input dengan margin */
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
            padding-left: 35px; /* Tambahkan padding untuk ikon */
            background-position: 10px center; /* Letakkan ikon di sebelah kiri input */
            background-repeat: no-repeat;
        }

        input[type="text"] {
            background-image: url('username-icon.png'); /* Tambahkan ikon untuk username */
        }

        input[type="password"] {
            background-image: url('password-icon.png'); /* Tambahkan ikon untuk password */
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username"><i class="fas fa-user"></i> Username:</label><br> <!-- Tambahkan ikon Font Awesome untuk username -->
            <input type="text" id="username" name="username" required><br>
            <label for="password"><i class="fas fa-lock"></i> Password:</label><br> <!-- Tambahkan ikon Font Awesome untuk password -->
            <input type="password" id="password" name="password" required><br><br>
            <input type="submit" value="Login">
        </form>
        <?php if (isset($error)) echo '<div class="error">' . $error . '</div>'; ?>
    </div>
</body>
</html>


