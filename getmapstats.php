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
$uid = $_POST['uid'];

// Create the SQL query
$sql = "SELECT users.name, map1times.time, map1scores.score 
        FROM users 
        LEFT JOIN map1times ON users.uid = map1times.uid 
        LEFT JOIN map1scores ON users.uid = map1scores.uid 
        WHERE users.uid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);  // "i" indicates the variable type is an integer
$stmt->execute();

$result = $stmt->get_result();

$response = [];
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response = [
        'status' => 'success',
        'data' => [
            'name' => $row["name"],
            'time' => $row["time"],
            'score' => $row["score"]
        ]
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'No matching records found'
    ];
}

echo json_encode($response);
// Close the statement and the connection
$stmt->close();
$conn->close();
?>

