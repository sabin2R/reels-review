<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="button.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            width: 60%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .welcome-section, .signup-section {
            width: 50%;
            padding: 40px;
            box-sizing: border-box;
        }

        .welcome-section {
            background-color: #f7f7f7;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .welcome-section h2 {
            margin-bottom: 20px;
        }

        .welcome-section button {
            padding: 10px 20px;
            border: none;
            background-color: #555;
            color: #fff;
            cursor: pointer;
        }

        .signup-section h2 {
            margin-bottom: 20px;
        }

        .signup-section form {
            display: flex;
            flex-direction: column;
        }

        .signup-section label {
            margin-bottom: 5px;
        }

        .signup-section input {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .signup-section button {
            padding: 10px;
            border: none;
            background-color: #555;
            color: #fff;
            cursor: pointer;
        }

        .signup-section a {
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        .signup-section p {
            margin: 10px 0;
            text-align: center;
        }

        .social-login {
            display: flex;
            justify-content: center;
        }

        .social-login a {
            margin: 0 10px;
        }

        .social-login img {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="welcome-section">
            <h2>Welcome Back!</h2>
            <button class="btn-1" onclick="window.location.href='login.php'">Sign In</button>
        </div>
        <div class="signup-section">
            <h2>Create an Account</h2>
            <form action="" method="POST">
                <label for="Name">Name</label>
                <input type="text" id="Name" name="Name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <button class ="btn-1" type="submit">Sign Up</button>
                <p>or use your email for registration</p>
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['Name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Database connection
        $servername ="localhost";
        $username="root";
        $password_db ="";
        $dbname="reelreview";
        $conn = new mysqli($servername, $username, $password_db, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Sanitize input
        $name = $conn->real_escape_string($name);
        $email = $conn->real_escape_string($email);
        $password = $conn->real_escape_string($hashed_password);

        // Insert user into database
        $sql = "INSERT INTO users (Name, email, password) VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " .$sql . "<br>" . $conn->error;
        }

        $conn->close();
    }
    ?>
</body>
</html>
