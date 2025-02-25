<?php
session_start();

$conn = new mysqli("localhost", "testing", "P@ssw0rd", "testing");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = "admin";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        echo "Success";
        exit;
    } else {
        $error = "Invalid password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Vulnerable Login</title>
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
