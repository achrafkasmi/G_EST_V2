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

  @if(!auth()->user()->is_uploaded)
  <div class="container form-container">
    <h2 class="form-title">Dossier de Stage</h2>

    <form action="{{ route('upload.post') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="mb-3">
        <label for="fileType" class="form-label">Select Type:</label>
        <select class="form-select form-control" id="fileType" name="fileType" required>
          <option selected disabled>Select type de dossier de stage</option>
          <option value="Stage d'initiation">Stage d'initiation</option>
          <option value="Stage professionnel">Stage professionnel</option>
          <option value="Stage technique">Stage technique</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="stageFile" class="form-label">Dossier de stage en PDF:</label>
        <input type="file" id="stageFile" name="stageFile" class="dropify" data-max-file-size="30M" data-height="100" />
      </div>

      <div class="mb-3">
        <label for="rapportFile" class="form-label">Rapport en PDF:</label>
        <input type="file" id="rapportFile" name="rapportFile" class="dropify" data-max-file-size="30M" data-height="100" />
      </div>

      <div class="d-grid gap-2 mt-3">
        <button class="btn submit-btn" type="submit">Envoyer</button>
      </div>
    </form>
  </div>

  @else

  <div class="containers">
    <h1 style="margin-bottom: 1em;font-size: 1em;font-weight: bold;text-align: center; color:aliceblue;">recapitulatif des informations de stages</h1>
    <table class="responsive-table">
      <thead>
        <tr>
          <th scope="col">type de stage</th>
          <th scope="col">dossier de stage</th>
          <th scope="col">rapport</th>
          <th scope="col">date delivrence</th>
          <th scope="col">modification</th>
          <th scope="col">observations</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">{{ auth()->user()->etudiant->stage->type_dossier }}</th>
          <td data-title="PDF dossier de stage"><a href="{{ Storage::url(auth()->user()->etudiant->stage->dossier_stage) }}" target="_blank">cliquer ici </a></td>
          <td data-title="PDF rapport de stage"><a href="{{ Storage::url(auth()->user()->etudiant->stage->rapport) }}" target="_blank">cliquer ici </a></td>
          <td data-title="date de delivrence de dossier" class="date"></a>{{ auth()->user()->etudiant->stage->created_at}}</td>
          <td data-title="modification"><a href="#"></a>modification temporairement impossible</td>
          @foreach(auth()->user()->etudiant->notifications as $notification)
          <td data-title="observation de l'encadrant">
            <p class="font-weight-normal">{{ $notification->text_message }}</p>
          </td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>

  @endif


</div>
<script>
  $(document).ready(function() {
    // Initialize Dropify on stageFile input
    $('#stageFile').dropify();

    // Initialize Dropify on rapportFile input
    $('#rapportFile').dropify();
  });
</script>
@endsection


<style>

</style>

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

<style>
  /*@media only screen and (max-width: 992px) {
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

    .body{               hada old background momkin n7tajo
        background-image: url('background2.png'); 
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: center;
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
    }*/













  html {
    box-sizing: border-box;
  }

  *,
  *:before,
  *:after {
    box-sizing: inherit;
  }

  body {
    color: rgba(224, 224, 224, .1);
  }

  table {
    margin: .3 em;

  }

  a {
    color: rgba(38, 137, 13, 1);

    &:hover,
    &:focus {
      color: rgba(4, 106, 56, 1);
    }
  }

  .containers {
    margin: 3%;
    width: 94%;
    height: 30%;

    @media (min-width: 48em) {
      margin: 2%;
      width: 96%;
    }

    @media (min-width: 75em) {
      margin: 2em auto;
      max-width: 75em;
    }
  }

  .responsive-table {
    width: 100%;
    height: 100%;
    position: relative;

    margin-bottom: 1.5em;
    border-spacing: 0;

    @media (min-width: 48em) {
      font-size: .9em;
    }

    @media (min-width: 62em) {
      font-size: 1em;
    }






    thead {
      /*Accessibly hide <thead> on narrow viewports*/
      position: absolute;
      clip: rect(1px 1px 1px 1px);
      /* IE6, IE7 */
      padding: 0;
      border: 0;
      height: 1px;
      width: 1px;
      overflow: hidden;

      @media (min-width: 48em) {
        /*Unhide <thead> on wide viewports*/
        position: relative;
        clip: auto;
        height: auto;
        width: auto;
        overflow: auto;
      }

      th {
        background-color: rgba(38, 137, 13, .25);
        border: 0.1px solid rgba(134, 188, 37, 1);
        font-weight: normal;
        text-align: center;
        color: white;

        &:first-of-type {
          text-align: left;
        }
      }
    }

    /*Set these items to display: block for narrow viewports*/
    tbody,
    tr,
    th,
    td {
      display: block;
      padding: 0;
      text-align: left;
      white-space: normal;
    }

    tr {
      @media (min-width: 48em) {
        /*Undo display: block*/
        display: table-row;
      }
    }

    th,
    td {
      padding: .5em;
      vertical-align: middle;

      @media (min-width: 30em) {
        padding: .75em .5em;
      }

      @media (min-width: 48em) {
        /*Undo display: block*/
        display: table-cell;
        padding: .5em;
      }

      @media (min-width: 62em) {
        padding: .75em .5em;
      }

      @media (min-width: 75em) {
        padding: .75em;
      }
    }

    caption {
      margin-bottom: 1em;
      font-size: 1em;
      font-weight: bold;
      text-align: center;

      @media (min-width: 48em) {
        font-size: 1.5em;
      }
    }

    tfoot {
      font-size: .8em;
      font-style: italic;

      @media (min-width: 62em) {
        font-size: .9em;
      }
    }

    tbody {
      @media (min-width: 48em) {
        /*Undo display: block*/
        display: table-row-group;
      }

      tr {
        margin-bottom: 1em;

        @media (min-width: 48em) {
          /*Undo display: block*/
          display: table-row;
          border-width: 1px;
        }

        &:last-of-type {
          margin-bottom: 0;
        }

        &:nth-of-type(even) {
          @media (min-width: 48em) {
            background-color: rgba(192, 192, 192, .15);
          }
        }
      }

      th[scope="row"] {
        background-color: rgba(38, 137, 13, 1);
        color: white;

        @media (min-width: 30em) {
          border-left: 1px solid rgba(134, 188, 37, 1);
          border-bottom: 1px solid rgba(134, 188, 37, 1);
        }

        @media (min-width: 48em) {
          background-color: transparent;
          color: rgba(192, 192, 192, .8);
          text-align: left;
        }
      }

      td {
        text-align: right;

        @media (min-width: 48em) {
          border-left: 1px solid rgba(134, 188, 37, 1);
          border-bottom: 1px solid rgba(134, 188, 37, 1);
          text-align: center;
        }

        &:last-of-type {
          @media (min-width: 48em) {
            border-right: 1px solid rgba(134, 188, 37, 1);
          }
        }
      }

      td[data-type=currency] {
        text-align: right;
      }

      td[data-title]:before {
        content: attr(data-title);
        float: left;
        font-size: .8em;
        color: rgba(192, 192, 192, .87);

        @media (min-width: 30em) {
          font-size: .9em;
        }

        @media (min-width: 48em) {
          /* Don’t show data-title labels*/
          content: none;
        }
      }
    }
  }
</style>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>