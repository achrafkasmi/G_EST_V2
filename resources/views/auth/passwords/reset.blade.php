@extends('master')

@section("app-mid")

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.default.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

<div class="app-main">
    @include('tiles.actions')

    <!-- Tabs Navigation -->
    <div class="tabs">
        <a href="{{ route('index.studentmanage') }}">
            <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
        </a>
        <button class="tablinks active" onclick="openTab(event, 'StudentsTab')">Students</button>
        <button class="tablinks" onclick="openTab(event, 'StaffTab')">Staff</button>
    </div>

    <!-- Students Tab -->
    <div id="StudentsTab" class="tabcontent" style="display: block;">
        <div class="datatabcontainer mt-4">
            <table class="tab" id="studentsTable">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Matricule</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                    <tr>
                        <td>{{ isset($student->nom_fr) ? $student->nom_fr : 'N/A' }} {{ isset($student->prenom_fr) ? $student->prenom_fr : 'N/A' }}</td>
                        <td>{{ isset($student->apogee) ? $student->apogee : 'N/A' }}</td>
                        <td>{{ isset($student->email) ? $student->email : 'N/A' }}</td>
                        <td>
                            <button class="reset-password" data-id="{{ $student->id }}">
                                <img src="{{ asset('password-reset.svg') }}" alt="Reset Password" />
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Staff Tab -->
    <div id="StaffTab" class="tabcontent" style="display: none;">
        <div class="datatabcontainer mt-4">
            <table class="tab" id="staffTable">
                <thead>
                    <tr>
                        <th>Nom complet</th>
                        <th>Identifiant</th>
                        <th>Last Update</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($personnel as $staffMember)
                    <tr>
                        <td>{{ isset($staffMember->name) ? $staffMember->name : 'N/A' }}</td>
                        <td>{{ isset($staffMember->email) ? $staffMember->email : 'N/A' }}</td>
                        <td>{{ isset($staffMember->updated_at) ? $staffMember->updated_at : 'N/A' }}</td>
                        <td>
                            <button class="reset-password" data-id="{{ $staffMember->id }}">
                                <img src="{{ asset('password-reset.svg') }}" alt="Reset Password" />
                            </button>
                        </td>
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
        // Initialize DataTables for Students and Staff
        $('#studentsTable').DataTable({
            scrollX: true
        });
        $('#staffTable').DataTable({
          
        });

        $('.reset-password').click(function() {
            var userId = $(this).data('id');

            // Show SweetAlert popup with form fields
            Swal.fire({
                title: 'Reset Password',
                html: '<input type="password" id="old-password" class="swal2-input" placeholder="Old Password">' +
                    '<input type="password" id="new-password" class="swal2-input" placeholder="New Password">' +
                    '<input type="password" id="confirm-password" class="swal2-input" placeholder="Confirm New Password">',
                focusConfirm: false,
                showCancelButton: true,
                confirmButtonText: 'Reset Password',
                preConfirm: () => {
                    const oldPassword = Swal.getPopup().querySelector('#old-password').value;
                    const newPassword = Swal.getPopup().querySelector('#new-password').value;
                    const confirmPassword = Swal.getPopup().querySelector('#confirm-password').value;

                    if (!oldPassword || !newPassword || !confirmPassword) {
                        Swal.showValidationMessage('All fields are required');
                    } else if (newPassword !== confirmPassword) {
                        Swal.showValidationMessage('New passwords do not match');
                    }

                    return {
                        oldPassword: oldPassword,
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route("password.reset") }}',
                        method: 'POST',
                        data: {
                            id: userId,
                            old_password: result.value.oldPassword,
                            password: result.value.newPassword,
                            password_confirmation: result.value.confirmPassword,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire('Reset!', 'Password has been reset.', 'success');
                        },
                        error: function(xhr, status, error) {
                            // Show detailed error message from server
                            Swal.fire('Error!', xhr.responseJSON.message || 'There was an error resetting the password.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>

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

    /*reset buttons*/
    .reset-password {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    .reset-password img {
        display: block;
        /* Prevents any extra space around the image */
        width: 24px;
        /* Adjust the width as needed */
        height: 24px;
        /* Adjust the height as needed */
    }
</style>

@endsection