<?php
  session_start();
  if ($_SESSION['login'] != 'admin') {
    exit;
  }
  $uploadDir = 'variant-images/'; // Thư mục lưu ảnh


  $colors = $_POST['color'];
  $stocks = $_POST['stock'];
  $images = $_FILES['image'];
  $name = $_POST['Name'];
  $productType = $_POST['ProductType'];
  $size = $_POST['Size'];
  $profile = $_POST['Profile'];
  $type = $_POST['Type'];
  $soundTest = $_POST['SoundTest'];
  $description = $_POST['Description'];
  $price = $_POST['Price'];

  $response = [];

  $conn = mysqli_connect('localhost', 'root', '', 'keyboardshop');

  $stmt = mysqli_prepare($conn, "INSERT INTO product (Name, Description, Price, ProductType, Size, Profile, Type, Soundtest) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "ssdsssss", $name, $description, $price, $productType, $size, $profile, $type, $soundTest);
  mysqli_stmt_execute($stmt);
  $newInsertID = mysqli_insert_id($conn);
  mysqli_stmt_close($stmt);

  for ($i = 0; $i < count($colors); $i++) {
      $color = $colors[$i];
      $stock = $stocks[$i];

      $imageName = basename($images['name'][$i]);
      $targetPath = $uploadDir . $imageName;

      $savePath = "../variant-images/". $imageName;
      if (!file_exists($targetPath)) {
          move_uploaded_file($images['tmp_name'][$i], $savePath);
      }

      

      $stmt = mysqli_prepare($conn, "INSERT INTO productvariant (ProductID, Color, Image, stock) VALUES (?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "issi", $newInsertID, $color, $targetPath, $stock);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      $response[] = [
          'color' => $color,
          'stock' => $stock,
          'image_path' => $targetPath
      ];
  }

  mysqli_close($conn);
  echo json_encode(['status' => 'success', 'data' => $response]);
?>