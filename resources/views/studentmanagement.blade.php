@extends('master')
@section("app-mid")
<title>Management Etudiant</title>
<div class="app-main">
    @include('tiles.actions')
    <div class="document-list" id="data-container">
        <a href="{{route('student.selection')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('listeetudiants.svg') }}" alt="black hole">
                <div class="card-content">
                    <h3>Student Lists</h3>
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

        <a href="{{route('Admin.Attendance.Stats.Index')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('qr.svg') }}" alt="qr" width="40px" height="40px" style="color: #1C274C;">
                <div class="card-content">
                    <h3>Attendance</h3>
                </div>
            </div>
        </a>

        <a href="{{route('avatar.select')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('user-avatars.svg') }}">
                <div class="card-content">
                    <h3>Avatars</h3>
                </div>
            </div>
        </a>

    </div>
    <div>
            <div class="orange-trait"></div>
        </div>
    <div class="document-list" id="data-container">
        <a href="{{route('password.reset.form')}}" class="card-link">
            <div class="card red-border">
                <img src="{{ asset('password.svg') }}" alt="password" width="40px" height="40px" style="color: #1C274C;">
                <div class="card-content">
                    <h3>Passwords</h3>
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
        max-height: 75px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card img {
        margin-right: 20px;
        width: 50px;
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

    .red-border {
        border: solid orangered .4mm;
    }
    .orange-trait {
        height: .3mm;
   margin-left: 100px;
   margin-right: 100px;
        background-color: orangered;
        margin-top: 40px;
        margin-bottom: 20px; /* Space below the line */
    }
</style>

@endsection