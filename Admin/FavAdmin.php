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

    // Consulta para obter todos os dados da tabela Vendas
    $stmt = $conn->prepare("SELECT f.idFav,
                                          l.user_Name,
                                          b.name AS nameBike
                                   FROM favourites f
                                   JOIN Login l on f.idUser = l.idUser
                                   JOIN Bikes b on f.idBike = b.idBike");
    $stmt->execute();
    // Verifica se há resultados
    $fav = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Captura erros de conexão ou execução
    die("Error: " . $e->getMessage());
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
    <title>ADMIN Bike</title>
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
        <li class="nav-item">
            <a class="nav-link" href="Users.php"><i class="ph-fill ph-users"></i> Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Bikes.php"><i class="ph-fill ph-bicycle"></i> Bikes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="Vendas.php"><i class="ph-fill ph-shopping-cart"></i> Sales</a>
        </li>
        <li class="nav-item select-nav">
            <a class="nav-link" href="FavAdmin.php"><i class="ph-fill ph-heart-straight"></i> Favourites</a>
        </li>
        <li>
            <button id="openEmailBox" class="btn btn-outline-danger"><b>Send a Email</b></button>
        </li>
    </ul>
    </div>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Favourites List</h2>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User Name</th>
                <th>Bike Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($fav) {
                foreach ($fav as $favourites) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($favourites['idFav']) . "</td>";
                        echo "<td>" . htmlspecialchars($favourites['user_Name']) . "</td>";
                        echo "<td>" . htmlspecialchars($favourites['nameBike']) . "</td>";
                        echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='14' class='text-center'>No users found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <a class="btn btn-warning text-light m-2">Edit Bike</a>
    <a class="btn btn-danger m-2">Remove Bike</a>

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