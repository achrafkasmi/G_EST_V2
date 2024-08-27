@extends('master')
@section("app-mid")
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<div class="app-main">
    @include('tiles.actions')
    <div class="tabs">
        <a href="{{ route('index.studentmanage') }}">
            <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
        </a>
        <!-- Tabs Navigation -->
        <button class="tablinks active" onclick="openTab(event, 'ChartTab')">Aperçu</button>
        <button class="tablinks" onclick="openTab(event, 'TableTab')">Etudiants</button>
        <button class="tablinks" onclick="openTab(event, 'TableTabStaff')">Staff</button>
    </div>

    <!-- Chart Tab -->
    <div id="ChartTab" class="tabcontent" style="display: block;">
        <div class="chart-row two">
            <div class="chart-container-wrapper big">
                <div class="chart-container">
                    <div class="chart-container-header">
                        <h2>Nombre des absences mensuelles</h2>
                        <span>par année universitaire</span>
                        <select id="year-select" name="academic_year">
                            @foreach($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
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

    <!-- Data Table Tab -->
    <div id="TableTab" class="tabcontent" style="display: none;">
        <div class="datatabcontainer mt-4">
            <table class="tab" id="myTable">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Absences</th>
                        <th>Absences justifiées</th>
                        <th>annee_uni</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($studentsWithAttendanceData as $student)
                    <tr>
                        <td>{{ $student->nom_fr }} {{ $student->prenom_fr }}</td>
                        <td>{{ $student->absences }}</td>
                        <td>{{ $student->justifiedAbsences }}</td>
                        <td>{{ $student->annee_uni}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Data Table Tab For staff-->
    <div id="TableTabStaff" class="tabcontent" style="display: none;">
        <div class="datatabcontainer mt-4">
            <table class="tab" id="myTableStaff">
                <thead>
                    <tr>
                        <th>Professeur</th>
                        <th>Element/Module</th>
                        <th>Filière</th>
                        <th>annee_uni</th>
                        <th>Nombre Total des heures</th>
                        <th>Cours</th>
                        <th>TD</th>
                        <th>TP</th>
                        <th>AP</th>
                        <th>EX</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessionDataByTeacher as $personnelId => $data)
                    <tr>
                        <td>{{ $data['professor_name'] }}</td>
                        <td>{{ $data['element_name'] }}</td>
                        <td>{{ $data['filiere'] }}</td>
                        <td>{{ $data['annee_uni'] }}</td>
                        <td>{{ $data['total_hours'] }} Heurs</td>

                        <td style="color: #e91e63;">
                            {{ $data['course_counts']['C']['count'] ?? 0 }}
                            ({{ number_format($data['course_counts']['C']['hours']) }} Heurs)
                        </td>

                        <td style="color: #9c27b0;">
                            {{ $data['course_counts']['TD']['count'] ?? 0 }}
                            ({{ number_format($data['course_counts']['TD']['hours']) }} Heurs)
                        </td>

                        <td style="color: #4caf50;">
                            {{ $data['course_counts']['TP']['count'] ?? 0 }}
                            ({{ number_format($data['course_counts']['TP']['hours']) }} Heurs)
                        </td>

                        <td style="color: #2196f3;">
                            {{ $data['course_counts']['AP']['count'] ?? 0 }}
                            ({{ number_format($data['course_counts']['AP']['hours']) }} Heurs)
                        </td>

                        <td style="color: #ff9800;">
                            {{ $data['course_counts']['Examen']['count'] ?? 0 }}
                            ({{ number_format($data['course_counts']['Examen']['hours']) }} Heurs)
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Function to handle tab switching
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    $(document).ready(function() {
        // Initialize Selectize on the year-select element
        $('#year-select').selectize({
            create: false,
            sortField: 'text'
        });

        // Function to initialize and update the chart
        function updateChart(data) {
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
                                fontColor: '#5e6a81',
                                beginAtZero: true
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
                    data: {
                        labels: data.labels, // months
                        datasets: [{
                                label: 'Total Absences',
                                backgroundColor: totalAttendanceGradient,
                                pointBackgroundColor: '#00c7d6',
                                borderColor: '#0e1a2f',
                                borderWidth: 1,
                                data: data.totalAbsences
                            },
                            {
                                label: 'Justified Absences',
                                backgroundColor: justifiedAttendanceGradient,
                                pointBackgroundColor: '#ff6384',
                                borderColor: '#ff6384',
                                borderWidth: 1,
                                data: data.justifiedAbsences
                            }
                        ]
                    },
                    options: options
                });
            }
        }

        // Fetch initial data for the default selected year
        fetchChartData($('#year-select').val());

        // Fetch and update chart data when year is changed
        $('#year-select').change(function() {
            var selectedYear = $(this).val();
            fetchChartData(selectedYear);
        });

        // Function to fetch chart data via AJAX
        function fetchChartData(year) {
            $.ajax({
                url: '{{ route("admin.fetchCurrentDateAttendanceStats") }}',
                method: 'GET',
                data: {
                    year: year
                },
                success: function(response) {
                    // Assuming response contains { labels: [], totalAbsences: [], justifiedAbsences: [] }
                    updateChart(response);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        // Initialize DataTable
        if (window.matchMedia("(max-width: 767px)").matches) {
            $('#myTable').DataTable({
                scrollX: true
            });
        } else {
            $('#myTable').DataTable();
        }
        (window.matchMedia("(max-width: 767px)").matches)
        $('#myTableStaff').DataTable({
            scrollX: true
        });

    });
</script>

<!-- Additional Styles -->
<style>
    tbody {
        color: grey;
    }

    .dt-layout-row {
        color: #808080;
    }

    .dt-layout-cell.dt-end {
        color: grey;
    }

    .dt-column-order {
        color: rgba(0, 207, 222, 1);
    }

    .dt-column-title {
        color: #686D76;
    }

    .dt-paging {
        color: grey;
    }

    .datatabcontainer {
        background-color: var(--app-bg-dark);
        color: #fff;
        border-collapse: collapse;
        width: 100%;
    }

    .tab th,
    .tab td {
        padding: 8px;
        text-align: left;
    }

    /* Tabs styles */
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;

    }

    .tablinks {
        padding: 10px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        border-radius: 20px;
    }

    .tablinks.active {
        background-color: #d1d1d1;
        font-weight: bold;
    }

    .tabcontent {
        display: none;
    }
</style>
@endsection