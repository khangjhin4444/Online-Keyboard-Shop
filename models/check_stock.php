<?php 
  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $color = $_GET['color'];
    $quantity = $_GET['quantity'];
  }
  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

  $stmt = mysqli_prepare($conn, "SELECT * FROM productvariant WHERE ProductID = ? AND Color = ? AND stock >= ?");
  mysqli_stmt_bind_param($stmt, "ssi", $productID, $color, $quantity);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  $response = ['stock' => false];
  if (mysqli_num_rows($result) > 0) {
      $response['stock'] = true;
  }

  echo json_encode($response);
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
?>