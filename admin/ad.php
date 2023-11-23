<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Tableau de bord administratif</title>
</head>

<body>

    <h1>Tableau de bord administratif</h1>
    <a href="/projet-randonnee/admin/gestion_utilisateurs/users_list.php">Liste des utilisateurs</a>

    <h2>Ajouter une nouvelle randonnée</h2>
    <form method="post" action="" enctype="multipart/form-data">
        <label for="hike_name">Nom :</label><br>
        <input type="text" id="hike_name" name="hike_name" required><br>

        <label for="hike_description">Description :</label><br>
        <textarea id="hike_description" name="hike_description" required></textarea><br>

        <label for="latitude">Latitude :</label><br>
        <input type="text" id="latitude" name="latitude" required><br>

        <label for="longitude">Longitude :</label><br>
        <input type="text" id="longitude" name="longitude" required><br>

        <label for="popularity_score">Score de popularité :</label><br>
        <input type="number" id="popularity_score" name="popularity_score" min="1" max="5" required><br>

        <label for="hike_photo">Photo :</label><br>
        <input type="file" id="hike_photo" name="hike_photo"><br>

        <input type="submit" value="Ajouter" name="add_hike">
    </form>

    <?php

    require_once(__DIR__ . '/../includes/db/db.php');
    try {

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_hike'])) {
            $hike_name = $_POST['hike_name'] ?? '';
            $hike_description = $_POST['hike_description'] ?? '';
            // $departure_address = $_POST['departure_address'] ?? '';
            $popularity_score = $_POST['popularity_score'] ?? '';
            $hike_photo = $_FILES['hike_photo'] ?? null;
            $latitude = $_POST['latitude'] ?? '';
            $longitude = $_POST['longitude'] ?? '';

            // Vérification si les valeurs sont des nombres
            if (!is_numeric($latitude) || !is_numeric($longitude)) {
                echo "Les valeurs de latitude et de longitude doivent être des nombres valides.";
            } else {
                // Votre code d'insertion dans la base de données ici
            }

            if ($hike_photo && $hike_photo['name'] !== '') {
                $photo_name = $hike_photo['name'];
                $target_dir = __DIR__ . "/../uploads/"; // Chemin absolu vers le dossier des images
                $target_file = $target_dir . basename($photo_name);

                if (move_uploaded_file($hike_photo['tmp_name'], $target_file)) {
                    $query = "INSERT INTO randonnees (nom, description, latitude, longitude, popularite, photo) VALUES (:nom, :description, :latitude, :longitude, :popularite, :photo)";
                    $stmt = $connexion->prepare($query);
                    $stmt->bindParam(':nom', $hike_name);
                    $stmt->bindParam(':description', $hike_description);
                    // $stmt->bindParam(':adresse_depart', $departure_address);
                    $stmt->bindParam(':latitude', $latitude);
                    $stmt->bindParam(':longitude', $longitude);
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
                header('Location: ad.php');
                exit();
            } else {
                echo "Erreur lors de la suppression de la randonnée.";
            }
        }


        // Affichage des randonnées dans le tableau
        echo "<h2>Liste des randonnées</h2>";
        echo "<table border='1'>";
        echo "<thead><tr><th>Nom</th><th>Description</th><th>Score de popularité</th><th>Photo</th><th>Carte</th><th>Action</th></tr></thead>";
        echo "<tbody>";

        $query = "SELECT * FROM randonnees";
        $stmt = $connexion->query($query);
        $randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($randonnees as $randonnee) {
            echo "<tr>";
            echo "<td>" . $randonnee['nom'] . "</td>";
            echo "<td>" . $randonnee['description'] . "</td>";
            echo "<td>" . $randonnee['popularite'] . "</td>";
            echo "<td><img src='/projet-randonnee/uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée' style='width: 200px; height: 200px;'></td>";
            echo "<td><div id='map_" . $randonnee['id'] . "' style='width: 300px; height: 200px;'></div></td>";
            echo "<td><a href='delete_hike.php?id=" . $randonnee['id'] . "'>Supprimer</a></td>";
            echo "</tr>";

            echo "<script>
                 function initMap" . $randonnee['id'] . "() {
                     var map = new google.maps.Map(document.getElementById('map_" . $randonnee['id'] . "'), {
                         zoom: 12,
                         center: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " }
                     });

                     var marker = new google.maps.Marker({
                         map: map,
                         position: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " }
                     });
                 }
                 initMap" . $randonnee['id'] . "();
             </script>";
        }

        echo "</tbody></table>";
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
    }
    ?>

    <div id="map" style="height: 400px;"></div>

    <script>
        function initMap() {
            <?php
            foreach ($randonnees as $randonnee) {
                $latitude = $randonnee['latitude'];
                $longitude = $randonnee['longitude'];

                // Vérifier si les valeurs de latitude et longitude sont valides
                if (is_numeric($latitude) && is_numeric($longitude)) {
                    echo "var map" . $randonnee['id'] . " = new google.maps.Map(document.getElementById('map_" . $randonnee['id'] . "'), {
                    zoom: 12,
                    center: { lat: " . $latitude . ", lng: " . $longitude . " }
                });

                var marker" . $randonnee['id'] . " = new google.maps.Marker({
                    position: { lat: " . $latitude . ", lng: " . $longitude . " },
                    map: map" . $randonnee['id'] . ",
                    title: '" . $randonnee['nom'] . "'
                });";
                }
            }
            ?>
        }

        // Appeler la fonction d'initialisation de la carte
        initMap();
    </script>





    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeuCYywAtt-tDROOKudIagSaLfDNNa8Zk&callback=initMap"
        async defer></script>
    <script src="admin_js/mapFunctions.js"></script>
</body>

</html>