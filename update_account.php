<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'includes/db_connect.php';

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// Fetch current user data to check if email has changed
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user['email'] !== $email) {
    // Check if the new email already exists
    $sql_email_check = "SELECT id FROM users WHERE email = ?";
    $stmt_email_check = $conn->prepare($sql_email_check);
    $stmt_email_check->bind_param("s", $email);
    $stmt_email_check->execute();
    $email_exists = $stmt_email_check->get_result()->num_rows > 0;
    $stmt_email_check->close();

    if ($email_exists) {
        echo "<script>alert('Email already in use. Please choose another email.'); window.location.href='account.php';</script>";
        exit();
    }
}

// Update user details
if (!empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql_update = "UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $name, $email, $password, $user_id);
} else {
    $sql_update = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssi", $name, $email, $user_id);
}

if ($stmt_update->execute()) {
    echo "<script>alert('Account updated successfully!'); window.location.href='account.php';</script>";
} else {
    echo "<script>alert('An error occurred while updating your account.'); window.location.href='account.php';</script>";
}

$stmt_update->close();
$conn->close();
?>
