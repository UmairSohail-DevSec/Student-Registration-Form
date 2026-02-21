<?php
session_start();
require 'config.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // user_id from session
    // all inputs required
    $cnic = $conn->real_escape_string($_POST['cnic']);
    $student_name = $conn->real_escape_string($_POST['student_name']);
    $father_name = $conn->real_escape_string($_POST['father_name']);
    $last_degree = $conn->real_escape_string($_POST['last_degree']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $province = $conn->real_escape_string($_POST['province']);
    $postal_code = $conn->real_escape_string($_POST['postal_code']);
    $gender = $conn->real_escape_string($_POST['gender']);
    // Check for duplicate submission
    $check_sql = "SELECT id FROM admissions WHERE user_id = $user_id OR cnic = '$cnic'";
    $result = $conn->query($check_sql);
    if ($result && $result->num_rows > 0) {
        echo " This CNIC is already used.";
        $conn->close();
        exit;
    }
    // Proceed if all required fields are filled
    if ($cnic && $student_name && $father_name && $last_degree && $phone && $address) {
        $sql = "INSERT INTO admissions (user_id, cnic, student_name, father_name, last_degree, phone, address, city, province, postal_code, gender)
                VALUES ('$user_id', '$cnic', '$student_name', '$father_name', '$last_degree', '$phone', '$address', '$city', '$province', '$postal_code', '$gender')";

        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo " DB Error: " . $conn->error;
        }
    } else {
        echo " Please fill all required fields.";
    }
}
$conn->close();
?>
