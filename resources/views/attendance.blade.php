@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    <div class="container">
        <h1>Generate QR Code for Attendance</h1>

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
                    <option value="8-10">8-10</option>
                    <option value="10-12">10-12</option>
                    <option value="12-14">12-14</option>
                    <option value="14-16">14-16</option>
                    <option value="16-18">16-18</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Generate QR Code</button>
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