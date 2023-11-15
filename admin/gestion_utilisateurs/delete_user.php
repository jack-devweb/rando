<!-- delete_user.php -->
<?php
// PHP : Logique pour supprimer l'utilisateur de la base de données
require_once(__DIR__ . '/../../includes/db/db.php'); 

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "DELETE FROM utilisateurs WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();

    header("Location: users_list.php"); 
    exit();
}
?>
