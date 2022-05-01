document
  .querySelector(".new-statement")
  .addEventListener("click", function (e) {
    e.preventDefault();
    const currentUser = document.querySelector("#users").value;
    const url = "/profile/statement/new/" + currentUser;
    window.location.href = url;
  });
