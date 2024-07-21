<?php

// Database connection details
$dsn = 'mysql:host=database;dbname=lamp';
$username = 'lamp';
$password = 'lamp';

if (rand(1, 20) === 1) {
    header("HTTP/1.1 500 Internal Server Error");
    die("Internal Server Error");
}

// Introduce a random delay about 1/5th of the time
if (rand(1, 5) === 1) {
    $delay = rand(1, 5); // Random delay between 1 and 5 seconds
    sleep($delay);
}

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the 'example' table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'example'");
    if ($stmt->rowCount() == 0) {
        // Create the 'example' table if it doesn't exist
        $pdo->exec("CREATE TABLE example (uuid CHAR(36) PRIMARY KEY)");
        echo "Table 'example' created successfully.<br>";
    }

    // Insert three random UUIDs
    for ($i = 0; $i < 3; $i++) {
        $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
        $stmt = $pdo->prepare("INSERT INTO example (uuid) VALUES (:uuid)");
        $stmt->execute(['uuid' => $uuid]);
    }
    echo "Three random UUIDs inserted successfully.<br>";

    // Query the table for UUIDs containing '%abc%'
    $stmt = $pdo->query("SELECT COUNT(*) FROM example WHERE uuid LIKE '%abc%' ORDER BY uuid");
    $count = $stmt->fetchColumn();

    echo "Number of UUIDs containing 'abc': $count";

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
