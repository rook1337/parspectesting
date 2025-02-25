<?php
session_start();

$conn = new mysqli("localhost", "testing", "P@ssw0rd", "testing");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password); // 'ss' means both are strings

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "Success";
        exit;
    } else {
        $error = "Invalid password!";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Secure Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Password:</label>
        <input type="text" name="password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
</body>
</html>
