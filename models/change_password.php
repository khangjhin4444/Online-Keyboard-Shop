<?php 
  $data = json_decode(file_get_contents("php://input"), true);
  $phone = $data['phone'];
  $password = $data['password'];
  $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $stmt = mysqli_prepare($conn, "UPDATE user SET password = ? WHERE Phone = ?");
  mysqli_stmt_bind_param($stmt, 'ss', $hashedPassword, $phone);
  mysqli_execute($stmt);
  mysqli_stmt_close($stmt);
  echo json_encode(['status' => 'changed']);
  mysqli_close($conn);
?>