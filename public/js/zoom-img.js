const productImg = document.getElementById("productImg");
const zoomResult = document.getElementById("zoomResult");
const zoomContainer = document.querySelector(".zoom-container");

zoomContainer.addEventListener("mousemove", (e) => {
  zoomResult.style.display = "block";
  const { left, top, width, height } = zoomContainer.getBoundingClientRect();

  const x = e.pageX - left;
  const y = e.pageY - top;

  const posX = (x / width) * 100;
  const posY = (y / height) * 100;

  zoomResult.style.backgroundImage = `url(${productImg.src})`;
  zoomResult.style.backgroundSize = `${width * 2}px ${height * 2}px`;
  zoomResult.style.backgroundPosition = `${posX}% ${posY}%`;
});

zoomContainer.addEventListener("mouseleave", () => {
  zoomResult.style.display = "none";
});
