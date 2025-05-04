<?php 
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
$userid = $_SESSION['id'];
// echo $userid;
$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE UserID = ?");
mysqli_stmt_bind_param($stmt, "s", $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$stmt = mysqli_prepare($conn, "SELECT SUM(Quantity) AS total_items FROM cartproduct WHERE UserID = ?");
mysqli_stmt_bind_param($stmt, "s", $userid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$quantity = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

$total_items = $quantity['total_items'] ?? 0;
echo $total_items;
mysqli_close($conn);
?>