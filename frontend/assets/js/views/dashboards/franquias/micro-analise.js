var ctx = document.getElementById('salesOverview').getContext('2d');
var chart_vendasQTD = $("#grafico_total").val().split(',');
var historicoVendas = new Chart(ctx, {        
    data: {
        labels: JSON.parse($("#grafico_periodo").val()),	
        datasets: [{
            backgroundColor: "rgba(121, 139, 255, 0.3)",
            color: "#798bff",
            fill: 'origin',
            borderColor: '#798bff',
            label: 'Faturamento',
            data: JSON.parse($("#grafico_faturamento").val())
        }]
    },
    type: 'line',
    options: {
        responsive: true,
        spanGaps: false,
        maintainAspectRatio: false,
        legend: {
            display: false
        },        
        elements: {
            line: {
                tension: 0.000001
            }
        },						
        tooltips: {
            mode: 'index',
            intersect: true,
            callbacks: {
                title: function title(tooltipItem, data) {
                  return "Vendas: " + chart_vendasQTD[tooltipItem[0].index] + '\nData: ' + data.labels[tooltipItem[0].index];
                },
                label: function label(tooltipItem, data) {
                  return 'R$ ' + data.datasets[tooltipItem.datasetIndex]['data'][tooltipItem['index']].toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                }
            }						
        },
        scales: {
            yAxes: [{
                display: true,
                ticks: {
                  beginAtZero: true,
                  fontSize: 11,
                  fontColor: '#9eaecf',
                  padding: 10,
                  callback: function callback(value, index, values) {
                    return 'R$ ' + value;
                  },
                  min: 0,
                  stepSize: 5000
                },
                gridLines: {
                  color: 'rgba(82, 100, 132, 0.2)',
                  tickMarkLength: 0,
                  zeroLineColor: 'rgba(82, 100, 132, 0.2)'
                }
            }],
            xAxes: [{
                display: true,
                ticks: {
                  fontSize: 9,
                  fontColor: '#9eaecf',
                  source: 'auto',
                  padding: 10
                },
                gridLines: {
                  color: "transparent",
                  tickMarkLength: 0,
                  zeroLineColor: 'transparent'
                }
            }]
        }                  
    }
});