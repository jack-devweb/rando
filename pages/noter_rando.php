<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Noter une randonnée</title>
    <link rel="stylesheet" href="styles.css">

</head>

<body>

    <h1>Noter une randonnée</h1>

    <!-- Formulaire pour noter une randonnée -->
    <form method="post" action="noter_rando.php">
        <label for="randonnee_id">Sélectionner une randonnée :</label><br>
        <select id="randonnee_id" name="randonnee_id" required>
            <?php
          

            require_once(__DIR__ . '/../includes/db/db.php');
          
        try {
              
                $query = "SELECT id, nom FROM randonnees"; // Sélectionnez l'ID et le nom des randonnées
                $stmt = $connexion->query($query);
                $randonnees = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($randonnees as $randonnee) {
                    echo "<option value='" . $randonnee['id'] . "'>" . $randonnee['nom'] . "</option>";
                }
            } catch (PDOException $e) {
                echo "Erreur de connexion : " . $e->getMessage();
            }
            ?>
        </select><br>

        <label for="note">Note :</label><br>
    <div class="rating">
        <input type="radio" id="star5" name="note" value="5"><label for="star5"></label>
        <input type="radio" id="star4" name="note" value="4"><label for="star4"></label>
        <input type="radio" id="star3" name="note" value="3"><label for="star3"></label>
        <input type="radio" id="star2" name="note" value="2"><label for="star2"></label>
        <input type="radio" id="star1" name="note" value="1"><label for="star1"></label>
    </div>

    <input type="submit" value="Noter" name="add_note">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_note'])) {
        try {
       
            $randonnee_id = $_POST['randonnee_id'];
            $note = $_POST['note'];

          
            $insertQuery = "INSERT INTO notes (id_randonnee, note) VALUES (:id_randonnee, :note)";
            $stmt = $connexion->prepare($insertQuery);
            $stmt->bindParam(':id_randonnee', $randonnee_id);
            $stmt->bindParam(':note', $note);
            if ($stmt->execute()) {
                // Note ajoutée avec succès, redirection vers user.php après 1 seconde
                echo "<p class='confirmation-message'>Note ajoutée avec succès!</p>";
                echo "<script>setTimeout(function () { window.location.href = 'user.php'; }, 1000);</script>";
                exit(); // Arrête l'exécution du script pour éviter l'affichage du reste de la page
            } else {
                echo "<p>Erreur lors de l'ajout de la note.</p>";
            }
        } catch (PDOException $e) {
            echo "Erreur de connexion : " . $e->getMessage();
        }
    }
    ?>

</body>

</html>
