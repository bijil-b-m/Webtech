<?php
$servername = "localhost:3307";
$username = "root@localhost";
$password = "";
$dbname = "university";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'];
$pass = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hashed_password);
$stmt->fetch();

if ($stmt->num_rows > 0 && password_verify($pass, $hashed_password)) {
    echo "Login successful! Welcome, " . htmlspecialchars($user);
} else {
    echo "Invalid username or password.";
}

$stmt->close();
$conn->close();
?>
