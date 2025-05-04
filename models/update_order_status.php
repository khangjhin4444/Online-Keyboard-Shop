<?php 
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }
  if (isset($_GET['OrderID']) && $_GET['status'] == 'accept') {
    $orderID = $_GET['OrderID'];
    $status = 'Delivered';
  }

  if (isset($_GET['OrderID']) && $_GET['status'] == 'decline') {
    $orderID = $_GET['OrderID'];
    $status = 'Declined';
  }

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $stmt = mysqli_prepare($conn, "UPDATE orders SET Status = ? WHERE OrderID = ?");
  mysqli_stmt_bind_param($stmt, "si", $status, $orderID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  
  mysqli_close($conn);
  echo json_encode(['orderID' => $orderID, 'Status' => $status]);
?>