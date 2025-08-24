<?php
session_start();
require 'config.php';

if (isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    $name   = htmlspecialchars($_POST['name']);
    $email  = htmlspecialchars($_POST['email']);
    $phone  = htmlspecialchars($_POST['number']);
    $service= htmlspecialchars($_POST['service']);
    $date   = htmlspecialchars($_POST['date']);
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO appointments (user_id, name, email, phone, service, appointment_date) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $userId, $name, $email, $phone, $service, $date);
    $stmt->execute();

    $message[] = "Cảm ơn <b>$name</b>, bạn đã đặt lịch hẹn <b>$service</b> vào <b>$date</b>. 
                  Chúng tôi sẽ liên hệ qua email <b>$email</b> hoặc số điện thoại <b>$phone</b>.";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dentist Website</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="icon" href="images/favicon.png"/>
   <style>
      .message {
         margin: 10px 0;
         padding: 10px;
         background: #d4edda;
         color: #155724;
         border: 1px solid #c3e6cb;
         border-radius: 5px;
      }
   </style>
</head>
<body>

<!-- header section starts  -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         
         <!-- Logo -->
         <a href="#home" class="logo">dental<span>Clinic.</span></a>
         
         <!-- Navbar -->
         <nav class="nav">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#reviews">reviews</a>
            <a href="#contact">contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
               <a href="profile.php">Profile</a>
            <?php endif; ?>
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
                  <a href="#contact" class="link-btn">Make Appointment</a>
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

<!-- home section starts  -->
<section class="home" id="home">
   <div class="container">
      <div class="row min-vh-100 align-items-center">
         <div class="content text-center text-md-left">
            <h3>Allow us to make your smile brighter.</h3>
            <p>DentalClinic Can Help You Get the Smile You've Always Wanted. We offer cosmetic dentistry, root canal therapy, cavity inspections, and more.
            </p>
            <a href="#contact" class="link-btn">make appointment</a>
         </div>
      </div>
   </div>
</section>
<!-- home section ends -->

<!-- about section starts  -->
<section class="about" id="about">
   <div class="container">
      <div class="row align-items-center">
         <div class="col-md-6 image">
            <img src="images/about-img.jpg" class="w-100 mb-5 mb-md-0" alt="">
         </div>
         <div class="col-md-6 content">
            <span>about us</span>
            <h3>Genuine Family Healthcare</h3>
            <p>DentalClinic helps you achieve the quintessentially oriented smile you have always craved. Our product gets the job done without making you go through any hassle or discomfort.</p>
            <a href="#contact" class="link-btn">make appointment</a>
         </div>
      </div>
   </div>
</section>
<!-- about section ends -->

<!-- services section starts  -->
<section class="services" id="services">
   <h1 class="heading">our services</h1>
   <div class="box-container container">
      <div class="box">
         <img src="images/icon-1.svg" alt="">
         <h3>Alignment specialist</h3>
      </div>
      <div class="box">
         <img src="images/icon-2.svg" alt="">
         <h3>Cosmetic dentistry</h3>
      </div>
      <div class="box">
         <img src="images/icon-3.svg" alt="">
         <h3>Oral hygiene experts</h3>
      </div>
      <div class="box">
         <img src="images/icon-4.svg" alt="">
         <h3>Root canal specialist</h3>
      </div>
      <div class="box">
         <img src="images/icon-5.svg" alt="">
         <h3>Live dental advisory</h3>
      </div>
      <div class="box">
         <img src="images/icon-6.svg" alt="">
         <h3>Cavity inspection</h3>
      </div>
   </div>
</section>
<!-- services section ends -->

<!-- contact section starts  -->
<section class="contact" id="contact">
   <h1 class="heading">make appointment</h1>

   <?php
      if (!empty($message)) {
         foreach ($message as $msg) {
            echo "<p class='message'>$msg</p>";
         }
      }
   ?>

   <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <span>Enter your name :</span>
      <input type="text" name="name" placeholder="Enter your name" class="box" required>
      <span>Enter your email :</span>
      <input type="email" name="email" placeholder="Enter your email" class="box" required>
      <span>Enter your number :</span>
      <input type="text" name="number" placeholder="Enter your number" class="box" pattern="[0-9]{10}" title="Phone number must be 10 digits" required>
      <span>Select Service :</span>
      <select name="service" class="box" required>
         <option value="">-- Select a service --</option>
         <option value="Alignment Specialist">Alignment Specialist</option>
         <option value="Cosmetic Dentistry">Cosmetic Dentistry</option>
         <option value="Oral Hygiene Experts">Oral Hygiene Experts</option>
         <option value="Root Canal Specialist">Root Canal Specialist</option>
         <option value="Live Dental Advisory">Live Dental Advisory</option>
         <option value="Cavity Inspection">Cavity Inspection</option>
      </select>
      <span>Enter appointment date :</span>
      <input type="datetime-local" name="date" class="box" min="<?php echo date('Y-m-d\TH:i'); ?>" required>
      <input type="submit" value="make appointment" name="submit" class="link-btn">
   </form>
</section>
<!-- contact section ends -->

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
