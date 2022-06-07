document
  .querySelector("#rh_users")
  .addEventListener("change", function (event) {
    const userId = event.target.value;
    if (userId) {
      const path = adminPath + "/" + userId;

      console.log(path);
      window.location.href = path;
    }
  });
