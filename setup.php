<?php
error_log("startup", 0);
try {
    $database = new SQLite3('./SQL/restot.sqlite3');
    echo "Connected to the database.\n";
    // Create the table restaurants if it does not exist and fill it with some data
    $database->exec('CREATE TABLE IF NOT EXISTS restaurants (
        RestaurantId INTEGER PRIMARY KEY AUTOINCREMENT,
        Name VARCHAR(50),
        Location VARCHAR(255)
    );');
    if ($database->lastErrorCode() !== 0) {
        throw new Exception($database->lastErrorMsg());
    }
    echo "Table restaurants created or successfully opened.\n";

    // Create the table commands if it does not exist
    $database->exec('CREATE TABLE IF NOT EXISTS commands (
        CommandId INTEGER PRIMARY KEY AUTOINCREMENT,
        RestaurantId INTEGER,
        CommandDate DATE,
        Commentary TEXT,
        DeliveryPlace VARCHAR(255),
        DeliveryStatus VARCHAR(50),
        ReasonForFailure TEXT
    );');
    if ($database->lastErrorCode() !== 0) {
        throw new Exception($database->lastErrorMsg());
    }
    echo "Table commands created or successfully opened.\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}