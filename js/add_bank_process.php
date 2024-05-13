<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norma_assistant";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$bankName = $_POST['bankName'];
$accountNumber = $_POST['accountNumber'];
$expirationDate = $_POST['expirationDate'];
$cvcCode = $_POST['cvcCode'];
$userID = $_POST['userID'];

// Insert data into the database
$sql = "INSERT INTO banks (bank_name, account_number, expiration_date, cvc_code, user_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $bankName, $accountNumber, $expirationDate, $cvcCode, $userID);

// Execute the prepared statement
if ($stmt->execute()) {
    echo "success";
} else {
    echo "error";
    // Log the error
    error_log("Error: " . $sql . "\n" . $stmt->error);
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
