@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    
    <div class="qr-code-container">
        <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>

    <div id="scanned-count-container" style="display: none;">
        <h2><span id="scanned-count">0</span></h2>
    </div>
    
    <div id="scanned-list-container" style="display: none;">
        <h2>Students who scanned:</h2>
        <ul id="scanned-list"></ul>
    </div>

    <div class="button-container">
        <img id="toggle-count" src="qrhandscanner.svg" alt="Unlock Icon" class="icon">
        <img id="toggle-list" src="list-down.svg" alt="List Icon" class="icon">
        <form action="{{ route('identify.absent.students') }}" method="POST" class="form-inline">
            @csrf
            <button type="submit" class="btn btn-identify">Identify and Store Absent Students</button>
        </form>
    </div>
</div>

<style>
    .qr-code-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 400px;  /* Adjusted width */
        height: 400px; /* Adjusted height */
        margin: 80 auto; 
    }

    #scanned-count-container, #scanned-list-container {
        text-align: center;
        margin-top: 20px;
    }

    .button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }

    .icon {
        cursor: pointer;
        width: 50px;
        height: 50px;
        margin-right: 20px;
        transition: transform 0.2s;
    }

    .icon:hover {
        transform: scale(1.1);
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
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchScannedCount() {
        $.ajax({
            url: '{{ route('scanned.count') }}',
            method: 'GET',
            success: function(data) {
                $('#scanned-count').text(data.count);
            },
            error: function() {
                console.error('Failed to fetch scanned count');
            }
        });
    }

    function fetchScannedList() {
        $.ajax({
            url: '{{ route('scanned.list') }}',
            method: 'GET',
            success: function(data) {
                $('#scanned-list').empty();
                data.students.forEach(function(student) {
                    $('#scanned-list').append('<li>' + student.first_name + ' ' + student.last_name + '</li>');
                });
            },
            error: function() {
                console.error('Failed to fetch scanned list');
            }
        });
    }

    $(document).ready(function() {
        // Fetch the scanned count every 5 seconds
        setInterval(fetchScannedCount, 5000);

        // Initial fetch
        fetchScannedCount();

        // Toggle the visibility of the scanned count
        $('#toggle-count').on('click', function() {
            $('#scanned-count-container').toggle();
        });

        // Toggle the visibility of the scanned list
        $('#toggle-list').on('click', function() {
            $('#scanned-list-container').toggle();
            fetchScannedList();
        });
    });
</script>

@endsection
