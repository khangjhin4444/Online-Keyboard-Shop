<?php 
  if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    if (strlen($phone) != 10 || !preg_match('/^[0][1-9][0-9]{8}$/', $phone)) {
      echo json_encode(['status' => 'failed']);
      exit;
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE Phone = ?");
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) <= 0) {
      echo json_encode(['status' => 'failed']);
      exit;
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo json_encode(['status' => 'success']);
  }
?>