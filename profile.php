<?php
session_start();
$conn = mysqli_connect('localhost','root','','dentalclinic') or die('connection failed');

if (!isset($_SESSION['user_id'])) {
   header("Location: login.php");
   exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'") or die('query failed');
$user = mysqli_fetch_assoc($query);

// Update user info
if (isset($_POST['update'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $phone = mysqli_real_escape_string($conn, $_POST['phone']);
   $password = mysqli_real_escape_string($conn, $_POST['password']);

   if (!empty($password)) {
      $hashed = password_hash($password, PASSWORD_DEFAULT);
      mysqli_query($conn, "UPDATE users SET name='$name', phone='$phone', password='$hashed' WHERE id='$user_id'") or die('update failed');
   } else {
      mysqli_query($conn, "UPDATE users SET name='$name', phone='$phone' WHERE id='$user_id'") or die('update failed');
   }
   $message = "Profile updated successfully!";
   // Refresh user info
   $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
   $user = mysqli_fetch_assoc($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>User Profile - Dental Clinic</title>
   <link rel="stylesheet" href="css/style.css">
   <style>
      .profile-container {
         max-width: 600px;
         margin: 100px auto;
         padding: 20px;
         background: #fff;
         box-shadow: 0 2px 8px rgba(0,0,0,0.1);
         border-radius: 10px;
      }
      .profile-container h2 {
         margin-bottom: 15px;
         text-align: center;
         color: #333;
      }
      .profile-info {
         margin-bottom: 20px;
         padding: 15px;
         background: #f9f9f9;
         border-radius: 8px;
         font-size: 15px;
      }
      .profile-info p {
         margin: 8px 0;
      }
      .profile-container form {
         display: flex;
         flex-direction: column;
         gap: 15px;
      }
      .profile-container input {
         padding: 10px;
         border: 1px solid #ddd;
         border-radius: 5px;
         font-size: 16px;
      }
      .profile-container button {
         padding: 10px;
         background: #16a085;
         border: none;
         color: #fff;
         font-size: 16px;
         border-radius: 5px;
         cursor: pointer;
      }
      .profile-container button:hover {
         background: #138d75;
      }
      .message {
         margin: 10px 0;
         color: green;
         text-align: center;
      }
   </style>
</head>
<body>

   <!-- Header same as index.php -->
   <header class="header">
      <a href="index.php" class="logo">Dental<span>Clinic</span></a>
      <nav class="nav">
         <a href="index.php#home">home</a>
         <a href="index.php#about">about</a>
         <a href="index.php#services">services</a>
         <a href="index.php#reviews">reviews</a>
         <a href="index.php#contact">contact</a>
         <a href="profile.php" class="active">profile</a>
         <a href="logout.php">logout</a>
      </nav>
   </header>

   <section class="profile-container">
      <h2>User Profile</h2>

      <?php if (!empty($message)) echo "<p class='message'>$message</p>"; ?>

      <!-- Current info -->
      <div class="profile-info">
         <p><strong>Name:</strong> <?php echo $user['name']; ?></p>
         <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
         <p><strong>Phone:</strong> <?php echo $user['phone']; ?></p>
      </div>

      <!-- Update form -->
      <form method="post">
         <input type="text" name="name" value="<?php echo $user['name']; ?>" placeholder="Enter new name" required>
         <input type="text" name="phone" value="<?php echo $user['phone']; ?>" placeholder="Enter new phone" required>
         <input type="password" name="password" placeholder="New password (leave blank if not changing)">
         <button type="submit" name="update">Update Profile</button>
      </form>
   </section>

</body>
</html>
