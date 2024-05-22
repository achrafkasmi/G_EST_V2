@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')

    
        <h1>Generated QR Code</h1>
        <div class="qr-code-container">
            <img src="{{ route('generate.qr.code') }}" alt="QR Code">
        </div>
   
</div>

<style>
    .qr-code-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 300px; /* Set the width of the container */
        height: 300px; /* Set the height of the container */
        margin: 0 auto; /* Center the container horizontally */
    }
</style>

@endsection
