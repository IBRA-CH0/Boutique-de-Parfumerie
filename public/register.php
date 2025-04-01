<?php
require_once "../app/init.php";
require_once "../template/header.php";

use App\Models\Utilisateur;// add this line to import the utilisateur class 
use App\manager\Database;  // Add this line to import the Database class

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validation des données
    $nom = (trim($_POST["nom"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $motDePasse = trim($_POST["mot_de_passe"]);

    if ($nom && $email && $motDePasse) {
        try {
            $pdo = Database::connect();

            // Vérifier si l'email existe déjà
            $query = $pdo->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
            $query->execute([$email]);
            $emailExists = $query->fetchColumn();

            if ($emailExists) {
                echo "<p>Un compte avec cet email existe déjà. <a href='login.php'>Connectez-vous ici</a></p>";
            } else {
                // Insérer l'utilisateur dans la base de données
                $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
                $query = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
                if ($query->execute([$nom, $email, $motDePasseHash])) {
                    echo "<p>Inscription réussie ! <a href='login.php'>Connectez-vous ici</a></p>";
                } else {
                    echo "<p>Erreur lors de l'inscription. Veuillez réessayer.</p>";
                }
            }
        } catch (PDOException $e) {
            echo "<p>Une erreur est survenue : " .($e->getMessage()) . "</p>";
        }
    } else {
        echo "<p>Veuillez remplir tous les champs correctement.</p>";
    }
}
?>

<h1>Inscription</h1>
<form method="POST">
    <label>Nom:</label>
    <input type="text" name="nom" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Mot de passe:</label>
    <input type="password" name="mot_de_passe" required><br>
    <button type="submit">S'inscrire</button>
</form>

<?php require_once "../template/footer.php"; ?>