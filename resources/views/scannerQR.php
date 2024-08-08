@extends('master')
@section("app-mid")
<div class="app-main">
    @include('tiles.actions')
    <div class="attendance-container">
        <h2>Scan the QR Code or Enter the Code to Mark Your Attendance</h2>
        <div class="qr-and-code-container">
            <div class="qr-code">
                {!! $qrCode !!}
            </div>
            <div class="unique-code">
                <h3>Or Enter the Code Manually</h3>
                <form action="{{ route('attendance.manual.entry') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="code">Code:</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ $uniqueCode }}" readonly>
                    </div>
                    <button type="submit" class="btn btn-submit">Mark Presence</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .attendance-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
    }

    .qr-and-code-container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    .qr-code,
    .unique-code {
        margin: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        padding: 10px;
        width: 300px;
        text-align: center;
    }

    .btn-submit {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>

@endsection