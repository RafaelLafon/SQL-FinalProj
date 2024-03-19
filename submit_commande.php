<?php
try {
    $database = new SQLite3('./myDatabase.sqlite');
    echo "Connected to the database.\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}