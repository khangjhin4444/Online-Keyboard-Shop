<?php 
  if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $stmt = mysqli_prepare($conn, "SELECT Name FROM product WHERE Name = ?");
    mysqli_stmt_bind_param($stmt, "s", $name);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) == 0) {
      echo json_encode(['status' => 'ok']);
    } else {
      echo json_encode(['status' => 'fail']);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit;
  }
?>