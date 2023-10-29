<?php
header("Access-Control-Allow-Origin: *");

header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$dbusername = "ditz";
$dbpassword = "hotdogsql";
$dbname = "tougeleaderboard";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]));
}

// Get player name from POST data
$playername = $_POST['name'] ?? '';

// Query to get uid for the given playername from the users table
$sql = "SELECT uid FROM users WHERE name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $playername);  // "s" indicates the variable type is a string
$stmt->execute();
$result = $stmt->get_result();

$response = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = [
        'status' => 'success',
        'data' => ['uid' => $row["uid"]]
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => "No user found with the name: " . $playername
    ];
}

echo json_encode($response);

// Close the statement and the connection
$stmt->close();
$conn->close();
?>

