<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "norma_assistant";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    die(json_encode(['success' => false, 'message' => 'Database connection failed.']));
}

$email = $_POST['email'];
$password = $_POST['password'];

// Validate form data
if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

// Fetch user data from the database
$sql = "SELECT user_id, password FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    die(json_encode(['success' => false, 'message' => 'Database query failed.']));
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}

$user = $result->fetch_assoc();
$storedPassword = $user['password'];

// Verify password
if (!password_verify($password, $storedPassword)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    exit;
}

// Set session variables
$_SESSION['email'] = $email;

echo json_encode(['success' => true, 'message' => 'Login successful.']);

$stmt->close();
$conn->close();
?>
