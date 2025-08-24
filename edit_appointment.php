<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$id = intval($_GET['id']);

// Lấy dữ liệu lịch hẹn
$stmt = $conn->prepare("SELECT service, appointment_date FROM appointments WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $id, $userId);
$stmt->execute();
$result = $stmt->get_result();
$appointment = $result->fetch_assoc();

if (!$appointment) {
    die("Không tìm thấy lịch hẹn.");
}

// Cập nhật
if (isset($_POST['update'])) {
    $service = $_POST['service'];
    $date = $_POST['date'];

    $stmt = $conn->prepare("UPDATE appointments SET service = ?, appointment_date = ? WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ssii", $service, $date, $id, $userId);
    if ($stmt->execute()) {
        header("Location: view_appointments.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Edit Appointment</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top:100px;">
   <h2>Edit Appointment</h2>
   <form method="post">
      <div class="form-group">
         <label>Service</label>
         <input type="text" name="service" value="<?php echo htmlspecialchars($appointment['service']); ?>" class="form-control" required>
      </div>
      <div class="form-group">
         <label>Date</label>
         <input type="datetime-local" name="date" value="<?php echo date('Y-m-d\TH:i', strtotime($appointment['appointment_date'])); ?>" class="form-control" required>
      </div>
      <button type="submit" name="update" class="btn btn-primary">Update</button>
      <a href="view_appointments.php" class="btn btn-secondary">Cancel</a>
   </form>
</div>
</body>
</html>
