let monthSelected = "";
let signature = "";
let buttons = document.querySelectorAll("button");
const table = document.querySelector("table");
const tbody = document.querySelector("tbody");

document.getElementById("users").addEventListener("change", (e) => {
  table.classList.add("d-none");
  signature = e.target.options[e.target.selectedIndex].dataset.signature;
});

buttons.forEach((button) =>
  button.addEventListener("click", (b) => {
    monthSelected = b.target.value;
    const month = b.target.value.split("/").reverse().join("/");
    const user = document.getElementById("users").value;
    if (user) {
      fetch(path + "?user=" + user + "&month=" + month + "/01")
        .then((r) => r.json())
        .then((f) => {
          if (f.length > 0) {
            table.classList.remove("d-none");

            attendancesShow(f);
          } else {
            // table.append = "<h3>Pas d'emargement à cette période</h3>";
          }
        });
    }
  })
);

function attendancesShow(attendances) {
  const attendancesDate = attendances.map((a) => new Date(a.date));
  let dates = [
    ...new Set(
      attendancesDate.map((a) => {
        return a.getDate();
      })
    ),
  ].map((d) => {
    return {
      [d]: attendancesDate
        .filter((aa) => aa.getDate() === d)
        .map(
          (aaa) => aaa.getHours() + ":" + ("0" + aaa.getMinutes()).slice(-2)
        ),
    };
  });

  let html = "";
  dates.forEach(function (d) {
    let attendanceOfDay = Object.values(d).join().split(",");
    let alert = false;
    let deleted = "";
    if (attendanceOfDay.length % 2 != 0) {
      deleted = attendanceOfDay.pop();
      alert = true;
    }

    let minutes = attendanceOfDay
      .map((a) => a.split(":"))
      .map((b) => b[0] * 60 + parseInt(b[1]))
      .reverse()
      .reduce((accumulator, currentValue, currentIndex) => {
        if (currentIndex % 2 == 0) {
          return +accumulator + currentValue;
        } else {
          return +accumulator - currentValue;
        }
      }, 0);

    const hours = attendanceOfDay.join("</p><p>");
    const signatures = [];
    for (let i = 0; i < attendanceOfDay.length; i++) {
      signatures.push("<img src='" + signature + "'>");
    }

    html += `<tr><td ><h2>${Object.keys(d) + "/" + monthSelected}</h2>
    ${
      alert
        ? "<p class='text-danger d-block'> /!\\ Attention l'emargement de " +
          deleted +
          " à été retiré</p>"
        : ""
    }<p class="d-block">Temps de présence : <strong>${Math.floor(
      minutes / 60
    )}h${("0" + (minutes % 60)).slice(
      -2
    )}</strong></p></td><td ><p  >${hours}</p></td><td>${signatures.join(
      ""
    )}</td></tr>`;
  });

  tbody.innerHTML = html;
}
