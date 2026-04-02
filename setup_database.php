<?php
// Database setup script for E-Voting system

echo "Setting up E-Voting database...\n";

try {
    // First try to connect to existing database
    $conn = new mysqli('localhost', 'root', '', 'e_voting');

    if ($conn->connect_error) {
        echo "Database does not exist. Creating...\n";

        // Connect without database to create it
        $conn2 = new mysqli('localhost', 'root', '');
        if ($conn2->connect_error) {
            die("Connection failed: " . $conn2->connect_error . "\n");
        }

        // Create database
        if ($conn2->query("CREATE DATABASE e_voting") === TRUE) {
            echo "Database 'e_voting' created successfully.\n";
        } else {
            die("Error creating database: " . $conn2->error . "\n");
        }

        $conn2->close();

        // Now connect to the new database
        $conn = new mysqli('localhost', 'root', '', 'e_voting');
        if ($conn->connect_error) {
            die("Connection to new database failed: " . $conn->connect_error . "\n");
        }
    }

    echo "Connected to database. Importing schema...\n";

    // Read and execute SQL file
    $sql = file_get_contents('database_setup.sql');
    if ($sql === false) {
        die("Could not read database_setup.sql file.\n");
    }

    // Split into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    $successCount = 0;
    $errorCount = 0;

    foreach($statements as $stmt) {
        if(!empty($stmt)) {
            if ($conn->query($stmt) === TRUE) {
                $successCount++;
            } else {
                echo "Error executing: " . $stmt . "\n";
                echo "Error: " . $conn->error . "\n";
                $errorCount++;
            }
        }
    }

    echo "Database setup complete!\n";
    echo "Successful statements: $successCount\n";
    echo "Errors: $errorCount\n";

    // Verify tables were created
    $result = $conn->query("SHOW TABLES");
    echo "\nCreated tables:\n";
    while ($row = $result->fetch_array()) {
        echo "- " . $row[0] . "\n";
    }

    // Show sample data
    $result = $conn->query("SELECT COUNT(*) as count FROM students");
    $row = $result->fetch_assoc();
    echo "\nSample voters loaded: " . $row['count'] . "\n";

    $conn->close();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>