@extends('master')
@section("app-mid")
<div class="app-main">
    @include('tiles.actions')
    <form action="{{ route('handleManualEntry') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="manual_code">Enter the 8-Digit Code:</label>
        <input type="text" name="manual_code" id="manual_code" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
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