@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')

<body>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Attendance marked successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/'; // Redirect to a desired page
            }
        });
    </script>
</body>
@endsection