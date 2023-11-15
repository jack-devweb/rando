<!-- edit_user.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le Rôle d'Utilisateur</title>
</head>
<body>

<h1>Modifier le Rôle d'Utilisateur</h1>

<?php
require_once(__DIR__ . '/../../includes/db/db.php'); // Inclure le fichier de connexion à la base de données


if (isset($_GET['id']) && !empty($_GET['id'])) {
        $user_id = $_GET['id'];
    echo "ID récupéré : " . $user_id; 

    $query = "SELECT * FROM utilisateurs WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {

        echo "<form method='post' action='update_role.php'>";
        echo "<input type='hidden' name='user_id' value='" . $user['id'] . "'>";
        echo "<label>Nouveau rôle : </label>";
        echo "<input type='text' name='new_role' value='" . $user['admin'] . "' required>";
        echo "<input type='submit' value='Enregistrer'>";
        echo "</form>";
    } else {
        echo "<p>Utilisateur non trouvé.</p>";
    }
} else {
    echo "<p>Paramètre d'identification manquant.</p>";
}
?>


</body>
</html>
