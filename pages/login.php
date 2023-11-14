<?php
session_start();

// Inclure le fichier de connexion à la base de données
require_once(__DIR__ . '/../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Requête pour récupérer l'utilisateur depuis la base de données
    $query = "SELECT id, username, password, admin FROM utilisateurs WHERE username = :username";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Vérifier si le mot de passe correspond
        if (password_verify($password, $user['password'])) {
            // Authentification réussie, définir les variables de session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // Vérifier les privilèges administratifs
            if ($user['admin'] == 1) {
                // Redirection vers le tableau de bord administratif
                header('Location: ../admin/admin.php/');
                exit();
            } else {
                // Redirection vers une page utilisateur standard
                header('Location: user_page.php');
                exit();
            }
        } else {
            // Mot de passe incorrect
            $error_message = "Mot de passe incorrect";
        }
    } else {
        // Utilisateur non trouvé
        $error_message = "Identifiant incorrect";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <!-- Ajoutez ici vos balises meta, liens CSS, etc. -->
</head>
<body>

<h1>Connexion</h1>

<?php if (isset($error_message)) : ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="post" action="">
    <label for="username">Identifiant :</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Se connecter">
</form>

<p>Pas encore inscrit ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>

</body>
</html>
