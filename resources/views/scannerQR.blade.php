@extends('master')

@section('app-mid')

<div class="app-main">
    @include('tiles.actions')
    <title>Attendance Scanner</title>
    <script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <style>
        #qr-reader {
            width: 100%;
        }

        .only-mobile {
            display: none;
        }
    </style>
    <script>
        function isMobileDevice() {
            return /Mobi|Android/i.test(navigator.userAgent);
        }

        window.onload = function() {
            if (!isMobileDevice()) {
                document.getElementById('only-mobile-message').style.display = 'block';
                document.getElementById('qr-reader').style.display = 'none';
            } else {
                document.getElementById('only-mobile-message').style.display = 'none';
                document.getElementById('qr-reader').style.display = 'block';
            }

            const qrCodeSuccessCallback = (decodedText, decodedResult) => {
                fetch('/store-scanned-attendance', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            qr_data: decodedText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Attendance recorded successfully!');
                        } else {
                            alert('Failed to record attendance.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error recording attendance.');
                    });
            };

            const qrCodeErrorCallback = (errorMessage) => {
                console.error(`QR Code Error: ${errorMessage}`);
            };

            const html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: 250
                },
                qrCodeSuccessCallback,
                qrCodeErrorCallback
            );
        };
    </script>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('
            success ') }}',
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('
            error ') }}',
        });
    </script>
    @endif
    </head>

    <body>
        <div id="only-mobile-message" class="only-mobile">
            <p>This page is only accessible from mobile devices.</p>
        </div>
        <div id="qr-reader"></div>
    </body>
</div>