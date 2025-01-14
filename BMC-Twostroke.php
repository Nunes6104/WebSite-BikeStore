<?php
// Dados de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite"; // Nome do banco de dados

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificando a conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$idBike = 11; // Definição fixa do ID Bikes
// Recolhe informação da base de dados
$sql = "SELECT * FROM Bikes WHERE idBike = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idBike);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $bike = $result->fetch_assoc();
} else {
    echo "Bicicleta não encontrada.";
}
$name = $bike['name'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMC Twostroke</title>
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

<div class="row g-0 bg-body-secondary position-relative">
    <div class="col-md-6 mb-md-0 p-md-4">
        <div id="carouselExampleDark" class="carousel carousel-dark slide img-fluid" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="10000">
                    <img src="//us.bmc-switzerland.com/cdn/shop/files/6c91f175-e111-4551-987f-4a57bb72f35e_89bc97f8-d31c-4a1d-8073-39cace07b63c_1800x1800.jpg?v=1700152515" class="d-block w-100 rounded-1" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="2000">
                    <img src="//us.bmc-switzerland.com/cdn/shop/files/6c91f175-e111-4551-987f-4a57bb72f35e_89bc97f8-d31c-4a1d-8073-39cace07b63c_1800x1800.jpg?v=1700152515" class="d-block w-100 rounded-1" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="//us.bmc-switzerland.com/cdn/shop/files/6c91f175-e111-4551-987f-4a57bb72f35e_89bc97f8-d31c-4a1d-8073-39cace07b63c_1800x1800.jpg?v=1700152515" class="d-block w-100 rounded-1" alt="...">
                </div>
            </div>
            <!-- Controles do Carousel -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="col-md-6 p-4 ps-md-0">
        <h3 class="mt-0 mt-2"><?= $name?></h3>

        <div class="d-flex flex-wrap align-items-center gap-4 ms-2 mt-4">
          <div class="price-section">
              <h3><strong>700,00 €</strong></h3>
          </div>
        <!-- Formulário de Adicionar ao Carrinho -->
        <form method="POST" action="Cart.php" class="d-flex flex-column flex-md-row align-items-center gap-2 mb-2">
            <input type="hidden" name="idBike" value="<?= $idBike ?>">

            <!-- Campo para selecionar a quantidade -->
            <input 
                type="number" 
                name="quantidade" 
                value="1" 
                min="1" 
                class="form-control w-auto text-center" 
                style="max-width: 80px;" 
            >

            <!-- Botão de Adicionar ao Carrinho -->
            <button type="submit" class="btn btn-outline-success" name="add_to_cart">
                <i class="ph ph-shopping-cart"></i>ADD TO CART</button>
        </form>

        <!-- Accordion Ajustado -->
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button btn btn-dark focus-ring focus-ring-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Details
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                    <div class="accordion-body overflow-auto">
                        <p><strong>Key Features</strong></p>
                        <p>24" Wheels, 6-11 Years, 120-145cm Wide Range SRAM 1x8 Drivetrain, Ergonomic SDG Cockpit and Saddle High-Volume Kenda Booster 2.4” Tires
                        </p>
                    </div>
                </div>
            <!-- Mais Seções do Accordion -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed btn btn-dark focus-ring focus-ring-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Tecnical Information
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body overflow-auto">
                        <p><strong>Frame</strong></p> 
                        <p>Aerolight Disc ACR Carbon Monocoque</p>
                        <hr>
                        <p><strong>Fork</strong></p>
                        <p>Aerolight, Integrated Tapered Full Carbon 1.5"</p>
                        <hr>
                        <p><strong>Drivetrain</strong></p>  
                        <p><strong>Shifters</strong></p> 
                        <p>Shimano Ultegra DI2 Hydra</p>  
                        <p><strong>Rear Derailleur</strong></p>
                        <p>Shimano Ultegra DI2 8150 12sp</p>
                        <p><strong>Front Derailleur</strong></p>
                        <p>Shimano Ultegra DI2 8150</p>
                        <p><strong>Crankset</strong></p>
                        <p>Shimano Ultegra FCR8100 52/36</p>
                        <p><strong>Cassette</strong></p>
                        <p>Shimano Ultegra 11/34</p>
                        <p><strong>Chain</strong></p>
                        <p>Shimano Ultegra</p>
                        <hr>
                        <p><strong>Brakes</strong></p>
                        <p><strong>Front Brake</strong></p>
                        <p>Shimano Ultegra Hydraulic</p>
                        <p><strong>Rear Brake</strong></p>
                        <p>Shimano Ultegra Hydraulic</p>
                        <hr>
                        <p><strong>Wheelset</strong></p>
                        <p>Vision SC60</p>
                        <hr>
                        <p><strong>Tires</strong></p>
                        <p>Pirelli Pzero Race 700x28</p>
                    </div>
                </div>
            </div>

            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed btn btn-dark focus-ring focus-ring-secondary"
                        type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree"
                        aria-expanded="false" aria-controls="collapseThree">
                        Reviews
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body overflow-auto">
                        <strong>Top Reviews</strong>
                        <p></p>
                        <p>
                            <img width="30" height="30" src="https://img.icons8.com/windows/32/user-male-circle.png"
                                alt="user-male-circle" />
                            <strong>Kevin</strong> : I would say for anyone who is building, definitely look into
                            these gpu's!! The one I brought let me play any game FLAWLESSLY with 0 lag and around
                            200-160 fps which isn’t too shabby considering the monitor I use most has only 144 hz.
                        </p>

                        <hr>
                        <p>
                            <img width="30" height="30" src="https://img.icons8.com/windows/32/user-male-circle.png"
                                alt="user-male-circle" />
                            <strong>Anthony</strong> : fast shipping, i upgraded to this from an Asus phoenix 3050
                            oc and its a world of difference! runs really well, much cooler than my previous gpu.
                            would recommend
                        </p>

                        <hr>
                        <p>
                            <img width="30" height="30" src="https://img.icons8.com/windows/32/user-male-circle.png"
                                alt="user-male-circle" />
                            <strong>LeoFer</strong> : fast shipping, met my expectations fully. I was replacing a
                            2070 card that appeared overwhelmed by newer gaming requirements and was degrading game
                            performance. The change solved my issues as expected. The price was good and delivery on
                            time.
                        </p>

                    </div>
                </div>
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
</body>
</html>