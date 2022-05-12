var calendarEl = document.getElementById("calendar");
var calendar = new FullCalendar.Calendar(calendarEl, {
  initialView: "dayGridMonth",
  locale: "fr",
  firstDay: 1,
  buttonText: { today: "Aujourd'hui" },
  events: "/profile/holiday/all",
  contentHeight: 400,
  handleWindowResize: true,
});
calendar.addEvent({});
calendar.render();
// withToAuto(calendarEl);
// // calendar.updateSize();

// function withToAuto(element) {
//   if (element && element.style) {
//     element.style.width = "auto";
//     element.childNodes.forEach((a) => {
//       withToAuto(a);
//     });
//   } else {
//     return;
//   }
// }
// calendarEl.childNodes.forEach((e) => (e.style.width = "auto"));

// fetch("http://localhost:8000/profile/holiday/all")
//   .then((r) => r.json())
//   .then((d) => {
//     d.forEach((h) => {
//       calendar.addEvent({
//         title:
//           h.user.firstname + " " + h.user.lastname + (h.status ? "" : " ?"),
//         start: h.startDate,
//         end: h.endDate,
//         allDay: true,
//         backgroundColor: h.status ? "rgb(65, 157, 120)" : "rgb(241, 97, 131)",
//         // display: "background",
//       });
//     });
//     calendar.updateSize();
//   });
