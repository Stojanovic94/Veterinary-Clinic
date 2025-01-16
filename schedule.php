<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ljubimac_id = $_POST['ljubimac_id'];
    $veterinar_id = $_POST['veterinar_id'];
    $datum = $_POST['datum'];

    // Provera da li veterinar ima zakazan pregled u tom terminu
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Pregled WHERE veterinar_id = :veterinar_id AND datum = :datum");
    $stmt->execute(['veterinar_id' => $veterinar_id, 'datum' => $datum]);
    $result = $stmt->fetchColumn();
    
    if ($result > 0) {
        // Ako ima zakazan pregled onda ide zakazivanje na sledeći mogući termin
        $datum = date('Y-m-d H:i', strtotime('+1 hour', strtotime($datum)));
    }
    
    // Insert u tabelu Pregledi
    $stmt = $pdo->prepare("INSERT INTO Pregled (ljubimac_id, veterinar_id, datum) VALUES (:ljubimac_id, :veterinar_id, :datum)");
    $stmt->execute(['ljubimac_id' => $ljubimac_id, 'veterinar_id' => $veterinar_id, 'datum' => $datum]);

    header('Location: dashboard.php');
    exit;
}
?>
