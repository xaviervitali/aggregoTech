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

let colors = [
  [241, 97, 131],
  [191, 188, 168],
  [210, 167, 149],
  [229, 76, 69],
  [241, 16, 16],
  [233, 29, 28],
  [150, 146, 68],
  [161, 201, 147],
  [185, 92, 20],
  [248, 17, 16],
];

// charts

document.querySelectorAll(".graph").forEach(function (td, i) {
  const labels = [
    ...new Set(statements[i].appreciations.map((e) => e.level.title)),
  ];
  const categories = [
    ...new Set(statements[i].appreciations.map((e) => e.skill.category.title)),
  ];
  let series = [];
  categories.forEach((cat) => {
    let values = [];
    labels.forEach((lab) => {
      // debugger;
      values.push(
        statements[i].appreciations.filter(
          (app) => app.skill.category.title == cat && app.level.title == lab
        ).length
      );
    });
    series.push({ name: cat, data: values });
  });
  options = {
    chart: {
      type: "radar",
    },
    dataLabels: {
      enabled: true,
      background: {
        enabled: true,
        borderRadius: 2,
      },
    },

    yaxis: {
      tickPlacement: "off",
      labels: {
        formatter: function (value) {
          return "";
        },
      },
    },
    series: series,
    labels: labels,
  };

  var chart = new ApexCharts(td, options);
  // debugger;

  chart.render();
});
