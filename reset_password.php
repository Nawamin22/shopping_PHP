
<?php
include('includes/config.php');
?>

<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding: 100px;
        }

        .container {
            max-width: 400px;
            margin:  auto;
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
        }

        .form-input {
            margin: 10px 0;
            width: 80%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-submit {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($_GET['email']) && isset($_GET['token'])) {
            $email = $_GET['email'];
            $token = $_GET['token'];

            // ตรวจสอบว่าอีเมลและโทเคนถูกต้องหรือไม่
            $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND reset_token='$token'");
            $num = mysqli_num_rows($query);

            if ($num > 0) {
                echo '<h2>Reset Your Password</h2>';
                echo '<form method="post" action="update_password.php">';
                echo '<input type="hidden" name="email" value="' . $email . '">';
                echo '<input class="form-input" type="password" name="password" placeholder="New Password" required>';
                echo '<input class="form-submit" type="submit" name="update" value="Update Password">';
                echo '</form>';
            } else {
                echo '<p>Invalid email or token.</p>';
            }
        }
        ?>
    </div>
</body>
</html>
