<?php
session_start();
// Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    // Se não estiver autenticado, redireciona para o login (index.php)
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motion Bikes</title>
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

<!--Carousel-->
<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="2000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner1.jpeg" class="d-block w-100" alt="Imagem 1">
    </div>
    <div class="carousel-item">
      <img src="img/banner2.jpeg" class="d-block w-100" alt="Imagem 2">
    </div>
    <div class="carousel-item">
      <img src="img/banner3.jpeg" class="d-block w-100" alt="Imagem 3">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!--Cards-->
<div class="container">
  <div class="row" style="padding-top: 5%; padding-bottom: 5%;">
    <div class="col-md-4 mb-4">
      <div class="card" style="width: 100%;">
        <img src="https://bhbikes.b-cdn.net/cache/general/fe3c5c/lt805_rcr_n1.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">AERO TT 8.0</h5>
          <p class="card-text">Price: 9.199,90 €</p>
          <a href="BH-AEROTT.php" class="btn btn-primary">Take a Look</a>
        </div>
      </div>
    </div>
 

    <div class="col-md-4 mb-4">
      <div class="card" style="width: 100%;">
        <img src="//us.bmc-switzerland.com/cdn/shop/files/f4e0d977-3c3c-42fd-9e94-1055a15c657f_1800x1800.jpg?v=1731409225" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Kaius 01 THREE</h5>
          <p class="card-text">Price: 6.700,00 €</p>
          <a href="BMC-Kaius.php" class="btn btn-primary">Take a Look</a>
        </div>
      </div>
    </div>

    <div class="col-md-4 mb-4">
      <div class="card" style="width: 100%;">
        <img src="//us.bmc-switzerland.com/cdn/shop/files/f57dd3fa-7204-4d93-b145-7bb155d60430_1800x1800.jpg?v=1702543648" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Alpenchallenge AL ONE</h5>
          <p class="card-text">Price: 2.000,00€</p>
          <a href="BMC-Alpenchallenge.php" class="btn btn-primary">Take a Look</a>
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