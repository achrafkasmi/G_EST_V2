@extends('master')

@section("app-mid")
<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>


<style>
    body {
        background-color: #26324a;
        /* Slightly lighter than #1f273d */
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .form-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #2f3c57;
        /* Slightly lighter than #1f273d */
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
        /* Slightly lighter than #2a354e */
        border: 1px solid #4d6396;
        /* Slightly lighter than #364862 */
        color: #b8c2d3;
    }

    .form-select:focus,
    .form-control:focus {
        background-color: #394a6e;
        /* Slightly lighter than #2a354e */
        border-color: #4d6396;
        /* Slightly lighter than #364862 */
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
</head>


<div class="app-main">

    @include('tiles.actions')

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès!',
            text: '{{session('
            success ')}}',
        });
    </script>
    @endif

    <div class="container form-container">
        <h2 class="form-title">Retirer un Etudiant</h2>

        <form action="{{ route('storeretrait') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="fileType" class="form-label">Sélectionner Type de retrait :</label>
                <select class="form-select form-control" id="fileType" name="fileType" required>
                    <option selected disabled>Ce retrait est :</option>
                    <option value="provisoire">Provisoire</option>
                    <option value="definitive">Definitive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="textInput" class="form-label">Motif du retrait</label>
                <input type="text" id="textInput" name="textInput" class="form-control" placeholder="fin d'etudes...">
            </div>

            <div class="mb-3">
                <label for="dossier" class="form-label">Dossier de retrait:</label>
                <input type="file" id="dossier" name="dossier" class="dropify" data-max-file-size="30M" data-height="100" />
            </div>

            <input type="hidden" name="id_etu" value="{{ $id_etu }}">

            <div class="d-grid gap-2 mt-3">
                <button class="btn submit-btn" type="submit">Envoyer</button>
            </div>
        </form>


    </div>



</div>
<script>
    $(document).ready(function() {
        // Initialize Dropify on stageFile input
        $('#dossier').dropify();

    });
</script>
@endsection


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">



<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>