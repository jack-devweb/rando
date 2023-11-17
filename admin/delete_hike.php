<?php
// Vérification si une demande de suppression de randonnée est reçue
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        // Connexion à la base de données
        $connexion = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    // Redirection en cas de problème ou d'accès incorrect à cette page
    header('Location: ad.php');
    exit();
}
?>
