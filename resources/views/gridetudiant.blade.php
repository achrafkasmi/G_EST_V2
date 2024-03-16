@extends('master')

@section("app-mid")

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>
  
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
          <th scope="row">Type de Stage</th>
          <td data-title="PDF dossier de stage"><a <a href="{{ Storage::url(auth()->user()->stage_file) }}" target="_blank">cliquer ici </a></td>
          <td data-title="PDF rapport de stage"><a <a href="{{ Storage::url(auth()->user()->rapport_file) }}" target="_blank">cliquer ici </a></td>
          <td data-title="date de delivrence de dossier" <a href="#" class="date"></a>--/--/----</td>
          <td data-title="vous puvez modifier que avant la confirmation de Professeur encadrant"><a href="http://127.0.0.1:8000/messtages">Clicker ici</a></td>
          <td data-title="observation de l'encadrant">
            <p class="font-weight-normal"> bon travail A+</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>


  <!-- Optional JavaScript -->
 
</body>
@endsection


<style>
  /*@import "bourbon@5.*";
  @import "variables";*/


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
    margin: 5% 3%;
    width: 100%;
    height: 30%;
    background-color: #050e2d;


    @media (min-width: 48em) {
      margin: 2%;
      width: 55%;
    }

    @media (min-width: 75em) {
      margin: 2em auto;
      max-width: 75em;
    }
  }

  .responsive-table {
    width: 100%;
    height: 100%;
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