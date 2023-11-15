<?php
require_once(__DIR__ . '/../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $hike_name = $_POST['hike_name'];
    $hike_description = $_POST['hike_description'];


    // Requête pour insérer une nouvelle randonnée dans la base de données
    $query = "INSERT INTO randonnees (nom, description) VALUES (:nom, :description)";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':nom', $hike_name);
    $stmt->bindParam(':description', $hike_description);



    if ($stmt->execute()) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de l'ajout de la randonnée.";
    }
}
?>