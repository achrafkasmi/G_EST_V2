@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attendance Overview</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Total Sessions</h6>
                            <p class="display-4">{{ $totalSessions }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Missed Sessions</h6>
                            <p class="display-4">{{ $missedSessions }}</p>
                        </div>
                    </div>
                    <h6>Attendance Rate</h6>
                    <p class="display-4">{{ $attendancePercentage }}%</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attendance by Module</h5>
                    <canvas id="moduleAttendanceChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attendance Trend (Last 10 Sessions)</h5>
                    <canvas id="attendanceTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Detailed Attendance by Module</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Total Sessions</th>
                                <th>Missed Sessions</th>
                                <th>Attendance Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceByModule as $module)
                            <tr>
                                <td>{{ $module->intitule_element }}</td>
                                <td>{{ $module->total_sessions }}</td>
                                <td>{{ $module->missed_sessions }}</td>
                                <td>{{ round(($module->total_sessions - $module->missed_sessions) / $module->total_sessions * 100, 2) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Attendance Trend Chart
    var ctxTrend = document.getElementById('attendanceTrendChart').getContext('2d');
    var attendanceTrend = @json($attendanceTrend);
    
    var labelsTrend = attendanceTrend.map(item => item.date);
    var dataTrend = attendanceTrend.map(item => item.status === 'Absent' ? 0 : 1); // Mark as 1 for Present, 0 for Absent
    
    var trendChart = new Chart(ctxTrend, {
        type: 'line',
        data: {
            labels: labelsTrend,
            datasets: [{
                label: 'Attendance Trend',
                data: dataTrend,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Status'
                    },
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            return value === 1 ? 'Present' : 'Absent';
                        }
                    }
                }
            }
        }
    });

    // Attendance by Module Chart
    var ctxModule = document.getElementById('moduleAttendanceChart').getContext('2d');
    var attendanceByModule = @json($attendanceByModule);
    
    var labelsModule = attendanceByModule.map(item => item.intitule_element);
    var totalSessionsData = attendanceByModule.map(item => item.total_sessions);
    var missedSessionsData = attendanceByModule.map(item => item.missed_sessions);
    
    var moduleChart = new Chart(ctxModule, {
        type: 'bar',
        data: {
            labels: labelsModule,
            datasets: [
                {
                    label: 'Total Sessions',
                    data: totalSessionsData,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Missed Sessions',
                    data: missedSessionsData,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Modules'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Number of Sessions'
                    },
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
