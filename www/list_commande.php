
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
}
?>
<html>
<head>
    <title>Liste des commandes</title>
</head>
<body>
    <h1>Liste des commandes</h1>
    <table border="1">
        <tr>
            <th>CommandId</th>
            <th>RestaurantId</th>
            <th>CommandDate</th>
            <th>Commentary</th>
            <th>DeliveryPlace</th>
            <th>DeliveryStatus</th>
            <th>ReasonForFailure</th>
        </tr>
        <?php foreach ($commands as $command) : ?>
            <tr>
                <td><?= $command['CommandId'] ?></td>
                <td><?= $command['RestaurantId'] ?></td>
                <td><?= $command['CommandDate'] ?></td>
                <td><?= $command['Commentary'] ?></td>
                <td><?= $command['DeliveryPlace'] ?></td>
                <td><?= $command['DeliveryStatus'] ?></td>
                <td><?= $command['ReasonForFailure'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>