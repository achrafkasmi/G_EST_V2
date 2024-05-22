@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')

    <div class="container form-container bg-light-gray">
        <h1 class="text-center mb-4" style="font-weight: bold; color: white;">Saisir les informations de la séance</h1>
        <form action="{{ route('generate.qr.code') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="id_local" class="form-label">Local:</label>
                <select class="form-select form-control" id="id_local" name="id_local" required>
                    <option selected disabled>Selectionner un local</option>
                    @foreach($locals as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="id_personnel" class="form-label">Personnel:</label>
                <select class="form-select form-control" id="id_personnel" name="id_personnel" required>
                    <option selected disabled>Selectionner un personnel</option>
                    @foreach($personnels as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="id_element_pedago" class="form-label">Element Pedagogique:</label>
                <select class="form-select form-control" id="id_element_pedago" name="id_element_pedago" required>
                    <option selected disabled>Selectionner un élément pédagogique</option>
                    @foreach($elementsPedago as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="annee_uni" class="form-label">année Academique:</label>
                <input type="text" name="annee_uni" id="annee_uni" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="heure_debut_seance" class="form-label">heure debut séance:</label>
                <input type="time" name="heure_debut_seance" id="heure_debut_seance" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="heure_fin_seance" class="form-label">heure fin séance:</label>
                <input type="time" name="heure_fin_seance" id="heure_fin_seance" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Generer QR Code</button>
        </form>
    </div>
</div>

<style>
    .form-control {
        color: grey;
    }

    .datatabcontainer {
        border-radius: 12px;
        background-color: #6497b1;
        color: #000000;
    }

    .container {
        max-width: 600px;
        margin: 0 auto;
        /* This will horizontally center the container */
    }

    .container {
        background-color: #5e6a81;
        border-radius: 10px;
        margin: 5% auto;
        /* Adjusted margin to center vertically and horizontally */
        padding: 5px;
        position: relative;
    }

    .form-label {
        color: wheat;
    }




    @media only screen and (max-width: 768px) {
        .excelinput {
            width: 80%;
            margin-left: 10%;
        }
    }

    @media only screen and (max-width: 480px) {
        .excelinput {
            width: 90%;
            margin-left: 5%;
        }
    }

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

    .submit-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        width: 150px;
        border-radius: 10px;
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