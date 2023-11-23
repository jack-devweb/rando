<?php
session_start();

require_once(__DIR__ . '/../includes/db/db.php');
// Vérification si une demande de suppression de randonnée est reçue
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $hike_id = $_GET['id'];
        // Requête de suppression de la randonnée avec l'identifiant spécifié
        $query = "DELETE FROM randonnees WHERE id = :id";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(':id', $hike_id);

        if ($stmt->execute()) {
            // Redirection vers une page après la suppression de la randonnée
            header('Location: ad.php');
            exit();
        } else {
            echo "Erreur lors de la suppression de la randonnée.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
} else {
    header('Location: ad.php');
    exit();
}
?>
