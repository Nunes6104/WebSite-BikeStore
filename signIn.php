<?php
// Conexão com a base de dados
$servername = "localhost";
$username = "root";
$password = ""; // Substituir pela password da base de dados
$dbname = "PHPWebsite"; // Nome da base de dados

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $dtaNasc = $_POST['dob'];
    
    // Verificar se o email ou username já existe
    $checkSql = "SELECT * FROM Login WHERE email = '$email' OR user_Name = '$userName'";
    $result = $conn->query($checkSql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Este email ou nome de usuário já existe.');</script>";
    } else {
        // Inserir os dados na tabela Login
        $sql = "INSERT INTO Login (first_Name, last_Name, user_Name, email, password, phone, nif, country, distric, street, postal_Code, dta_Nasc) 
                VALUES ('$firstName', '$lastName', '$userName', '$email', '$password', '$phone', '$nif', '$country', '$district', '$street', '$postalCode', '$dtaNasc')";

        if ($conn->query($sql) === TRUE) {
            // Redirecionar para a mesma página ou outra página após o registo
            header("Location: index.php");
            exit(); // Garantir que o código após o redirecionamento não seja executado
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SignIn MotionBikes</title>
    <link rel="icon" type="image/svg+xml" sizes="40x40" href="img/logo1.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="Style/sheetSign.css" media="screen" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark rounded shadow-lg">
    <div class="container-fluid">
        <a class="navbar-brand ms-4 d-inline fs-2" href="">
            <img src="img/logo1.png" alt="Logo" style="max-width: 80px;" class="d-inline-block align-text-center ">
            Motion Bikes
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-danger text-white">
                    <h4>Sign In</h4>
                    <a href="Index.php">Already Has a Account</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <!-- First Name and Last Name -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name" required>
                            </div>
                        </div>

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label passwordver">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
                            <!-- Aviso de senha abaixo -->
                            <span id="passwordWarning" style="color: red; display: none;">Password must be at least 8 characters long.</span>
                        </div>

                        <!-- Mobile and Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter your mobile number" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <div class="row">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <input type="text" class="form-control mb-2" name="district" placeholder="District" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control mb-2" name="postalCode" placeholder="Postal Code" required>
                                </div>
                            </div>
                            <input type="text" class="form-control" name="street" placeholder="Street" required>
                        </div>

                        <!-- Age and NIF -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="col-md-6">
                                <label for="nif" class="form-label">NIF</label>
                                <input type="number" class="form-control" id="nif" name="nif" placeholder="Enter your NIF" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-danger" id="submitButton" disabled>Sign In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const form = document.getElementById('loginForm');
    const passwordInput = document.getElementById('password');
    const passwordWarning = document.getElementById('passwordWarning');

    passwordInput.addEventListener('input', function() {
            if (passwordInput.value.length < 8) {
                passwordWarning.style.display = 'inline'; // Exibir aviso
            } else {
                passwordWarning.style.display = 'none'; // Esconder aviso
            }
    });
    // Função para verificar se todos os campos obrigatórios estão preenchidos
    function checkForm() {
        var inputs = document.querySelectorAll('input[required]');
        var submitButton = document.getElementById('submitButton');
        
        // Verifica se todos os campos obrigatórios estão preenchidos
        var allFilled = Array.from(inputs).every(function(input) {
            return input.value.trim() !== '';
        });

        // Se todos os campos estiverem preenchidos, habilita o botão; caso contrário, desativa
        submitButton.disabled = !allFilled;
    }

    // Adiciona eventos de 'input' para todos os campos obrigatórios
    window.onload = function() {
        var inputs = document.querySelectorAll('input[required]');
        
        inputs.forEach(function(input) {
            input.addEventListener('input', checkForm);  // Chama a função sempre que o valor mudar
        });
        
        checkForm();  // Verifica inicialmente se o botão deve ser ativado
    };
</script>
</body>
</html>
