<?php
session_start(); // Inicia a sessão
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite";
// Verifica se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redireciona para o login
    exit;
}
// Obter o ID do utilizador a partir da sessão
$user_id = $_SESSION['user_id'];

try {
    // Conexão com a base de dados utilizando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Habilita o modo de erro
    // Buscar os dados do utilizador
    $stmt = $conn->prepare("SELECT * FROM Login WHERE idUser = ?");
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();
    // Verificar se encontrou o utilizador
    if ($stmt->rowCount() === 1) {
        $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        echo "Erro: Utilizador não encontrado.";
        exit;
    }

    // Atualizar dados do cliente - verifica se o formulário foi enviado com POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Captura os dados enviados pelo formulário
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $userName = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['mobile'];
        $nif = $_POST['nif'];
        $country = $_POST['country'];
        $district = $_POST['district'];
        $street = $_POST['street'];
        $postalCode = $_POST['postalCode'];
        $dob = $_POST['dob'];
        // Atualizar os dados no banco de dados utilizando PDO
        $updateSql = "UPDATE Login SET first_Name = :firstName, last_Name = :lastName, user_Name = :userName, email = :email, password = :password, phone = :phone, nif = :nif, country = :country, distric = :district, street = :street, postal_Code = :postalCode, dta_Nasc = :dob WHERE idUser = :user_id";

        $stmt = $conn->prepare($updateSql);
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':userName', $userName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':nif', $nif);
        $stmt->bindParam(':country', $country);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':postalCode', $postalCode);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "<script>alert('Dados atualizados com sucesso!');</script>";
            // Redirecionar ou mostrar mensagem de sucesso
            header("Location: account.php"); // página de perfil
            exit();
        } else {
            echo "Erro: " . $stmt->errorInfo()[2];
        }
    }

} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
}
$conn = null; // Fecha a conexão com a base de dados
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="icon" type="image/svg+xml" sizes="40x40" href="img/logo1.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/sheet.css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
      .card {
    margin-top: 50px;
    margin-bottom: 50px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.table th, .table td {
    text-align: center;
    color: white;
    background-color: rgba(50, 45, 45, 0.5);
}
h1 {
    margin-top: 20px;
    font-size: 2.5rem;
    text-align: center;
    color: white;
}
.password-container {
    display: flex;
    align-items: center;
    position: relative;
    width: max-content;
}
.password-container input {
    flex: 1;
}
.password-container button {
    margin-left: 5px;
}
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark rounded shadow-lg">
  <div class="container-fluid">
    <a class="navbar-brand ms-4 d-inline fs-2" href="Main.php">
      <img src="img/logo1.png" alt="Logo" style="max-width: 80px;" class="d-inline-block align-text-center ">
      Motion Bikes
    </a>

    <div class="navbar-expand ms-auto me-5">
    <ul class="navbar-nav flex-row">
      <li class="nav-item me-4 fs-4">
        <a class="nav-link" href="Favourites.php">
        <i class="ph ph-heart-straight"></i>
        </a>
      </li>

      <li class="nav-item me-4 fs-4">
        <a class="nav-link" href="cart.php">
          <i class="ph ph-shopping-cart"></i>
        </a>
      </li>
        
      <li class="nav-item dropdown fs-4">
        <a class="nav-link dropdown-toggle fs-4" role="button" data-bs-toggle="dropdown"  aria-expanded="false">
          <i class="ph ph-user"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark">
          <li><a class="dropdown-item fs-5" href="account.php">Account</a></li>
          <li><a class="dropdown-item fs-5" href="Orders.php">Orders</a></li>
          <li><a class="dropdown-item fs-5" href="logout.php">Log Out</a></li>
        </ul>
      </li>
    </ul>
  </div>
    
    <!--MENU BARRA LATERAL-->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-danger" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">MENU</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav">
          <li class="nav-item dropdown p-3">
            <form class="d-flex" role="search">
                <input class="form-control me-2" id="searchInput" type="text" placeholder="Search">
                <button class="btn btn-outline-dark btn-light" type="submit">Search</button>
            </form>
            <ul class="displaySearch" id="results">
                <li><a class="dropdown-item fs-5" href="BH-Bikes.php">BH Bikes</a></li>
                <li><a class="dropdown-item fs-5" href="BH-Aerolight.php">BH Aerolight 7.0</a></li>
                <li><a class="dropdown-item fs-5" href="BH-AEROTT.php">BH AERO TT 8.0</a></li>
                <li><a class="dropdown-item fs-5" href="BH-LYNXRace.php">BH BLYNX RACE LT 7.5</a></li>
                <li><a class="dropdown-item fs-5" href="BH-LYNXTrail.php">BH LYNX TRAIL 9.5</a></li>
                <li><a class="dropdown-item fs-5" href="BH-RS1.php">BH RS1 4.0</a></li>
                <li><a class="dropdown-item fs-5" href="BH-Ultralight.php">BH ULTRALIGHT 9.0</a></li>

                <li><a class="dropdown-item fs-5" href="BMC.php">BMC</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-Alpenchallenge.php">BMC Alpenchallenge AL ONE</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-Kaius.php"> BMC Kaius 01 THREE</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-Speedmachine.php">BMC Speedmachine 01 ONE</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-Teammachine.php">BMC Teammachine R 01 ONE</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-Twostroke.php">BMC Twostroke AL 24</a></li>
                <li><a class="dropdown-item fs-5" href="BMC-URS.php">BMC URS 01 THREE</a></li>

                <li><a class="dropdown-item fs-5" href="Cannondale.php">Cannondale</a></li>
                <li><a class="dropdown-item fs-5" href="Cervelo.php">Cervelo</a></li>
                <li><a class="dropdown-item fs-5" href="Focus.php">Focus</a></li>              
                <li><a class="dropdown-item fs-5" href="Merida.php">Merida</a></li>
                <li><a class="dropdown-item fs-5" href="MMR.php">MMR</a></li>
                <li><a class="dropdown-item fs-5" href="Pinarello.php">Pinarello</a></li>   
                <li><a class="dropdown-item fs-5" href="Scott.php">Scott</a></li>             
                <li><a class="dropdown-item fs-5" href="Specialized.php">Specialized</a></li>

                <li><a class="dropdown-item fs-5" href="about-us.php">About Us</a></li>
                <li><a class="dropdown-item fs-5" href="account.php">Account</a></li>                
                <li><a class="dropdown-item fs-5" href="Cart.php">Cart</a></li>
                <li><a class="dropdown-item fs-5" href="Main.php">Main</a></li>
                <li><a class="dropdown-item fs-5" href="Orders.php">Orders</a></li>
            </ul>
          </li>
          
          <li class="nav-item p-2">
            <a class="nav-link fs-4" href="Best-Sellers.php">Best Sellers</a>
          </li>
          <li class="nav-item dropdown p-2">
            <a class="nav-link dropdown-toggle fs-4" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Brand
            </a>
              <ul class="dropdown-menu dropdown-transparent p-2">
                <li><a class="dropdown-item fs-5" href="Brand.php">All Brands</a></li>
                <li><a class="dropdown-item fs-5" href="BH-Bikes.php">BH Bikes</a></li>
                <li><a class="dropdown-item fs-5" href="BMC.php">BMC</a></li>
                <li><a class="dropdown-item fs-5" href="Cannondale.php">Cannondale</a></li>
                <li><a class="dropdown-item fs-5" href="Cervelo.php">Cervelo</a></li>
                <li><a class="dropdown-item fs-5" href="Focus.php">Focus</a></li>
                <li><a class="dropdown-item fs-5" href="Merida.php">Merida</a></li>
                <li><a class="dropdown-item fs-5" href="MMR.php">MMR</a></li>
                <li><a class="dropdown-item fs-5" href="Pinarello.php">Pinarello</a></li>   
                <li><a class="dropdown-item fs-5" href="Scott.php">Scott</a></li>             
                <li><a class="dropdown-item fs-5" href="Specialized.php">Specialized</a></li>
              </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<div class="container my-5" style="max-width: 100%;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-white">
                    <h2 class="text-center"><b>Edit Account Profile</b></h2>
                    <a href="account.php">Go Back to Account</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user_data['first_Name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user_data['last_Name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user_data['user_Name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-container d-flex">
                            <input type="password" id="passwordField" name="password" value="<?php echo htmlspecialchars($user_data['password']); ?>" class="form-control" required>
                            <button type="button" id="togglePassword" class="btn btn-outline-secondary ms-2">Show</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="mobile" name="mobile" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nif" class="form-label">NIF</label>
                            <input type="text" class="form-control" id="nif" name="nif" value="<?php echo htmlspecialchars($user_data['nif']); ?>" required>
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
                            <input type="text" class="form-control mb-2" name="district" value="<?php echo htmlspecialchars($user_data['distric']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="street" class="form-label">Street</label>
                            <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($user_data['street']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="postalCode" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="postalCode" name="postalCode" value="<?php echo htmlspecialchars($user_data['postal_Code']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="dob" value="<?php echo htmlspecialchars($user_data['dta_Nasc']); ?>" required>
                        </div>

                        <button type="submit" class="btn btn-outline-warning w-100"><b>Update</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<footer> 
  <div class="hstack text-center">
    <div class="vstack fs-5"><strong>Motion Bikes</strong>
      <div class="p-2 fs-6">
        <a class="link-dark link-underline link-underline-opacity-0" href="about-us.php">About Us</a>
      </div>
      <!--Text Box-->
      <div class="p-2 fs-6">
      <div class="overlay hidden"></div>
      <a class="text-dark link-underline link-underline-opacity-0 openModal" href="#">Contacts</a>
      <div class="showBox hidden">
        <div class="topBox">
          <h5 class="title">Contacts</h5>
          <button type="button" class="closeBox" aria-label="Close">✖</button>
        </div>
        <hr>
        <div class="content">
          <div class="contact-item">
            <h5><b>Email:</b></h5>
            <h6>general@motionbikes.com</h6>
          </div>
          <div class="contact-item">
            <h5><b>Phone Number:</b></h5>
            <h6>927 402 094</h6>
          </div>
          <div class="contact-item">
            <hr>
            <a class="link-dark link-underline link-underline-opacity-0 m-2" href="https://www.instagram.com" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 50 50">
                <path d="M 16 3 C 8.83 3 3 8.83 3 16 L 3 34 C 3 41.17 8.83 47 16 47 L 34 47 C 41.17 47 47 41.17 47 34 L 47 16 C 47 8.83 41.17 3 34 3 L 16 3 z M 37 11 C 38.1 11 39 11.9 39 13 C 39 14.1 38.1 15 37 15 C 35.9 15 35 14.1 35 13 C 35 11.9 35.9 11 37 11 z M 25 14 C 31.07 14 36 18.93 36 25 C 36 31.07 31.07 36 25 36 C 18.93 36 14 31.07 14 25 C 14 18.93 18.93 14 25 14 z M 25 16 C 20.04 16 16 20.04 16 25 C 16 29.96 20.04 34 25 34 C 29.96 34 34 29.96 34 25 C 34 20.04 29.96 16 25 16 z">
                </path>
              </svg>
            </a>
            <a class="link-dark link-underline link-underline-opacity-0 m-2" href="https://www.facebook.com" target="_blank">
              <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 50 50">
                <path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z">
                </path>
              </svg>
            </a>
            <a class=" link-dark link-underline-opacity-0 m-2" href="https://www.twitter.com" target="_blank">
              <svg aria-hidden="true" x="0px" y="0px" width="25" height="25" viewBox="0 0 24 24">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
                </path>
              </svg>
            </a>
          </div>
        </div>
      </div>
      </div>

      <div class="p-2 fs-6">
        <a class="link-dark link-underline link-underline-opacity-0" href="WhereWeAre.html">Where we are</a>
      </div>
    </div>

    <div class="vstack fs-5"><strong>Useful links</strong>
      <div class="p-2 fs-6">
        <a class="link-dark link-underline link-underline-opacity-0" href="https://www.instagram.com" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 50 50">
            <path d="M 16 3 C 8.83 3 3 8.83 3 16 L 3 34 C 3 41.17 8.83 47 16 47 L 34 47 C 41.17 47 47 41.17 47 34 L 47 16 C 47 8.83 41.17 3 34 3 L 16 3 z M 37 11 C 38.1 11 39 11.9 39 13 C 39 14.1 38.1 15 37 15 C 35.9 15 35 14.1 35 13 C 35 11.9 35.9 11 37 11 z M 25 14 C 31.07 14 36 18.93 36 25 C 36 31.07 31.07 36 25 36 C 18.93 36 14 31.07 14 25 C 14 18.93 18.93 14 25 14 z M 25 16 C 20.04 16 16 20.04 16 25 C 16 29.96 20.04 34 25 34 C 29.96 34 34 29.96 34 25 C 34 20.04 29.96 16 25 16 z">
            </path>
          </svg>
          Instagram</a>
      </div>
      <div class="p-2 fs-6">
        <a class="link-dark link-underline link-underline-opacity-0" href="https://www.facebook.com" target="_blank">
          <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 50 50">
            <path d="M25,3C12.85,3,3,12.85,3,25c0,11.03,8.125,20.137,18.712,21.728V30.831h-5.443v-5.783h5.443v-3.848 c0-6.371,3.104-9.168,8.399-9.168c2.536,0,3.877,0.188,4.512,0.274v5.048h-3.612c-2.248,0-3.033,2.131-3.033,4.533v3.161h6.588 l-0.894,5.783h-5.694v15.944C38.716,45.318,47,36.137,47,25C47,12.85,37.15,3,25,3z">
            </path>
          </svg>
          Facebook</a>
      </div>
      <div class="p-2 fs-6 me-5">
        <a class=" link-dark link-underline-opacity-0" href="https://www.twitter.com" target="_blank">
          <svg aria-hidden="true" x="0px" y="0px" width="25" height="25" viewBox="0 0 24 24">
            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z">
            </path>
          </svg>
          X</a>
      </div>
    </div>
  </div>

  <div class="text-center">
    <hr>
    <small>© 2024 Cyclone Motion Bikes. All rights reserved. The images shown may not correspond to the product
      specifications in the Portuguese market. Due to technical reasons, the colors presented may differ slightly from
      the actual colors.</small>
  </div>
</footer>
<script src="Js/jsScript.js"></script>
<script>
//botão para alternar a visibilidade da senha
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordField = document.getElementById('passwordField');
    const passwordType = passwordField.type === 'password' ? 'text' : 'password';
    passwordField.type = passwordType;
    
    // Alterar o texto do botão conforme o estado da senha
    this.textContent = passwordType === 'password' ? 'Show' : 'Hide';
});
</script>
</body>
</html>
