<?php
require 'function.php';

//cek login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM login WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        $_SESSION['login'] = true;
        header("location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }

    // Close the statement
    $stmt->close();
}

if (isset($_SESSION['login'])) {
    header("location: dashboard.php");
    // exit();
}
?>

