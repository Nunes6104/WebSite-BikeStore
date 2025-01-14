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
    // Conexão com a base de dados usando PDO
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Atualizar dados do cliente - verifica se o formulário foi enviado com POST
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Apagar a conta
        $stmt = $conn->prepare("DELETE FROM Login WHERE idUser = :idUser");
        $stmt->bindParam(":idUser", $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            // Apaga a sessão e redireciona para a página inicial com alerta
            session_unset();
            session_destroy();
            echo "<script>
                alert('Your account has been deleted.');
                window.location.href = 'index.php';
            </script>";
            exit();
        } else {
            echo "<script>alert('Erro ao apagar a conta.');</script>";
        }
    }
    // Buscar os dados do utilizador
    $stmt = $conn->prepare("SELECT * FROM Login WHERE idUser = :idUser");
    $stmt->bindParam(":idUser", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar se encontrou o utilizador
    if (!$user_data) {
        echo "Erro: Utilizador não encontrado.";
        exit;
    }

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <link rel="icon" type="image/svg+xml" sizes="40x40" href="img/logo1.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/sheet.css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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

<div class="container d-flex justify-content-center">
    <div class="card w-75">
        <div class="card-body">
            <h1>My Account</h1>
            <div class="table-responsive">
                <table class="table table-striped table-bordered mt-4">
                    <tr>
                        <th>First Name</th>
                        <td><?php echo htmlspecialchars($user_data['first_Name']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo htmlspecialchars($user_data['last_Name']); ?></td>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <td><?php echo htmlspecialchars($user_data['user_Name']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($user_data['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Password</th>
                        <td>
                            <div class="password-container d-flex">
                                <input type="password" id="passwordField" value="<?php echo htmlspecialchars($user_data['password']); ?>" class="form-control" readonly>
                                <button type="button" id="togglePassword" class="btn btn-outline-secondary ms-2">Show</button>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo htmlspecialchars($user_data['phone']); ?></td>
                    </tr>
                    <tr>
                        <th>NIF</th>
                        <td><?php echo htmlspecialchars($user_data['nif']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo htmlspecialchars($user_data['dta_Nasc']); ?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?php echo htmlspecialchars($user_data['country']); ?></td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td><?php echo htmlspecialchars($user_data['distric']); ?></td>
                    </tr>
                    <tr>
                        <th>Street</th>
                        <td><?php echo htmlspecialchars($user_data['street']); ?></td>
                    </tr>
                    <tr>
                        <th>Postal Code</th>
                        <td><?php echo htmlspecialchars($user_data['postal_Code']); ?></td>
                    </tr>
                </table>
                <div style="display: flex; justify-content: end;">
                <a href="edit-account.php" class="btn btn-outline-warning m-2"><b>Edit Account</b></a>
                <a href="" class="btn btn-outline-danger m-2 openDelete"><b>Delete Account</b></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="showDelete hidden">
  <div class="topBox">
    <h5 class="title"><b>Delete Account</b></h5>
    <button type="button" class="closeDel" aria-label="Close">✖</button>
  </div>
  <hr>
  <div class="content">
    <div class="content-item text-center">
      <h6>Are you sure you want to delete all your data?</h6>
      <form method="POST" action="">
      <button type="submit" class="btn btn-outline-danger m-2"><b>I Understand</b></button>
      </form>
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

//botão para eliminar conta
const openDelete = document.querySelector('.openDelete');
const showDelete = document.querySelector('.showDelete');
const closeDel = document.querySelector('.closeDel');

openDelete.addEventListener('click', function(){
    showDelete.classList.remove('hidden');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
});

closeDel.addEventListener('click', function(){
    showDelete.classList.add('hidden');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
});
overlay.addEventListener('click', closeDel);
</script>
</body>
</html>
