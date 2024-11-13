// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function atualizarDadosGrafico() {
fetch('http://localhost:4000/usuariosStatus')
  .then(response => {
    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }
    return response.json();
  })
  .then(data => {
    // Exibir os totais de usuários ativos e inativos
    const usuariosAtivos = data.usuariosAtivos;
    const usuariosInativos = data.usuariosInativos;
    // Pie Chart Example with two items
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Ativos", "Inativos"], // Two items
    datasets: [{
      data: [ usuariosAtivos, usuariosInativos], // Adjusted data for two items
      backgroundColor: ['#4e73df', '#1cc88a'], // Colors for two items
      hoverBackgroundColor: ['#2e59d9', '#17a673'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});


    console.log(`Total de usuários ativos: ${usuariosAtivos}`);
    console.log(`Total de usuários inativos: ${usuariosInativos}`);
  })
  .catch(error => {
    console.error('Erro ao buscar o total de documentos:', error);
  });
}

  document.addEventListener("DOMContentLoaded", function() {
    atualizarDadosGrafico();
  
    // Atualizar os dados a cada 5 segundos (5000ms)
    setInterval(atualizarDadosGrafico, 5000);
  });

