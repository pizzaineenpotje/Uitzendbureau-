<?php
include "../Includes/Navbar.php";

// Formulierverwerking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $skill = mysqli_real_escape_string($conn, $_POST["skill"]);
    
    $sql = "INSERT INTO skills (name) VALUES ('$skill')";

    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Skill is aangemaakt</div>";
    } else {
        echo "<div class='alert alert-danger'>Fout bij aanmaken van een skill</div>";
    }
}

// Skill verwijderen
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $sql = "DELETE FROM skills WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-warning'>Skill is verwijderd</div>";
    } 
}

// Skills ophalen
$skills = mysqli_query($conn, "SELECT * FROM skills");
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitzendbureau - Skill Toevoegen</title>
    
    <link rel="stylesheet" href="../Styles/Main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <style>
       
    </style>
</head>
<body>

<form class="form" method="post" action="Add_skill.php">
    <div class="mb-3">
        <label for="skill" class="form-label">Naam van de skill:</label>
        <input type="text" class="form-control" id="skill" name="skill" required>
    </div>
    <button type="submit" class="btn btn-primary">Verzenden</button>
</form>

<h2 style="margin-left:10%; margin-top:2%;">Huidige skills</h2>
<table>
    <thead>
        <tr>
            <th>Skillnaam</th>
            <th>Actie</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($skills)): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>
                    <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                       onclick="return confirm('Weet je zeker dat je deze skill wilt verwijderen?');">
                        Verwijderen
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
