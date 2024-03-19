<?php
try {
    $database = new SQLite3('../SQL/restot.sqlite3');
    echo "Connected to the database.\n";
    // Create the table if it does not exist
    $database->exec('CREATE TABLE IF NOT EXISTS restaurants (
        RestaurantId INTEGER PRIMARY KEY AUTOINCREMENT,
        Name VARCHAR(50),
        Location VARCHAR(255)
    );');
    if ($database->lastErrorCode() !== 0) {
        throw new Exception($database->lastErrorMsg());
    }
    echo "Table created or successfully opened.\n";


    // Fill the table with some data
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['nom_resto'];
        $location = $_POST['localisation_resto'];

        $stmt = $database->prepare('INSERT INTO restaurants (Name, Location) VALUES (?, ?)');
        $stmt->bindParam(1, $name, SQLITE3_TEXT);
        $stmt->bindParam(2, $location, SQLITE3_TEXT);

        if ($stmt->execute()) {
            echo "Commande submitted successfully.";
        } else {
            echo "Failed to submit the commande.";
        }
    }
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}