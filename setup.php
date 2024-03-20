<?php
error_log("startup", 0);
try {
    $database = new SQLite3('./SQL/restot.sqlite3');
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

    // Check if the table is empty
    $stmt = $database->prepare("SELECT COUNT(*) FROM restaurants");
    $result = $stmt->execute();
    $rowCount = $result->fetchArray()[0];

    if ($rowCount == 0) {
        // Fill the table with some data
        $restaurants = array(
            array('Resto1', 'Nimes'),
            array('Resto2', 'Toulouse')
        );

        $stmt = $database->prepare("INSERT INTO restaurants (Name, Location) VALUES (?, ?)");
        foreach ($restaurants as $restaurant) {
            $stmt->bindParam(1, $restaurant[0], SQLITE3_TEXT);
            $stmt->bindParam(2, $restaurant[1], SQLITE3_TEXT);
            $stmt->execute();
        }

        echo "Les restaurants ont été ajoutés avec succès.";
    } else {
        echo "La table des restaurants n'est pas vide, aucun ajout n'est nécessaire.";
    }

    // Fermer la connexion à la base de données
    $database->close();

    
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
