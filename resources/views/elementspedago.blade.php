@extends('master')

@section('app-mid')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('diplomes.index') }}" id="">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">

    </a>
    <a href="#" id="toggleFormBtn">
        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="white" />
            <path d="M12 8.25C12.4142 8.25 12.75 8.58579 12.75 9V11.25H15C15.4142 11.25 15.75 11.5858 15.75 12C15.75 12.4142 15.4142 12.75 15 12.75H12.75L12.75 15C12.75 15.4142 12.4142 15.75 12 15.75C11.5858 15.75 11.25 15.4142 11.25 15V12.75H9C8.58579 12.75 8.25 12.4142 8.25 12C8.25 11.5858 8.58579 11.25 9 11.25H11.25L11.25 9C11.25 8.58579 11.5858 8.25 12 8.25Z" fill="#1C274C" />
        </svg>
    </a>
    <a href="">
        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="white" />
            <path d="M15 12.75C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H15Z" fill="#1C274C" />
        </svg>
    </a>
    <div class="datatabcontainer mt-4">
        <table class="tab" id="myTable">
            <thead>
                <tr>
                    <th>Code etape</th>
                    <th>Intitule element</th>
                    <th>Professeur d'élement</th>
                    <th>Nouvelle liaison</th>
                </tr>
            </thead>
            <tbody>
                @foreach($elements as $element)
                <tr>
                    <td>{{ $element->code_etape}}</td>
                    <td>{{ $element->intitule_element }}</td>
                    <td>
                        @php
                        // Retrieve the newest personnel data for this element
                        $personnel = App\Models\PersonnelElementPedagoguique::where('id_element_pedago', $element->id)
                        ->join('t_personnel', 't_personnel.id', '=', 't_personnel_element_pedago.personnel_id')
                        ->orderBy('t_personnel_element_pedago.created_at', 'desc') // Order by timestamp in descending order
                        ->limit(1) // Limit the result to one row
                        ->pluck('t_personnel.nom_personnel'); // Change 'name' to 'nom_personnel'
                        @endphp
                        @foreach($personnel as $person)
                        {{ $person }} <!-- Display the name of the newest personnel -->
                        @endforeach
                    </td>

                    <td>
                        <select class="form-select form-control small-select teacher-select" data-element-id="{{ $element->id }}" required>
                            <option selected disabled>Selectionner l'encadrant </option>
                            @foreach($teachers as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div id="formContainer" class="containerf form-container bg-light-gray" style="display: none;">
    <form action="{{ route('store-module-etape', ['id' => $id, 'etape_id' => $etape_id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container2">
            <h2 class="form-title text-white">Ajouter un nouveau Module à cette Etape</h2>

            <div class="mb-3">
                <label for="code_etape" class="form-label" style="color: white;">Code Etape</label>
                <input type="text" class="form-control" id="code_etape" name="code_etape" maxlength="50">
            </div>

            <!-- Hidden input for id_etape -->
            <input type="hidden" id="id_etape" name="id_etape" value="{{ $etape_id }}">

            <div class="mb-3">
                <label for="type_etape_element" class="form-label" style="color: white;">Type Etape Element</label>
                <input type="text" class="form-control" id="type_etape_element" name="type_etape_element" maxlength="30">
            </div>

            <div class="mb-3">
                <label for="intitule_element" class="form-label" style="color: white;">Intitulé Element</label>
                <input type="text" class="form-control" id="intitule_element" name="intitule_element" maxlength="100">
            </div>

            <div class="mb-3">
                <label for="nbr_heures_cours" class="form-label" style="color: white;">Nombre d'heures de cours</label>
                <input type="number" step="0.01" class="form-control" id="nbr_heures_cours" name="nbr_heures_cours">
            </div>

            <div class="mb-3">
                <label for="nbr_heures_td" class="form-label" style="color: white;">Nombre d'heures de TD</label>
                <input type="number" step="0.01" class="form-control" id="nbr_heures_td" name="nbr_heures_td">
            </div>

            <div class="mb-3">
                <label for="nbr_heures_tp" class="form-label" style="color: white;">Nombre d'heures de TP</label>
                <input type="number" step="0.01" class="form-control" id="nbr_heures_tp" name="nbr_heures_tp">
            </div>

            <div class="mb-3">
                <label for="nbr_heures_ap" class="form-label" style="color: white;">Nombre d'heures d'AP</label>
                <input type="number" step="0.01" class="form-control" id="nbr_heures_ap" name="nbr_heures_ap">
            </div>

            <div class="mb-3">
                <label for="nbr_heures_evaluation" class="form-label" style="color: white;">Nombre d'heures d'évaluation</label>
                <input type="number" step="0.01" class="form-control" id="nbr_heures_evaluation" name="nbr_heures_evaluation">
            </div>

            <div class="mb-3">
                <label for="decription_module" class="form-label" style="color: white;">Description du Module</label>
                <textarea class="form-control" id="decription_module" name="decription_module" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="coefficient" class="form-label" style="color: white;">Coefficient</label>
                <input type="number" step="0.01" class="form-control" id="coefficient" name="coefficient">
            </div>

            <div class="d-grid gap-2 mt-3">
                <button class="btn submit-btn" type="submit">Enregistrer</button>
            </div>
        </div>
    </form>
</div>


    <form action="{{ route('storeByExcel', ['id' => $id, 'etape_id' => $etape_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file">Upload Excel File:</label>
            <input type="file" id="file" name="file" class="dropify" data-max-file-size="30M" data-height="100" required />
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
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

<script>
    $(document).ready(function() {
        $('#file').dropify();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.teacher-select');

        selects.forEach(select => {
            select.addEventListener('change', function() {
                const elementId = this.dataset.elementId;
                const teacherId = this.value;
                const teacherName = this.options[this.selectedIndex].text;
                const urlParams = new URLSearchParams(window.location.search);
                const id = '{{ $id }}';
                const etapeId = '{{ $etape_id }}';

                Swal.fire({
                    title: 'Confirmer la sélection',
                    text: `Voulez-vous vraiment assigner ${teacherName} à cet élément pédagogique?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, confirmer!',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/store-teacher-element/${id}/${etapeId}`, {
                            method: "POST",
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                element_id: elementId,
                                teacher_id: teacherId
                            })
                        }).then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    'Enregistré!',
                                    'Le professeur a été assigné avec succès.',
                                    'success'
                                )
                            } else {
                                Swal.fire(
                                    'Erreur!',
                                    'Il y a eu un problème lors de l\'enregistrement.',
                                    'error'
                                )
                            }
                        }).catch(error => {
                            Swal.fire(
                                'Erreur!',
                                'Il y a eu un problème lors de l\'enregistrement.',
                                'error'
                            )
                        });
                    }
                });
            });
        });
    });
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

@endsection


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">