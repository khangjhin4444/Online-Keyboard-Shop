<?php 
  session_start();
  if ($_SESSION['login'] != 'user') {
    header("Location: index.php");
    exit;
  }

  if (isset($_GET['OrderID'])) {
    $orderID = $_GET['OrderID'];

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    $stmt = mysqli_prepare($conn, "UPDATE orders SET Status = 'Canceled' WHERE OrderID = ?");
    mysqli_stmt_bind_param($stmt, "i", $orderID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($conn);
    echo json_encode(['status' => 'success', 'orderID' => $orderID]);
  }
?>