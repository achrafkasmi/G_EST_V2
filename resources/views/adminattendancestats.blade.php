@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('index.studentmanage') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="chart-row two">
        <div class="chart-container-wrapper big">
            <div class="chart-container">
                <div class="chart-container-header">
                    <h2>Nombre des Etudiants inscrits</h2>
                    <span>par année universitaire</span>
                </div>
                <div class="line-chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas id="attendanceChart" width="932" height="466" style="display: block; height: 233px; width: 466px;" class="chartjs-render-monitor"></canvas>
                </div>
                <div class="chart-data-details">
                    <div class="chart-details-header"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var chartElement = document.getElementById('attendanceChart');
        if (chartElement) {
            var chartContext = chartElement.getContext('2d');

            // Gradient for total attendance
            var totalAttendanceGradient = chartContext.createLinearGradient(0, 0, 0, 450);
            totalAttendanceGradient.addColorStop(0, 'rgba(0, 199, 214, 0.32)');
            totalAttendanceGradient.addColorStop(0.3, 'rgba(0, 199, 214, 0.1)');
            totalAttendanceGradient.addColorStop(1, 'rgba(0, 199, 214, 0)');

            // Gradient for justified attendance
            var justifiedAttendanceGradient = chartContext.createLinearGradient(0, 0, 0, 450);
            justifiedAttendanceGradient.addColorStop(0, 'rgba(255, 99, 132, 0.32)');
            justifiedAttendanceGradient.addColorStop(0.3, 'rgba(255, 99, 132, 0.1)');
            justifiedAttendanceGradient.addColorStop(1, 'rgba(255, 99, 132, 0)');

            // Data from the controller
            var labels = @json($monthlyAbsences->pluck('month'));
            var totalAbsences = @json($monthlyAbsences->pluck('total_absences'));
            var justifiedAbsences = @json($monthlyAbsences->pluck('total_justified_absences')); // Assuming you added this in your query

            var data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Absences',
                        backgroundColor: totalAttendanceGradient,
                        pointBackgroundColor: '#00c7d6',
                        borderColor: '#0e1a2f',
                        borderWidth: 1,
                        data: totalAbsences
                    },
                    {
                        label: 'Justified Absences',
                        backgroundColor: justifiedAttendanceGradient,
                        pointBackgroundColor: '#ff6384',
                        borderColor: '#ff6384',
                        borderWidth: 1,
                        data: justifiedAbsences
                    }
                ]
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
                    display: true,
                    labels: {
                        fontColor: '#5e6a81'
                    }
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
    });
</script>

@endsection
