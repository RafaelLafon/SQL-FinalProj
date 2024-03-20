<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Restôt - HomePage</title>
    <link rel="stylesheet" href="CSS/style.css">
    <script src="JS/script.js"></script>
</head>

<body>
    <header>
        <h1>RESTÔT</h1>
        <h4>
            Here, you can search and find whatever you want.
            <br>
            Select the food, the Restaurant and the place to be delevered.
            <br>
            It's simple as that.
        </h4>
    </header>

    <div class="center">
        <form action="/submit_commande.php" method="post">
            <div class="form-group">
                <label for="nom_resto">Nom du restaurant :</label>
                <input type="text" id="nom_resto" name="nom_resto" required>
            </div>
            <div class="form-group">
                <label for="localisation_resto">Localisation du restaurant :</label>
                <input type="text" id="localisation_resto" name="localisation_resto" required>
            </div>
            <div class="form-group">
                <label for="commentaire">Commentaire :</label>
                <input type="text" id="commentaire" name="commentaire" rows="4" required>
            </div>
            <div class="form-group">
                <label for="lieu_livraison">Lieu de livraison de la commande :</label>
                <input type="text" id="lieu_livraison" name="lieu_livraison" required>
            </div>
            <button type="submit">Soumettre la commande</button>
        </form>

    </div>

    <footer>
        <p class="bottom_text">&copy; 2024 Restôt. All rights reserved.</p>
    </footer>
</body>

</html>