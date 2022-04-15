function toggleMenu() {
  const headernavbar = document.querySelector(".headernavbar");
  const headerburger = document.querySelector(".headerburger");
  headerburger.addEventListener("click", (e) => {
    headernavbar.classList.toggle("show-nav");
    document.querySelector(".headernavbar__links").classList.toggle("none");
  });
}
toggleMenu();
