<?php
$database = new SQLite3('../SQL/restot.sqlite3');

// if the form was submitted, insert the command into the database
$command = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_resto = $_POST['resto_id'];
    $delivery_place = $_POST['lieu_livraison'];
    $commentary = $_POST['commentaire'];
    $date = date('Y-m-d H:i:s');

    $stmt = $database->prepare('INSERT INTO commands (RestaurantId, CommandDate, Commentary, DeliveryPlace) VALUES (?, ?, ?, ?)');
    $stmt->bindParam(1, $id_resto, SQLITE3_INTEGER);
    $stmt->bindParam(2, $date, SQLITE3_TEXT); // :/
    $stmt->bindParam(3, $commentary, SQLITE3_TEXT);
    $stmt->bindParam(4, $delivery_place, SQLITE3_TEXT);

    $command = [
        'RestaurantId' => $id_resto,
        'CommandDate' => $date,
        'Commentary' => $commentary,
        'DeliveryPlace' => $delivery_place,
    ];

    if ($stmt->execute()) {
        // Get the last inserted ID
        $commandId = $database->lastInsertRowID();

        // Add the CommandId to the $command array
        $command['CommandId'] = $commandId;
    } else {
        echo "Erreur lors de l'enregistement de la commande.";
    }
}

// always fetch the restaurants
$restaurants = [];
$stmt = $database->prepare('SELECT RestaurantId, Name, Location FROM restaurants');
$result = $stmt->execute();
while ($row = $result->fetchArray()) {
    $location = $row['Location'];
    $name = $row['Name'];
    $restaurantId = $row['RestaurantId'];
    $restaurants[] = [
        'RestaurantId' => $restaurantId,
        'Name' => $name,
        'Location' => $location,
    ];
}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Restôt - HomePage</title>
    <link rel="stylesheet" href="/CSS/style.css">
    <script src="/JS/script.js"></script>
</head>

<body>
    <header>
        <h1>RESTÔT</h1>
        <nav>
            <ul>
                <li><a href="/index.php">Accueil</a></li>
                <li><a href="/list_commande.php">Lister les commandes</a></li>
            </ul>
        </nav>
        <h4>
            Select the food, the Restaurant and the place to be delivered.
            <br>
            It's simple as that.
        </h4>
    </header>

    <main>
        <?php if (isset($command['CommandId'])) : ?>
            <a href="/show_commande.php?id=<?= $command['CommandId'] ?>">Commande n°<?= $command['CommandId'] ?> soumise avec succès.</a>
        <?php endif; ?>
        <form id="new_commande" method="post">
            <div class="form-group">
                <label for="resto_id">Restaurant :</label>
                <select id="resto_id" name="resto_id" required>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant['RestaurantId'] ?>"><?= $restaurant['Name'] ?> : <?= $restaurant['Location'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="commentaire">Commentaire :</label>
                <textarea id="commentaire" name="commentaire" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label for="lieu_livraison">Lieu de livraison de la commande :</label>
                <input type="text" id="lieu_livraison" name="lieu_livraison" required>
            </div>
            <button type="submit">Soumettre la commande</button>
        </form>

    </main>

    <footer>
        <p class="bottom_text">&copy; 2024 Restôt. All rights reserved.</p>
    </footer>
</body>

</html>