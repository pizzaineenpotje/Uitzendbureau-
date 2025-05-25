<?php
include "../Includes/Navbar.php";

// Formulierverwerking - wordt alleen uitgevoerd als het formulier is ingediend (POST request)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ontvangt het email en wachtwoord van het formulier
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Zoek gebruiker in de database
    $sql = "SELECT * FROM candidates WHERE email = '$email'";
    //?
    $result = mysqli_query($conn, $sql);

    //?
    if (mysqli_num_rows($result) == 1) {
        //Associatieve array
        $user = mysqli_fetch_assoc($result);
        
        // Verifieer wachtwoord
        if (password_verify($password, $user['password'])) {
            // Start sessie en sla gebruikersgegevens op
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
            
            // Doorverwijzen naar dashboard of homepagina
            header("Location: index.php");
            exit();
        } else {
            echo "Ongeldig wachtwoord";
        }
    } else {
        echo "Geen gebruiker gevonden met dit e-mailadres";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <!-- Meta informatie en titel -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitzendbureau - Inloggen</title>
    
    <!-- CSS bestanden -->
    <link rel="stylesheet" href="../Styles/Main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <!-- Loginformulier met POST method en verwerking in hetzelfde bestand -->
     <!-- waarom als class form? -->
    <form class="form" method="post" action="Login.php">
        <h2 class="text-center mb-4">Inloggen</h2>
        
        <!-- E-mail input -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mailadres</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Wachtwoord input -->
        <div class="mb-3">
            <label for="password" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <!-- Verzendknop -->
        <button type="submit" class="btn btn-primary w-100">Inloggen</button>
        
        <!-- Registratielink -->
        <div class="mt-3 text-center">
            <p>Nog geen account? <a href="Register.php">Registreer hier</a></p>
        </div>
    </form>
</body>
</html>