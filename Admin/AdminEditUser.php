<?php
session_start();

// Conexão com a base de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite";

if (!isset($_SESSION['user_email']) || $_SESSION['user_email'] !== 'admin@motionbike.pt') {
    header("Location: index.php");
    exit();
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obter todos os utilizadores
    $stmt = $conn->prepare("SELECT * FROM Login");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $selectedUser = null;

    // Verificar se o utilizador foi selecionado
    if (isset($_POST['user_id']) && $_POST['user_id'] !== '') {
        $selectedUserId = $_POST['user_id'];

        // Obter os dados do utilizador selecionado
        $stmt = $conn->prepare("SELECT * FROM Login WHERE idUser = :user_id");
        $stmt->bindParam(':user_id', $selectedUserId, PDO::PARAM_INT);
        $stmt->execute();
        $selectedUser = $stmt->fetch(PDO::FETCH_ASSOC);

        // Atualizar dados do utilizador
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['firstName'])) {
            $updateSql = "UPDATE Login SET 
                first_Name = :firstName, 
                last_Name = :lastName, 
                user_Name = :userName, 
                email = :email, 
                password = :password, 
                phone = :phone, 
                nif = :nif, 
                country = :country, 
                distric = :district, 
                street = :street, 
                postal_Code = :postalCode, 
                dta_Nasc = :dob 
                WHERE idUser = :user_id";

            $stmt = $conn->prepare($updateSql);
            $stmt->bindParam(':firstName', $_POST['firstName']);
            $stmt->bindParam(':lastName', $_POST['lastName']);
            $stmt->bindParam(':userName', $_POST['username']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':password', $_POST['password']);
            $stmt->bindParam(':phone', $_POST['mobile']);
            $stmt->bindParam(':nif', $_POST['nif']);
            $stmt->bindParam(':country', $_POST['country']);
            $stmt->bindParam(':district', $_POST['district']);
            $stmt->bindParam(':street', $_POST['street']);
            $stmt->bindParam(':postalCode', $_POST['postalCode']);
            $stmt->bindParam(':dob', $_POST['dob']);
            $stmt->bindParam(':user_id', $selectedUserId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<script>alert('Dados atualizados com sucesso!');</script>";
                header("Location: AdminEditUser.php");
                exit();
            } else {
                echo "Erro: " . $stmt->errorInfo()[2];
            }
        }
    }
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN Edit User</title>
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
        <h2>Edit User</h2>
        <!-- Exibição de mensagem de sucesso -->
        <?php if (isset($message)) : ?>
            <div class="alert alert-success" role="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Formulário para selecionar e excluir usuário -->
        <form method="POST" action="AdminEditUser.php">
            <div class="m-3">
                <label for="user_id" class="form-label">Select User</label>
                <select class="form-select" name="user_id" id="user_id" onchange="this.form.submit()">
                    <option value="">Select a User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= htmlspecialchars($user['idUser']) ?>" <?= isset($selectedUserId) && $selectedUserId == $user['idUser'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['user_Name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Preencher os dados do utilizador para edição -->
            <?php if ($selectedUser): ?>
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($selectedUser['first_Name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($selectedUser['last_Name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($selectedUser['user_Name']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($selectedUser['email']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="password-container d-flex">
                    <input type="password" id="passwordField" name="password" value="<?php echo htmlspecialchars($selectedUser['password']); ?>" class="form-control" required>
                    <button type="button" id="togglePassword" class="btn btn-outline-secondary ms-2">Show</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">Phone</label>
                    <input type="tel" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($selectedUser['phone']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="nif" class="form-label">NIF</label>
                    <input type="text" class="form-control" id="nif" name="nif" value="<?php echo htmlspecialchars($selectedUser['nif']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="country" class="form-label">Country</label>
                    <select class="form-control mb-2" name="country" required>
                        <option value="">Select a country</option>
                        <option value="Albânia">Albânia</option>
                        <option value="Alemanha">Alemanha</option>
                        <option value="Andorra">Andorra</option>
                        <option value="Áustria">Áustria</option>
                        <option value="Bélgica">Bélgica</option>
                        <option value="Bielorrússia">Bielorrússia</option>
                        <option value="Bósnia e Herzegovina">Bósnia e Herzegovina</option>
                        <option value="Bulgária">Bulgária</option>
                        <option value="Chipre">Chipre</option>
                        <option value="Croácia">Croácia</option>
                        <option value="Dinamarca">Dinamarca</option>
                        <option value="Eslováquia">Eslováquia</option>
                        <option value="Eslovénia">Eslovénia</option>
                        <option value="Espanha">Espanha</option>
                        <option value="Estónia">Estónia</option>
                        <option value="Finlândia">Finlândia</option>
                        <option value="França">França</option>
                        <option value="Grécia">Grécia</option>
                        <option value="Hungria">Hungria</option>
                        <option value="Irlanda">Irlanda</option>
                        <option value="Islândia">Islândia</option>
                        <option value="Itália">Itália</option>
                        <option value="Kosovo">Kosovo</option>
                        <option value="Letónia">Letónia</option>
                        <option value="Liechtenstein">Liechtenstein</option>
                        <option value="Lituânia">Lituânia</option>
                        <option value="Luxemburgo">Luxemburgo</option>
                        <option value="Macedónia do Norte">Macedónia do Norte</option>
                        <option value="Malta">Malta</option>
                        <option value="Moldávia">Moldávia</option>
                        <option value="Mónaco">Mónaco</option>
                        <option value="Montenegro">Montenegro</option>
                        <option value="Noruega">Noruega</option>
                        <option value="Países Baixos">Países Baixos</option>
                        <option value="Polónia">Polónia</option>
                        <option value="Portugal">Portugal</option>
                        <option value="Reino Unido">Reino Unido</option>
                        <option value="República Checa">República Checa</option>
                        <option value="Roménia">Roménia</option>
                        <option value="Rússia">Rússia</option>
                        <option value="San Marino">San Marino</option>
                        <option value="Sérvia">Sérvia</option>
                        <option value="Suécia">Suécia</option>
                        <option value="Suíça">Suíça</option>
                        <option value="Turquia">Turquia</option>
                        <option value="Ucrânia">Ucrânia</option>
                        <option value="Vaticano">Vaticano</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="district" class="form-label">District</label>
                    <input type="text" class="form-control mb-2" name="district" value="<?php echo htmlspecialchars($selectedUser['distric']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($selectedUser['street']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="postalCode" class="form-label">Postal Code</label>
                    <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($selectedUser['postal_Code']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($selectedUser['dta_Nasc']); ?>" required>
                </div>

                <button type="submit" class="btn btn-danger">Edit User</button>
                <a href="Users.php" class="btn btn-secondary m-3">Back to Admin Panel</a>
            <?php endif; ?>
        </form>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>