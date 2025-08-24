<?php
session_start();
require 'config.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Lưu session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];

            header("Location: index.php"); 
            exit;
        } else {
            $error = "Mật khẩu không đúng!";
        }
    } else {
        $error = "Email không tồn tại!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Đăng nhập - DentalClinic</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/favicon.png"/>
   <style>
      body {
         background: #f8f9fa;
      }
      .login-container {
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
      }
      .login-box {
         background: #fff;
         padding: 40px;
         border-radius: 10px;
         box-shadow: 0 0 15px rgba(0,0,0,0.1);
         width: 100%;
         max-width: 400px;
      }
      .login-box h3 {
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
   </style>
</head>
<body>

<!-- header (giữ đồng bộ với index.php) -->
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
         <a href="index.php#contact" class="link-btn">make appointment</a>
      </div>
   </div>
</header>

<div class="login-container">
   <div class="login-box">
      <h3>Đăng nhập</h3>
      <?php if ($error) { echo "<div class='error-msg'>$error</div>"; } ?>
      <form method="post" action="">
         <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
         </div>
         <div class="form-group">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
         </div>
         <button type="submit" name="login" class="link-btn btn-block">Đăng nhập</button>
      </form>
   </div>
</div>


</body>
</html>
