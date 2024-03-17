<!DOCTYPE html>
<html>

<head>
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

<body>
    <?php
include('includes/config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'admin/PHPMailer/src/PHPMailer.php';
require 'admin/PHPMailer/src/SMTP.php';
require 'admin/PHPMailer/src/Exception.php';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(32)); // สร้างโทเคนสำหรับการยืนยัน

    // เชื่อมต่อกับฐานข้อมูลและตรวจสอบว่ามีอีเมลในฐานข้อมูลหรือไม่
    $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
    $num = mysqli_num_rows($query);

    if ($num > 0) {
        // บันทึกโทเคนลงในฐานข้อมูล เพื่อใช้ในการยืนยัน
        mysqli_query($con, "UPDATE users SET reset_token ='$token' WHERE email='$email'");

        // สร้างอินสแตนซ์ของ PHPMailer
        $mail = new PHPMailer;

        // ตั้งค่า SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // ตั้งค่าเซิร์ฟเวอร์ SMTP ของคุณ
        $mail->SMTPAuth = true;
        $mail->Username = 'nwmin22@gmail.com'; // ชื่อผู้ใช้ SMTP
        $mail->Password = 'ogph giaq bnuk ecmx'; // รหัสผ่าน SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // เลือกการเชื่อมต่อที่ปลอดภัย
        $mail->Port = 587; // หมายเลขพอร์ต SMTP

        // ตั้งค่าผู้ส่ง
        $mail->setFrom('Vintage_Shirt_Shop@gmail.com', 'Vintage Shirt Shop');
        $mail->addAddress($email);

        // ตั้งค่าเนื้อหาอีเมล
        $mail->Subject = 'Password reset';
        $mail->Body = "Click this link to reset your password : http://localhost/shopping/reset_password.php?email=$email&token=$token";

        // ส่งอีเมล
        if ($mail->send()) {
            echo "<div class='message-box yellow-border'>A password reset link has been sent to your email.</div>";
        } else {
            echo "<div class='message-box yellow-border'>Email sending failed: " . $mail->ErrorInfo . "</div>";
        }
    } else {
        echo "<div class='message-box'>Invalid email</div>";
    }

    mysqli_close($con);
}
?>
    <button class="back-button" onclick="window.history.go(-1)">Back</button>
</body>

</html>