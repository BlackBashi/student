$(function() {

  var dataNotas = JSON.parse($("#graficomedia").attr('data'));
  var data = new Array();
  var bimestre = new Array();

  for(var notas in dataNotas) {
    data.push(parseInt(dataNotas[notas]));
    bimestre.push(notas);
  }

  var options = {
      series: [{name: "Desktops",
        data: data
    }],
      chart: {
      height: 350,
      type: 'line',
      zoom: {
        enabled: false
      }
    },
    dataLabels: {
      enabled: false
    },
    stroke: {
      curve: 'straight'
    },
    title: {
      text: 'Notas',
      align: 'left'
    },
    grid: {
      row: {
        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
        opacity: 0.5
      },
    },
    xaxis: {
      categories: bimestre,
    }
    };

    var chart = new ApexCharts(document.querySelector("#graficomedia"), options);
    chart.render();
})