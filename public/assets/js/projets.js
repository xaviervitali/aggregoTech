var options = {
  chart: {
    type: "radialBar",
  },
  colors: ["#73c9e1", "#467fb4", "#333985", "#513374"].reverse(),

  plotOptions: {
    radialBar: {
      dataLabels: {
        name: {
          fontSize: "22px",
        },
        value: {
          fontSize: "16px",
        },
      },
    },
  },
  dataLabels: {
    style: {
      //   colors: ["#423078", "#3E6CA8", "#70C5DF", "#5D3570"],
    },
  },

  fill: {
    // colors: ["#423078", "#3E6CA8", "#70C5DF", "#5D3570"],
    type: "gradient",
    gradient: {
      shade: "light",
      shadeIntensity: 0.4,
      inverseColors: true,
      opacityFrom: 1,
      opacityTo: 1,
      stops: [0, 50, 53, 91],
    },
  },
  labels: ["SEO", "Performances", "Accessibilité", "Bonnes Pratiques"],
};

document.querySelectorAll("#chart").forEach(function (chart) {
  options.series = chart.dataset.value.split(",");
  //   console.log(options);
  var toto = new ApexCharts(chart, options);
  toto.render();
});

// var options = {
//   series: [44, 55, 67, 83],
//   chart: {
//     height: 350,
//     type: "radialBar",
//   },
//   plotOptions: {
//     radialBar: {
//       dataLabels: {
//         name: {
//           fontSize: "22px",
//         },
//         value: {
//           fontSize: "16px",
//         },
//         total: {
//           show: true,
//           label: "Total",
//           formatter: function (w) {
//             // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
//             return 249;
//           },
//         },
//       },
//     },
//   },
//   labels: ["Apples", "Oranges", "Bananas", "Berries"],
// };

// var chart = new ApexCharts(document.querySelector("#chart"), options);
// chart.render();
