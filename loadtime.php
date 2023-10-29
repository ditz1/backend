
<?php
header("Access-Control-Allow-Origin: *");

// Database credentials
$servername = "localhost";
$dbusername = "ditz";
$dbpassword = "hotdogsql";
$dbname = "tougeleaderboard";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get uid and besttime from POST data
$uid = isset($_POST['uid']) ? intval($_POST['uid']) : 0;
$map1besttime = isset($_POST['besttime']) ? floatval($_POST['besttime']) : 0.0;

// Query to insert times for the given uid into map1times table
$sql = "update map1times set time=? where uid = ? ";
$stmt = $conn->prepare($sql);
$stmt->bind_param("di", $map1besttime, $uid);  // "i" indicates integer, "d" indicates double/float
if ($stmt->execute()) {
    echo "Time successfully inserted for UID: ". $map1besttime. $uid;
} else {
    echo "Error inserting time for UID: " . $uid;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>
