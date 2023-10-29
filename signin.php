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

// Get user details from POST data
$name = $_POST['name'] ?? '';
$password = $_POST['password'] ?? '';

// Query to get the hashed password for the given username from the users table
$sql = "SELECT password FROM users WHERE name = ?;";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $name);  
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If the user is found and the password is correct
if ($row && password_verify($password, $row['password'])) {
    echo "User signed in successfully!";
} else {
    echo "Incorrect username or password.";
}

// Close the statement and the connection
$stmt->close();
$conn->close();
?>


