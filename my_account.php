<?php
session_start();
require 'config.php';

// Kiểm tra user đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Lấy thông tin user từ DB
$stmt = $conn->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Account - Dental Clinic</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Header -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         <a href="index.php#home" class="logo">dental<span>Clinic.</span></a>
         <nav class="nav">
            <a href="index.php#home">home</a>
            <a href="index.php#about">about</a>
            <a href="index.php#services">services</a>
            <a href="index.php#reviews">reviews</a>
            <a href="index.php#contact">contact</a>
         </nav>
         <div>
            <a href="view_appointments.php" class="link-btn">My Appointments</a>
            <a href="my_account.php" class="link-btn">My Account</a>
            <a href="logout.php" class="link-btn">Logout</a>
         </div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
   </div>
</header>

<!-- My Account Section -->
<section class="contact" style="margin-top:100px;">
   <div class="container">
      <h1 class="heading">My Account</h1>
      <div class="box-container">
         <div class="box" style="padding:20px; font-size:18px; line-height:1.8;">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></p>
         </div>
      </div>
   </div>
</section>

<!-- Footer -->
<section class="footer">
   <div class="box-container container">
      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>phone number</h3>
         <p>+123-456-7890</p>
      </div>
      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>our address</h3>
         <p>227, Nguyen Van Cu, District 5, HCM city</p>
      </div>
      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>10:00am to 07:00pm</p>
      </div>
      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email address</h3>
         <p>nhom09@gmail.com</p>
      </div>
   </div>
   <div class="credit"> This is the work of group 09. </div>
</section>

</body>
</html>
