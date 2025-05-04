<?php
  session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
  ]);
  session_start();

  if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
  }
  $userId = $_SESSION['id'];
  if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $phone = $_GET['phone'];
    $address = $_GET['address'];
    $request = $_GET['request'];
    $shipping = $_GET['shipping'];
    $payment = $_GET['payment'];
    $date = $_GET['date'];
    $time = $_GET['time'];
    $total = $_GET['total'];
    $total = str_replace(['.', 'đ'], '', $total);
  }
  if (!preg_match('/^[0][1-9][0-9]{8}$/', $phone) || empty($name) || empty($phone) || empty($address) || empty($shipping) || empty($payment) || empty($date) || empty($time)) {
    echo "error";
    exit();
  }
  // Create order
  $conn = mysqli_connect('localhost','root','','keyboardshop');

  $stmt = mysqli_prepare($conn, "INSERT INTO orders (UserID, Name, Phone, Address, Request, Shipping, Payment, Date, Time, Status, Total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', ?)");
  mysqli_stmt_bind_param($stmt, "sssssssssi", $userId, $name, $phone, $address, $request, $shipping, $payment, $date, $time, $total);
  mysqli_stmt_execute($stmt);
  $orderId = mysqli_insert_id($conn);
  mysqli_stmt_close($stmt);

  $stmt = mysqli_prepare($conn, "SELECT * FROM cartproduct WHERE UserID = ?");
  mysqli_stmt_bind_param($stmt, "s", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  while ($row = mysqli_fetch_assoc($result)) {
    $productID = $row['ProductID'];
    $color = $row['Color'];
    $quantity = $row['Quantity'];

    // Add product to order
    $stmt1 = mysqli_prepare($conn, "INSERT INTO orderproduct (OrderID, ProductID, Color, Quantity) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt1, "issi", $orderId, $productID, $color, $quantity);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
  }
  mysqli_stmt_close($stmt);

  $stmt = mysqli_prepare($conn, "SELECT * FROM cartproduct WHERE UserID = ?");
  mysqli_stmt_bind_param($stmt, "s", $userId);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $cart = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);

  $productID = $cart['ProductID'];
  $color = $cart['Color'];
  $quantity = $cart['Quantity'];

  $stmt = mysqli_prepare($conn, "SELECT stock FROM productvariant WHERE ProductID = ? AND Color = ?");
  mysqli_stmt_bind_param($stmt, "ss", $productID, $color);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $stockQuantity = mysqli_fetch_assoc($result);
  mysqli_stmt_close($stmt);

  if ($stockQuantity) {
    if ($stockQuantity['stock'] <= $quantity) {
      // Delete from other cart
      $stmt = mysqli_prepare($conn, "DELETE FROM cartproduct WHERE ProductID = ? AND Color = ?");
      mysqli_stmt_bind_param($stmt, "ss", $productID, $color);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
      
      // Update stock to 0
      $stmt = mysqli_prepare($conn, "UPDATE productvariant SET stock = 0 WHERE ProductID = ? AND Color = ?");
      mysqli_stmt_bind_param($stmt, "ss", $productID, $color);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    } else {
      $newStockQuantity = $stockQuantity['stock'] - $quantity;
      // Update stock
      $stmt = mysqli_prepare($conn, "UPDATE productvariant SET stock = ? WHERE ProductID = ? AND Color = ?");
      mysqli_stmt_bind_param($stmt, "iss", $newStockQuantity, $productID, $color);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
  
      // Update cart
      $stmt = mysqli_prepare($conn, "UPDATE cartproduct SET Quantity = ? WHERE ProductID = ? AND Color = ?");
      mysqli_stmt_bind_param($stmt, "iss", $newStockQuantity, $productID, $color);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);
    }
  }

  // Delete this user cart
  $stmt = mysqli_prepare($conn, "DELETE FROM cartproduct WHERE UserID = ?");
  mysqli_stmt_bind_param($stmt, "s", $userId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  
  echo json_encode(['status' => 'success', 'orderId' => $orderId]);
  mysqli_close($conn);
?>