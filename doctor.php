<?php
@include 'config.php'; // file kết nối DB (mysqli_connect)

$query = mysqli_query($conn, "SELECT * FROM doctors") or die('query failed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Our Doctors</title>
   <link rel="stylesheet" href="style.css"> <!-- dùng chung style -->
</head>
<body>

<?php @include 'header.php'; ?> <!-- menu -->

<section class="doctors">
   <h1 class="title">Meet Our Doctors</h1>

   <div class="doctor-container">
      <?php while($row = mysqli_fetch_assoc($query)){ ?>
         <div class="doctor-card">
            <img src="images/<?php echo $row['photo']; ?>" alt="Doctor Photo">
            <h3><?php echo $row['name']; ?></h3>
            <p><strong>Specialty:</strong> <?php echo $row['specialty']; ?></p>
            <p><strong>Email:</strong> <?php echo $row['email']; ?></p>
            <p><strong>Phone:</strong> <?php echo $row['phone']; ?></p>
         </div>
      <?php } ?>
   </div>
</section>

<?php @include 'footer.php'; ?> <!-- footer -->

</body>
</html>
