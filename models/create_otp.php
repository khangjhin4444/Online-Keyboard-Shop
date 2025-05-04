<?php 
  if (isset($_GET['otp']) && isset($_GET['phone'])) {
    $otp = $_GET['otp'];
    $phone = $_GET['phone'];

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE Phone = ?");
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "SELECT * FROM password_reset_tokens WHERE user_id = ? AND token = ? AND used = 0 AND expires_at > NOW()");
    mysqli_stmt_bind_param($stmt, "ii", $user['UserID'], $otp);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($data) {
      echo json_encode(['status' => 'success', 'pos' => '1']);
    }
    mysqli_close($conn);
    exit;
  }

  if (isset($_GET['phone']) && !isset($_GET['otp'])) {
    $phone = $_GET['phone'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE Phone = ?");
    mysqli_stmt_bind_param($stmt, "s", $phone);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "DELETE FROM password_reset_tokens WHERE user_id = ? OR expires_at < NOW()");
    mysqli_stmt_bind_param($stmt, "i", $user['UserID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $token = rand(100000, 999999);
    $expires_at = (new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh')))
              ->modify('+5 minutes')
              ->format('Y-m-d H:i:s');

    // Save token
    $stmt = mysqli_prepare($conn, "INSERT INTO password_reset_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sis", $user['UserID'], $token, $expires_at);
    mysqli_stmt_execute($stmt);
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    echo json_encode(['status' => 'success']);	
    exit;
  }
?>