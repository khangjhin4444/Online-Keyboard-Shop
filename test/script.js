
function changeImage(newSrc) {
  // Cập nhật ảnh chính
  document.getElementById("displayedImage").src = newSrc;
  
  // Cập nhật đường dẫn của Fancybox
  document.getElementById("mainImageLink").href = newSrc;
}