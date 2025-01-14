<?php
session_start();
// PDO connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PHPWebsite"; // Name of the database
try {
    // Create a PDO instance
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions for errors
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // If the connection fails, output the error
    die("Connection failed: " . $e->getMessage());
}
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login
    exit;
}

// Check if the cart is not empty
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $idUser = $_SESSION['user_id'];
        $idBike = $item['idBike'];
        $quantidade = $item['quantidade'];

        // Fetch the price of the bike
        $query = "SELECT price FROM Bikes WHERE IdBike = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$idBike]); // Bind the parameter and execute the query

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $price = $row['price'];
            // Calculate the total price
            $totalPrice = $price * $quantidade;

            // Insert the sale data into the vendas table
            $insert_query = "INSERT INTO vendas (IdUser, IdBike, totalPrice) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->execute([$idUser, $idBike, $totalPrice]); // Execute the insert query
        } else {
            echo "Product not found!";
        }
    }
    // Remove all items from the cart after the sale
    $delete_query = "DELETE FROM cart WHERE IdUser = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->execute([$idUser]); // Execute the delete query
    // Clear the cart in the session
    $_SESSION['cart'] = [];
} else {
    echo "Cart is empty!";
}
// Close the PDO connection (optional as it's automatically closed when the script ends)
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanks for Buying in Motion Bikes</title>
    <link rel="icon" type="image/svg+xml" sizes="40x40" href="img/logo1.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/sheet.css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
    .thank-you-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin : 20px;
        height: 100%;
        background-color: rgb(222, 191, 191);
    }

    .thank-you-box {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        max-width: 500px;
        width: 100%;
    }

    .thank-you-heading {
        font-size: 32px;
        font-weight: bold;
        color: #4CAF50;
        margin-bottom: 20px;
    }

    .thank-you-message {
        font-size: 18px;
        color: #555;
        margin-bottom: 30px;
    }

    .order-button, .continue-shopping-button {
        display: inline-block;
        padding: 12px 25px;
        margin: 10px 5px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .order-button {
        background-color: #007bff;
        color: white;
    }

    .continue-shopping-button {
        background-color: #28a745;
        color: white;
    }

    .order-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .continue-shopping-button:hover {
        background-color: #218838;
        transform: scale(1.05);
    }
    </style>
</head>
<body>
<div class="thank-you-container">
        <div class="thank-you-box">
            <h1 class="thank-you-heading">Thank you for your purchase!</h1>
            <p class="thank-you-message">Your order has been placed successfully, and will be processed soon. You can check your orders in the 'Orders' section.</p>
            <a href="Orders.php" class="order-button">View Orders</a>
            <a href="Main.php" class="continue-shopping-button">Continue Shopping</a>
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