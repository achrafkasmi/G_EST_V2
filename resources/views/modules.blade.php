@extends('master')

@section('app-mid')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<div class="app-main">
    <!--<div class="containerf form-container bg-light-gray">
        <form action="{{ route('diplomes.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container2">
                <h2 class="form-title text-white">Ajouter des Diplomes</h2>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label" style="color: white;">Intitulé du Diplome (Français)</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="intitule_diplome_fr" placeholder="example:Génie Miner">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="form-label" style="color: white;">Intitulé du Diplome (Arabe)</label>
                    <input type="text" class="form-control" id="exampleFormControlInput2" name="intitule_diplome_ar" placeholder="مثال: الهندسة المعلوماتية">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput3" class="form-label" style="color: white;">Définir Code du Diplome</label>
                    <input type="text" class="form-control" id="exampleFormControlInput3" name="code_diplome" placeholder="">
                </div>

                <p style="color: white;"> Diplome Acrédité le <input type="text" id="datepicker" name="date_accreditation"></p>

                <div class="mb-3">
                    <label for="exampleFormControlInput4" class="form-label" style="color: white;">Année début accreditation Diplome</label>
                    <input type="text" class="form-control" id="exampleFormControlInput4" name="anne_debut_accreditation" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput5" class="form-label" style="color: white;">Année fin accreditation Diplome</label>
                    <input type="text" class="form-control" id="exampleFormControlInput5" name="anne_fin_accreditation" placeholder="">
                </div>

                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label" style="color: white;">Code Chef de Filière</label>
                    <input type="text" class="form-control" id="exampleFormControlInput6" name="id_personnel" placeholder="Ex:GI123..">
                </div>

                <div class="d-grid gap-2 mt-3">
                    <button class="btn submit-btn" type="submit">Enregistrer</button>
                </div>

            </div>
        </form>
    </div>-->


    <div class="datatabcontainer mt-4">
        <table class="tab" id="myTable">

            <thead>
                <tr>
                    <th>Intitulé du Diplome</th>
                    <th>Date accreditation</th>
                    <th>Code diplome</th>
                    <!--<th>Chef Filière</th>-->
                </tr>
            </thead>
            <tbody>

            @foreach($diplomes as $diplome)
            <tr>
                <td>{{ $diplome->intitule_diplome_fr }}</td>
                <td>{{ $diplome->date_accreditation }}</td>
                <td>{{ $diplome->code_diplome }}</td>
                <!--<td>{{ $diplome->chef_filiere }}</td> --><!-- Assuming you have a chef_filiere column in your Diplome model -->
            </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>
<script>
    let table = new DataTable('#myTable');
</script>






<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $("#datepicker").datepicker();
    });
</script>
<style>
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


@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">