<?php
$database = new SQLite3('../SQL/restot.sqlite3');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['set_status'])) {
        $stmt = $database->prepare('UPDATE commands SET DeliveryStatus = ?, ReasonForFailure = ? WHERE CommandId = ?');
        $stmt->bindParam(1, $_POST['deliveryStatus'], SQLITE3_TEXT);
        $stmt->bindParam(2, $_POST['reasonForFailure'], SQLITE3_TEXT);
        $stmt->bindParam(3, $_POST['commandId'], SQLITE3_INTEGER);
        $stmt->execute();
    } elseif (isset($_GET['delete'])) {
        $stmt = $database->prepare('DELETE FROM commands WHERE CommandId = ?');
        $stmt->bindParam(1, $_POST['commandId'], SQLITE3_INTEGER);
        $stmt->execute();
        header('Location: /list_commande.php');
    }
}

$stmt = $database->prepare('SELECT CommandId, RestaurantId, CommandDate, Commentary, DeliveryPlace, DeliveryStatus, ReasonForFailure FROM commands WHERE CommandId = ?');
$stmt->bindParam(1, $_GET['id'], SQLITE3_INTEGER);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if ($row) {
    $command = [
        'CommandId' => $row['CommandId'],
        'RestaurantId' => $row['RestaurantId'],
        'CommandDate' => $row['CommandDate'],
        'Commentary' => $row['Commentary'],
        'DeliveryPlace' => $row['DeliveryPlace'],
        'DeliveryStatus' => $row['DeliveryStatus'] === null ? 'pending' : $row['DeliveryStatus'],
        'ReasonForFailure' => $row['ReasonForFailure'],
    ];

    // Retrieve the restaurant data
    $stmt = $database->prepare('SELECT Name, Location FROM restaurants WHERE RestaurantId = ?');
    $stmt->bindParam(1, $command['RestaurantId'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    if($row){
        $command['RestaurantName'] = $row['Name'];
        $command['RestaurantLocation'] = $row['Location'];
    }else{
        $command['RestaurantName'] = 'Unknown';
        $command['RestaurantLocation'] = 'Unknown';
    }

}
?>

<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <title>Commande <?= $command['CommandId'] ?></title>
    <link rel="stylesheet" href="/CSS/style.css">
    <script src="/JS/script.js"></script>
    <script>
        function toggleReasonForFailure() {
            var deliveryStatus = document.getElementById("deliveryStatus");
            var reasonForFailureLabel = document.getElementById("reasonForFailureLabel");
            var reasonForFailure = document.getElementById("reasonForFailure");

            if (deliveryStatus.value === "failed") {
                reasonForFailureLabel.style.display = "block";
                reasonForFailure.style.display = "block";
                reasonForFailure.required = true;
            } else {
                reasonForFailureLabel.style.display = "none";
                reasonForFailure.style.display = "none";
                reasonForFailure.required = false;
            }
        }
    </script>
</head>
<body>
    <nav>
        <ul>
            <li><a href="/index.php">Accueil</a></li>
            <li><a href="/list_commande.php">Lister les commandes</a></li>
        </ul>
    </nav>
    <?php if (isset($command)) : ?>
        <h1>Commande <?= $command['CommandId'] ?></h1>
        <p>Restaurant: <?= $command['RestaurantName'] ?> à <?= $command['RestaurantLocation'] ?> (ID : <?= $command['RestaurantId'] ?>)</p>
        <p>Date de la commande: <?= $command['CommandDate'] ?></p>
        <p>Commentaire: <?= $command['Commentary'] ?></p>
        <p>Lieu de livraison: <?= $command['DeliveryPlace'] ?></p>
        <form action="?id=<?= $command['CommandId'] ?>&set_status" method="POST">
            <input type="hidden" name="commandId" value="<?= $command['CommandId'] ?>">
            <label for="deliveryStatus">Statut de la livraison:</label>
            <select name="deliveryStatus" id="deliveryStatus" onchange="toggleReasonForFailure()" >
                <option value="pending" <?= $command['DeliveryStatus'] === 'pending' ? 'selected' : '' ?>>En attente</option>
                <option value="delivered" <?= $command['DeliveryStatus'] === 'delivered' ? 'selected' : '' ?>>Livré</option>
                <option value="failed" <?= $command['DeliveryStatus'] === 'failed' ? 'selected' : '' ?>>Échec</option>
            </select>
            <br>
            <label for="reasonForFailure" id="reasonForFailureLabel" style="display: none;">Raison de l'échec:</label>
            <input type="text" name="reasonForFailure" id="reasonForFailure" style="display: none;">
            <br>
            <input type="submit" value="Mettre à jour">
        </form>
        <?if ($command['DeliveryStatus'] === 'failed') : ?>
            <p>Raison de l'échec: <?= $command['ReasonForFailure'] ?></p>
        <? endif; ?>
        <form action="?delete" method="POST">
            <input type="hidden" name="commandId" value="<?= $command['CommandId'] ?>">
            <input type="submit" value="Supprimer la commande">
        </form>
    <?php else : ?>
        <p>Commande inconnue.</p>
    <?php endif; ?>

</body>