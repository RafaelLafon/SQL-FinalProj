<?php
$database = new SQLite3('../SQL/restot.sqlite3');
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
        'DeliveryStatus' => $row['DeliveryStatus'] === null ? 'pending' : 
                    ($row['DeliveryStatus'] === 1 ? 'delivered' : 'failed'),
        'ReasonForFailure' => $row['ReasonForFailure'],
    ];

    // Retrieve the restaurant data
    $stmt = $database->prepare('SELECT Name, Location FROM restaurants WHERE RestaurantId = ?');
    $stmt->bindParam(1, $command['RestaurantId'], SQLITE3_INTEGER);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);
    $command['RestaurantName'] = $row['Name'];
    $command['RestaurantLocation'] = $row['Location'];

} else {
    echo "No command found with the given ID.";
}
?>

<!doctype html>
<html lang="fr">

<head>
    <title>Commande <?= $command['CommandId'] ?></title>
</head>
<body>
    <p><a href="/list_commande.php">Retour à la liste des commandes</a></p>
    <?php if (isset($command)) : ?>
        <h1>Commande <?= $command['CommandId'] ?></h1>
        <p>Restaurant: <?= $command['RestaurantName'] ?> à <?= $command['RestaurantLocation'] ?> (ID : <?= $command['RestaurantId'] ?>)</p>
        <p>Date de la commande: <?= $command['CommandDate'] ?></p>
        <p>Commentaire: <?= $command['Commentary'] ?></p>
        <p>Lieu de livraison: <?= $command['DeliveryPlace'] ?></p>
        <p>Statut de la livraison: <?= $command['DeliveryStatus'] ?></p>
        <?if ($command['DeliveryStatus'] === 'failed') : ?>
            <p>Raison de l'échec: <?= $command['ReasonForFailure'] ?></p>
        <? endif; ?>
    <?php endif; ?>
</body>