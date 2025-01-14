<?php
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Podaci o vlasniku
    $username = $_POST['username'];
    $password = hashPassword($_POST['password']);
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $email = $_POST['email'];
    
    // Podaci o ljubimcu
    $ljubimacIme = $_POST['ljubimac_ime'];
    $ljubimacRasa = $_POST['ljubimac_rasa'];
    $ljubimacDatumRodjenja = $_POST['ljubimac_datum_rodjenja'];

    try {
        // Pokretanje transakcije
        $pdo->beginTransaction();
        
        // Unos podataka o vlasniku
        $stmtVlasnik = $pdo->prepare("INSERT INTO Vlasnik (username, lozinka, ime, prezime, email) VALUES (:username, :password, :ime, :prezime, :email)");
        $stmtVlasnik->execute([
            'username' => $username,
            'password' => $password,
            'ime' => $ime,
            'prezime' => $prezime,
            'email' => $email
        ]);
        
        // Unos podataka o ljubimcu
        $stmtLjubimac = $pdo->prepare("INSERT INTO Ljubimac (ime, rasa, datum_rodjenja, vlasnik_id) VALUES (:ime, :rasa, :datum_rodjenja, (SELECT id FROM Vlasnik WHERE username = :username))");
        $stmtLjubimac->execute([
            'ime' => $ljubimacIme,
            'rasa' => $ljubimacRasa,
            'datum_rodjenja' => $ljubimacDatumRodjenja,
            'username' => $username
        ]);

        // Potvrda transakcije
        $pdo->commit();

        // Preusmeravanje na logovanje
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        // Otkazivanje transakcije u slučaju greške
        $pdo->rollBack();
        die("Došlo je do greške: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Registracija novog korisnika</h1>
    </header>
    <main>
        <form method="POST">
            <h2>Podaci o vlasniku</h2>
            <input type="text" name="username" placeholder="Korisničko ime" required>
            <input type="password" name="password" placeholder="Lozinka" required>
            <input type="text" name="ime" placeholder="Ime" required>
            <input type="text" name="prezime" placeholder="Prezime" required>
            <input type="email" name="email" placeholder="Email" required>
            <h2>Podaci o ljubimcu</h2>
            <input type="text" name="ljubimac_ime" placeholder="Ime ljubimca" required>
            <input type="text" name="ljubimac_rasa" placeholder="Rasa ljubimca">
            <input type="date" name="ljubimac_datum_rodjenja" placeholder="Datum rođenja">
            <button type="submit">Registruj se</button>
        </form>
    </main>
</body>
</html>
