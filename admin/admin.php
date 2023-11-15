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
<form method="post" action="" enctype="multipart/form-data">
    <label for="hike_name">Nom :</label><br>
    <input type="text" id="hike_name" name="hike_name" required><br>
    
    <label for="hike_description">Description :</label><br>
    <textarea id="hike_description" name="hike_description" required></textarea><br>
    
    <label for="departure_address">Adresse de départ :</label><br>
    <input type="text" id="departure_address" name="departure_address" required><br>
    
    <label for="popularity_score">Score de popularité :</label><br>
    <input type="number" id="popularity_score" name="popularity_score" min="1" max="5" required><br>
    
    <label for="hike_photo">Photo :</label><br>
    <input type="file" id="hike_photo" name="hike_photo"><br>
    
    <input type="submit" value="Ajouter" name="add_hike">
</form>


<?php
try {
    $connexion = new PDO('mysql:host=localhost;dbname=randos', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_hike'])) {
    $hike_name = $_POST['hike_name'] ?? '';
    $hike_description = $_POST['hike_description'] ?? '';
    $departure_address = $_POST['departure_address'] ?? '';
    $popularity_score = $_POST['popularity_score'] ?? '';
    $hike_photo = $_FILES['hike_photo'] ?? null;

    if ($hike_photo && $hike_photo['name'] !== '') {
        $photo_name = $hike_photo['name'];
        $target_dir = __DIR__ . "/../uploads/"; // Chemin absolu vers le dossier des images
        $target_file = $target_dir . basename($photo_name);

        if (move_uploaded_file($hike_photo['tmp_name'], $target_file)) {
            $query = "INSERT INTO randonnees (nom, description, adresse_depart, popularite, photo) VALUES (:nom, :description, :adresse_depart, :popularite, :photo)";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':nom', $hike_name);
            $stmt->bindParam(':description', $hike_description);
            $stmt->bindParam(':adresse_depart', $departure_address);
            $stmt->bindParam(':popularite', $popularity_score);
            $stmt->bindParam(':photo', $photo_name);

            if ($stmt->execute()) {
                echo "<p>Randonnée ajoutée avec succès!</p>";
            } else {
                echo "<p>Erreur lors de l'ajout de la randonnée.</p>";
            }
        } else {
            echo "<p>Erreur lors de l'upload de la photo.</p>";
        }
    } else {
        echo "<p>Veuillez sélectionner une photo.</p>";
    }
}

// Reste du code pour la suppression et l'affichage des randonnées...



// Vérifier si une demande de suppression de randonnée est reçue
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $hike_id = $_GET['id'];

    $query = "DELETE FROM randonnees WHERE id = :id";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':id', $hike_id);

    if ($stmt->execute()) {
        header('Location: admin.php');
        exit();
    } else {
        echo "Erreur lors de la suppression de la randonnée.";
    }
}

// Afficher les randonnées dans le tableau
echo "<h2>Liste des randonnées</h2>";
echo "<table>";
echo "<thead><tr><th>Nom</th><th>Description</th><th>Adresse de départ</th><th>Score de popularité</th><th>Photo</th><th>Action</th></tr></thead>";
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
    echo "<td>" . $randonnee['adresse_depart'] . "</td>";
    echo "<td>" . $randonnee['popularite'] . "</td>";
    echo "<td><img src='/projet-randonnee/uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée' style='width: 100px; height: 100px;'></td>";
    echo "<td><a href='delete_hike.php?id=" . $randonnee['id'] . "'>Supprimer</a></td>";
    echo "</tr>";
}

echo "</tbody></table>";


?>

</body>
</html>