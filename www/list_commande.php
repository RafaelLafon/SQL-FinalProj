
<?php
$database = new SQLite3('../SQL/restot.sqlite3');
$stmt = $database->prepare('SELECT CommandId, RestaurantId, CommandDate, Commentary, DeliveryPlace, DeliveryStatus, ReasonForFailure FROM commands');
$result = $stmt->execute();
$commands = [];
while ($row = $result->fetchArray()) {
    // Process each row here
    $commandId = $row['CommandId'];
    $restaurantId = $row['RestaurantId'];
    $commandDate = $row['CommandDate'];
    $commentary = $row['Commentary'];
    $deliveryPlace = $row['DeliveryPlace'];
    $deliveryStatus = $row['DeliveryStatus'];
    $reasonForFailure = $row['ReasonForFailure'];

    // Do something with the retrieved data
    $commands[] = [
        'CommandId' => $commandId,
        'RestaurantId' => $restaurantId,
        'CommandDate' => $commandDate,
        'Commentary' => $commentary,
        'DeliveryPlace' => $deliveryPlace,
        'DeliveryStatus' => $deliveryStatus,
        'ReasonForFailure' => $reasonForFailure,
    ];
    // Todo sanitize data
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Liste des commandes</title>
    <link rel="stylesheet" href="/CSS/style.css">
    <script src="/JS/script.js"></script>
</head>
<body>
    <h1>Liste des commandes</h1>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="list_commande.php">Lister les commandes</a></li>
        </ul>
    </nav>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID du restaurant</th>
            <th>Date de la commande</th>
            <th>Commentaire</th>
            <th>Lieu de livraison</th>
            <th>Status de livraison</th>
            <th>Raison en cas d'échec de livraison</th>
        </tr>
        <?php foreach ($commands as $command) : ?>
            <tr>
                <td><a href="/show_commande.php?id=<?= $command['CommandId'] ?>"><?= $command['CommandId'] ?></a></td>
                <td><?= $command['RestaurantId'] ?></td>
                <td><?= $command['CommandDate'] ?></td>
                <td><?= $command['Commentary'] ?></td>
                <td><?= $command['DeliveryPlace'] ?></td>
                <td><?= $command['DeliveryStatus'] ?></td>
                <td><?= $command['ReasonForFailure'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>