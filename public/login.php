<?php
// On charge les fichiers nécessaires pour la page
require_once "../app/init.php";
require_once "../template/header.php";

// On vérifie si l'utilisateur est déjà connecté
if (isset($_SESSION['utilisateur_id'])) {
    header('Location: index.php');
    exit;
}

// On traite le formulaire quand l'utilisateur clique sur "Se connecter"
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $motDePasse = $_POST['mot_de_passe'];

    // On vérifie que les champs ne sont pas vides
    if ($email && $motDePasse) {
        try {
            // On cherche l'utilisateur dans la base de données
            $pdo = \App\manager\Database::connect();
            $query = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
            $query->execute([$email]);
            $utilisateur = $query->fetch();

            // On vérifie le mot de passe et on connecte l'utilisateur
            if ($utilisateur && password_verify($motDePasse, $utilisateur['mot_de_passe'])) {
                $_SESSION['utilisateur_id'] = $utilisateur['id'];
                $_SESSION['utilisateur_nom'] = $utilisateur['nom'];
                header('Location: index.php');
                exit;
            } else {
                $erreur = "Email ou mot de passe incorrect.";
            }
        } catch (PDOException $e) {
            // En cas d'erreur avec la base de données
            $erreur = "Erreur lors de la connexion : " . $e->getMessage();
        }
    } else {
        // Si les champs sont vides
        $erreur = "Veuillez remplir tous les champs correctement.";
    }
}
?>

<div class="container">
    <h1>Connexion</h1>

    <!-- Affichage des messages d'erreur -->
    <?php if (isset($erreur)): ?>
        <div class="error"><?php echo ($erreur); ?></div>
    <?php endif; ?>

    <!-- Formulaire pour entrer ses identifiants -->
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe :</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit">Se connecter</button>
    </form>

    <!-- Lien vers la page d'inscription -->
    <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous ici</a></p>
</div>

<?php require_once "../template/footer.php"; ?>