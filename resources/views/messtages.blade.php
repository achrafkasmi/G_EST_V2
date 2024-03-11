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
            background-color: #26324a; /* Slightly lighter than #1f273d */
            color: #fff;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #2f3c57; /* Slightly lighter than #1f273d */
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
            background-color: #394a6e; /* Slightly lighter than #2a354e */
            border: 1px solid #4d6396; /* Slightly lighter than #364862 */
            color: #b8c2d3;
        }

        .form-select:focus,
        .form-control:focus {
            background-color: #394a6e; /* Slightly lighter than #2a354e */
            border-color: #4d6396; /* Slightly lighter than #364862 */
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

    <div class="container form-container">
        <h2 class="form-title">Dossier de Stage</h2>

        <form action="{{ route('upload.post') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="fileType" class="form-label">Select Type:</label>
                <select class="form-select form-control" id="fileType" name="fileType">
                    <option selected>Select type de dossier de stage</option>
                    <option value="1">Stage d'initiation</option>
                    <option value="2">Stage professionnel</option>
                    <option value="3">Stage technique</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="stageFile" class="form-label">Dossier de stage en PDF:</label>
                <input type="file" id="stageFile" name="stageFile" class="dropify" data-max-file-size="1M" data-height="100" />
            </div>

            <div class="mb-3">
                <label for="rapportFile" class="form-label">Rapport en PDF:</label>
                <input type="file" id="rapportFile" name="rapportFile" class="dropify" data-max-file-size="1M" data-height="100" />
            </div>

            <div class="d-grid gap-2 mt-3">
                <button class="btn submit-btn" type="submit">Envoyer</button>
            </div>
        </form>
    </div>

</div>
<script>
    $(document).ready(function() {
        // Initialize Dropify on stageFile input
        $('#stageFile').dropify();

        // Initialize Dropify on rapportFile input
        $('#rapportFile').dropify();
    });
</script>
@endsection


<style>
    @media only screen and (max-width: 992px) {
        .form {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 10px;
            width: 98%;
            position: absolute;
            left: 0;
        }
    }

    @media only screen and (min-width: 992px) {
        .form {
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0;
            width: 50%;
            position: absolute;
            left: 25%;
        }
    }

    /*.body{               hada old background momkin n7tajo
        background-image: url('background2.png'); 
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
    }*/

    .form-floatings {
        position: fixed;
        bottom: 0;
        width: 50%;
        transform: translateX(-50%);
    }

    .border {
        position: relative;
        border-radius: 20px;
    }
</style>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<!-- Include Bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">