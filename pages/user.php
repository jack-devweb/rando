<?php
require_once(__DIR__ . '/../includes/db/db.php');

// Requête pour récupérer les données des randonnées depuis la base de données
$query = "SELECT * FROM randonnees";
$stmt = $connexion->query($query);
$randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page Utilisateur - Randonnées</title>
    <!-- Ajoutez ici vos balises meta, liens CSS, etc. -->
    <link rel="stylesheet" href="styles.css">
    <!-- Ajoutez la balise script pour charger l'API Google Maps -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeuCYywAtt-tDROOKudIagSaLfDNNa8Zk&callback=initMaps" async defer></script>
    <style>
        /* Ajoutez ici le style pour la carte */
        .map {
            height: 300px;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Menu -->
    <nav>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Profil</a></li>
        </ul>
    </nav>

    <h1>Liste des randonnées</h1>

    <div class="card-container">
        <?php
        if ($randonnees && is_array($randonnees)) {
            foreach ($randonnees as $index => $randonnee) {
                // Génération d'un identifiant unique pour chaque carte
                $map_id = 'map_' . $index;

                // Affichage des détails de la randonnée dans une carte
                echo "<div class='card'>";
                echo "<h2>" . $randonnee['nom'] . "</h2>";
                echo "<p>Description : " . $randonnee['description'] . "</p>";
                echo "<div id='" . $map_id . "' class='map'></div>";
                echo "<img src='../uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée'>";
                echo "<form method='post' action='noter_rando.php'>";
                echo "<input type='hidden' name='randonnee_id' value='" . $randonnee['id'] . "'>";
                echo "<label for='note'>Notez cette randonnée :</label>";
                echo "<input type='number' id='note' name='note' min='0' max='5' step='1'>";
                echo "<input type='submit' value='Noter'>";
                echo "<td>" . ($randonnee['note'] ?? 'Aucune note pour le moment') . "</td>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "Aucune randonnée trouvée.";
        }
        ?>
    </div>

    <!-- Script pour initialiser les cartes Google Maps -->
    <script>
        function initMaps() {
            <?php
            if ($randonnees && is_array($randonnees)) {
                foreach ($randonnees as $index => $randonnee) {
                    $map_id = 'map_' . $index;
                    // Vérification des valeurs de latitude et longitude
                    if (is_numeric($randonnee['latitude']) && is_numeric($randonnee['longitude'])) {
                        echo "var map_$index = new google.maps.Map(document.getElementById('$map_id'), {
                            center: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " },
                            zoom: 10
                        });
                        var marker_$index = new google.maps.Marker({
                            position: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " },
                            map: map_$index,
                            title: '" . $randonnee['nom'] . "'
                        });";
                    }
                }
            }
            ?>
        }
        // Appel de la fonction d'initialisation des cartes Google Maps
        initMaps();
    </script>

</body>

</html>
