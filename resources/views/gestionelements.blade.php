@extends('master')

@section('app-mid')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('diplomes.index') }}" id="">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">

    </a>
    <a href="#" id="toggleFormBtn">
        <svg width="45px" height="45px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="white" />
            <path d="M12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="#1C274C" />
        </svg>
    </a>
    <div class="datatabcontainer mt-4">
        <table class="tab" id="myTable">
            <thead>
                <tr>
                    <th>code etape diplome</th>
                    <th>nom etape diplome</th>
                    <th>liaisons</th>
                </tr>
            </thead>
            <tbody>
                @foreach($etapes as $etape)
                <tr>
                    <td>{{ $etape->code_etape_diplome }}</td>
                    <td>{{ $etape->nom_etape_diplome }}</td>
                    <td>
                        <a href="{{ route('elementspedago', ['id' => $id_diplome, 'etape_id' => $etape->id]) }}">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 6L21 6.00066M10 12L21 12.0007M10 18L21 18.0007M3 5L5 4V10M5 10H3M5 10H7M7 20H3L6.41274 17.0139C6.78593 16.6873 7 16.2156 7 15.7197C7 14.7699 6.23008 14 5.28033 14H5C4.06808 14 3.28503 14.6374 3.06301 15.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        <a href="#">
                            <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="#1C274C" />
                                <path d="M15 12.75C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H15Z" fill="red" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <div id="formContainer" class="containerf form-container bg-light-gray" style="display: none;">
        <form action="{{ route('store-etape-diplome') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container2">
                <h2 class="form-title text-white">Ajouter une nouvelle Etape a ce Diplome</h2>
                <div class="mb-3">
                    <label for="code_etape_diplome" class="form-label" style="color: white;">Code Etape Diplome</label>
                    <input type="text" class="form-control" id="code_etape_diplome" name="code_etape_diplome" maxlength="50">
                </div>

                <div class="mb-3">
                    <label for="nom_etape_diplome" class="form-label" style="color: white;">Nom Etape Diplome</label>
                    <input type="text" class="form-control" id="nom_etape_diplome" name="nom_etape_diplome" maxlength="500">
                </div>

                <div class="mb-3">
                    <label for="id_diplome" class="form-label" style="color: white;">ID Diplome</label>
                    <select class="form-control" id="id_diplome" name="id_diplome">
                        <option selected disabled>Diplome</option>
                        @foreach ($diplomes as $diploma)
                        <option value="{{ $diploma->id }}">{{ $diploma->intitule_diplome_fr }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button class="btn submit-btn" type="submit">Enregistrer</button>
                </div>
            </div>
        </form>
    </div>
</div>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{session('
        success ')}}',
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('
        error ') }}'
    });
</script>
@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#toggleFormBtn').click(function() {
            $('#formContainer').toggle();
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>

<script>
    let table = new DataTable('#myTable');
</script>
<style>
    .datatabcontainer1 {
        border-radius: 12px;
        background-color: #6497b1;
        color: #000000;
    }

    .container2 {
        max-width: 500px;
        margin: 0 auto;
        /* This will horizontally center the container */
    }

    .containerf {
        background-color: #5e6a81;
        border-radius: 10px;
        margin: 5% auto;
        /* Adjusted margin to center vertically and horizontally */
        padding: 5px;
        position: relative;
    }

    .excelinput {
        width: 90%;
        /* Adjusted width to fit inside container */
        margin: 0 auto;
        /* Center the element horizontally */
        color: white;
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





<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>


@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">