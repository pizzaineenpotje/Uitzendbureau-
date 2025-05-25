<?php
include "../Includes/Init.php";


if (isset($_POST['logout'])) {
    // Maak de hele $_SESSION array leeg
    $_SESSION = array();
    // Dit verwijdert alle gegevens aan de serverkant
    session_destroy();

    header("Location: ../Pages/Login.php");
    exit; // Stop verdere uitvoering van de code
}
?>

<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../styles/Navbar.css">
</head>

<body>
    <!-- Navigatiebalk -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <!-- Titel/logo van het uitzendbureau -->
            <a class="navbar-brand" href="#">Uitzendbureau</a>

            <!-- Knop voor mobiele weergave om menu in/uit te klappen -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Inhoud van de navigatiebalk -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <div class="navbar-nav">
                    <!-- Navigatielinks met actieve stijl op basis van huidige pagina -->

                    <!-- Home -->
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"
                        href="../Pages/index.php">Home</a>

                    <!-- Skill toevoegen -->
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'Add_skill.php' ? 'active' : '' ?>"
                        href="../Pages/Add_skill.php">Skill toevoegen</a>

                    <!-- Profiel -->
                    <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'Profile.php' ? 'active' : '' ?>"
                        href="../Pages/Profile.php">Profiel</a>

                    <!-- Inloggen/uitloggen -->
                    <?php if (isset($_SESSION['user_id'])): ?>

                        <form method="post" class="nav-item">
                            <button type="submit" name="logout" class="nav-link logout-btn"
                                style="background: none; border: none; cursor: pointer;">Uitloggen</button>
                        </form>

                    <?php else: ?>
                        <!-- Als gebruiker niet is ingelogd, toon login link -->
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'Login.php' ? 'active' : '' ?>"
                            href="../Pages/Login.php">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

</body>

</html>