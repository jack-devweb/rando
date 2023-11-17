<?php
require_once(__DIR__ . '/../includes/db/db.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $hike_name = $_POST['hike_name'] ?? '';
    $hike_description = $_POST['hike_description'] ?? '';

    // Vérification des données obligatoires
    if (empty($hike_name) || empty($hike_description)) {
        echo "Veuillez remplir tous les champs obligatoires.";
        exit();
    }

    try {
        $connexion->beginTransaction();

        // Requête pour insérer une nouvelle randonnée dans la base de données
        $query = "INSERT INTO randonnees (nom, description) VALUES (:nom, :description)";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':nom', $hike_name);
        $stmt->bindParam(':description', $hike_description);

        if ($stmt->execute()) {
            $connexion->commit();
            header('Location: ad.php');
            exit();
        } else {
            // En cas d'échec, annuler les modifications
            $connexion->rollBack();
            echo "Erreur lors de l'ajout de la randonnée.";
        }
    } catch (PDOException $e) {
        // Gestion des exceptions
        $connexion->rollBack();
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
    }
}
?>
