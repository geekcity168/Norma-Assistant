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

$data = json_decode(file_get_contents("php://input"));

$stmt = $conn->prepare("INSERT INTO users (full_name, email, password, country) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $email, $password, $country);


$fullname = $data->fullname;
$email = $data->email;
$password = password_hash($data->password, PASSWORD_DEFAULT); 
$country = $data->country;
$stmt->execute();

$_SESSION['email'] = $email;

$stmt->close();
$conn->close();

echo "Signup successful!";
?>
