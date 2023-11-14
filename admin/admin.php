<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de bord administratif</title>
    <!-- Ajoutez ici vos balises meta, liens CSS, etc. -->
</head>
<body>

<h1>Tableau de bord administratif</h1>
<a href="/projet-randonnee/admin/gestion_utilisateurs/users_list.php">Liste des utilisateurs</a>


<!-- Formulaire pour ajouter de nouvelles randonnées -->
<h2>Ajouter une nouvelle randonnée</h2>
<form method="post" action="">
    <label for="hike_name">Nom :</label><br>
    <input type="text" id="hike_name" name="hike_name" required><br>
    <label for="hike_description">Description :</label><br>
    <textarea id="hike_description" name="hike_description" required></textarea><br>
    <!-- Ajoutez d'autres champs pour les détails de la randonnée -->
    <input type="submit" value="Ajouter" name="add_hike">
</form>

<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=randos', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

// Vérifier si le formulaire d'ajout de randonnée est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_hike'])) {
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
        echo "<p>Randonnée ajoutée avec succès!</p>";
    } else {
        echo "<p>Erreur lors de l'ajout de la randonnée.</p>";
    }
}

// Vérifier si une demande de suppression de randonnée est reçue
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $hike_id = $_GET['id'];

    $query = "DELETE FROM randonnees WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $hike_id);

    if ($stmt->execute()) {
        // Redirection vers cette même page pour actualiser la liste après la suppression
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de la randonnée.";
    }
}

// Affichage de la liste des randonnées
echo "<h2>Liste des randonnées</h2>";
echo "<table>";
echo "<thead><tr><th>Nom</th><th>Description</th><th>Action</th></tr></thead>";
echo "<tbody>";

// Requête pour sélectionner toutes les randonnées
$query = "SELECT * FROM randonnees";
$stmt = $connexion->query($query);
$randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les randonnées dans le tableau
foreach ($randonnees as $randonnee) {
    echo "<tr>";
    echo "<td>" . $randonnee['nom'] . "</td>";
    echo "<td>" . $randonnee['description'] . "</td>";
    echo "<td><a href='delete_hike.php?id=" . $randonnee['id'] . "'>Supprimer</a></td>";
    echo "</tr>";
}

echo "</tbody></table>";

?>

</body>
</html>
