<!--<link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">-->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@extends('master')
@section("app-mid")



<div class="app-main">
    @include('tiles.actions')
    <div class="chart-row three">
        <div class="chart-container-wrapper">
            <a href="#" id="toggleCrudContainer">
                <div class="chart-container">
                    <div class="chart-info-wrapper">
                        <h2>Dossiers de Stage</h2>
                        <span>Visualiser</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="chart-container-wrapper">
            <div class="chart-container">
                <div class="chart-info-wrapper">
                    <h2>Attendance</h2>
                    <span>Commencer</span>
                </div>
            </div>
        </div>
        <div class="chart-container-wrapper">
            <div class="chart-container">
                <div class="chart-info-wrapper">
                    <h2>cursus</h2>
                    <span>Descriptifs Et Documentations</span>
                </div>
            </div>
        </div>
    </div>

    <div class="datatabcontainer mt-4">
        <table class="tab" id="myTable">

            <thead>
                <tr>
                    <th>Nom complet</th>
                    <th>Type de stage</th>
                    <th>Dossier de stage</th>
                    <th>Rapport</th>
                    <th>Actions</th>
                    <th>Bibliothèque</th>
                </tr>
            </thead>
            <tbody>

                @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->etudiant->stage->type_dossier}}</td>
                    <td><a href="{{ Storage::url($user->etudiant->stage->dossier_stage)}}" target="_blank">Cliquez ici</a></td>
                    <td><a href="{{ Storage::url($user->etudiant->stage->rapport) }}" target="_blank">Cliquez ici</a></td>
                    <td>
                        @if ($user->etudiant->stage->validation_prof)
                        <a href="{{ route('student.validation', $user->id) }}">
                            <svg width="24px" height="24px" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                <circle fill="#4CAF50" cx="24" cy="24" r="21" />
                                <polygon fill="#CCFF90" points="34.6,14.6 21,28.2 15.4,22.6 12.6,25.4 21,33.8 37.4,17.4" />
                            </svg>
                        </a>

                        @else
                        <a href="{{ route('student.validation', $user->id) }}" title="Approve" onclick="approveStage(1)">
                            <svg class="approve" width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path class="approve-fill" fill="{{ auth()->check() ? 'black' : 'yellow' }}" d="M26,24c-0.553,0-1,0.448-1,1v4H7V3h10v7c0,0.552,0.447,1,1,1h7v4c0,0.552,0.447,1,1,1s1-0.448,1-1v-4.903    c0.003-0.033,0.02-0.063,0.02-0.097c0-0.337-0.166-0.635-0.421-0.816l-7.892-7.891c-0.086-0.085-0.187-0.147-0.292-0.195    c-0.031-0.015-0.063-0.023-0.097-0.034c-0.082-0.028-0.166-0.045-0.253-0.05C18.043,1.012,18.022,1,18,1H6C5.447,1,5,1.448,5,2v28    c0,0.552,0.447,1,1,1h20c0.553,0,1-0.448,1-1v-5C27,24.448,26.553,24,26,24z M19,9V4.414L23.586,9H19z" />
                                <path class="approve-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M30.73,15.317c-0.379-0.404-1.01-0.424-1.414-0.047l-10.004,9.36l-4.629-4.332c-0.404-0.378-1.036-0.357-1.414,0.047    c-0.377,0.403-0.356,1.036,0.047,1.413l5.313,4.971c0.192,0.18,0.438,0.27,0.684,0.27s0.491-0.09,0.684-0.27l10.688-10    C31.087,16.353,31.107,15.72,30.73,15.317z" />
                            </svg>
                        </a>

                        <!--<a title="Disapprove" onclick="showVoiceForm({{ $user->etudiant->id }})" style="margin-left:5px;">
                            <svg width="24px" height="24px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="black" fill="none">
                                <path d="M47.67,28.43v3.38a15.67,15.67,0,0,1-31.34,0V28.43" stroke-linecap="round" />
                                <rect x="22.51" y="6.45" width="18.44" height="34.22" rx="8.89" stroke-linecap="round" />
                                <line x1="31.73" y1="57.34" x2="31.73" y2="47.71" stroke-linecap="round" />
                                <line x1="37.14" y1="57.55" x2="26.43" y2="57.55" stroke-linecap="round" />
                            </svg>
                        </a>

                        <a title="Disapprove" onclick="showTextForm({{ $user->etudiant->id }})" style="margin-left:5px;">
                            <svg width="24px" height="24px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4.99951 16.55V19.9C4.99922 20.3102 5.11905 20.7114 5.34418 21.0542C5.56931 21.397 5.88994 21.6665 6.26642 21.8292C6.6429 21.9919 7.05875 22.0408 7.46271 21.9698C7.86666 21.8989 8.24103 21.7113 8.53955 21.4301L11.1495 18.9701H12.0195C17.5395 18.9701 22.0195 15.1701 22.0195 10.4701C22.0195 5.77009 17.5395 1.97009 12.0195 1.97009C6.49953 1.97009 2.01953 5.78009 2.01953 10.4701C2.042 11.6389 2.32261 12.7882 2.84125 13.8358C3.35989 14.8835 4.10373 15.8035 5.01953 16.53L4.99951 16.55Z" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17 9.5H7" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M13 12.5H7" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>-->

                        @endif
                    </td>
                    <td>
                        @if ($user->etudiant->stage->is_recommanded && $user->etudiant->stage->validation_prof)
                        <a href="{{ route('student.recomandation', $user->id) }}">
                            <svg width="24px" height="24px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 9.32001H7.5C6.37366 9.25709 5.2682 9.64244 4.42505 10.3919C3.5819 11.1414 3.06958 12.1941 3 13.32V18.32C3.06958 19.446 3.5819 20.4986 4.42505 21.2481C5.2682 21.9976 6.37366 22.3829 7.5 22.32H16.5C17.6263 22.3829 18.7318 21.9976 19.575 21.2481C20.4181 20.4986 20.9304 19.446 21 18.32V13.32C20.9304 12.1941 20.4181 11.1414 19.575 10.3919C18.7318 9.64244 17.6263 9.25709 16.5 9.32001Z" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17 9.32001V7.32001C17 5.99392 16.4732 4.72217 15.5355 3.78448C14.5978 2.8468 13.3261 2.32001 12 2.32001" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @elseif ($user->etudiant->stage->validation_prof)
                        <a href="{{ route('student.recomandation', $user->id) }}">
                            <svg width="24px" height="24px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 9.32001H7.5C6.37366 9.25709 5.26818 9.64244 4.42503 10.3919C3.58188 11.1414 3.06958 12.1941 3 13.32V18.32C3.06958 19.446 3.58188 20.4986 4.42503 21.2481C5.26818 21.9976 6.37366 22.3829 7.5 22.32H16.5C17.6263 22.3829 18.7318 21.9976 19.575 21.2481C20.4181 20.4986 20.9304 19.446 21 18.32V13.32C20.9304 12.1941 20.4181 11.1414 19.575 10.3919C18.7318 9.64244 17.6263 9.25709 16.5 9.32001Z" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17 9.32001V7.32001C17 5.99392 16.4732 4.72217 15.5355 3.78448C14.5979 2.8468 13.3261 2.32001 12 2.32001C10.6739 2.32001 9.40214 2.8468 8.46446 3.78448C7.52678 4.72217 7 5.99392 7 7.32001V9.32001" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @else
                        <svg width="24px" height="24px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5 9.32001H7.5C6.37366 9.25709 5.26818 9.64244 4.42503 10.3919C3.58188 11.1414 3.06958 12.1941 3 13.32V18.32C3.06958 19.446 3.58188 20.4986 4.42503 21.2481C5.26818 21.9976 6.37366 22.3829 7.5 22.32H16.5C17.6263 22.3829 18.7318 21.9976 19.575 21.2481C20.4181 20.4986 20.9304 19.446 21 18.32V13.32C20.9304 12.1941 20.4181 11.1414 19.575 10.3919C18.7318 9.64244 17.6263 9.25709 16.5 9.32001Z" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 9.32001V7.32001C17 5.99392 16.4732 4.72217 15.5355 3.78448C14.5979 2.8468 13.3261 2.32001 12 2.32001C10.6739 2.32001 9.40214 2.8468 8.46446 3.78448C7.52678 4.72217 7 5.99392 7 7.32001V9.32001" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        @endif
                    </td>
                </tr>
                <!-- Voice Form -->
                <form id="voiceForm" method="POST" action="{{ route('ADD-RAPPORT-COMMENT') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id_etu" id="id_etu_voice"> <!-- Add this hidden input field -->

                    <div class="disapprove-popup" id="voicePopup" style="display: none;">
                        <div class="popup-content">
                            <div id="voiceContainer">
                                <div class="voice-controls-container">
                                    <button type="button" id="startRecordBtn" onclick="startRecording()" class="record-button">
                                        <svg width="45px" height="45px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="black" fill="none">
                                            <path d="M47.67,28.43v3.38a15.67,15.67,0,0,1-31.34,0V28.43" stroke-linecap="round" />
                                            <rect x="22.51" y="6.45" width="18.44" height="34.22" rx="8.89" stroke-linecap="round" />
                                            <line x1="31.73" y1="57.34" x2="31.73" y2="47.71" stroke-linecap="round" />
                                            <line x1="37.14" y1="57.55" x2="26.43" y2="57.55" stroke-linecap="round" />
                                        </svg>
                                    </button>
                                    <button type="button" id="stopRecordBtn" style="display: none;" onclick="stopRecording()" class="stop-record-button">
                                        <svg width="45px" height="45px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#00bd6b">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                                            <g id="SVGRepo_iconCarrier">
                                                <path d="M3 10L3 14M7.5 11V13M12 6V18M16.5 3V21M21 10V14" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="divaudio" style="display: flex;">
                                <audio id="audioPlayer" controls style="display: none;"></audio>
                                <button id="deleteVoiceBtn" onclick="deleteRecordedVoice(event)" style="display: none;" class="delete-voice-button">
                                    <svg fill="#000000" width="50px" height="50px" viewBox="0 0 24 24" id="delete-alt-2" data-name="Flat Line" xmlns="http://www.w3.org/2000/svg" class="icon flat-line">
                                        <path d="M17.07,20.07,18,7H6l.93,13.07a1,1,0,0,0,1,.93h8.14A1,1,0,0,0,17.07,20.07Z" style="fill: rgb(44, 169, 188); stroke-width: 2;"></path>
                                        <path d="M16,7V4a1,1,0,0,0-1-1H9A1,1,0,0,0,8,4V7" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                                        <path d="M12,11v6M4,7H20M17.07,20.07,18,7H6l.93,13.07a1,1,0,0,0,1,.93h8.14A1,1,0,0,0,17.07,20.07Z" style="fill: none; stroke: rgb(0, 0, 0); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                                    </svg>
                                </button>
                            </div>


                            <div class="popup-buttons">
                                <button type="button" class="button-cancel" onclick="hideVoicePopup()">Annuler</button>
                                <button type="button" class="button-send" onclick="submitVoiceForm({{ $user->etudiant->id }})">Envoyer les mises à jours</button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Text Form -->
                <form id="textForm" method="POST" action="{{ route('ADD-RAPPORT-COMMENT') }}">
                    @csrf
                    <input type="hidden" name="id_etu" id="id_etu_text"> <!-- Add this hidden input field -->

                    <div class="disapprove-popup" id="textPopup" style="display: none;">
                        <div class="popup-content">
                            <label for="disapproveNote" style="font-weight: bold; color:#000">Notes de l'encadrant:</label>
                            <div id="inputContainer">
                                <!-- Text Input -->
                                <textarea name="notification" id="disapproveNote" class="popup-input" rows="4"></textarea>
                            </div>
                            <div class="popup-buttons">
                                <button type="button" class="button-cancel" onclick="hideTextPopup()">Annuler</button>
                                <button type="button" class="button-send" onclick="submitTextForm({{ $user->etudiant->id }})">
                                    <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.3009 13.6949L20.102 3.89742M10.5795 14.1355L12.8019 18.5804C13.339 19.6545 13.6075 20.1916 13.9458 20.3356C14.2394 20.4606 14.575 20.4379 14.8492 20.2747C15.1651 20.0866 15.3591 19.5183 15.7472 18.3818L19.9463 6.08434C20.2845 5.09409 20.4535 4.59896 20.3378 4.27142C20.2371 3.98648 20.013 3.76234 19.7281 3.66167C19.4005 3.54595 18.9054 3.71502 17.9151 4.05315L5.61763 8.2523C4.48114 8.64037 3.91289 8.83441 3.72478 9.15032C3.56153 9.42447 3.53891 9.76007 3.66389 10.0536C3.80791 10.3919 4.34498 10.6605 5.41912 11.1975L9.86397 13.42C10.041 13.5085 10.1295 13.5527 10.2061 13.6118C10.2742 13.6643 10.3352 13.7253 10.3876 13.7933C10.4468 13.87 10.491 13.9585 10.5795 14.1355Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>
<script>
    let table = new DataTable('#myTable');
</script>

<script>
    let mediaRecorder;
    let recordedChunks = [];
    let mediaStream;

    const startRecordBtn = document.getElementById('startRecordBtn');
    const stopRecordBtn = document.getElementById('stopRecordBtn');
    const audioPlayer = document.getElementById('audioPlayer');

    function startRecording() {
        navigator.mediaDevices.getUserMedia({
                audio: true
            })
            .then(function(stream) {
                mediaStream = stream;
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.ondataavailable = function(event) {
                    recordedChunks.push(event.data);
                };
                mediaRecorder.onstop = function() {
                    const blob = new Blob(recordedChunks, {
                        type: 'audio/wav'
                    });
                    const audioUrl = URL.createObjectURL(blob);
                    audioPlayer.src = audioUrl;
                    audioPlayer.style.display = 'block';
                    stopRecordBtn.style.display = 'none';
                    startRecordBtn.style.display = 'inline-block';
                    // Show delete button
                    document.getElementById('deleteVoiceBtn').style.display = 'inline-block';
                };
                recordedChunks = [];
                mediaRecorder.start();
                startRecordBtn.style.display = 'none';
                stopRecordBtn.style.display = 'inline-block';
            })
            .catch(function(err) {
                console.error("Erreur lors de l'accès au microphone :", err);
            });
    }

    function stopRecording() {
        mediaRecorder.stop();
        mediaStream.getTracks().forEach(track => track.stop()); // Stop the media stream to release microphone
    }

    function submitForm() {
        const textMessage = document.getElementById('disapproveNote').value.trim();
        const voiceBlob = recordedChunks.length > 0 ? new Blob(recordedChunks, {
            type: 'audio/wav'
        }) : null;

        // Create FormData object
        const formData = new FormData(document.getElementById('commentForm'));

        // Append text message if available
        if (textMessage !== '') {
            formData.append('notification', textMessage);
        }

        // Append voice message if available
        if (voiceBlob !== null) {
            formData.append('voice_message', voiceBlob);
        }

        // Send AJAX request
        $.ajax({
            url: $('#commentForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Commentaire ajouté avec succès !',
                    willClose: () => {
                        // Clear textarea
                        $('#disapproveNote').val('');

                        // Hide audio player
                        audioPlayer.pause();
                        audioPlayer.src = '';
                        audioPlayer.style.display = 'none';

                        // Hide popup
                        hideDisapprovePopup();

                        // Reset recordedChunks array
                        recordedChunks = [];
                    }
                });
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "Une erreur s'est produite lors de l'ajout d'un commentaire. Veuillez réessayer."
                });
                console.error(xhr.responseText);
            }
        });
    }

    function hideDisapprovePopup() {
        var popup = document.getElementById("disapprovePopup");
        popup.style.display = "none";
    }

    // Function to toggle the visibility of the .crud-container
    function toggleCrudContainer() {
        var datatabcontainer = document.querySelector('.datatabcontainer');
        var saveButton = document.querySelector('.save-button');

        // Toggle the display style
        datatabcontainer.style.display = (datatabcontainer.style.display === 'none' || datatabcontainer.style.display === '') ? 'block' : 'none';
        saveButton.style.display = (saveButton.style.display === 'none' || saveButton.style.display === '') ? 'block' : 'none';
    }

    // Function to handle the link click and prevent default behavior
    function handleLinkClick(event) {
        event.preventDefault();
        toggleCrudContainer();
    }

    // Assuming you have a reference to the link inside the chart container
    var toggleLink = document.getElementById('toggleCrudContainer');

    // Adding click event listener to the link
    toggleLink.addEventListener('click', handleLinkClick);

    // Function to search the table
    function searchTable() {
        //search logic
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector(".table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Function to show the disapprove popup
    function showDisapprovePopup(idEtu) {
        var popup = document.getElementById("disapprovePopup");

        // Create a hidden input element
        var hiddenInput = document.createElement("input");
        hiddenInput.type = "hidden";
        hiddenInput.name = "id_etu";
        hiddenInput.value = idEtu;

        // Append the hidden input to the popup
        popup.appendChild(hiddenInput);

        // Set the display style to "flex" to show the popup
        popup.style.display = "flex";

        // Disable the onclick event of the icon
        document.getElementById('disapproveIcon').onclick = null;
    }

    // Function to hide the disapprove popup
    function hideDisapprovePopup() {
        var popup = document.getElementById("disapprovePopup");
        popup.style.display = "none";
    }

    // Function to disapprove a stage
    function disapproveStage() {
        // Implement your disapprove logic here
        var note = document.getElementById("disapproveNote").value;
        alert("Stage disapproved with note: " + note);
        hideDisapprovePopup();
    }

    // Function to approve a stage
    function approveStage(rowId) {
        // Implement your approve logic here
        alert("Étape approuvée pour cette rangée " + rowId);
    }

    // Function to show the voice recording form
    function showVoiceForm(idEtu) {
        var voicePopup = document.getElementById("voicePopup");
        voicePopup.style.display = "block";

        // Set the value of the hidden input field
        document.getElementById("id_etu_voice").value = idEtu;
    }

    // Function to show the text sending form
    function showTextForm(idEtu) {
        var textPopup = document.getElementById("textPopup");
        textPopup.style.display = "block";

        // Set the value of the hidden input field
        document.getElementById("id_etu_text").value = idEtu;
    }

    // Function to hide the voice popup
    function hideVoicePopup() {
        var voicePopup = document.getElementById("voicePopup");
        voicePopup.style.display = "none";
    }

    // Function to submit the text form
    function submitTextForm(idEtu) {
        const textMessage = document.getElementById('disapproveNote').value.trim();

        // Create FormData object
        const formData = new FormData(document.getElementById('textForm'));

        // Append text message if available
        if (textMessage !== '') {
            formData.append('notification', textMessage);
        }

        // Append id_etu
        formData.append('id_etu', idEtu);

        // Send AJAX request
        $.ajax({
            url: $('#textForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Commentaire texte ajouté avec succès !',
                    willClose: () => {
                        // Clear textarea
                        $('#disapproveNote').val('');

                        // Hide popup
                        hideTextPopup();
                    }
                });
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "Une erreur s'est produite lors de l'ajout d'un commentaire textuel. Veuillez saisir un message texte."
                });
                console.error(xhr.responseText);
            }
        });
    }

    // Function to submit the voice form
    function submitVoiceForm(idEtu) {
        const voiceBlob = recordedChunks.length > 0 ? new Blob(recordedChunks, {
            type: 'audio/wav'
        }) : null;

        // Create FormData object
        const formData = new FormData(document.getElementById('voiceForm'));

        // Append voice message if available
        if (voiceBlob !== null) {
            formData.append('voice_message', voiceBlob);
        }

        // Append id_etu
        formData.append('id_etu', idEtu);

        // Send AJAX request
        $.ajax({
            url: $('#voiceForm').attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Show success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Commentaire vocal ajouté avec succès!',
                    willClose: () => {
                        // Clear audio player
                        audioPlayer.pause();
                        audioPlayer.src = '';
                        audioPlayer.style.display = 'none';

                        // Hide popup
                        hideVoicePopup();

                        // Reset recordedChunks array
                        recordedChunks = [];
                    }
                });
            },
            error: function(xhr, status, error) {
                // Show error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "Une erreur s'est produite lors de l'ajout d'un commentaire vocal, veuillez enregistrer un."
                });
                console.error(xhr.responseText);
            }
        });
    }
    // Function to hide the text popup
    function hideTextPopup() {
        var textPopup = document.getElementById("textPopup");
        textPopup.style.display = "none";
    }
    // Function to delete recorded voice
    function deleteRecordedVoice(event) {
        event.preventDefault(); // Prevent default form submission behavior

        // Display Swal confirmation dialogue
        Swal.fire({
            title: 'êtes-vous sûr?',
            text: "Vous ne pourrez pas récupérer la voix enregistrée !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, supprimez!',
            cancelButtonText: 'Non, annulez'
        }).then((result) => {
            if (result.isConfirmed) {
                // If user confirms deletion, execute delete operation
                // Clear audio player
                audioPlayer.pause();
                audioPlayer.src = '';
                audioPlayer.style.display = 'none';

                // Reset recordedChunks array
                recordedChunks = [];

                // Hide delete button
                document.getElementById('deleteVoiceBtn').style.display = 'none';

                // Show success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Supprimé!',
                    text: 'Votre message vocal a été supprimé.',
                    timer: 2000, // Automatically close after 2 seconds
                    showConfirmButton: false
                });
            }
        });
    }
</script>

@endsection

<style>
    .input-container {
        display: flex;
        flex-direction: row-reverse;
        /* Reverse the direction to align from right */
        align-items: center;
        margin-top: 10px;
        /* Add margin if needed */
    }

    .popup-input {
        flex: 1;
        /* Expand to fill available space */
        margin-right: 10px;
        /* Add some space between input and voice controls */
    }

    .voice-controls-container {
        display: flex;
        align-items: center;
    }

    .record-button,
    .stop-record-button,
    .delete-voice-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 50%;
        padding: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-right: 10px;
        /* Add some space between buttons */
    }

    .record-button:hover,
    .stop-record-button:hover,
    .delete-voice-button:hover {
        background-color: #0056b3;
    }

    .button-cancel {
        position: absolute;
        bottom: 10px;
        /* Adjust this value to set the distance from the bottom */
        left: 10px;
        /* Adjust this value to set the distance from the left */
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color: #ccc;
        /* Background color */
        color: #000;
        /* Text color */
        transition: background-color 0.3s ease;
        /* Transition effect */
    }

    /* Hover effect for cancel button */
    .button-cancel:hover {
        background-color: #bbb;
        /* Darken the background color on hover */
    }

    /* Send button */
    .button-send {
        position: absolute;
        bottom: 10px;
        /* Adjust this value to set the distance from the bottom */
        right: 10px;
        /* Adjust this value to set the distance from the left */
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        background-color: #ff0000;
        /* Red background color */
        color: #fff;
        /* Text color */
        transition: background-color 0.3s ease;
        /* Transition effect */
    }

    /* Hover effect for send button */
    .button-send:hover {
        background-color: #cc0000;
        /* Darker red on hover */
    }

    .popup-content {
        position: relative;
        /* Add relative positioning */
        background-color: rgba(211, 211, 211, 0.8);
        border: 1px solid #ccc;
        border-radius: 15px;
        padding: 30px;
        min-width: 600px;
        min-height: 400px;
        margin: 0 auto;
    }

    .popup-input {
        width: calc(100% - 20px);
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        /* Border radius */
        resize: none;
        background-color: #f2f2f2;
        /* Light grey background color */
        transition: border-color 0.3s ease;
        /* Transition effect for border color */
    }

    /* Hover effect for text input area */
    .popup-input:hover {
        border-color: #007bff;
        /* Change border color on hover */
    }

    /* Focus effect for text input area */
    .popup-input:focus {
        outline: none;
        /* Remove default focus outline */
        border-color: #007bff;
        /* Change border color on focus */
    }

    .delete-voice-button {
        background-color: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .delete-voice-button:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .delete-voice-button svg {
        width: 100%;
        height: 100%;
        fill: #000;
    }

    .divaudio {
        display: flex;
        align-items: center;
    }
</style>



<script src="{{ asset('assets/js/dashboard.js') }}"></script>