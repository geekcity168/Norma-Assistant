<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norma_assistant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user email from session
$email = $_SESSION['email'];

// Fetch user data from the database
$sql = "SELECT full_name, email FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
    // Output user data as JSON
    echo json_encode($userData);
} else {
    // Return empty JSON object if user not found
    echo json_encode((object) []);
}

$stmt->close();
$conn->close();
?>
