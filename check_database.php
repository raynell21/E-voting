<?php
// Check current database status
echo "Checking E-Voting database status...\n\n";

try {
    $conn = new mysqli('localhost', 'root', '', 'e_voting');

    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error . "\n");
    }

    echo "✅ Connected to database 'e_voting'\n\n";

    // Check tables
    $result = $conn->query("SHOW TABLES");
    echo "📋 Tables in database:\n";
    $tables = [];
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
        echo "- " . $row[0] . "\n";
    }

    echo "\n";

    // Check each table
    if (in_array('students', $tables)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM students");
        $row = $result->fetch_assoc();
        echo "👥 Students table: " . $row['count'] . " records\n";

        // Show first few students
        $result = $conn->query("SELECT nid, phone, name FROM students LIMIT 5");
        echo "   Sample data:\n";
        while ($row = $result->fetch_assoc()) {
            echo "   - NID: {$row['nid']}, Phone: {$row['phone']}, Name: {$row['name']}\n";
        }
    }

    if (in_array('votes', $tables)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM votes");
        $row = $result->fetch_assoc();
        echo "🗳️  Votes table: " . $row['count'] . " records\n";
    }

    if (in_array('candidates', $tables)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM candidates");
        $row = $result->fetch_assoc();
        echo "👤 Candidates table: " . $row['count'] . " records\n";
    }

    echo "\n🔍 Testing login with sample data:\n";

    // Test login query
    $stmt = $conn->prepare("SELECT id, phone FROM students WHERE nid = ? AND phone = ?");
    $test_nid = '12345678';
    $test_phone = '+254700000001';

    $stmt->bind_param("ss", $test_nid, $test_phone);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if ($student) {
        echo "✅ Login test PASSED: NID $test_nid with phone $test_phone found (ID: {$student['id']})\n";
    } else {
        echo "❌ Login test FAILED: NID $test_nid with phone $test_phone not found\n";
    }

    $stmt->close();
    $conn->close();

    echo "\n💡 If login is failing, try these solutions:\n";
    echo "1. Check that you're entering the exact NID and phone number\n";
    echo "2. Make sure XAMPP MySQL is running\n";
    echo "3. Verify the database name in connection.php is 'e_voting'\n";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>