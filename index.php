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

<!-- pricing section starts -->
<section id="pricing" style="padding:60px 0;background:#f8fafc;">

  <style>
    .pricing-inline .heading{
      text-align:center;font-size:36px;letter-spacing:.5px;margin:0 0 24px;
    }
    .pricing-inline .container{max-width:1000px;margin:0 auto;padding:0 16px;}
    .pricing-inline .price-table-wrap{margin:0 auto;overflow-x:auto;}
    .pricing-inline .price-table{
      width:100%;border-collapse:separate;border-spacing:0;background:#fff;
      border-radius:16px;overflow:hidden;box-shadow:0 12px 30px rgba(2,6,23,.08);
    }
    .pricing-inline .price-table th{
      background:#0ea5e9;color:#fff;text-transform:uppercase;font-weight:600;
      font-size:14px;letter-spacing:.06em;padding:14px 18px;text-align:left;
    }
    .pricing-inline .price-table th.th-right{ text-align:right; }
    .pricing-inline .price-table td{
      padding:16px 18px;font-size:16px;color:#1f2937;vertical-align:middle;
    }
    .pricing-inline .row-alt{ background:#f9fbff; }
    .pricing-inline .row-featured{ background:#fff7f7; }
    .pricing-inline .td-right{ text-align:right; }

    .pricing-inline .sale-badge{
      display:inline-flex;align-items:center;gap:6px;margin-left:8px;
      padding:4px 10px;border-radius:999px;background:#ef4444;color:#fff;
      font-weight:700;font-size:12px;letter-spacing:.3px;
      box-shadow:0 4px 12px rgba(239,68,68,.25);
    }

    .pricing-inline .price-stack{
      display:flex;flex-direction:column;align-items:flex-end;line-height:1.15;
    }
    .pricing-inline .price-old{
      color:#9ca3af;font-weight:700;padding:0 .06em;
      text-decoration:line-through;text-decoration-color:#ef4444;text-decoration-thickness:2px;
      background:linear-gradient(#ef4444,#ef4444) center/100% 2px no-repeat;
    }
    .pricing-inline .price-new{color:#16a34a;font-weight:800;margin-top:4px;}
    .pricing-inline .price-book{padding:10px 18px;border-radius:999px;font-size:14px;display:inline-block;}
    .pricing-inline .price-note{margin-top:12px;text-align:center;color:#64748b;font-size:14px;}
  </style>

  <div class="pricing-inline">
    <h1 class="heading">PRICING</h1>

    <div class="container">
      <div class="price-table-wrap">
        <table class="price-table">
          <thead>
            <tr>
              <th>Product/Service</th>
              <th>Description</th>
              <th class="th-right">Price</th>
              <th></th>
            </tr>
          </thead>
          <tbody>

            <tr class="row-featured">
              <td>
                Braces (Orthodontics)
                <span class="sale-badge"><i class="fas fa-tags"></i> SALE 30%</span>
              </td>
              <td>Comprehensive Orthodontic Treatment</td>
              <td class="td-right">
                <div class="price-stack">
                  <span class="price-old">40.000.000 VND</span>
                  <span class="price-new">28.000.000 VND</span>
                </div>
              </td>
              <td class="td-right">
                <a href="#contact" class="link-btn price-book" data-service="Braces (Orthodontics)">Book</a>
              </td>
            </tr>

            <tr>
              <td>Teeth Whitening</td>
              <td>In-Clinic Whitening Session</td>
              <td class="td-right"><strong>400.000 VND</strong></td>
              <td class="td-right">
                <a href="#contact" class="link-btn price-book" data-service="Teeth Whitening">Book</a>
              </td>
            </tr>

            <tr class="row-alt">
              <td>Oral Care Kit</td>
              <td>Brush + Floss + Mouthwash</td>
              <td class="td-right"><strong>250.000 VND</strong></td>
              <td class="td-right">
                <a href="#contact" class="link-btn price-book" data-service="Oral Care Kit">Book</a>
              </td>
            </tr>

            <tr>
              <td>Root Canal</td>
              <td>Single-Tooth Therapy</td>
              <td class="td-right"><strong>999.999 VND</strong></td>
              <td class="td-right">
                <a href="#contact" class="link-btn price-book" data-service="Root Canal">Book</a>
              </td>
            </tr>

            <tr class="row-alt">
              <td>Scaling &amp; Polishing</td>
              <td>Cleaning + Tartar Removal</td>
              <td class="td-right"><strong>300.000 VND</strong></td>
              <td class="td-right">
                <a href="#contact" class="link-btn price-book" data-service="Scaling &amp; Polishing">Book</a>
              </td>
            </tr>

          </tbody>
        </table>

        <p class="price-note">*Prices are indicative. Final quote after consultation.</p>
      </div>
    </div>
  </div>
</section>
<!-- pricing section ends -->

<!-- doctor section starts -->
<section class="doctors" id="doctors">

    <h1 class="heading"> our <span>DOCTOR</span> </h1>

    <div class="box-container">

        <div class="box" style="text-align:center; padding:20px; box-shadow:0 5px 15px rgba(0,0,0,.1); border-radius:10px; margin:10px; background:#fff;">
            <img src="images/Chi-Hieu.jpg" alt="Doctor 1" style="width:150px; height:150px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
            <h3>Dr Chi Hieu</h3>
            <span>Dental Specialist</span>
            <p style="margin-top:10px; font-size:14px; color:#555;">Dr. Chi Hieu has 10 years of experience in cosmetic and restorative dentistry.</p>
        </div>

        <div class="box" style="text-align:center; padding:20px; box-shadow:0 5px 15px rgba(0,0,0,.1); border-radius:10px; margin:10px; background:#fff;">
            <img src="images/Nguyen-Hoang.jpg" alt="Doctor 2" style="width:150px; height:150px; object-fit:cover; border-radius:50%; margin-bottom:10px;">
            <h3>Dr. Nguyen Hoang</h3>
            <span>Orthodontist</span>
            <p style="margin-top:10px; font-size:14px; color:#555;">Specialized in braces and teeth alignment with over 8 years of expertise.</p>
        </div>

    </div>

</section>
<!-- doctor section ends -->

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

<!-- review section starts -->
<section class="reviews" id="reviews" style="text-align:center; margin:30px auto; width:80%; max-width:700px;">
   <h1 class="heading" style="font-size:36px; font-weight:bold; color:#0056a3; margin-bottom:20px;">Reviews</h1>
   <?php
   $reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 5");
   if(mysqli_num_rows($reviews) > 0){
      while($row = mysqli_fetch_assoc($reviews)){
         echo "<div class='review' style='background:#fff; margin:15px auto; padding:18px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.15); font-size:20px; text-align:left;'>";
         echo "<strong style='font-size:22px; color:#333;'>".$row['name']."</strong> - <span style='color:gold; font-size:22px;'>".str_repeat("⭐", $row['rating'])."</span>";
         if(!empty($row['comment'])){
            echo "<p style='font-size:18px; margin:10px 0; color:#555;'>".$row['comment']."</p>";
         }
         echo "<small style='font-size:16px; color:#888;'>".$row['created_at']."</small>";
         echo "</div>";
      }
   } else {
      echo "<p style='font-size:18px;'>No reviews yet.</p>";
   }
   ?>
   <a href="review.php" style="display:inline-block; margin-top:15px; background:#28a745; color:#fff; padding:10px 18px; border-radius:6px; text-decoration:none; font-size:18px;">Viết đánh giá</a>
</section>
<!-- review section ends -->

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
