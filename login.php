<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel = "stylesheet" href ="button.css">
    <link rel = "stylesheet" href ="./asset/css/login.css">

</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h2>Welcome Back!</h2>
            <button class= "btn-1" onclick="window.location.href='register.php'">Sign Up</button>
        </div>
        <div class="login-section">
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <button class= "btn-1" type="submit">Sign In</button>
                <a href="#">Forgot Password?</a>
                <p>Or</p>
                <p>Login with:</p>
                <div class="social-login">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </form>
        </div>
    </div>
    
    <?php
    include "db_connect.php";
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        

        // Sanitize input
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($password);

        // Query to check user credentials
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: main.php");
                exit();
            } else {
                echo "<script>alert('Invalid password.');</script>";
            }
        } else {
            echo "<script>alert('No user found with this email.');</script>";
        }

        $conn->close();
    }
    ?>
</body>
</html>
