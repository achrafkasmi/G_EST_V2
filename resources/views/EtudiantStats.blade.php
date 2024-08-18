@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('attendance.dash.blade') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="attendance-wrapper">
        <div class="attendance-card">
            <h5 class="attendance-title">Total Sessions</h5>
            <p class="attendance-number total">{{ $totalSessions }}</p>
        </div>

        <div class="attendance-card missed">
            <h5 class="attendance-title">Missed Sessions</h5>
            <p class="attendance-number">{{ $missedSessions }}</p>
            <button class="justify-button">Justifier une séance</button>
        </div>

        <div class="attendance-card rate">
            <h5 class="attendance-title">Attendance Rate</h5>
            <p class="attendance-number rate-value" data-rate="{{ $attendancePercentage }}">{{ $attendancePercentage }}%</p>
        </div>
    </div>
</div>

<style>
    .attendance-wrapper {
        display: flex;
        justify-content: space-around;
        margin-top: 3em;
        padding: 1em;
        flex-wrap: wrap;
    }

    .attendance-card {
        width: 30%;
        padding: 2em;
        box-shadow: 0px 15px 50px -13px rgba(0, 0, 0, 0.34);
        border-radius: 1em;
        background: grey;
        text-align: center;
        position: relative;
        transition: transform 0.2s ease-in-out;
        margin-bottom: 1.5em;
    }

    .attendance-card:hover {
        transform: translateY(-10px);
    }

    .attendance-title {
        font-size: 1.2em;
        color: #333;
        margin-bottom: 1em;
        font-weight: bold;
    }

    .attendance-number {
        font-size: 3em;
        font-weight: bold;
    }

    .attendance-number.total {
        color: #007bff; /* Blue for total sessions */
    }

    .attendance-card.missed .attendance-number {
        color: red;
    }

    .justify-button {
        position: absolute;
        bottom: 1mm;
        right: 1mm;
        padding: 0.5em 1em;
        font-size: 0.9em;
        color: #FFF;
        background-color: crimson;
        border: none;
        border-radius: 1em;
        cursor: pointer;
    }

    .attendance-card.rate .attendance-number.rate-value {
        color: var(--rate-color, green); /* Default to green */
    }

    /* Dynamic colors based on attendance rate */
    .attendance-card.rate .attendance-number.rate-value {
        --rate-color: orange;
    }

  
    /* Animation for rate change */
    .attendance-number.rate-value {
        transition: color 0.5s ease-in-out;
    }

    /* Media Queries for Responsiveness */
    @media (max-width: 768px) {
        .attendance-card {
            width: 45%;
        }
    }

    @media (max-width: 480px) {
        .attendance-card {
            width: 100%;
        }

        .justify-button {
            font-size: 0.8em;
            padding: 0.4em 0.8em;
        }
    }
</style>

@endsection
