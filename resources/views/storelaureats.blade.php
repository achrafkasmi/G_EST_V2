@extends('master')

@section("app-mid")
<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">


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
            laureat ajouté ')}}',
        });
    </script>
    @endif
    @if(session('errror'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'error!',
            text: '{{session('
            laureat non ajouté ')}}',
        });
    </script>
    @endif
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="container form-container">
        <h2 class="form-title">Nouveau lauréat</h2>

        <form action="{{ route('storelaureat.post') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="fileType" class="form-label">Sélectionner Type de diplome :</label>
                <select class="form-select form-control" id="fileType" name="fileType" required>
                    <option selected disabled>Ce diplome est:</option>
                    <option value="DUT">Un DUT</option>
                    <option value="LP">Une LP</option>
                </select>
            </div>

            <input type="hidden" name="id_etu" value="{{ $id_etu }}">


            <div class="mb-3" id="stageFileInput">
                <label for="stageFile" class="form-label">Dossier de laureat:</label>
                <input type="file" id="dossierloaureat" name="dossierloaureat" class="dropify" data-max-file-size="30M" data-height="100" />
            </div>

            <div class="mb-3">
                <label for="diplome" class="form-label">Diplome:</label>
                <select class="form-select form-control" id="diplome" name="diplome" required>
                    <option selected disabled>Intitule du diplome :</option>
                    @foreach($diplomas as $diploma)
                    <option value="{{ $diploma->id }}">{{ $diploma->intitule_diplome_fr }}</option> <!-- Assuming 'name' is a column in the diplomas table -->
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="academicYear" class="form-label">Année universitaire:</label>
                <input type="text" id="academicYear" name="academicYear" class="form-control" value="{{ date('Y') }}-{{ date('Y') + 1 }}" placeholder="A U">
            </div>

            <div class="d-grid gap-2 mt-3">
                <button class="btn submit-btn" type="submit">Envoyer</button>
            </div>
        </form>


    </div>



</div>
<script>
    $(document).ready(function() {

        $('#dossierloaureat').dropify();

    });
</script>
@endsection


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">