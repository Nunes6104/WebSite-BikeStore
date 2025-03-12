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
    $stmt = $conn->prepare("SELECT * FROM Login");
    $stmt->execute();

    // Verifica se há resultados
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <title>ADMIN User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

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

        body {
    font-family: Arial, sans-serif;
    background-color:rgb(255, 50, 50);
    color: #333;
}

/* Sidebar fixa para telas maiores */
.sidebar {
    position: fixed;
    left: 0;
    height: 100%;
    width: 15%;
    background-color: #343a40;
    color: white;
    box-shadow: 0px 5px 5px 10px rgb(0,0,0,0.1);
    padding: 20px;
    overflow-y: auto;
}

h5 {
    color: rgb(255, 50, 50);
    text-align: center;
    font-weight: bold;
    font-size: 25px;
}

h2 {
    font-size: 35px;
    font-weight: bold;
    color: #333;
}

.sidebar .nav-link {
    color: #ccc;
    font-weight: bold;
    margin: 10px 0;
}

.sidebar .nav-link:hover {
    color: rgb(255, 50, 50);
}

/* Ajusta o conteúdo principal */
.main-content {
    text-align: center;
    max-width: 100%;
    margin-left: 15%;
    padding: 20px;
    font-size: 20px;
}

.offcanvas {
    background-color: #343a40;
    color: white;
}

.offcanvas-body .nav-link {
    font-size: 25px;
    color: #ccc;
    font-weight: bold;
    margin: 10px 0;
}

.offcanvas-body .nav-link:hover {
    color: rgb(255, 50, 50);
}

table {
    width: 100%;
    table-layout: fixed; /* Garante que as células terão um layout fixo */
}

table td {
    word-wrap: break-word; /* Quebra palavras longas para que não ultrapassem os limites da célula */
    overflow: auto; /* Adiciona barra de rolagem quando o conteúdo excede o limite da célula */
    max-width: 150px; /* Define a largura máxima da célula */
    max-height: 50px; /* Define a altura máxima da célula */
    white-space: nowrap; /* Impede quebras de linha dentro da célula */
}

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

.overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.5);
  display: none;
  justify-content: center;
  align-items: center;
}

.email-box {
  background: #fff;
  width: 400px;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.email-box h2 {
  margin-top: 0;
  font-size: 20px;
  color: #333;
}

.email-box label {
  font-size: 14px;
  color: #555;
}

.email-box input, .email-box textarea {
  width: 100%;
  padding: 10px;
  margin: 10px 0;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 14px;
}

.email-box textarea {
  height: 100px;
  resize: none;
}

.closeDel {
    background-color: transparent;
    border: none;
    font-size: 1.5rem;
    color: #f00;
    cursor: pointer;
    transition: color 0.3s ease;
    float: right;
}
.closeDel:hover {
    color: #c00;
}

/* Sidebar responsiva para dispositivos móveis */
@media (max-width: 768px) {
    .sidebar {
        display: none;
    }

    .main-content {
        margin-left: 0;
    }
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
    <h2 class="mb-4">Users List</h2>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fisrt Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>País</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($users): ?>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['idUser']); ?></td>
                <td><?php echo htmlspecialchars($user['first_Name']); ?></td>
                <td><?php echo htmlspecialchars($user['last_Name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['country']); ?></td>
                <td>
                    <button class="btn btn-secundary btn-sm details-btn" data-id="<?php echo htmlspecialchars($user['idUser']); ?>">+ details</button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="5" class="text-center">No Users</td></tr>
    <?php endif; ?>
    </tbody>
</table>

    <!--Mais detalhes-->
    <!-- Modal do Bootstrap -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="user-details-content"></div> <!-- Aqui serão mostrados os detalhes -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


    <!--<table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>User Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Phone</th>
                <th>NIF</th>
                <th>Country</th>
                <th>District</th>
                <th>Street</th>
                <th>Postal Code</th>
                <th>Date of Birth</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>-->
    <a class="btn btn-success m-2" href="/WebSite-BikeStore/signIn.php">Add User</a>
    <a class="btn btn-warning text-light m-2" href="AdminEditUser.php">Edit User</a>
    <a class="btn btn-danger m-2" href="AdmindeleteUser.php">Remove User</a>

<!--PopUp Eliminar-->

<!--Email Form-->
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
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

$(document).ready(function () {
    $('#myTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/Portuguese.json"
        }
    });
});

$(document).ready(function () {
    $(".details-btn").click(function () {
        var userId = $(this).data("id"); // Obtém o ID do utilizador

        $.ajax({
            type: "POST",
            url: "get_user_details.php",
            data: { user_id: userId },
            success: function (response) {
                $("#user-details-content").html(response); // Insere os detalhes no modal
                $("#userDetailsModal").modal("show"); // Abre o modal do Bootstrap
            },
            error: function () {
                alert("Erro ao buscar detalhes do utilizador.");
            }
        });
    });
});

</script>
</body>
</html>