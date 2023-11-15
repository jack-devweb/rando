<!-- users_list.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Utilisateurs</title>
</head>
<body>

<h1>Liste des Utilisateurs</h1>

<table>
    <thead>
        <tr>
            <th>Nom d'utilisateur</th>
            <th>Rôle</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- PHP : Récupération des utilisateurs depuis la base de données et affichage dans le tableau -->
        <?php
require_once(__DIR__ . '/../../includes/db/db.php'); 

        $query = "SELECT * FROM utilisateurs";
        $stmt = $connexion->query($query);
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['username'] . "</td>";
            echo "<td>" . $user['admin'] . "</td>";
            echo "<td><a href='edit_user.php?id=" . $user['id'] . "'>Modifier (ID: " . $user['id'] . ")</a> | <a href='delete_user.php?id=" . $user['id'] . "'>Supprimer</a></td>";
            echo "</tr>";
            
        }
        ?>
    </tbody>
</table>

</body>
</html>
