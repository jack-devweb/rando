<?php
session_start(); // Démarrer une session pour gérer l'état de connexion de l'utilisateur

require_once(__DIR__ . '/../includes/db/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si le formulaire d'inscription est soumis

    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier si l'utilisateur existe déjà
    $query = "SELECT id FROM utilisateurs WHERE username = :username";
    $stmt = $connexion->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $existing_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        // L'utilisateur existe déjà
        $error_message = "Cet identifiant est déjà utilisé, veuillez en choisir un autre.";
    } else {
        // Hasher le mot de passe avant de l'insérer dans la base de données
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insérer un nouvel utilisateur dans la base de données
        $insert_query = "INSERT INTO utilisateurs (username, password) VALUES (:username, :password)";
        $insert_stmt = $connexion->prepare($insert_query);
        $insert_stmt->bindParam(':username', $username);
        $insert_stmt->bindParam(':password', $hashed_password);

        if ($insert_stmt->execute()) {
            // Rediriger l'utilisateur vers la page de connexion après l'inscription réussie
            header('Location: login.php');
            exit();
        } else {
            $error_message = "Erreur lors de l'inscription. Veuillez réessayer.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <!-- Ajoutez ici vos balises meta, liens CSS, etc. -->
</head>
<body>

<h1>Inscription</h1>

<?php if (isset($error_message)) : ?>
    <p><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="post" action="">
    <label for="username">Identifiant :</label><br>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Mot de passe :</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="S'inscrire">
</form>

<p>Déjà un utilisateur ? <a href="login.php">Connectez-vous ici</a>.</p>

</body>
</html>
