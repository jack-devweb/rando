<?php
require_once(__DIR__ . '/../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['note']) && isset($_POST['randonnee_id'])) {
    $note = $_POST['note'];
    $randonnee_id = $_POST['randonnee_id'];

    try {
        $connexion = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Requête d'insertion de la note dans la table "notes"
        $insertQuery = "INSERT INTO notes (randonnee_id, note) VALUES (:randonnee_id, :note)";
        $stmt = $connexion->prepare($insertQuery);
        $stmt->bindParam(':randonnee_id', $randonnee_id);
        $stmt->bindParam(':note', $note);
        // Exécution de la requête
        if ($stmt->execute()) {
            header('Location: user.php');
            exit();
        } else {
            echo "Erreur lors de l'insertion de la note dans la base de données.";
        }
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
} else {
    header('Location: user.php');
    exit();
}
?>
