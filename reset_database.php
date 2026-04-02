<?php
// Reset database script - clears existing data and reimports

echo "🔄 Resetting E-Voting database...\n\n";

try {
    $conn = new mysqli('localhost', 'root', '', 'e_voting');

    if ($conn->connect_error) {
        die("❌ Database connection failed: " . $conn->connect_error . "\n");
    }

    echo "✅ Connected to database 'e_voting'\n";

    // Clear existing data (but keep tables)
    echo "🗑️  Clearing existing data...\n";

    $tables_to_clear = ['votes', 'students', 'candidates'];
    foreach ($tables_to_clear as $table) {
        if ($conn->query("TRUNCATE TABLE $table") === TRUE) {
            echo "   Cleared table: $table\n";
        } else {
            echo "   Warning: Could not clear $table: " . $conn->error . "\n";
        }
    }

    echo "\n📥 Re-importing sample data...\n";

    // Read and execute SQL file
    $sql = file_get_contents('database_setup.sql');
    if ($sql === false) {
        die("❌ Could not read database_setup.sql file.\n");
    }

    // Split into individual statements and filter out CREATE DATABASE and USE statements
    $statements = array_filter(array_map('trim', explode(';', $sql)));

    $successCount = 0;
    $errorCount = 0;

    foreach($statements as $stmt) {
        if(!empty($stmt)) {
            // Skip CREATE DATABASE and USE statements since DB already exists
            if (stripos($stmt, 'CREATE DATABASE') === 0 || stripos($stmt, 'USE ') === 0) {
                continue;
            }

            if ($conn->query($stmt) === TRUE) {
                $successCount++;
            } else {
                echo "❌ Error executing: " . substr($stmt, 0, 50) . "...\n";
                echo "   Error: " . $conn->error . "\n";
                $errorCount++;
            }
        }
    }

    echo "\n✅ Database reset complete!\n";
    echo "   Successful statements: $successCount\n";
    echo "   Errors: $errorCount\n";

    // Verify data was imported
    $result = $conn->query("SELECT COUNT(*) as count FROM students");
    $row = $result->fetch_assoc();
    echo "\n👥 Students loaded: " . $row['count'] . "\n";

    $result = $conn->query("SELECT COUNT(*) as count FROM candidates");
    $row = $result->fetch_assoc();
    echo "👤 Candidates loaded: " . $row['count'] . "\n";

    // Test login
    echo "\n🔍 Testing login with sample data:\n";
    $stmt = $conn->prepare("SELECT id, phone FROM students WHERE nid = ? AND phone = ?");
    $test_nid = '12345678';
    $test_phone = '+254700000001';

    $stmt->bind_param("ss", $test_nid, $test_phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        echo "✅ Login test PASSED: NID $test_nid found!\n";
        echo "   You can now login with:\n";
        echo "   - NID: 12345678\n";
        echo "   - Phone: +254700000001\n";
    } else {
        echo "❌ Login test FAILED: Sample data not found\n";
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>