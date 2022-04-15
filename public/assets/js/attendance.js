$(".attendanceButton").click(function () {
  date = new Date().toLocaleString().split("/").join("-").replace(",", "");
  $.ajax({
    url: "/profile/attendance/new",
    type: "POST",
    data: { date: date, user: document.location.href.split("/").reverse()[0] },
    success: function (data) {
      console.log(data);

      window.location.reload();
    },
  });
});

/*
//  * Ajax functions
//  */
// function saveSignature() {
//   $.ajax({
//     url: "/profile/user/signature",
//     type: "POST",
//     data: { signature: canvas.toDataURL() },

//     success: function (data) {
//       console.log(data);
//       window.location.reload();
//     },
//   });
// }
