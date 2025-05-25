<?php
include "../Includes/Navbar.php";

// Skills ophalen uit de database
$skills_result = $conn->query("SELECT name FROM skills");
$all_skills = [];
while ($row = $skills_result->fetch_assoc()) {
    $all_skills[] = $row['name'];
}

// Formulierverwerking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $bsn = mysqli_real_escape_string($conn, $_POST['bsn']);
    $birth_date = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $desired_salary = mysqli_real_escape_string($conn, $_POST['desired_salary']);
    $skills_array = isset($_POST['skills']) ? $_POST['skills'] : []; //moet ik nog leren
    $skills = mysqli_real_escape_string($conn, implode(', ', $skills_array));
    $education_and_courses = mysqli_real_escape_string($conn, $_POST['education_and_courses']);

    $db_gender = 'X';
    if ($gender == 'male') {
        $db_gender = 'M';
    } elseif ($gender == 'female') {
        $db_gender = 'V';
    }

    $sql = "INSERT INTO candidates (
                first_name, 
                last_name, 
                email, 
                password, 
                gender, 
                bsn, 
                birth_date, 
                desired_salary, 
                skills,
                education_and_courses
            ) VALUES (
                '$first_name', 
                '$last_name', 
                '$email', 
                '$password', 
                '$db_gender', 
                '$bsn', 
                '$birth_date', 
                '$desired_salary', 
                '$skills',
                '$education_and_courses'
            )";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php");
        exit();
    } else {
        echo "Fout bij registratie";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uitzendbureau - Registratie</title>
    
    <link rel="stylesheet" href="../Styles/Main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
</head>

<body>
    <form class="form" method="post" action="Register.php">
        <div class="row">
            <div class="mb-3 col">
                <label for="first_name" class="form-label">Voornaam</label>
                <input type="text" class="form-control" id="first_name" name="first_name" required>
            </div>
            <div class="mb-3 col">
                <label for="surname" class="form-label">Achternaam</label>
                <input type="text" class="form-control" id="surname" name="last_name" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mailadres</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Wachtwoord</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Geslacht</label>
            <select class="form-select" id="gender" name="gender" required>
                <option value="">Selecteer geslacht</option>
                <option value="male">Man</option>
                <option value="female">Vrouw</option>
                <option value="other">Anders</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="bsn" class="form-label">BSN</label>
            <input type="text" class="form-control" id="bsn" name="bsn" required minlength="9" maxlength="9">
        </div>

        <div class="mb-3">
            <label for="birth_date" class="form-label">Geboortedatum</label>
            <input type="date" class="form-control" id="birth_date" name="birth_date" required>
        </div>

        <div class="mb-3">
            <label for="desired_salary" class="form-label">Gewenst salaris (€)</label>
            <input type="number" class="form-control" id="desired_salary" name="desired_salary" min="0" step="100" required>
        </div>

        <!-- Dynamisch gegenereerde checkboxen voor vaardigheden -->

        <!-- ? -->

        <!-- ? -->

        <!-- ? -->

        <!-- ? -->
        <div class="mb-3">
            <label class="form-label">Vaardigheden</label><br>
            <?php foreach ($all_skills as $skill): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="skills[]" value="<?= htmlspecialchars($skill) ?>" id="<?= htmlspecialchars($skill) ?>">
                    <label class="form-check-label" for="<?= htmlspecialchars($skill) ?>">
                        <?= htmlspecialchars($skill) ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="mb-3">
            <label for="education_and_courses" class="form-label">Opleiding/Cursussen</label>
            <input type="text" class="form-control" id="education_and_courses" name="education_and_courses" required>
        </div>

        <button type="submit" class="btn btn-primary">Verzenden</button>
    </form>
</body>
</html>
