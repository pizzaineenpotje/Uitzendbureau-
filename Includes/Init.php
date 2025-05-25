<?php
// Start de sessie als deze nog niet is gestart
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vereiste bestanden includen
include 'connect.php';

// Functie om te controleren of gebruiker is ingelogd
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Sla de huidige URL op voor redirect na login
        $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
        
        // Stuur door naar login pagina
        header("Location: ../Pages/Login.php");
        exit();
    }
}

// Automatisch uitvoeren voor specifieke pagina's
$protected_pages = ['Profile.php', 'Add_skill.php']; // Vul aan met beveiligde pagina's
$current_page = basename($_SERVER['PHP_SELF']);

if (in_array($current_page, $protected_pages)) {
    checkLogin();
}

?>
