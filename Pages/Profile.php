<?php
include "../Includes/Navbar.php";
$user_id = $_SESSION['user_id'];

// Skills ophalen
$skills_result = $conn->query("SELECT name FROM skills");
$all_skills = array();
while ($row = $skills_result->fetch_assoc()) {
    $all_skills[] = $row['name'];
}

// Formulierverwerking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $bsn = $_POST['bsn'];
    $birth_date = $_POST['birth_date'];
    $desired_salary = $_POST['desired_salary'];
    $education_and_courses = $_POST['education_and_courses'];
    $skills = isset($_POST['skills']) ? implode(', ', $_POST['skills']) : '';

    $update_sql = "UPDATE candidates SET first_name=?, last_name=?, email=?, 
        gender=?, bsn=?, birth_date=?, desired_salary=?, skills=?, education_and_courses=? WHERE id=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssssssdssi", $first_name, $last_name, $email, 
        $gender, $bsn, $birth_date, $desired_salary, $skills, $education_and_courses, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Gebruikersdata ophalen
$sql = "SELECT * FROM candidates WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_Data = $result->fetch_assoc();
$user_skills = array_map('trim', explode(',', $user_Data['skills']));
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruikersgegevens</title>
    <link rel="stylesheet" href="../Styles/Main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="user_data">
        <?php if (isset($_GET['edit'])): ?>
            <form method="post">
                <table cellpadding="8">
                    <tr><td>Voornaam</td><td><input type="text" name="first_name" value="<?= htmlspecialchars($user_Data['first_name']) ?>"></td></tr>
                    <tr><td>Achternaam</td><td><input type="text" name="last_name" value="<?= htmlspecialchars($user_Data['last_name']) ?>"></td></tr>
                    <tr><td>Email</td><td><input type="email" name="email" value="<?= htmlspecialchars($user_Data['email']) ?>"></td></tr>

                    <tr><td>Geslacht</td>
                        <td>
                            <select name="gender">
                                <option value="M" <?= $user_Data['gender'] === 'M' ? 'selected' : '' ?>>Man</option>
                                <option value="V" <?= $user_Data['gender'] === 'V' ? 'selected' : '' ?>>Vrouw</option>
                                <option value="X" <?= $user_Data['gender'] === 'X' ? 'selected' : '' ?>>Anders</option>
                            </select>
                        </td>
                    </tr>

                    <tr><td>BSN</td><td><input type="text" name="bsn" value="<?= htmlspecialchars($user_Data['bsn']) ?>"></td></tr>
                    <tr><td>Geboortedatum</td><td><input type="date" name="birth_date" value="<?= htmlspecialchars($user_Data['birth_date']) ?>"></td></tr>
                    <tr><td>Gewenst salaris</td><td><input type="number" step="0.01" name="desired_salary" value="<?= htmlspecialchars($user_Data['desired_salary']) ?>"></td></tr>

                    <tr><td>Skills</td>
                        <td>
                            <?php foreach ($all_skills as $skill): ?>
                                <div>
                                    <input type="checkbox" name="skills[]" value="<?= htmlspecialchars($skill) ?>" 
                                    <?= in_array($skill, $user_skills) ? 'checked' : '' ?>> 
                                    <?= htmlspecialchars($skill) ?>
                                </div>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr><td>Opleiding/Cursussen</td><td><input type="text" name="education_and_courses" value="<?= htmlspecialchars($user_Data['education_and_courses']) ?>"></td></tr>
                </table><br>
                <button type="submit" class="btn btn-success">Opslaan</button>
                <a href="<?= $_SERVER['PHP_SELF'] ?>" class="btn btn-secondary">Annuleren</a>
            </form>

        <?php else: ?>
            <table cellpadding="8">
                <tr><th>Veld</th><th>Waarde</th></tr>
                <tr><td>Voornaam</td><td><?= htmlspecialchars($user_Data['first_name']) ?></td></tr>
                <tr><td>Achternaam</td><td><?= htmlspecialchars($user_Data['last_name']) ?></td></tr>
                <tr><td>Email</td><td><?= htmlspecialchars($user_Data['email']) ?></td></tr>
                <tr><td>Geslacht</td><td>
                    <?php
                    echo match ($user_Data['gender']) {
                        'M' => 'Man',
                        'V' => 'Vrouw',
                        default => 'Anders'
                    };
                    ?>
                </td></tr>
                <tr><td>BSN</td><td><?= htmlspecialchars($user_Data['bsn']) ?></td></tr>
                <tr><td>Geboortedatum</td><td><?= htmlspecialchars($user_Data['birth_date']) ?></td></tr>
                <tr><td>Gewenst salaris</td><td>€<?= htmlspecialchars($user_Data['desired_salary']) ?></td></tr>
                <tr><td>Skills</td><td><?= htmlspecialchars($user_Data['skills']) ?></td></tr>
                <tr><td>Opleiding/Cursussen</td><td><?= htmlspecialchars($user_Data['education_and_courses']) ?></td></tr>
            </table><br>
            <a href="?edit=1" class="btn btn-primary edit_btn">Bewerk gegevens</a>
        <?php endif; ?>
    </div>
</body>
</html>
