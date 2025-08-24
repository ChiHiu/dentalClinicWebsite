<?php
session_start();
require 'config.php';

// Nếu chưa đăng nhập thì quay về login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Xử lý hủy lịch hẹn
if (isset($_GET['cancel_id'])) {
    $cancelId = intval($_GET['cancel_id']);
    $stmt = $conn->prepare("UPDATE appointments SET status = 'Cancelled' WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cancelId, $userId);
    $stmt->execute();
    header("Location: view_appointments.php");
    exit();
}

// Lấy danh sách lịch hẹn của user
$stmt = $conn->prepare("SELECT id, service, appointment_date, status 
                        FROM appointments 
                        WHERE user_id = ? 
                        ORDER BY appointment_date DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>My Appointments - DentalClinic</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
      table {
         background: #fff;
         border-radius: 8px;
         overflow: hidden;
         box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      }
      th {
         background: #007bff;
         color: white;
         text-align: center;
      }
      td {
         text-align: center;
         vertical-align: middle;
      }
   </style>
</head>
<body>

<!-- Header -->
<header class="header fixed-top">
   <div class="container">
      <div class="row align-items-center justify-content-between">
         <a href="index.php#home" class="logo">dental<span>Clinic.</span></a>
         <nav class="nav">
            <a href="index.php#home">Home</a>
            <a href="index.php#about">About</a>
            <a href="index.php#services">Services</a>
            <a href="index.php#reviews">Reviews</a>
            <a href="index.php#contact">Contact</a>
         </nav>
         <div>
            <a href="view_appointments.php" class="link-btn">My Appointments</a>
            <a href="logout.php" class="link-btn">Logout</a>
         </div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>
   </div>
</header>

<!-- Appointment List -->
<section class="contact" style="margin-top:100px;">
   <div class="container">
      <h1 class="heading">My Appointments</h1>
      <?php if ($result->num_rows > 0): ?>
      <table class="table table-bordered">
         <thead>
            <tr>
               <th>ID</th>
               <th>Service</th>
               <th>Appointment Date</th>
               <th>Status</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
               <td><?php echo $row['id']; ?></td>
               <td><?php echo htmlspecialchars($row['service']); ?></td>
               <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
               <td>
                  <?php if ($row['status'] == 'Pending'): ?>
                     <span class="badge badge-warning">Pending</span>
                  <?php elseif ($row['status'] == 'Confirmed'): ?>
                     <span class="badge badge-success">Confirmed</span>
                  <?php else: ?>
                     <span class="badge badge-danger">Cancelled</span>
                  <?php endif; ?>
               </td>
               <td>
                  <?php if ($row['status'] !== 'Cancelled'): ?>
                     <a href="edit_appointment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                     <a href="view_appointments.php?cancel_id=<?php echo $row['id']; ?>" 
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Bạn có chắc muốn hủy lịch hẹn này?');">Cancel</a>
                  <?php else: ?>
                     <span class="text-muted">No actions</span>
                  <?php endif; ?>
               </td>
            </tr>
            <?php endwhile; ?>
         </tbody>
      </table>
      <?php else: ?>
         <p class="text-center">Bạn chưa có lịch hẹn nào.</p>
      <?php endif; ?>
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
