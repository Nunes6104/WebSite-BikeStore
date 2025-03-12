<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $userId = intval($_POST['user_id']); // Sanitizar o input

    // Conexão com a base de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "PHPWebsite";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Buscar os detalhes do utilizador
        $stmt = $conn->prepare("SELECT * FROM Login WHERE idUser = :id");
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userDetails) {
            echo "<table class='table table-bordered'>";
                echo "<tr><th>ID</th><td>" . htmlspecialchars($userDetails['idUser']) . "</td></tr>";
                echo "<tr><th>First Name</th><td>" . htmlspecialchars($userDetails['first_Name']) . "</td></tr>";
                echo "<tr><th>Username</th><td>" . htmlspecialchars($userDetails['last_Name']) . "</td></tr>";
                echo "<tr><th>Username</th><td>" . htmlspecialchars($userDetails['user_Name']) . "</td></tr>";
                echo "<tr><th>Email</th><td>" . htmlspecialchars($userDetails['email']) . "</td></tr>";
                echo "<tr><th>Phone</th><td>" . htmlspecialchars($userDetails['phone']) . "</td></tr>";
                echo "<tr><th>NIF</th><td>" . htmlspecialchars($userDetails['nif']) . "</td></tr>";
                echo "<tr><th>Country</th><td>" . htmlspecialchars($userDetails['country']) . "</td></tr>";
                echo "<tr><th>District</th><td>" . htmlspecialchars($userDetails['distric']) . "</td></tr>";
                echo "<tr><th>Street</th><td>" . htmlspecialchars($userDetails['street']) . "</td></tr>";
                echo "<tr><th>Postal Code</th><td>" . htmlspecialchars($userDetails['postal_Code']) . "</td></tr>";
                echo "<tr><th>Data of Birth</th><td>" . htmlspecialchars($userDetails['dta_Nasc']) . "</td></tr>";
                echo "<tr><th>Date of Creation</th><td>" . htmlspecialchars($userDetails['dta_Create']) . "</td></tr>";
            echo "</table>";
        } else {
            echo "<p class='text-danger'>No Data Found</p>";
        }
    } catch (PDOException $e) {
        echo "<p class='text-danger'>Erro: " . $e->getMessage() . "</p>";
    }
}
?>
