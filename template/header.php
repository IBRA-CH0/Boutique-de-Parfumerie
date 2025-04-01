<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique de Parfumerie</title>
    <link rel="icon" type="image/jpeg" href="../public/images/chanel_no5.jpg">
    <link rel="stylesheet" href="/Evaluation CHORFI-IBRAHIM/styles.css">
</head>
<body>
<header>
    <h1>Boutique de Parfumerie</h1>
    <nav>
        <a href="index.php">Accueil</a>
        <?php if (isset($_SESSION["utilisateur_id"])): ?>
            <a href="logout.php">Déconnexion</a>
            <a href="panier.php">Mon Panier</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
            <a href="register.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>