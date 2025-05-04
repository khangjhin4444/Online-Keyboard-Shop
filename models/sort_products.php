<?php
session_set_cookie_params([
  'httponly' => true,  // Ngăn JavaScript truy cập session cookie
  'secure' => true,    // Chỉ gửi cookie qua HTTPS (chỉ bật khi dùng HTTPS)
  'samesite' => 'Strict' // Ngăn CSRF attack
]);
session_start();
$conn = mysqli_connect("localhost", "root", "", "keyboardshop");
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET["ProductType"])) {
  $type = $_GET['ProductType'];
}

$orderBy = "ProductID"; // Mặc định sắp xếp theo id
$orderDir = "ASC"; // Mặc định tăng dần

if (isset($_GET["sort_name"]) && $_GET["sort_name"] !== "default") {
  $orderBy = "name";
  $orderDir = ($_GET["sort_name"] === "asc") ? "ASC" : "DESC";
}

if (isset($_GET["sort_price"]) && $_GET["sort_price"] !== "default") {
  $orderBy = "price";
  $orderDir = ($_GET["sort_price"] === "asc") ? "ASC" : "DESC";
}

if (isset($_GET['sub'])) {
  $sub = $_GET['sub'];
  if ($type == 'KeyboardKit' || $type == 'Prebuild') {
    $sql = "SELECT p.ProductId AS id, p.Name AS name, p.Price AS price, 
                (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
                FROM product p WHERE p.ProductType = ? AND p.Size = ? ORDER BY $orderBy $orderDir LIMIT 8";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $type, $sub);
  } else if ($type == 'Keycap') {
    $sql = "SELECT p.ProductId AS id, p.Name AS name, p.Price AS price, 
                (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
                FROM product p WHERE p.ProductType = ? AND p.Profile = ? ORDER BY $orderBy $orderDir LIMIT 8";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $type, $sub);
  } else if ($type == 'Switch') {
    $sql = "SELECT p.ProductId AS id, p.Name AS name, p.Price AS price, 
                (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
                FROM product p WHERE p.ProductType = ? AND p.Type = ? ORDER BY $orderBy $orderDir LIMIT 8";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $type, $sub);
  }
} else {
  $sql = "SELECT p.ProductId AS id, p.Name AS name, p.Price AS price, 
            (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
            FROM product p WHERE p.ProductType = ? ORDER BY $orderBy $orderDir LIMIT 8";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "s", $type);
}
// $sql = "SELECT * FROM products WHERE category_id = $id ORDER BY $orderBy $orderDir LIMIT 8";

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
  if ($_SESSION['login'] == 'guest') {
    echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    echo '<div class="card" style="width: 100%; height: 100%;">';
    echo "<a href='authentication.php'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
    echo '<div class="card-body" style="height: 150px;">';
    echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
    echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    echo '<a href="authentication.php" class="btn btn-primary">VIEW MORE</a>';
    echo '</div></div></div>';
  } else {
    echo '<div class="col col-12 col-xxl-3 col-xl-4 col-md-6 text-center">';
    echo '<div class="card" style="width: 100%; height: 100%;">';
    echo "<a href='?page=product.php&productId={$row['id']}'><img src='{$row["image"]}' class='card-img-top' style='width: 100%; height: 300px !important; object-fit:cover' alt='{$row["name"]}'></a>";
    echo '<div class="card-body" style="height: 150px;">';
    echo '<h5 class="card-title" style="font-size: 16px; height: 30px">' . $row["name"] . '</h5>';
    echo '<p class="card-text">Price: ' . number_format($row["price"], 0, ',', '.') . 'đ</p>';
    echo "<a href='?page=product.php&productId={$row['id']}' class='btn btn-primary'>VIEW MORE</a>";
    echo '</div></div></div>';
  }
}
mysqli_stmt_close($stmt);

// Check if there are more than 8 products
$stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS total FROM Product WHERE ProductType = ?");
mysqli_stmt_bind_param($stmt, "s", $type);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$check_row = mysqli_fetch_assoc($result);
$total_products = $check_row['total'];
mysqli_stmt_close($stmt);

if ($total_products <= 8) {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelector(".show-more-btn").style.display = "none";
            });
          </script>';
}
mysqli_close($conn);
?>
