<?php
// update_role.php
require_once(__DIR__ . '/../../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'], $_POST['new_role'])) {
        $user_id = $_POST['user_id'];
        $new_role = $_POST['new_role'];

        // Mettre à jour le rôle de l'utilisateur dans la base de données
        $update_query = "UPDATE utilisateurs SET admin = :new_role WHERE id = :user_id";
        $stmt = $connexion->prepare($update_query);
        $stmt->bindParam(':new_role', $new_role);
        $stmt->bindParam(':user_id', $user_id);

        if ($stmt->execute()) {
            // Redirection vers la page des utilisateurs après la mise à jour réussie
            header('Location: users_list.php');
            exit();
        } else {
            echo "Erreur lors de la mise à jour du rôle de l'utilisateur.";
        }
    }
}
?>
