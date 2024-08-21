@extends('master')
@section("app-mid")
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>

<div class="app-main">
    @include('tiles.actions')
    <div class="container form-container">
        <div class="form-title">générer QR de présence</div>

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
                <select id="id_personnel" name="id_personnel" class="form-control" required readonly>
                    <option value="{{ Auth::user()->personnel->id }}">{{ Auth::user()->personnel->nom_personnel }}</option>
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
                <div id="annee-tags-container" class="tags-container">
                    <!-- Selected tags will appear here -->
                </div>
                <select id="annee" class="form-control tag-select" required>
                <option value="" disabled selected>Select Annee</option>
                    @foreach($annees as $annee)
                    <option value="{{ $annee }}">{{ $annee }}</option>
                    @endforeach
                </select>
                
            </div>

            <div class="form-group">
                <label for="filiere">Filière</label>
                <div id="filiere-tags-container" class="tags-container">
                    <!-- Selected tags will appear here -->
                </div>
                <select id="filiere-select" class="form-control tag-select">
                    <option value="" disabled selected>Select Filière</option>
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
                    <option value="8-10">08:00h-10:00h</option>
                    <option value="10-12">10:00h-12:00h</option>
                    <option value="12-14">12:00h-14:00h</option>
                    <option value="14-16">14:00h-16:00h</option>
                    <option value="16-18">16:00h-18:00h</option>
                </select>
            </div>

            <div class="form-group">
                <label for="type_seance">Type of Session</label>
                <select name="type_seance" id="type_seance" class="form-control" required>
                    @foreach ($typeSeances as $typeSeance)
                    <option value="{{ $typeSeance }}">{{ $typeSeance }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Generate QR Code</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
   @if(session('qr_error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('qr_error') }}",
    });
@endif

@if(session('avatar_error'))
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('avatar_error') }}",
    });
@endif

</script>
<script>
    // Get the current year
    const currentYear = new Date().getFullYear();
    // Set the academic year in the format current year-current year+1
    const academicYear = `${currentYear}-${currentYear + 1}`;
    // Set the value of the input field
    document.getElementById('annee_uni').value = academicYear;
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filiereSelect = document.getElementById('filiere-select');
        const filiereTagsContainer = document.getElementById('filiere-tags-container');
        const filiereValidationIcon = document.getElementById('filiere-validation-icon');

        filiereSelect.addEventListener('change', function() {
            const selectedValue = filiereSelect.value;
            if (selectedValue) {
                addTag(selectedValue, 'filiere');
                filiereValidationIcon.style.display = 'none';
            }
        });

        function addTag(value, type) {
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.textContent = value;

            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-tag';
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', function() {
                filiereTagsContainer.removeChild(tag);
            });

            tag.appendChild(removeBtn);
            filiereTagsContainer.appendChild(tag);

            // Add hidden input to form
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `${type}[]`;
            hiddenInput.value = value;
            tag.appendChild(hiddenInput);
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        const anneeSelect = document.getElementById('annee');
        const anneeTagsContainer = document.getElementById('annee-tags-container');
        const anneeValidationIcon = document.getElementById('annee-validation-icon');

        anneeSelect.addEventListener('change', function() {
            const selectedValue = anneeSelect.value;
            if (selectedValue) {
                addTag(selectedValue, 'annee');
                anneeValidationIcon.style.display = 'inline-block';
            }
        });

        function addTag(value, type) {
            const tag = document.createElement('div');
            tag.className = 'tag';
            tag.textContent = value;

            const removeBtn = document.createElement('span');
            removeBtn.className = 'remove-tag';
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', function() {
                anneeTagsContainer.removeChild(tag);
            });

            tag.appendChild(removeBtn);
            anneeTagsContainer.appendChild(tag);

            // Add hidden input to form
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `${type}[]`;
            hiddenInput.value = value;
            tag.appendChild(hiddenInput);
        }
    });
</script>

<style>
    body {
        background-color: #26324a;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .form-container {
        max-width: 600px;
        margin: 50px auto;
        background-color: #2f3c57;
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
        border: 1px solid #4d6396;
        color: #b8c2d3;
    }

    .form-select:focus,
    .form-control:focus {
        background-color: #394a6e;
        border-color: #4d6396;
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


    .tag-input-group {
        display: flex;
        align-items: center;
        margin-top: 10px;
    }

    .tags-container {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 10px;
    }

    .tag {
        background-color: #28a745;
        color: #fff;
        padding: 5px 10px;
        border-radius: 15px;
        display: inline-flex;
        align-items: center;
        font-size: 14px;
    }

    .tag .remove-tag {
        margin-left: 8px;
        cursor: pointer;
    }

    .tag-select {
        flex: 1;
        background-color: #394a6e;
        border: 1px solid #4d6396;
        color: #b8c2d3;
    }

    .add-tag-btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px;
        cursor: pointer;
        margin-left: 5px;
        border-radius: 50%;
    }

    .validation-icon {
        margin-left: 10px;
        color: green;
        font-size: 18px;
        vertical-align: middle;
        display: none;
    }

    .validation-icon::before {
        content: '\f058';
        /* FontAwesome check icon */
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }
</style>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">