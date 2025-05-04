<?php
if (session_status() == PHP_SESSION_NONE) {
  session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
  ]);
  session_start();
}
$userid = $_SESSION['id'];
function updateCartProduct($userid, $productID, $color, $quantity) {
  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  if ($quantity == 0) {
    $stmt = mysqli_prepare($conn, "DELETE FROM cartproduct WHERE UserID = ? AND ProductID = ? AND Color = ?");
    mysqli_stmt_bind_param($stmt, "sss", $userid, $productID, $color);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  } else {
    $stmt = mysqli_prepare($conn, "UPDATE cartproduct SET Quantity = ? WHERE UserID = ? AND ProductID = ? AND Color = ?");
    mysqli_stmt_bind_param($stmt, "isss", $quantity, $userid, $productID, $color);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }
  mysqli_close($conn);
}

if (isset($_GET['ProductID']) && isset($_GET['color']) && isset($_GET['quantity'])) {
  echo $_GET['ProductID'];
  updateCartProduct($userid, $_GET['ProductID'], $_GET['color'], $_GET['quantity']);
}
?>