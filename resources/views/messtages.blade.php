@extends('master')

@section("app-mid")
<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>


<style>
  body {
    background-color: #26324a;
    /* Slightly lighter than #1f273d */
    color: #fff;
    font-family: 'Arial', sans-serif;
  }

  .form-container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #2f3c57;
    /* Slightly lighter than #1f273d */
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
    /* Slightly lighter than #2a354e */
    border: 1px solid #4d6396;
    /* Slightly lighter than #364862 */
    color: #b8c2d3;
  }

  .form-select:focus,
  .form-control:focus {
    background-color: #394a6e;
    /* Slightly lighter than #2a354e */
    border-color: #4d6396;
    /* Slightly lighter than #364862 */
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

  @include('tiles.actions')

  @if(session('success'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: '{{ session('success') }}',
  });
</script>
@endif

@if(session('error'))
<script>
  Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: '{{ session('error') }}',
  });
</script>
@endif

  @if(auth()->user()->etudiant && auth()->user()->etudiant->stages && auth()->user()->etudiant->stages->isNotEmpty())
  <div class="containers">
  @if(!(auth()->user()->etudiant->stages->where('type_dossier', 'Stage d\'initiation')->isNotEmpty() && auth()->user()->etudiant->stages->where('type_dossier', 'Stage professionnel')->isNotEmpty() && auth()->user()->etudiant->stages->where('type_dossier', 'Stage technique')->isNotEmpty() && auth()->user()->etudiant->stages->where('type_dossier', 'PFE')->isNotEmpty()))
    <div class="mt-3">
      <button class="btn submit-btn" type="button" data-bs-toggle="collapse" data-bs-target="#uploadForm" aria-expanded="false" aria-controls="uploadForm">
        <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M18.5 20L18.5 14M18.5 14L21 16.5M18.5 14L16 16.5" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
          <path d="M12 19H5C3.89543 19 3 18.1046 3 17V7C3 5.89543 3.89543 5 5 5H9.58579C9.851 5 10.1054 5.10536 10.2929 5.29289L12 7H19C20.1046 7 21 7.89543 21 9V11" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>
    @endif
    <h1 style="margin-bottom: 1em;font-size: 1em;font-weight: bold;text-align: center; color:aliceblue;">Recapitulatif des informations de stages</h1>
    <table class="responsive-table">
      <thead>
        <tr>
          <th scope="col">Type de stage</th>
          <th scope="col">Dossier de stage</th>
          <th scope="col">Rapport</th>
          <th scope="col">Date de délivrance</th>
          <th scope="col">Modification</th>
          <th scope="col">Observations</th>
        </tr>
      </thead>
      <tbody>
        @foreach(auth()->user()->etudiant->stages as $stage)
        <tr>
          <th scope="row">{{ $stage->type_dossier }}</th>
          @if($stage->type_dossier !== 'PFE')
          <td data-title="PDF dossier de stage">
            <a href="{{ Storage::url($stage->dossier_stage) }}" target="_blank">cliquer ici</a>
          </td>
          @else
          <td data-title="PDF du Dossier de stage">----</td>
          @endif

          <td data-title="PDF du Rapport"><a href="{{ Storage::url($stage->rapport) }}" target="_blank">cliquer ici</a></td>
          <td data-title="Date de délivrance de dossier" class="date">{{ $stage->created_at }}</td>
          @if(!$stage->validation_prof)
          <td data-title="Modification"><a href="{{ route('upload.edit', $stage->id) }}" class="btn btn-danger">Mettre à jour les fichiers</a></td>
          @else
          <td data-title="Modification">Votre rapport est approuvé</td>
          @endif
          @foreach(auth()->user()->etudiant->notifications as $notification)
          @endforeach
          <td data-title="Observation de l'encadrant">
            @if(false)
            <p class="font-weight-normal">{{ $notification->text_message }}</p>
            @endif
            <p class="font-weight-normal">---</p>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="container form-container collapse" id="uploadForm">
    <h2 class="form-title">Dossier de Stage</h2>
    <form action="{{ route('upload.post') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="fileType" class="form-label">Type de dossier:</label>
        <select class="form-select form-control" id="fileType" name="fileType" required>
          <option selected disabled>Selectionner le type du dossier de stage</option>
          @if(!auth()->user()->etudiant->stages->where('type_dossier', 'Stage d\'initiation')->isNotEmpty())
          <option value="Stage d'initiation">Stage d'initiation</option>
          @endif
          @if(!auth()->user()->etudiant->stages->where('type_dossier', 'Stage professionnel')->isNotEmpty())
          <option value="Stage professionnel">Stage professionnel</option>
          @endif
          @if(!auth()->user()->etudiant->stages->where('type_dossier', 'Stage technique')->isNotEmpty())
          <option value="Stage technique">Stage technique</option>
          @endif
          @if(!auth()->user()->etudiant->stages->where('type_dossier', 'PFE')->isNotEmpty())
          <option value="PFE">PFE</option>
          @endif
        </select>
      </div>

      <div class="mb-3" id="stageFileInput">
        <label for="stageFile" class="form-label">Dossier de stage en PDF:</label>
        @if(old('fileType') !== 'PFE')
        <input type="file" id="stageFile" name="stageFile" class="dropify" data-max-file-size="7M" data-height="100" />
        @endif
      </div>

      <div class="mb-3">
        <label for="rapportFile" class="form-label">Rapport en PDF:</label>
        <input type="file" id="rapportFile" name="rapportFile" class="dropify" data-max-file-size="7M" data-height="100" />
      </div>

      <div class="mb-3">
        <label for="textInput" class="form-label">Titre Du Rapport:</label>
        <input type="text" id="textInput" name="textInput" class="form-control" placeholder="Entrer le titre du rapport:">
      </div>

      <div class="mb-3">
        <label for="teacherSelect" class="form-label">Professeur encadrant:</label>
        <select class="form-select form-control" id="teacherSelect" name="teacherSelect" required>
          <option selected disabled>Selectionner l'encadrant superviseur</option>
          @foreach($teachers as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
          @endforeach
        </select>
      </div>

      <div class="d-grid gap-2 mt-3">
        <button class="btn submit-btn" type="submit">Envoyer</button>
      </div>
    </form>
  </div>

  @else
  <div class="container form-container">
    <h2 class="form-title">Dossier de Stage</h2>
    <form action="{{ route('upload.post') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="fileType" class="form-label">Type de dossier:</label>
        <select class="form-select form-control" id="fileType" name="fileType" required>
          <option selected disabled>Selectionner le type du dossier de stage</option>
          <option value="Stage d'initiation">Stage d'initiation</option>
          <option value="Stage professionnel">Stage professionnel</option>
          <option value="Stage technique">Stage technique</option>
          <option value="PFE">PFE</option>
        </select>
      </div>

      <div class="mb-3" id="stageFileInput">
        <label for="stageFile" class="form-label">Dossier de stage en PDF:</label>
        @if(old('fileType') !== 'PFE')
        <input type="file" id="stageFile" name="stageFile" class="dropify" data-max-file-size="7M" data-height="100" />
        @endif
      </div>

      <div class="mb-3">
        <label for="rapportFile" class="form-label">Rapport en PDF:</label>
        <input type="file" id="rapportFile" name="rapportFile" class="dropify" data-max-file-size="7M" data-height="100" />
      </div>

      <div class="mb-3">
        <label for="textInput" class="form-label">Titre Du Rapport:</label>
        <input type="text" id="textInput" name="textInput" class="form-control" placeholder="Entrer le titre du rapport:">
      </div>

      <div class="mb-3">
        <label for="teacherSelect" class="form-label">Professeur encadrant:</label>
        <select class="form-select form-control" id="teacherSelect" name="teacherSelect" required>
          <option selected disabled>Selectionner l'encadrant superviseur</option>
          @foreach($teachers as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
          @endforeach
        </select>
      </div>

      <div class="d-grid gap-2 mt-3">
        <button class="btn submit-btn" type="submit">Envoyer</button>
      </div>
    </form>
  </div>
  @endif
</div>
<script>
  $(document).ready(function() {
    // Dropify on stageFile input
    $('#stageFile').dropify();

    // Dropify on rapportFile input
    $('#rapportFile').dropify();

  });
</script>
@endsection


<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- Include Bootstrap CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">

<script>
  setTimeout(function() {
    document.getElementById('successMessage').style.display = 'none';
  }, 2000);
</script>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const fileTypeSelect = document.getElementById("fileType");
    const stageFileInput = document.getElementById("stageFileInput");

    fileTypeSelect.addEventListener("change", function() {
      if (fileTypeSelect.value === "PFE") {
        stageFileInput.style.display = "none";
      } else {
        stageFileInput.style.display = "block";
      }
    });

    // Initial check in case "PFE" is pre-selected
    if (fileTypeSelect.value === "PFE") {
      stageFileInput.style.display = "none";
    }
  });
</script>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>