<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/public/assets/css/loginform.css">
    <title>Connexion</title>
</head>

<body>
    <form method="POST">
        <h1>Se connecter</h1>
        <div>
            <input id="email" placeholder="Mail" type="email" name="email" required>
        </div>
        <div>
            <input id="password" placeholder="Mot de passe" type="password" name="password" required>
        </div>
        <?php
        if ($errorInfo) {
            echo "<p class='error'>Utilisateur ou Mot de passe incorrect</p>";
        }
        ?>

        <input type="submit" class="btn" value="Se connecter">

        <a href="/register">
            <div id="btn2">S'inscrire</div>
        </a>
    </form>
    <p>Mot de passe oublié ? <u style="color:#f1c40f;">Cliquez ici !</u></p>
</body>

</html>