@extends('master')
@section("app-mid")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<div class="app-main">
    @include('tiles.actions')
    <div class="container form-container">
        <div class="form-title">générer QR de présence</div>

        <form action="{{ route('generate.qr.code') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="id_local">Local</label>
                <select id="id_local" name="id_local" class="form-control" required>
                    @foreach($locals as $id => $local)
                    <option value="{{ $id }}">{{ $local }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_personnel">Personnel</label>
                <select id="id_personnel" name="id_personnel" class="form-control" required>
                    @foreach($personnels as $id => $personnel)
                    <option value="{{ $id }}">{{ $personnel }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="id_element_pedago">Element Pedagogique</label>
                <select id="id_element_pedago" name="id_element_pedago" class="form-control" required>
                    @foreach($elementsPedago as $id => $element)
                    <option value="{{ $id }}">{{ $element }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="annee">Année</label>
                <select id="annee" name="annee" class="form-control" required>
                    @foreach($annees as $annee)
                    <option value="{{ $annee }}">{{ $annee }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="filiere">Filière</label>
                <select id="filiere" name="filiere" class="form-control" required>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere }}">{{ $filiere }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="annee_uni">Année Universitaire</label>
                <select id="annee_uni" name="annee_uni" class="form-control" required>
                    @foreach($anneeUnis as $anneeUni)
                    <option value="{{ $anneeUni }}">{{ $anneeUni }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="periode_seance">Période Séance</label>
                <select id="periode_seance" name="periode_seance" class="form-control" required>
                    <option value="8-10">08:00h-10:00h</option>
                    <option value="10-12">10:00h-12:00h</option>
                    <option value="12-14">12:00h-14:00h</option>
                    <option value="14-16">14:00h-16:00h</option>
                    <option value="16-18">16:00h-18:00h</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type_seance">Type of Session</label>
                <select name="type_seance" id="type_seance" class="form-control">
                    @foreach ($typeSeances as $typeSeance)
                    <option value="{{ $typeSeance }}">{{ $typeSeance }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Generate QR Code</button>
        </form>
    </div>
</div>

<style>
    body {
        background-color: #26324a;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .form-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #2f3c57;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 24px;
        color: #007bff;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-label {
        color: #b8c2d3;
    }

    .form-select,
    .form-control {
        background-color: #394a6e;
        border: 1px solid #4d6396;
        color: #b8c2d3;
    }

    .form-select:focus,
    .form-control:focus {
        background-color: #394a6e;
        border-color: #4d6396;
        color: #b8c2d3;
    }

    .dropify-wrapper {
        border-radius: 8px;
        overflow: hidden;
    }

    .dropify-wrapper .dropify-message p {
        font-size: 14px;
        color: #b8c2d3;
    }

    .submit-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        cursor: pointer;
    }

    .submit-btn:hover {
        background-color: #0056b3;
    }
</style>
<script>
    // Get the current year
    const currentYear = new Date().getFullYear();
    // Set the academic year in the format current year-current year+1
    const academicYear = `${currentYear}-${currentYear + 1}`;
    // Set the value of the input field
    document.getElementById('annee_uni').value = academicYear;
</script>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">