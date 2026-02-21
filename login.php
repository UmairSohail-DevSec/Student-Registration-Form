<?php
session_start();
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Fixed table name: changed 'user' to 'users'
    $sql = "SELECT * FROM users WHERE email='$email'";
    
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            echo "login successful. Redirecting...";
            header("Location:admission.html"); // Correct file to show form
            exit;
        } else {
            echo "❌ Invalid password!";
        }
    } else {
        echo "❌ User not found!";
    }
}
$conn->close();
?>
