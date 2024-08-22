@extends('master')
@section("app-mid")

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<div class="app-main">

    @include('tiles.actions')
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('
            success ') }}',
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: '{{ session('
            error ') }}',
        });
    </script>
    @endif
    <a href="{{ route('fetch.library') }}" id="">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">

    </a>
    <div class="container form-container">
        <div class="form-title">Ajout Manuel des Dossiers de Stage</div>
        <form action="{{ route('dossier-stage.manualstore') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="annee_universitaire" class="form-label">Année Universitaire</label>
                <input type="text" name="annee_universitaire" id="annee_universitaire" class="form-control">
            </div>
            <div class="form-group">
                <label for="rapport" class="form-label">Rapport En PDF</label>
                <input type="file" name="rapport" id="rapport" class="form-control dropify">
            </div>
            <div class="form-group">
                <label for="titre_rapport" class="form-label">Titre du Rapport</label>
                <input type="text" name="titre_rapport" id="titre_rapport" class="form-control">
            </div>
            <div class="form-group">
                <label for="uploaded_type" class="form-label">Type du Rapport</label>
                <select name="uploaded_type" id="uploaded_type" class="form-control form-select" required>
                    <option value="is_uploaded_initiation">Initiation</option>
                    <option value="is_uploaded_technique">Technique</option>
                    <option value="is_uploaded_pfe">PFE</option>
                    <option value="is_uploaded_professionelle">Professionelle</option>
                </select>
            </div>
            <button type="submit" class="btn submit-btn">Submit</button>
        </form>
    </div>
</div>




<script>
    $(document).ready(function() {
        // Initialize Dropify on file inputs with customized height
        $('#dossier_stage').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something wrong happened.'
            }
        });
        $('#rapport').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something wrong happened.'
            }
        });
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
        background-color: #2f3c57;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: auto;
        margin-top: 50px;
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
        height: 80px;
        /* Custom height */
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
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">