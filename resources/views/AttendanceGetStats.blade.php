@extends('master')

@section("app-mid")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<title>Select Avatars</title>

<div class="app-main">
    <div class="container form-container">
        <div class="form-title">Selection des attributs de la liste</div>
        <form action="{{ route('Generate.statsPdf') }}" method="post" enctype="multipart/form-data" target="_blank" id="documentForm">
            @csrf

            <div class="form-group">
                <select id="filiere-select" name="filiere" class="form-control tag-select" required>
                    <option value="" disabled selected>Selectionner Filière</option>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere->FILIERE }}">{{ $filiere->FILIERE }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <select id="annee" name="annee" class="form-control tag-select" required>
                    <option value="" disabled selected>Selectionner Etape Pédagogique</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee->Annee }}">{{ $annee->Annee }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                
                <select id="annee_uni" name="annee_uni" class="form-control tag-select" required>
                    <option value="" disabled selected>Selectionner Annee Universitaire</option>
                    @foreach($annee_unis as $annee_uni)
                    <option value="{{ $annee_uni->annee_uni }}">{{ $annee_uni->annee_uni }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Submit Button -->
            <button type="submit" class="submit-btn">Download PDF</button>
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

@endsection