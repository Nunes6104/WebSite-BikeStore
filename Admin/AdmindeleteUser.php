<?php
session_start();
// Conexão com a base de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite";
// Verifica se o utilizador está autenticado como administrador
if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@motionbike.pt') {
    // Redireciona para a página de login caso não seja administrador
    header("Location: index.php");
    exit();
}

try {
    // Conexão com a base de dados usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar todos os usuários da tabela 'Login'
    $stmt = $conn->prepare("SELECT idUser, user_Name FROM Login");
    $stmt->execute();
    // Armazenar os usuários
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar se o formulário foi enviado para excluir um usuário
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        // Eliminar o usuário selecionado
        $deleteStmt = $conn->prepare("DELETE FROM Login WHERE idUser = :idUser");
        $deleteStmt->bindParam(':idUser', $user_id);
        $deleteStmt->execute();

        $message = "User with ID: $user_id has been deleted.";
    }

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Delete User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" type="text/css" href="sheetAdmin.css" media="screen"/>
    <style>
        .container {
            max-width: 100%;
            text-align: center;
            background: white;
            border-radius: 5px;
        }

        .select-nav {
            background: rgb(255, 50, 50);
            border-radius: 5px;
        }
    </style>
</head>
<body>
<nav class="navbar bg-body-tertiary d-block">
  <div class="container-fluid">
    <a class="navbar-brand" href="Admin.php">ADMIN DASHBOARD</a>  
    
    <div class="text-end d-flex">
    <button class="btn btn-transparent d-block fs-4" style="text-align: end;" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
    <i class="ph-bold ph-list-dashes"></i> Menu
    </button>
    <a class="btn btn-secundary fs-5" href="/website-bikestore/logout.php" style="text-align: end;">
    <i class="ph-bold ph-users"></i> LogOut
    </a>
    </div>
  </div>
</nav>
<!-- Sidebar responsiva (Offcanvas) para dispositivos móveis -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Admin Panel</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="Admin.php"><i class="ph-fill ph-house"></i> Home</a>
        </li>
        <li class="nav-item select-nav">
            <a class="nav-link" href="Users.php"><i class="ph-fill ph-users"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Bikes.php"><i class="ph-fill ph-bicycle"></i> Bikes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Vendas.php"><i class="ph-fill ph-shopping-cart"></i> Sales</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="FavAdmin.php"><i class="ph-fill ph-heart-straight"></i> Favourites</a>
        </li>
        <li>
            <button id="openEmailBox" class="btn btn-outline-danger"><b>Send a Email</b></button>
        </li>
    </ul>
    </div>
</div>

    <div class="container mt-5">
        <h2>Delete User</h2>

        <!-- Exibição de mensagem de sucesso -->
        <?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Formulário para selecionar e excluir usuário -->
        <form method="POST" action="AdmindeleteUser.php">
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User to Delete</label>
                <select class="form-select" name="user_id" id="user_id" required>
                    <option value="">Select a User</option>
                    <?php foreach ($users as $user) : ?>
                        <option value="<?= htmlspecialchars($user['idUser']) ?>"><?= htmlspecialchars($user['user_Name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Delete User</button>
            <a href="Users.php" class="btn btn-secondary m-3">Back to Admin Panel</a>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>