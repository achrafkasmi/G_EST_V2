@extends('master')

@section('app-mid')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<div class="app-main">
@include('tiles.actions')

    <div class="datatabcontainer mt-4">
        <table class="tab" id="myTable">

            <thead>
                <tr>
                    <th>Intitulé du Diplome</th>
                    <th>Date accreditation</th>
                    <th>Code diplome</th>
                    <th>liaisons</th>
                </tr>
            </thead>
            <tbody>

                @foreach($diplomes as $diplome)
                <tr>
                    <td>{{ $diplome->intitule_diplome_fr }}</td>
                    <td>{{ $diplome->date_accreditation }}</td>
                    <td>{{ $diplome->code_diplome }}</td>
                    <td> <a href="#" id="#">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.7281 3.88396C17.1624 2.44407 19.2604 2.41383 20.4219 3.57981C21.5856 4.74798 21.5542 6.85922 20.1189 8.30009L17.6951 10.7333C17.4028 11.0268 17.4037 11.5017 17.6971 11.794C17.9906 12.0863 18.4655 12.0854 18.7578 11.7919L21.1816 9.35869C23.0929 7.43998 23.3329 4.37665 21.4846 2.5212C19.6342 0.663551 16.5776 0.905664 14.6653 2.82536L9.81768 7.69182C7.90639 9.61053 7.66643 12.6739 9.5147 14.5293C9.80702 14.8228 10.2819 14.8237 10.5754 14.5314C10.8688 14.2391 10.8697 13.7642 10.5774 13.4707C9.41376 12.3026 9.4451 10.1913 10.8804 8.75042L15.7281 3.88396Z" fill="#1C274C" />
                                <path opacity="0.5" d="M14.4846 9.4707C14.1923 9.17724 13.7174 9.17632 13.4239 9.46864C13.1305 9.76097 13.1296 10.2358 13.4219 10.5293C14.5856 11.6975 14.5542 13.8087 13.1189 15.2496L8.27129 20.1161C6.83696 21.556 4.73889 21.5862 3.57742 20.4202C2.41376 19.2521 2.4451 17.1408 3.8804 15.6999L6.30424 13.2666C6.59657 12.9732 6.59565 12.4983 6.30219 12.206C6.00873 11.9137 5.53386 11.9146 5.24153 12.208L2.81769 14.6413C0.906387 16.56 0.666428 19.6234 2.5147 21.4788C4.36518 23.3365 7.42173 23.0944 9.334 21.1747L14.1816 16.3082C16.0929 14.3895 16.3329 11.3262 14.4846 9.4707Z" fill="#1C274C" />
                            </svg>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <a href="#" id="toggleFormBtn">
        <svg width="55px" height="55px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="white" />
            <path d="M12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="#1C274C" />
        </svg>
    </a>


    <div id="formContainer" class="containerf form-container bg-light-gray" style="display: none;">
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