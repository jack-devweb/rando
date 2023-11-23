<?php
// delete_user.php
require_once(__DIR__ . '/../../includes/db/db.php');

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    try {
        // Supprimer les notes associées à cet utilisateur dans la table 'notes'
        $delete_user_notes_query = "DELETE FROM notes WHERE id_utilisateur = :id";
        $delete_user_notes_stmt = $connexion->prepare($delete_user_notes_query);
        $delete_user_notes_stmt->bindParam(':id', $user_id);
        $delete_user_notes_stmt->execute();

        // Supprimer les enregistrements de randonnées associés à cet utilisateur dans la table 'utilisateur_randonnees'
        $delete_user_randonnees_query = "DELETE FROM utilisateur_randonnees WHERE utilisateur_id = :id";
        $delete_user_randonnees_stmt = $connexion->prepare($delete_user_randonnees_query);
        $delete_user_randonnees_stmt->bindParam(':id', $user_id);
        $delete_user_randonnees_stmt->execute();

        // Supprimer l'utilisateur de la table 'utilisateurs'
        $delete_user_query = "DELETE FROM utilisateurs WHERE id = :id";
        $delete_user_stmt = $connexion->prepare($delete_user_query);
        $delete_user_stmt->bindParam(':id', $user_id);
        $delete_user_stmt->execute();

        header("Location: users_list.php");
        exit();
    } catch (PDOException $e) {
        echo "Erreur PDO : " . $e->getMessage();
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>
