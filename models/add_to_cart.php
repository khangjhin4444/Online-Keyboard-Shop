<?php
session_set_cookie_params([
    'httponly' => true,  // Ngăn JavaScript truy cập session cookie
    'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
    'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['id']) && isset($_GET["productID"])) {
    $id = $_SESSION['id'];
    $productId = $_GET['productID'];
    $color = $_GET['color'] ?? 'Basic';
    $quantity = $_GET['quantity'] ?? 1;

    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

    $stmt = mysqli_prepare($conn, "SELECT * FROM productvariant WHERE ProductID = ? AND Color = ?");
    mysqli_stmt_bind_param($stmt, "ss", $productId, $color);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $variant = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, "SELECT Quantity FROM cartproduct WHERE UserID = ? AND ProductID = ? AND Color = ?");
    mysqli_stmt_bind_param($stmt, "sss", $id, $productId, $color);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($row) {
        $newQuantity = $row['Quantity'] + $quantity;
        // If exist in cart, change quantity
        if ($newQuantity > $variant['stock']) {
            echo json_encode([
                'success' => false
            ]);
            mysqli_close($conn);
            exit();
        }

        $stmt = mysqli_prepare($conn, "UPDATE cartproduct SET Quantity = ? WHERE UserID = ? AND ProductID = ? AND Color = ?");
        mysqli_stmt_bind_param($stmt, "ssss", $newQuantity, $id, $productId, $color);
        mysqli_stmt_execute($stmt);
        $updateResult = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        // No exist in cart, add new
        $stmt = mysqli_prepare($conn, "INSERT INTO cartproduct (UserID, ProductID, Color, Quantity) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $id, $productId, $color, $quantity);
        mysqli_stmt_execute($stmt);
        $insertResult = mysqli_stmt_get_result($stmt);
        mysqli_stmt_close($stmt);
    }

    echo json_encode([
        'success' => true,
        'productID' => $productId,
        'color' => $color,
        'quantity' => $row ? $newQuantity : $quantity
    ]);

    mysqli_close($conn);
}
?>
