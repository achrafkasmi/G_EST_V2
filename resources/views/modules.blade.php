@extends('master')

@section('app-mid')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<div class="app-main">
    @include('tiles.actions')
    <a href="#" id="toggleFormBtn">
        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="white" />
            <path d="M12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="#1C274C" />
        </svg>
    </a>

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
                    <td><a href="{{ route('gestionelements', $diplome->id ) }}" id="#">
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M16.1898 2H7.81976C4.17976 2 2.00977 4.17 2.00977 7.81V16.18C2.00977 19.82 4.17976 21.99 7.81976 21.99H16.1898C19.8298 21.99 21.9998 19.82 21.9998 16.18V7.81C21.9998 4.17 19.8298 2 16.1898 2Z" fill="#292D32" />
                                <path d="M16.41 14.1703C15.8 12.4303 14.16 11.2603 12.32 11.2603C12.31 11.2603 12.31 11.2603 12.3 11.2603L10.24 11.2702C10.24 11.2702 10.24 11.2702 10.23 11.2702C9.46998 11.2702 8.80999 10.7602 8.60999 10.0302C9.49999 9.75024 10.15 8.92025 10.15 7.94025C10.15 6.73025 9.16001 5.74023 7.95001 5.74023C6.74001 5.74023 5.75 6.73025 5.75 7.94025C5.75 8.83025 6.28999 9.60025 7.04999 9.94025V14.2802C6.28999 14.5802 5.75 15.3202 5.75 16.1802C5.75 17.3102 6.66999 18.2303 7.79999 18.2303C8.92999 18.2303 9.84998 17.3102 9.84998 16.1802C9.84998 15.3102 9.30999 14.5802 8.54999 14.2802V12.2603C9.03999 12.5703 9.61998 12.7502 10.23 12.7502H10.24L12.3 12.7402C13.48 12.7002 14.53 13.4602 14.95 14.5602C14.46 14.9402 14.14 15.5202 14.14 16.1802C14.14 17.3102 15.06 18.2303 16.19 18.2303C17.32 18.2303 18.24 17.3102 18.24 16.1802C18.25 15.1402 17.44 14.2803 16.41 14.1703Z" fill="#292D32" />
                            </svg>
                        </a>
                        <a >
                            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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