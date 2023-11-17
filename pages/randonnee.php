<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

$query = "SELECT * FROM randonnees";
$stmt = $connexion->query($query);
$randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

include('user.php');
?>
