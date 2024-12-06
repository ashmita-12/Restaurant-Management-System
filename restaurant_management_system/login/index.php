<?php
session_start();
$_SESSION['admin_id'] = null;

if (isset($_POST['login'])) {
    include "../config.php";

    // Sanitize the inputs to prevent SQL injection
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    // Fetch user from the database
    $result_query = "SELECT id, username, password FROM login WHERE username = '$username' AND password = '$password'";

    $user_result = mysqli_query($connection, $result_query);
    if (!$user_result) {
        echo "Error: " . mysqli_error($connection);
        exit();
    }

    // Check if the query returned any rows
    if (mysqli_num_rows($user_result) > 0) {
        $user = mysqli_fetch_assoc($user_result);
        // User has been found, log them in
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_type'] = 'admin';

        echo "<script>window.location.href='../admin'</script>";
        exit();
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurant Management System</title>
    <link rel="stylesheet" href="../style.css">
</head>

<body>
    <div class="container">
        <div class="form-container">
            <p class="title" style="text-align:center;">Login</p>
            <p style="text-align:center;margin:10px 0">Please login to our restaurant management system</p>
            <form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" placeholder="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="password" required>
                    <div class="forgot"></div>
                </div>
                <button class="sign" name="login" style="color:white;">Sign in</button>
            </form>
        </div>
    </div>
</body>

</html>