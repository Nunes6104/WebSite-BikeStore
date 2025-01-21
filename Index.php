<?php
session_start(); // Inicia a sessão
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite";
// Inicializar variáveis para mensagens
$error_message = "";

try {
    // Conexão com a base de dados usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Preparar a consulta para evitar SQL Injection
        $stmt = $conn->prepare("SELECT * FROM Login WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            $Login = $stmt->fetch(PDO::FETCH_ASSOC);
            if($email === 'admin@motionbike.pt' && $password === 'Admin1234'){
                $_SESSION['user_email'] = $email;
                $_SESSION['user_password'] = $password;
                header("Location: Admin/Admin.php");
                echo "<script>alert('Welcome to the Admin Dashboard')</script>";
                exit;
            }
            // Verifica a pass
            if ($password === $Login['password']) { 
                // Login bem-sucedido
                $_SESSION['user_id'] = $Login['idUser']; // Salva o ID do utilizador na sessão
                $_SESSION['user_email'] = $Login['email'];
                $_SESSION['user_password'] = $Login['password'];
                header("Location: Main.php");
                exit;
            } else {
                $error_message = "Incorrect Password.";
            }
        } else {
            $error_message = "User not Found.";
        }
    }
} catch (PDOException $e) {
    // Captura erros de conexão ou execução
    die("Erro de conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn Motion Bikes</title>
    <link rel="icon" type="image/svg+xml" sizes="40x40" href="img/logo1.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/sheet.css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark rounded shadow-lg" style="position: fixed; z-index: 100; width: 100%; max-width: 100%">
    <div class="container-fluid">
        <a class="navbar-brand ms-4 d-inline fs-2" href="Main.html">
        <img src="img/logo1.png" alt="Logo" style="max-width: 80px;" class="d-inline-block align-text-center ">
        Motion Bikes
        </a>
    </div>
</nav>
<div class="login-page">
    <div class="loginModal">
        <div class="topBox">
            <h4 class="title">Log In</h4>
            <a href="signIn.php">New Here? Sign In</a>
        </div>
        <hr>
        <div class="content">
            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <div class="contact-item">
                <form id="loginForm" action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </div>
    <video autoplay muted loop>
    <source src="img/background.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
</div>

</body>
</html>