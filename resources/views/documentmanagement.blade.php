@extends('master')
@section("app-mid")
<title>E-Documents</title>

<div class="app-main">
    @include('tiles.actions')
    <div class="document-list " id="data-container">
        <a href="{{ route('DC')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('doc-share.svg') }}" alt="targetting">
                <div class="card-content">
                    <h3>E-doc sharing</h3>
                </div>
            </div>
        </a>
        <a href="{{ route('documentsettings.index')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('settings.svg') }}" alt="settings">
                <div class="card-content">
                    <h3>doc settings</h3>
                </div>
            </div>
        </a>

        <a href="{{ route('dash-of-scan')}}" class="card-link">
            <div class="card">
                <img src="{{ asset('scanneddoc.svg') }}" alt="settings">
                <div class="card-content">
                    <h3>scanned baccalaureate</h3>
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
        padding: 7px;
        text-align: left;
        max-height: 75px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .card img {
        margin-right: 20px;
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