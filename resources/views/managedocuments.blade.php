@extends('master')

@section("app-mid")
<title>Ajout E-Documents</title>
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
</style>

<div class="app-main">
    @include('tiles.actions')

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Succès!',
            text: '{{session('
            success ')}}',
        });
    </script>
    @endif
    <a href="{{ route('documents.index') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="container form-container">
        <h2 class="form-title">Ajouter des documents à diffuser</h2>

        <form action="{{ route('document.post') }}" method="post" enctype="multipart/form-data" id="documentForm">
            @csrf

            <div class="mb-3">
                <label for="fileType" class="form-label">Sélectionner Type de destination :</label>
                <select class="form-select form-control" id="fileType" name="fileType" required>
                    <option selected disabled>Ce document est :</option>
                    <option value="student">Pour les étudiants</option>
                    <option value="teacher">pour le Staff</option>
                </select>
            </div>

            <div class="mb-3" id="stageFileInput">
                <label for="stageFile" class="form-label">Document à télécharger :</label>
                <input type="file" id="stageFile" name="stageFile" class="dropify" data-max-file-size="30M" data-height="100" />
            </div>

            <div class="mb-3">
                <label for="textInput" class="form-label">Titre et/ou désignation :</label>
                <div contenteditable="true" id="textInput" class="form-control" style="min-height: 50px; border: 1px solid #ced4da; padding: 10px;"></div>
                <input type="hidden" id="hiddenTextInput" name="textInput">
            </div>

            <div class="d-grid gap-2 mt-3">
                <button class="btn submit-btn" type="submit">Envoyer</button>
            </div>
            <div class="note"> *note if you want to send a red colored text you can type red:SomeText endColor               
            </div>
        </form>
    </div>
    
</div>

<script>
    $(document).ready(function() {
        // Initialize Dropify on stageFile input
        $('#stageFile').dropify();
    });

    $(document).ready(function() {
        $('#textInput').on('input', function() {
            let content = $(this).html();
            content = content.replace(/red:([^<]+?)endColor/g, '<span style="color: red;">$1</span><span>&nbsp;</span>');
            $(this).html(content);
            placeCaretAtEnd(this);

            // Check if endColor is present, remove it and reset contenteditable div
            if (content.includes('endColor')) {
                content = content.replace('endColor', '');
                $(this).html(content + '<span>&nbsp;</span>');
                placeCaretAtEnd(this);
            }
        });

        $('#documentForm').on('submit', function() {
            const textContent = $('#textInput').html(); // Get HTML content
            $('#hiddenTextInput').val(textContent);
        });

        function placeCaretAtEnd(el) {
            el.focus();
            if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
                var range = document.createRange();
                range.selectNodeContents(el);
                range.collapse(false);
                var sel = window.getSelection();
                sel.removeAllRanges();
                sel.addRange(range);
            } else if (typeof document.body.createTextRange != "undefined") {
                var textRange = document.body.createTextRange();
                textRange.moveToElementText(el);
                textRange.collapse(false);
                textRange.select();
            }
        }
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



<style>
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
                    content: none;
                }
            }
        }
    }
    .note{
        font-size: .6em;
        margin-top: 10px;
    }
</style>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>