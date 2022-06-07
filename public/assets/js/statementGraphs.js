document.querySelectorAll(".graph").forEach(function (td, i) {
  let series = [];

  levels.forEach((level) => {
    series.push(
      statements[i % statements.length].appreciations.filter((app) => {
        return (
          app.level.title == level &&
          app.skill.category.id == parseInt(td.dataset.category)
        );
      }).length
    );
  });
  // console.log(series);
  options = {
    chart: {
      type: "pie",
      width: "200",
    },
    labels: levels,
    series: series,

    legend: {
      show: false,
    },
  };
  var chart = new ApexCharts(td, options);
  chart.render();

  // td.innerHTML += i;
});
