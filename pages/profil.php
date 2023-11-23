<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeuCYywAtt-tDROOKudIagSaLfDNNa8Zk&callback=initMaps"
        async defer></script></head>

<body>
    <nav>
        <ul>
            <li><a href="user.php">Accueil</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="login.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        </ul>
    </nav>

    <h1>Liste des randonnées sur votre profil</h1>
    <div class="card-container">
        <?php
        require_once(__DIR__ . '/../includes/db/db.php');

        session_start();
        if (isset($_SESSION['utilisateur_id'])) {
            $id_utilisateur = $_SESSION['utilisateur_id'];

            $query = "
                SELECT r.*, AVG(n.note) AS moyenne_note
                FROM randonnees r
                INNER JOIN utilisateur_randonnees ur ON r.id = ur.randonnee_id
                LEFT JOIN notes n ON r.id = n.id_randonnee
                WHERE ur.utilisateur_id = :id_utilisateur
                GROUP BY r.id
            ";

            $stmt = $connexion->prepare($query);
            $stmt->bindParam(':id_utilisateur', $id_utilisateur);
            $stmt->execute();
            $randonnees_profil = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($randonnees_profil && is_array($randonnees_profil)) {
                foreach ($randonnees_profil as $index => $randonnee) {
                    $map_id = 'map_' . $index;
                    echo "<div class='card'>";
                    echo "<h2>" . $randonnee['nom'] . "</h2>";
                    echo "<div id='" . $map_id . "' class='map'></div>";
                    echo "<p>Description : " . $randonnee['description'] . "</p>";
                    echo "<p>Photo : <img src='../uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée'></p>";
                    echo "<div class='rating'>";
                    
                    $moyenne_note = $randonnee['moyenne_note'];
                    for ($i = 5; $i > 0; $i--) {
                        if ($moyenne_note >= $i) {
                            echo "<span class='filled'>&#9733;</span>";
                        } else {
                            echo "<span class='empty'>&#9734;</span>";
                        }
                    }
                    echo "</div>"; // Fermeture de la div pour les étoiles

                    echo "</div>"; // Fermeture de la div pour la carte
                }
            } else {
                echo "Aucune randonnée trouvée sur votre profil.";
            }
        } else {
            header("Location: login.php");
            exit();
        }
        ?>
    </div>

    <script>
        function initMaps() {
            <?php
            // Récupération des données stockées pour créer les cartes
            if ($randonnees_profil && is_array($randonnees_profil)) {
                foreach ($randonnees_profil as $index => $randonnee) {
                    echo "var map_id = 'map_$index';
                    var map = new google.maps.Map(document.getElementById(map_id), {
                        center: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " },
                        zoom: 10
                    });
                    var marker = new google.maps.Marker({
                        position: { lat: " . $randonnee['latitude'] . ", lng: " . $randonnee['longitude'] . " },
                        map: map,
                        title: '" . $randonnee['nom'] . "'
                    });";
                }
            }
            ?>
        }
    
        // Appel de la fonction d'initialisation des cartes Google Maps
        initMaps();
    </script>
</body>

</html>
