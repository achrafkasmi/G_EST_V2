@extends('master')

@section('app-mid')

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('attendance.dash.blade') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <title>Attendance Scanner</title>
    <style>
        .manual-entry-container {
            text-align: center;
            margin-top: 50px;
        }

        .manual-entry-input {
            width: 300px;
            height: 40px;
            font-size: 16px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        .manual-entry-button {
            height: 40px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            padding: 0 20px;
        }

        .manual-entry-button:hover {
            background-color: #0056b3;
        }
    </style>
    
    <script>
        function handleManualEntry() {
            const attendanceEventId = document.getElementById('attendance-event-id').value.trim();

            if (attendanceEventId !== '') {
                // Perform action for manual entry (e.g., submit form, fetch data)
                console.log('Attendance Event ID:', attendanceEventId);
                // Replace with your fetch() request for manual entry
            } else {
                alert('Please enter an Attendance Event ID.');
            }
        }
    </script>

    <div class="manual-entry-container">
        <label for="attendance-event-id">Enter Attendance Event ID:</label>
        <input type="text" id="attendance-event-id" class="manual-entry-input" placeholder="Attendance Event ID">
        <button onclick="handleManualEntry()" class="manual-entry-button">Submit</button>
    </div>

</div>

@endsection
