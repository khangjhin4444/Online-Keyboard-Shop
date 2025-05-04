document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.querySelector(".menu-toggle");
  const sidebar = document.querySelector(".sidebar");

  menuToggle.addEventListener("click", function () {
    if (menuToggle.classList.contains("active")) {
      sidebar.classList.add("open");
      menuToggle.classList.remove("active");
    } else {
      sidebar.classList.remove("open");
      menuToggle.classList.add("active");
    }
  });

  document.addEventListener("click", function (event) {
    if (!sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
        sidebar.classList.remove("open");
        menuToggle.classList.add("active");
    }
  });
});

document.querySelector(".search-btn").addEventListener("click", function() {
  // let searchInput = document.querySelector(".search-bar")
  // let searchValue = searchInput.value.toLowerCase();
  window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
});

document.querySelector(".search-bar").addEventListener("keydown", function(event) {
  if (event.key === "Enter" && document.querySelector(".search-bar").value) {
    window.location.href = "?page=search_products.php&keyword=" + encodeURIComponent(document.querySelector(".search-bar").value);
  }
});