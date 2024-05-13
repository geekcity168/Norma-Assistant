<?php
session_start(); // Start the session

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norma_assistant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email address from the session
$email = $_SESSION['email'];

// Query to fetch user_id based on email
$sql = "SELECT user_id FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userID = $row['user_id'];

    // Retrieve other form data
    $bankName = $_POST['bankName'];
    $accountNumber = $_POST['accountNumber'];
    $expirationDate = $_POST['expirationDate'];
    $cvcCode = $_POST['cvcCode'];

    // Insert data into the database
    $sql = "INSERT INTO banks (bank_name, account_number, expiration_date, cvc_code, user_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $bankName, $accountNumber, $expirationDate, $cvcCode, $userID);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "error";
}

$conn->close();
?>
