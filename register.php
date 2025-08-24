<?php
session_start();
require 'config.php';

$error = "";
$success = "";

if (isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);


    // Kiểm tra mật khẩu trùng khớp
    if ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không trùng khớp!";
    } else {
        // Kiểm tra email đã tồn tại chưa
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email đã được đăng ký!";
        } else {
            // Hash mật khẩu
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $name, $email, $phone, $hash);
            
            if ($stmt->execute()) {
                $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay.";
            } else {
                $error = "Có lỗi xảy ra, vui lòng thử lại.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Đăng ký - DentalClinic</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/favicon.png"/>
   <style>
      body {
         background: #f8f9fa;
      }
      .register-container {
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .register-box {
         background: #fff;
         padding: 40px;
         border-radius: 10px;
         box-shadow: 0 0 15px rgba(0,0,0,0.1);
         width: 100%;
         max-width: 400px;
      }
      .register-box h3 {
         margin-bottom: 20px;
         text-align: center;
         font-weight: bold;
      }
      .error-msg {
         background: #f8d7da;
         color: #721c24;
         padding: 10px;
         border-radius: 5px;
         margin-bottom: 15px;
         text-align: center;
      }
      .success-msg {
         background: #d4edda;
         color: #155724;
         padding: 10px;
         border-radius: 5px;
         margin-bottom: 15px;
         text-align: center;
      }
   </style>
</head>
<body>

<!-- header -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         <a href="index.php" class="logo">dental<span>Clinic.</span></a>
         <nav class="nav">
            <a href="index.php#home">home</a>
            <a href="index.php#about">about</a>
            <a href="index.php#services">services</a>
            <a href="index.php#reviews">reviews</a>
            <a href="index.php#contact">contact</a>
         </nav>
         <a href="login.php" class="link-btn">login</a>
      </div>
   </div>
</header>

<div class="register-container">
   <div class="register-box">
      <h3>Tạo tài khoản</h3>
      <?php 
         if ($error) echo "<div class='error-msg'>$error</div>";
         if ($success) echo "<div class='success-msg'>$success</div>";
      ?>
      <form method="post" action="">
         <div class="form-group">
            <label>Họ và tên</label>
            <input type="text" name="name" class="form-control" required>
         </div>
         <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" pattern="[0-9]{10}" title="Số điện thoại phải có 10 chữ số" required>
         </div>
         <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
         </div>
         <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
         </div>
         <div class="form-group">
            <label>Xác nhận mật khẩu</label>
            <input type="password" name="confirm" class="form-control" required>
         </div>
         <button type="submit" name="register" class="link-btn btn-block">Đăng ký</button>
      </form>
      <p class="text-center mt-3">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
   </div>
</div>

</body>
</html>
