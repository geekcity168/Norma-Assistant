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

// Retrieve the user ID based on the email
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

$row = $result->fetch_assoc();
$userID = $row['user_id'];

$mobilePlatform = $_POST['mobilePlatform'];
$mobilePhone = $_POST['mobilePhone'];

if (empty($mobilePlatform) || empty($mobilePhone)) {
    error_log("Form data is incomplete");
    echo "error";
    exit;
}

$sql = "INSERT INTO mobile_gateway (mobile_platform, mobile_number, user_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo "error";
    exit;
}
$stmt->bind_param("ssi", $mobilePlatform, $mobilePhone, $userID);

if ($stmt->execute()) {
    echo "success";
} else {
    error_log("Execute failed: " . $stmt->error);
    echo "error";
}

$stmt->close();
$conn->close();
?>
