<?php
// Inclure le fichier de connexion à la base de données
require_once(__DIR__ . '/../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $hike_name = $_POST['hike_name'];
    $hike_description = $_POST['hike_description'];
    // Ajoutez d'autres champs si nécessaire

    // Requête pour insérer une nouvelle randonnée dans la base de données
    $query = "INSERT INTO randonnees (nom, description) VALUES (:nom, :description)";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':nom', $hike_name);
    $stmt->bindParam(':description', $hike_description);
    // Ajoutez d'autres liaisons de paramètres si nécessaire

    // Exécution de la requête d'insertion
    if ($stmt->execute()) {
        // Redirection vers la page admin après l'ajout réussi
        header('Location: admin.php');
        exit();
    } else {
        // Gestion de l'échec de l'ajout, peut-être afficher un message d'erreur
        echo "Erreur lors de l'ajout de la randonnée.";
    }
}
?>
