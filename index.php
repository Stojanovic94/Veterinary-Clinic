<?php
include 'includes/db.php';
include 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $stmt = $pdo->prepare("SELECT * FROM Vlasnik WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();
    
    if ($user && verifyPassword($password, $user['lozinka'])) {
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Pogrešan username ili lozinka.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Veterinarska Ambulanta</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <img src="images/banner.jpg" alt="Banner">
    </header>
    <main>
        <form method="POST">
            <h2>Log In</h2>
            <input type="text" name="username" placeholder="Korisničko ime" required>
            <input type="password" name="password" placeholder="Lozinka" required>
            <button type="submit">Uloguj se</button>
            <a href="signup.php">Registracija</a>
            <button type="reset">Odustani</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    </main>
</body>
</html>
