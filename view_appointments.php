<?php
session_start();
require 'config.php';

// Kiểm tra login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Lấy danh sách lịch hẹn của user
$stmt = $conn->prepare("SELECT name, email, phone, appointment_date FROM appointments WHERE user_id = ? ORDER BY appointment_date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>My Appointments - Dental Clinic</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/favicon.png"/>
   <style>
      .appointments {
         margin-top: 120px;
      }
      .appointments h1 {
         margin-bottom: 20px;
         text-align: center;
         font-size: 28px;
         font-weight: bold;
      }
      .appointments table {
         width: 100%;
         border-collapse: collapse;
         margin-top: 20px;
      }
      .appointments th, .appointments td {
         border: 1px solid #ddd;
         padding: 10px;
         text-align: center;
      }
      .appointments th {
         background: #06a3da;
         color: #fff;
      }
   </style>
</head>
<body>

<!-- header section starts  -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         
         <!-- Logo -->
         <a href="index.php#home" class="logo">dental<span>Clinic.</span></a>
         
         <!-- Navbar -->
         <nav class="nav">
            <a href="index.php#home">home</a>
            <a href="index.php#about">about</a>
            <a href="index.php#services">services</a>
            <a href="index.php#reviews">reviews</a>
            <a href="index.php#contact">contact</a>
         </nav>

         <!-- Kiểm tra login -->
         <div class="text-right">
            <?php if (isset($_SESSION['user_email'])): ?>
               <div>
                  <a href="view_appointments.php" class="link-btn">My Appointments</a>
                  <a href="logout.php" class="link-btn">Logout</a>
               </div>
               <div style="margin-top:5px; font-size:14px; color:#333;">
                  Xin chào, <b><?php echo htmlspecialchars($_SESSION['user_email']); ?></b>
               </div>
            <?php else: ?>
               <div>
                  <a href="index.php#contact" class="link-btn">Make Appointment</a>
                  <a href="login.php" class="link-btn">Login</a>
                  <a href="register.php" class="link-btn">Sign Up</a>
               </div>
            <?php endif; ?>
         </div>

         <!-- Mobile menu button -->
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
   </div>
</header>
<!-- header section ends -->

<!-- appointments section starts -->
<section class="appointments container">
   <h1>My Appointments</h1>
   <?php if ($result->num_rows > 0): ?>
      <table>
         <thead>
            <tr>
               <th>Name</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Appointment Date</th>
            </tr>
         </thead>
         <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
               <tr>
                  <td><?php echo htmlspecialchars($row['name']); ?></td>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td><?php echo htmlspecialchars($row['phone']); ?></td>
                  <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
               </tr>
            <?php endwhile; ?>
         </tbody>
      </table>
   <?php else: ?>
      <p style="text-align:center;">You have no appointments booked.</p>
   <?php endif; ?>
</section>
<!-- appointments section ends -->

<!-- footer section starts  -->
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
         <p>227, Nguyen Van Cu, District 5, HCM city </p>
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
<!-- footer section ends -->

<!-- custom js file link  -->
<script src="js/script.js"></script>
</body>
</html>
