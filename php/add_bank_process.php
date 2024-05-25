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

// Retrieve form data
$bankName = $_POST['bankName'];
$accountNumber = $_POST['accountNumber'];
$expirationDate = $_POST['expirationDate'];
$cvcCode = $_POST['cvcCode'];

// Validate form data (optional, but recommended)
if (empty($bankName) || empty($accountNumber) || empty($expirationDate) || empty($cvcCode)) {
    error_log("Form data is incomplete");
    echo "error";
    exit;
}

// Insert data into the database
$sql = "INSERT INTO banks (bank_name, account_number, expiration_date, cvc_code, user_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    echo "error";
    exit;
}
$stmt->bind_param("ssssi", $bankName, $accountNumber, $expirationDate, $cvcCode, $userID);

if ($stmt->execute()) {
    echo "success";
} else {
    error_log("Execute failed: " . $stmt->error);
    echo "error";
}

$stmt->close();
$conn->close();
?>
