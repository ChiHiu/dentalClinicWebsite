<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "POST received: " . htmlspecialchars($_POST['name']);
}
?>
<form method="post" action="">
    <input type="text" name="name">
    <input type="submit" value="Test Submit">
</form>
