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

        #reader {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .qr-reader-container {
            text-align: center;
            margin-top: 20px;
        }
    </style>

    <div class="manual-entry-container">
        <label for="attendance-event-id">Enter Attendance Event ID:</label>
        <input type="text" id="attendance-event-id" class="manual-entry-input" placeholder="Attendance Event ID">
        <button onclick="handleManualEntry()" class="manual-entry-button">Submit</button>
    </div>

    <div class="qr-reader-container">
        <div id="reader"></div>
    </div>

    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        function generateDeviceId() {
            return 'device-' + Math.random().toString(36).substr(2, 9);
        }

        function getDeviceId() {
            let deviceId = localStorage.getItem('device_id');
            if (!deviceId) {
                deviceId = generateDeviceId();
                localStorage.setItem('device_id', deviceId);
            }
            return deviceId;
        }

        function handleManualEntry() {
            const attendanceEventId = document.getElementById('attendance-event-id').value.trim();

            if (attendanceEventId !== '') {
                console.log('Attendance Event ID:', attendanceEventId);
                // Add logic to handle manual entry
            } else {
                alert('Please enter an Attendance Event ID.');
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code scanned = ${decodedText}`, decodedResult);
            
            const deviceId = getDeviceId();

            fetch('{{ route('scan.qr.code') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    qr_data: decodedText,
                    device_id: deviceId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Attendance recorded successfully!');
                } else {
                    alert('Failed to record attendance: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to record attendance.');
            });
        }

        function onScanFailure(error) {
            console.warn(`QR Code scan error: ${error}`);
        }

        let html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            { facingMode: "environment" },
            {
                fps: 10,
                qrbox: 250
            },
            onScanSuccess,
            onScanFailure
        );
    </script>
</div>
@endsection
