@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    <button id="leavePageBtn" style="background: none; border: none; padding: 0;">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </button>
    <div class="qr-code-container">
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
        <div id="scannedCount" class="scanned-count">Scanned Count: 0</div>
    </div>
    <div class="button-container">
        <form action="{{ route('identify.absent.students') }}" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-identify ">Identify and Store Absent Students</button>
        </form>
    </div>
    <div class="datatabcontainerr mt-4">
        <table class="tab" id="presenceTable">
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="attendanceTableBody">
                @foreach ($students as $student)
                <tr data-id="{{ $student->id }}">
                    <td>{{ $student->nom_fr }} {{ $student->prenom_fr }}</td>
                    <td class="status-cell">
                        @if (in_array($student->id, $scannedStudentIds))
                        Present
                        @else
                        Absent
                        @endif
                    </td>
                    <td>
                        @if (!in_array($student->id, $scannedStudentIds))
                        <button class="markitmanual" style="background: none; border: none;">
                            <img src="{{ asset('markitmanual.svg') }}" alt="Mark Attendance" width="24" height="24">
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#presenceTable').DataTable({
            // DataTable options
        });

        // Function to fetch and update scanned count
        function fetchScannedCount() {
            $.ajax({
                url: '{{ route("attendance.getScannedCount") }}',
                method: 'GET',
                success: function(response) {
                    $('#scannedCount').text('Scanned Count: ' + response.count);
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        }

        // Function to fetch and update attendance status
        function fetchAttendanceStatus() {
            $.ajax({
                url: '{{ route("attendance.getScannedList") }}',
                method: 'GET',
                success: function(response) {
                    // Update status cells
                    response.students.forEach(function(student) {
                        var statusClass = student.is_scanned ? 'present' : 'absent';
                        var statusText = student.is_scanned ? 'P' : 'A';
                        $('tr[data-id="' + student.id + '"] .status-cell').html('<span class="' + statusClass + '">' + statusText + '</span>');
                        if (student.is_scanned) {
                            // Remove the button for scanned students
                            $('tr[data-id="' + student.id + '"] .markitmanual').remove();
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error("An error occurred: " + error);
                }
            });
        }

        // Initial fetch
        fetchScannedCount();
        fetchAttendanceStatus();

        // Periodically fetch every - seconds
        setInterval(fetchScannedCount, 3000);
        setInterval(fetchAttendanceStatus, 3300);
    });

    $(document).on('click', '.markitmanual', function() {
        var studentId = $(this).closest('tr').data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to mark this student as present?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, mark as present!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("attendance.markAsPresent", ":id") }}'.replace(':id', studentId),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire('Success', 'Student marked as present.', 'success');
                            fetchAttendanceStatus(); // Refresh the status
                            fetchScannedCount(); // Refresh the scanned count
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + error);
                    }
                });
            }
        });
    });
    $(document).ready(function() {
        $('#leavePageBtn').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'êtes-vous sur?',
                text: "Voulez-vous vraiment quitter la page ? La liste des étudiants présents sera effacée.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, pars !',
                cancelButtonText: 'Non, reste'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("attendance.clearTempScannedStudents") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = '{{ route("attendance.form") }}'; 
                            } else {
                                Swal.fire('Error', 'Failed to clear scanned students.', 'error');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("An error occurred: " + error);
                        }
                    });
                }
            });
        });
    });
</script>
<style>
    .qr-code-container {
        display: flex;
        flex-direction: column;
        /* Adjust to align QR code and scanned count */
        justify-content: center;
        align-items: center;
        width: 400px;
        height: 400px;
        margin: 80 auto;
    }

    .scanned-count {
        margin-top: 10px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
    }

    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
        margin-bottom: 50px;
    }

    .form-inline {
        display: inline;
    }


    .btn-identify {
        padding: 15px 30px;
        font-size: 18px;
        font-weight: bold;
        color: #fff;
        background-color: #28a745;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .btn-identify:hover {
        background-color: #218838;
    }

    .present {
        color: green;
    }

    .absent {
        color: red;
    }

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
        white-space: nowrap;
    }

    .dt-paging {
        color: grey;
    }

    .datatabcontainerr {
        background-color: var(--app-bg-dark);
        color: #fff;
        border-collapse: collapse;
        width: 100%;
        overflow-x: auto;
    }

    .tab th,
    .tab td {
        padding: 8px;
        text-align: left;
        word-break: break-word;
    }

    .tab th {
        white-space: nowrap;
    }
</style>
@endsection