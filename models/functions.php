<?php 
  function renderCard($type, $id) {
    $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get first 8 products by type
    $stmt = mysqli_prepare($conn, "SELECT p.ProductId AS id, p.Name AS name, p.Price AS price, 
        (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
        FROM product p WHERE p.ProductType = ? LIMIT 8");
    mysqli_stmt_bind_param($stmt, "s", $type);
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

    // Check if there are more than 8 product
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
                    document.querySelectorAll(".show-more-btn").forEach(btn => {
                        if (btn.id === "'.$id.'") {
                            btn.style.display = "none";
                            console.log("No more products to load.");
                        }
                    });
                });
              </script>';
    }

    mysqli_close($conn);
  }


  function renderSearch($type, $keyword) {
    $keyword = iconv('UTF-8', 'ASCII//TRANSLIT', $keyword);
    $conn = mysqli_connect("localhost", "root", "", "keyboardshop");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $likeKeyword = "%$keyword%";
    $stmt = mysqli_prepare($conn, "SELECT p.ProductId as id, p.Name AS name, p.Price AS price, 
        (SELECT pv.Image FROM productvariant pv WHERE pv.ProductID = p.ProductID ORDER BY pv.Color ASC LIMIT 1) AS image
        FROM product p WHERE p.ProductType = ? AND (p.Name LIKE ? OR p.Description LIKE ?)");
    mysqli_stmt_bind_param($stmt, "sss", $type, $likeKeyword, $likeKeyword);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        return;
    }
    
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
    // $check_sql = "SELECT COUNT(*) AS total FROM Product WHERE ProductType = '$type'";
    // $check_result = mysqli_query($conn, $check_sql);
    // $check_row = mysqli_fetch_assoc($check_result);
    // $total_products = $check_row['total'];

    // if ($total_products <= 8) {
    //     echo '<script>
    //             document.addEventListener("DOMContentLoaded", function() {
    //                 document.querySelectorAll(".show-more-btn").forEach(btn => {
    //                     if (btn.id === "2") {
    //                         btn.style.display = "none";
    //                         console.log("No more products to load.");
    //                     }
    //                 });
    //             });
    //           </script>';
    // }

    mysqli_close($conn);
  }
?>