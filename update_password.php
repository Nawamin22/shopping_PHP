<?php
include('includes/config.php');
?>

<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: black;
            /* เปลี่ยนสีพื้นหลังเป็นสีดำ */
        }

        .message-box {
            border: 2px solid #333;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            background-color: #f7f7f7;
            font-weight: bold;
            /* ทำให้ตัวอักษรเป็นตัวหนา */
            font-family: Arial, sans-serif;
            /* เปลี่ยนรูปแบบตัวอักษร */
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #78BF63;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .yellow-border {
            border: 2px solid yellow;
            /* สีเส้นสีเหลือง */
        }
    </style>
</head>
<?php
if (isset($_POST['update'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    mysqli_query($con, "UPDATE users SET password='$password', reset_token='' WHERE email='$email'");
    echo "<div class='message-box yellow-border'>The password has been successfully updated.</div>";
    mysqli_close($con);
}
?>
 <a href="http://localhost/shopping/login.php" class="back-button">Go to Login</a>
</html>