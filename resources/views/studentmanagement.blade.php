@extends('master')
@section("app-mid")
<title>Management Etudiant</title>
<div class="app-main">
    @include('tiles.actions')
    <div class="document-list " id="data-container">
        <a href="#" class="card-link">
            <div class="card">
                <img src="{{ asset('black-hole.svg') }}" alt="black hole">
                <div class="card-content">
                    <h3>Black Hole</h3>
                </div>
            </div>
        </a>
        <a href="#" class="card-link">
            <div class="card">
                <img src="{{ asset('freeze.svg') }}" alt="freeze">
                <div class="card-content">
                    <h3>Freeze User</h3>
                </div>
            </div>
        </a>
        <a href="#" class="card-link">
            <div class="card">
                <img src="{{ asset('settings.svg') }}" alt="freeze">
                <div class="card-content">
                    <h3>Student management</h3>
                </div>
            </div>
        </a>
        <a href="#" class="card-link">
            <div class="card">
            <img src="{{ asset('qr.svg') }}" alt="qr" width="40px" height="40px" style="color: #1C274C;">
                <div class="card-content">
                    <h3>Attendance</h3>
                </div>
            </div>
        </a>
        
    </div>

</div>


<style>
    .document-list {
        padding-top: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .card {
        display: flex;
        align-items: center;
        border-radius: 8px;
        padding: 16px;
        text-align: left;
        max-height: 100px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card img {
        margin-right: 20px;
        /* Space between the image and text */
        width: 66px;
        height: 66px;
    }

    .card-content {
        flex: 1;
    }

    .card-content h3 {
        margin: 0;
        font-size: 1.6em;
        color: #3e3e3e;
    }

    .view-document.btn {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
    }
</style>

@endsection