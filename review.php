<?php
@include 'config.php'; // file kết nối DB

// Xử lý khi gửi form
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $rating = (int)$_POST['rating'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    if(!empty($name) && !empty($rating)){
        $insert = mysqli_query($conn, "INSERT INTO reviews (name, rating, comment) VALUES ('$name','$rating','$comment')") or die('query failed');
        if($insert){
            $msg = "Cảm ơn bạn đã đánh giá!";
        }
    } else {
        $msg = "Vui lòng nhập đầy đủ thông tin!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Đánh giá</title>
   <style>
      body { font-family: Arial, sans-serif; background:#f9f9f9; }
      .container { max-width:800px; margin:30px auto; background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,.1); }
      h1 { text-align:center; margin-bottom:20px; }
      form { margin-bottom:30px; }
      input, textarea, select { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:5px; }
      button { background:#28a745; color:#fff; padding:10px 15px; border:none; border-radius:5px; cursor:pointer; }
      button:hover { background:#218838; }
      .review { border-bottom:1px solid #ddd; padding:15px 0; }
      .stars { color:gold; }
      .msg { color:green; font-weight:bold; text-align:center; }
   </style>
</head>
<body>
   <div class="container">
      <h1>Khách hàng đánh giá</h1>
      <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>

      <!-- Form đánh giá -->
      <form action="" method="POST">
         <input type="text" name="name" placeholder="Tên của bạn" required>
         <select name="rating" required>
            <option value="">-- Chọn số sao --</option>
            <option value="5">⭐⭐⭐⭐⭐ - Rất tốt</option>
            <option value="4">⭐⭐⭐⭐ - Tốt</option>
            <option value="3">⭐⭐⭐ - Bình thường</option>
            <option value="2">⭐⭐ - Kém</option>
            <option value="1">⭐ - Rất tệ</option>
         </select>
         <textarea name="comment" placeholder="Ý kiến của bạn..." rows="4"></textarea>
         <button type="submit" name="submit">Gửi đánh giá</button>
      </form>

      <!-- Hiển thị review -->
      <h2>Đánh giá gần đây</h2>
      <?php
      $reviews = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC LIMIT 10");
      if(mysqli_num_rows($reviews) > 0){
         while($row = mysqli_fetch_assoc($reviews)){
            echo "<div class='review'>";
            echo "<strong>".$row['name']."</strong> - <span class='stars'>".str_repeat("⭐", $row['rating'])."</span>";
            if(!empty($row['comment'])){
                echo "<p>".$row['comment']."</p>";
            }
            echo "<small>".$row['created_at']."</small>";
            echo "</div>";
         }
      } else {
         echo "<p>Chưa có đánh giá nào.</p>";
      }
      ?>
   </div>
</body>
</html>