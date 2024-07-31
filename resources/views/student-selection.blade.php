@extends('master')

@section("app-mid")
<title>Extraction des Listes</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('index.studentmanage') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="container form-container">
        <div class="form-title">Selection des attributs de la liste</div>

        <form action="{{ route('student.generatePDF') }}" method="POST" target="_blank">
            @csrf
            <div class="form-group">
                <label for="annee" class="form-label">Année du diplome:</label>
                <select id="annee" name="annee" class="form-control" required>
                    <option value="" selected disabled>Select Annee</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->Annee }}">{{ $annee->Annee }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="filiere" class="form-label">Filière:</label>
                <select id="filiere" name="filiere" class="form-control" required>
                    <option value="" selected disabled>Select FILIERE</option>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere->FILIERE }}">{{ $filiere->FILIERE }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="annee_uni" class="form-label">année Academique:</label>
                <input type="text" name="annee_uni" id="annee_uni" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="columns" class="form-label">colonnes optionelles:</label>
                <div id="columns-container">
                    <div class="column-group d-flex align-items-center">
                        <input type="text" name="columns[]" class="form-control" placeholder="Nom de colonne">
                        <button type="button" class="btn btn-danger btn-sm ml-2 remove-column">Supprimer</button>
                    </div>
                </div>
                <button type="button" id="add-column" class="btn btn-secondary mt-2">Ajouter colonne</button>
            </div>
            <button type="submit" class="btn btn-primary mt-3">imprimer PDF</button>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-column').addEventListener('click', function() {
        var container = document.getElementById('columns-container');
        var newColumnGroup = document.createElement('div');
        newColumnGroup.className = 'column-group d-flex align-items-center';
        newColumnGroup.innerHTML = `
            <input type="text" name="columns[]" class="form-control mt-2" placeholder="Nom de colonne">
            <button type="button" class="btn btn-danger btn-sm ml-2 remove-column mt-2">Supprimer</button>
        `;
        container.appendChild(newColumnGroup);
    });

    document.getElementById('columns-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-column')) {
            e.target.parentElement.remove();
        }
    });
</script>

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
@endsection
