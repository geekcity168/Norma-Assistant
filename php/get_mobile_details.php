<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norma_assistant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['email'])) {
    error_log("No email found in session");
    die("No email found in session");
}

$email = $_SESSION['email'];

$sql = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    error_log("No user found with this email");
    die("No user found with this email");
}

$user = $result->fetch_assoc();
$userID = $user['user_id'];

// Retrieve the latest mobile details for the user
$sql = "SELECT mobile_platform, mobile_number FROM mobile_gateway WHERE user_id = ? ORDER BY mobile_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No mobile details found']);
    exit;
}

$mobileDetails = $result->fetch_assoc();
echo json_encode($mobileDetails);

$stmt->close();
$conn->close();
?>
