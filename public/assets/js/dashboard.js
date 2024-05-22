document.addEventListener('DOMContentLoaded', function() {
  var chartElement = document.getElementById('chart');
  if (chartElement) {
    var chartContext = chartElement.getContext('2d');
    var gradient = chartContext.createLinearGradient(0, 0, 0, 450);

    gradient.addColorStop(0, 'rgba(0, 199, 214, 0.32)');
    gradient.addColorStop(0.3, 'rgba(0, 199, 214, 0.1)');
    gradient.addColorStop(1, 'rgba(0, 199, 214, 0)');

    var data = {
      labels: ['2019', '2020', '2021', '2022', '2023', '2024'],
      datasets: [{
        label: 'Applications',
        backgroundColor: gradient,
        pointBackgroundColor: '#00c7d6',
        borderWidth: 1,
        borderColor: '#0e1a2f',
        data: [105, 200, 562, 750, 911, 1112]
      }]
    };

    var options = {
      responsive: true,
      maintainAspectRatio: true,
      animation: {
        easing: 'easeInOutQuad',
        duration: 520
      },
      scales: {
        yAxes: [{
          ticks: {
            fontColor: '#5e6a81'
          },
          gridLines: {
            color: 'rgba(200, 200, 200, 0.08)',
            lineWidth: 1
          }
        }],
        xAxes: [{
          ticks: {
            fontColor: '#5e6a81'
          }
        }]
      },
      elements: {
        line: {
          tension: 0.4
        }
      },
      legend: {
        display: false
      },
      point: {
        backgroundColor: '#00c7d6'
      },
      tooltips: {
        titleFontFamily: 'Poppins',
        backgroundColor: 'rgba(0,0,0,0.4)',
        titleFontColor: 'white',
        caretSize: 5,
        cornerRadius: 2,
        xPadding: 10,
        yPadding: 10
      }
    };

    new Chart(chartContext, {
      type: 'line',
      data: data,
      options: options
    });
  }

  var openRightArea = document.querySelector('.open-right-area');
  if (openRightArea) {
    openRightArea.addEventListener('click', function() {
      document.querySelector('.app-right').classList.add('show');
    });
  }

  var closeRight = document.querySelector('.close-right');
  if (closeRight) {
    closeRight.addEventListener('click', function() {
      document.querySelector('.app-right').classList.remove('show');
    });
  }

  var menuButton = document.querySelector('.menu-button');
  if (menuButton) {
    menuButton.addEventListener('click', function() {
      document.querySelector('.app-left').classList.add('show');
    });
  }

  var closeMenu = document.querySelector('.close-menu');
  if (closeMenu) {
    closeMenu.addEventListener('click', function() {
      document.querySelector('.app-left').classList.remove('show');
    });
  }
});

//# sourceURL=pen.js