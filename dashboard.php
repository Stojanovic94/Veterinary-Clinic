<?php
session_start();
include 'includes/db.php';
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['user']['username'];
$stmt = $pdo->prepare("SELECT ime FROM Vlasnik WHERE username = :username");
$stmt->execute(['username' => $username]);
$vlasnik = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Veterinarska Ambulanta</h1>
        <h2>Dobrodošli, <?php echo htmlspecialchars($vlasnik['ime']); ?>!</h2>
        <a href="logout.php" class="logout-btn">Odjava</a>
    </header>
    
    <h3>Zakazani Pregledi Vaših Ljubimaca</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ime Ljubimca</th>
                <th>Veterinar</th>
                <th>Datum i Vreme</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->prepare("
                SELECT p.id, l.ime AS ljubimac_ime, CONCAT(v.ime, ' ', v.prezime) AS veterinar, p.datum, p.opis
                FROM Pregled p
                JOIN Ljubimac l ON p.ljubimac_id = l.id
                JOIN Veterinar v ON p.veterinar_id = v.id
                WHERE l.vlasnik_id = (SELECT id FROM Vlasnik WHERE username = :username)
                ORDER BY p.datum ASC
            ");
            $stmt->execute(['username' => $username]);
            while ($pregled = $stmt->fetch()) {
                echo "<tr>
                    <td>{$pregled['id']}</td>
                    <td>" . htmlspecialchars($pregled['ljubimac_ime']) . "</td>
                    <td>" . htmlspecialchars($pregled['veterinar']) . "</td>
                    <td>{$pregled['datum']}</td>
                    <td>" . htmlspecialchars($pregled['opis']) . "</td>
                </tr>";
            }
            ?>
        </tbody>
    </table>

    <h3>Zakazivanje Pregleda</h3>
    <form method="POST" action="schedule.php">
        <label for="ljubimac">Izaberite Ljubimca:</label>
        <select name="ljubimac_id" id="ljubimac" required>
            <?php
            $stmt = $pdo->prepare("SELECT id, ime FROM Ljubimac WHERE vlasnik_id = (SELECT id FROM Vlasnik WHERE username = :username)");
            $stmt->execute(['username' => $username]);
            while ($ljubimac = $stmt->fetch()) {
                echo "<option value='{$ljubimac['id']}'>" . htmlspecialchars($ljubimac['ime']) . "</option>";
            }
            ?>
        </select>
        <label for="veterinar">Izaberite Veterinara:</label>
        <select name="veterinar_id" id="veterinar" required>
            <?php
            $stmt = $pdo->query("SELECT id, CONCAT(ime, ' ', prezime) AS ime FROM Veterinar");
            while ($veterinar = $stmt->fetch()) {
                echo "<option value='{$veterinar['id']}'>" . htmlspecialchars($veterinar['ime']) . "</option>";
            }
            ?>
        </select>
        <label for="datum">Izaberite Datum i Vreme:</label>
        <input type="datetime-local" name="datum" id="datum" required>
        <button type="submit">Zakazivanje Pregleda</button>
    </form>
</body>
</html>
