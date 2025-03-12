<?php
session_start(); // Inicia a sessão
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

    // Consulta para obter todos os dados da tabela Login
    $stmt = $conn->prepare("SELECT email FROM Login");
    $stmt->execute();

    // Verifica se há resultados
    $email = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Captura erros de conexão ou execução
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN USERS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" type="text/css" href="sheetAdmin.css" media="screen" />
    <style>
        .select-nav {
            background: rgb(255, 50, 50);
            border-radius: 5px;
        }
    </style>
    </style>
</head>
<body>
<nav class="navbar bg-body-tertiary d-block">
  <div class="container-fluid">
    <a class="navbar-brand" href="Admin.php">ADMIN DASHBOARD</a>
    <a class="btn btn-secundary fs-5" href="/website-bikestore/logout.php">
    <i class="ph-bold ph-users"></i> LogOut
    </a>    
    <button class="btn btn-transparent d-block d-md-none fs-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
    <i class="ph-bold ph-list-dashes"></i> Menu
    </button>
  </div>
</nav>

<!-- Sidebar fixa para telas maiores -->
<div class="sidebar d-none d-md-block">
    <h5>Admin Panel</h5>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link select-nav" href="Admin.php"><i class="ph-fill ph-house"></i> Home</a>
        </li>
        <li class="nav-item">
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
<!-- Sidebar responsiva (Offcanvas) para dispositivos móveis -->
<div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Admin Panel</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link active" href="Admin.php"><i class="ph-fill ph-house"></i> Home</a>
        </li>
        <li class="nav-item">
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

<div class="main-content">
    <h2>Welcome to the Admin Dashboard</h2>
    <p>This dashboard provides access to exclusive functionalities for administrators. Here, you can manage users, bikes, sales, and favourites. Use the menu on the left or the top to navigate between different options.</p>
    <p>With the right tools, you can optimize the user experience, manage platform data, and ensure everything is running smoothly. Take advantage of the admin panel for efficient platform management!</p>
    
    <form id="emailForm">
        <div class="overlay" id="overlay">
            <div class="email-box">
                <button class="closeDel" id="closeEmailBox">✖</button>
                <h2>Send Email</h2>
                <form id="emailForm">
                <label for="to_mail">User Email:</label>
                <select class="form-control" type="email" name="to_mail" id="to_mail" required>
                <?php
                if ($email) {
                    echo "<option><h5>Select Email</h5></option>";
                    foreach ($email as $data) {
                        echo "<option>" . htmlspecialchars($data['email']) . "</option>";
                    }
                } else {
                    echo "<option class='text-center'>Doesn't found users emails</option>";
                }
                ?>
                </select>
                
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" placeholder="Email subject" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

                <input type="submit" id="buttonSend" class="btn btn-info" value="Send Email">
                </form>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript"
  src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script>
emailjs.init('ZZlVPhZOWJwaKD09J')

// Abrir e fechar a caixa de email
const openEmailBox = document.getElementById("openEmailBox");
const closeEmailBox = document.getElementById("closeEmailBox");
const overlay = document.getElementById("overlay");

openEmailBox.addEventListener("click", () => {
    overlay.style.display = "flex";
});

closeEmailBox.addEventListener("click", () => {
    overlay.style.display = "none";
});

const btn = document.getElementById('buttonSend');
document.getElementById('emailForm')
 .addEventListener('submit', function(event) {
   event.preventDefault();

   btn.value = 'Sending...';
   const serviceID = 'service_vtii02o';
   const templateID = 'template_h7vu7zy';

   emailjs.sendForm(serviceID, templateID, this)
    .then(() => {
      btn.value = 'Send Email';
      alert(`Email sent successfully to ${email} !\n\nSubject: ${subject}\nMessage: ${message}`);
    }, (err) => {
      btn.value = 'Send Email';
      alert(JSON.stringify(err));
    });
});
</script>
</body>
</html>
