@extends('master')
@section("app-mid")


<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>



<title>justifier l'absence</title>
<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('attendance.dash.blade') }}" id="">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="container form-container">
        <div class="form-title">Ajout de justificatif d'absence</div>
        <form action="{{ route('attendance.storeJustification') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="motif" class="form-label">Motif d'absence: </label>
                <input type="text" name="titre_rapport" id="titre_rapport" class="form-control">
            </div>

            <div class="form-group">
                <label for="justif" class="form-label">Justificatif en PDF</label>
                <input type="file" name="rapport" id="rapport" class="form-control dropify">
            </div>

            <div class="form-group">
                <label for="session" class="form-label">Sélectionnez la séance à justifier :</label>
                <select name="id_attendance" id="session" class="form-control">
                    @if($attendanceRecords->isEmpty())
                    <option disabled>Aucune séance à justifier</option>
                    @else
                    @foreach($attendanceRecords as $record)
                    <option value="{{ $record->id }}">
                        {{ $record->type_seance }} - {{ $record->created_at->format('Y-m-d') }} - {{ optional($record->elementPedago)->intitule_element ?? 'Module non trouvé' }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>

            <button type="submit" class="btn submit-btn">Submit</button>
        </form>
    </div>
</div>

</div>

<style>
    body {
        background-color: #26324a;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .form-container {
        max-width: 600px;
        background-color: #2f3c57;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin: auto;
        margin-top: 50px;
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
        height: 80px;
        /* Custom height */
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
<script>
    $(document).ready(function() {
        $('#dossier_stage').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something wrong happened.'
            }
        });
        $('#rapport').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something wrong happened.'
            }
        });
    });
</script>
@endsection