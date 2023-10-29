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
$name= $_POST['name'] ?? '';
$password= $_POST['password'] ?? '' ;

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// Query to insert times for the given uid into map1times table
$sql = "INSERT INTO users (name, password) VALUES (?, ?);";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $name, $hashedPassword);  // "i" indicates integer, "d" indicates double/float
if ($stmt->execute()) {
    echo "account created: ". $name;
} else {
    echo "Error inserting time for UID: " . $name;
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>

</body>
</html>
