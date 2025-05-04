<?php 
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }

  if (isset($_GET['updateVariant']) && $_GET['updateVariant'] == true) {
    $productID = $_POST['ProductID'];
    $oldColors = $_POST['OldColor'];
    $colors = $_POST['Color'];
    $stocks = $_POST['Stock'];
    $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
    for ($i = 0; $i < count($colors); $i++) {
      $oldColor = $oldColors[$i];
      $color = $colors[$i];
      $stock = $stocks[$i];

      // mysqli_query($conn, "UPDATE cartproduct SET Color = '$color' WHERE ProductID = '$productID' AND Color = '$oldColor'");

      $stmt = mysqli_prepare($conn, "UPDATE productvariant SET Color = ?, stock = ? WHERE ProductID = ? AND Color = ?");
      mysqli_stmt_bind_param($stmt, "siss", $color, $stock, $productID, $oldColor);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      $response[] = [
        'color' => $color,
        'stock' => $stock
      ];
    }
    mysqli_close($conn);
    echo json_encode(['status' => 'success', 'data' => $response]);
    exit;
  }


  if (isset($_GET['ProductID'])) {
    $productID = $_GET['ProductID'];
    $name = $_GET['name'];
    $price = $_GET['price'];
    $description = $_GET['description'];
    $newProductType = $_GET['ProductType'];
    $newSize = $_GET['Size'];
    $newProfile = $_GET['Profile'];
    $newType = $_GET['Type'];
    $newURL = $_GET['SoundTest'];
  }

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');
  $stmt = mysqli_prepare($conn, "UPDATE product SET Name = ?, Price = ?, Description = ?, ProductType = ?, Size = ?, Profile = ?, Type = ?, Soundtest = ? WHERE ProductID = ?");
  mysqli_stmt_bind_param($stmt, "sdsssssss", $name, $price, $description, $newProductType, $newSize, $newProfile, $newType, $newURL, $productID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo json_encode(["size" => $newSize]);
  mysqli_close($conn);
?>