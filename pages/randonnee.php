<?php
require_once(__DIR__ . '/../../includes/db/db.php'); 

$query = "
SELECT randonnees.*, AVG(notes.note) AS moyenne_note
FROM randonnees
LEFT JOIN notes ON randonnees.id = notes.id_randonnee
GROUP BY randonnees.id
";
$stmt = $connexion->query($query);
$randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des randonnées</title>
    <!-- Vos balises meta, liens CSS, etc. -->
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <h1>Liste des randonnées</h1>
    <div class="card-container">
        <?php
        if ($randonnees && is_array($randonnees)) {
            foreach ($randonnees as $index => $randonnee) {
                echo "<div class='card'>";
                echo "<h2>" . $randonnee['nom'] . "</h2>";
                echo "<p>Description : " . $randonnee['description'] . "</p>";
                echo "<p>Popularité : " . $randonnee['popularite'] . "</p>";
                echo "<p>Photo : <img src='../uploads/" . $randonnee['photo'] . "' alt='Photo de la randonnée'></p>";
                echo "<p>Note moyenne : " . ($randonnee['moyenne_note'] ?? 'Aucune note pour le moment') . "</p>";

                echo "<form method='post' action='noter_rando.php'>";
                echo "<input type='hidden' name='id_randonnee' value='" . $randonnee['id'] . "'>";
                echo "<label for='note'>Notez cette randonnée :</label>";
                echo "<input type='number' id='note' name='note' min='0' max='5' step='1'>";
                echo "<input type='submit' value='Noter'>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "Aucune randonnée trouvée.";
        }
        ?>
    </div>

</body>

</html>
