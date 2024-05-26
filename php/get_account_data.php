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
$user_id = $user['user_id'];

$sql = "SELECT account_balance FROM bank_accounts WHERE user_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No account details found']);
    exit;
}

$account = $result->fetch_assoc();
echo json_encode($account);

$stmt->close();
$conn->close();

