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

// No need for the uid in this query, so we'll comment this out
// $uid = $_POST['uid'];

// Create the SQL query
$sql = "SELECT 
    users.name,
    map1times.time,
    map1scores.score
FROM 
    map1scores
JOIN 
    users ON map1scores.uid = users.uid
LEFT JOIN 
    map1times ON map1scores.uid = map1times.uid
WHERE
	map1times.time > 0 AND map1scores.score > 0
ORDER BY 
    map1scores.score DESC
LIMIT 10;
";

$stmt = $conn->prepare($sql);
// Since we're not using the uid in the query, we'll comment this out too
// $stmt->bind_param("i", $uid);  // "i" indicates the variable type is an integer
$stmt->execute();

$result = $stmt->get_result();

$response = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'status' => 'success',
            'name' => $row["name"],
            'time' => $row["time"],
            'score' => $row["score"]
        ];
    }
} else {
    $response[] = [
        'status' => 'error',
        'message' => 'No matching records found'
    ];
}

echo json_encode(['results' => $response]);

// Close the statement and the connection
$stmt->close();
$conn->close();
?>