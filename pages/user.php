<?php
session_start();

require_once(__DIR__ . '/../includes/db/db.php');

if (!isset($_SESSION['utilisateur_id'])) {
    // Redirigez l'utilisateur vers la page de connexion si la session n'est pas initialisée
    header("Location: login.php");
    exit();
} else {
    $stmt = $connexion->prepare('SELECT username FROM utilisateurs WHERE id = :user_id');
    $stmt->bindParam(':user_id', $_SESSION['utilisateur_id']);
    if ($stmt->execute()) {
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($userData) {
            $username = $userData['username'];
            // Afficher le nom d'utilisateur
            echo '<p>Bonjour, ' . htmlspecialchars($username) . '!</p>';
        }
    } else {
        // Gestion de l'erreur de la requête SQL
        echo "Erreur lors de la récupération du nom d'utilisateur";
    }
}

$query = "SELECT * FROM randonnees";
$stmt = $connexion->query($query);
$randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fonction pour récupérer les moyennes des notes par randonnée
function getAverageNotes($connexion) {
    $notesQuery = "SELECT id_randonnee, AVG(note) AS moyenne_note FROM notes GROUP BY id_randonnee";
    $stmt = $connexion->query($notesQuery);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_randonnee'])) {
    if (isset($_POST['randonnee_id'])) {
        // Récupérer l'ID de la randonnée sélectionnée
        $randonnee_id = $_POST['randonnee_id'];

        $utilisateur_id = $_SESSION['utilisateur_id'];

        // Insérer les données dans la table utilisateur_randonnees
        $insertQuery = "INSERT INTO utilisateur_randonnees (utilisateur_id, randonnee_id) VALUES (:utilisateur_id, :randonnee_id)";
        $stmt = $connexion->prepare($insertQuery);
        $stmt->bindParam(':utilisateur_id', $utilisateur_id);
        $stmt->bindParam(':randonnee_id', $randonnee_id);

        if ($stmt->execute()) {
            // Redirection vers user.php après l'ajout de la randonnée
            header("Location: user.php");
            exit();
        } else {
            echo "Erreur lors de l'ajout de la randonnée au profil.";
        }
    } else {
        echo "ID de randonnée manquant.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Page Utilisateur - Randonnées</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDeuCYywAtt-tDROOKudIagSaLfDNNa8Zk&callback=initMaps"
        async defer></script>
</head>

<body>
    <nav>
        <ul>
            <li><a href="user.php">Accueil</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="login.php">Connexion</a></li>
            <li><a href="inscription.php">Inscription</a></li>
        </ul>
    </nav>

    <h1>Liste des randonnées</h1>
    <div class="card-container">
        <?php
        if ($randonnees && is_array($randonnees)) {
            foreach ($randonnees as $index => $randonnee) {
                $map_id = 'map_' . $index;

                echo "<div class='card'>";
                echo "<h2>" . $randonnee['nom'] . "</h2>";
                echo "<p>Description : " . $randonnee['description'] . "</p>";
                echo "<div id='" . $map_id . "' class='map'></div>";
                echo "<img src='../uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée'>";

                echo "<div class='rating'>";
                $note = $notesMap[$randonnee['id']] ?? 0;
                for ($i = 5; $i > 0; $i--) {
                    if ($note >= $i) {
                        echo "<span class='filled'>&#9733;</span>";
                    } else {
                        echo "<span class='empty'>&#9734;</span>";
                    }
                }
                echo "</div>";

                echo "<a href='noter_rando.php?id=" . $randonnee['id'] . "'>Noter cette randonnée</a>";

                echo "<form method='post' action='user.php'>";
                echo "<input type='hidden' name='randonnee_id' value='" . $randonnee['id'] . "'>";
                echo "<input type='submit' value='Ajouter à mon profil' name='ajouter_randonnee'>";
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
