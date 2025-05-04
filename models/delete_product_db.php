<?php
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }

  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $stmt = mysqli_prepare($conn, "SELECT * FROM orderproduct WHERE ProductID = ?");
    mysqli_stmt_bind_param($stmt, "s", $productID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($order = mysqli_fetch_assoc($result)) {
      $orderID = $order['OrderID'];

      // Decline orders has deleted product
      $stmt1 = mysqli_prepare($conn, "UPDATE orders SET Status = 'Declined' WHERE OrderID = ?");
      mysqli_stmt_bind_param($stmt1, "i", $orderID);
      mysqli_stmt_execute($stmt1);
      mysqli_stmt_close($stmt1);
    }

    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "DELETE FROM product WHERE ProductID = ?");
    mysqli_stmt_bind_param($stmt, "s", $productID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
?>