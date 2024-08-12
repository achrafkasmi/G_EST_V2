<!--<link rel="stylesheet" href="//cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css">-->

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@extends('master')
@section("app-mid")
<title>Acceuil</title>


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
            <a href="{{ url('/attendance') }}" style="text-decoration: none; color: inherit;">
                <div class="chart-container">
                    <div class="chart-info-wrapper">
                        <h2>Attendance</h2>
                        <span>Commencer</span>
                    </div>
                </div>
            </a>
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
                @foreach($user['stages'] as $stage)
                <tr>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $stage->type_dossier }}</td>
                    <td><a href="{{ Storage::url($stage->dossier_stage) }}" target="_blank">Cliquez ici</a></td>
                    <td><a href="{{ Storage::url($stage->rapport) }}" target="_blank">Cliquez ici</a></td>
                    <td>
                        @if ($stage->validation_prof)
                        <a href="{{ route('student.validation', $stage->id) }}">
                            <svg width="24px" height="24px" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                                <circle fill="#4CAF50" cx="24" cy="24" r="21" />
                                <polygon fill="#CCFF90" points="34.6,14.6 21,28.2 15.4,22.6 12.6,25.4 21,33.8 37.4,17.4" />
                            </svg>
                        </a>
                        @else
                        <a href="{{ route('student.validation', $stage->id) }}" title="Approve" onclick="approveStage(1)">
                            <svg class="approve" width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path class="approve-fill" fill="{{ auth()->check() ? 'black' : 'yellow' }}" d="M26,24c-0.553,0-1,0.448-1,1v4H7V3h10v7c0,0.552,0.447,1,1,1h7v4c0,0.552,0.447,1,1,1s1-0.448,1-1v-4.903 c0.003-0.033,0.02-0.063,0.02-0.097c0-0.337-0.166-0.635-0.421-0.816l-7.892-7.891c-0.086-0.085-0.187-0.147-0.292-0.195 c-0.031-0.015-0.063-0.023-0.097-0.034c-0.082-0.028-0.166-0.045-0.253-0.05C18.043,1.012,18.022,1,18,1H6C5.447,1,5,1.448,5,2v28 c0,0.552,0.447,1,1,1h20c0.553,0,1-0.448,1-1v-5C27,24.448,26.553,24,26,24z M19,9V4.414L23.586,9H19z" />
                                <path class="approve-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M30.73,15.317c-0.379-0.404-1.01-0.424-1.414-0.047l-10.004,9.36l-4.629-4.332c-0.404-0.378-1.036-0.357-1.414,0.047 c-0.377,0.403-0.356,1.036,0.047,1.413l5.313,4.971c0.192,0.18,0.438,0.27,0.684,0.27s0.491-0.09,0.684-0.27l10.688-10 C31.087,16.353,31.107,15.72,30.73,15.317z" />
                            </svg>
                        </a>
                        @endif
                    </td>
                    <td>
                        @if ($stage->is_recommanded && $stage->validation_prof)
                        <a href="{{ route('student.recomandation', $stage->id) }}">
                            <svg width="24px" height="24px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.5 9.32001H7.5C6.37366 9.25709 5.2682 9.64244 4.42505 10.3919C3.5819 11.1414 3.06958 12.1941 3 13.32V18.32C3.06958 19.446 3.5819 20.4986 4.42505 21.2481C5.2682 21.9976 6.37366 22.3829 7.5 22.32H16.5C17.6263 22.3829 18.7318 21.9976 19.575 21.2481C20.4181 20.4986 20.9304 19.446 21 18.32V13.32C20.9304 12.1941 20.4181 11.1414 19.575 10.3919C18.7318 9.64244 17.6263 9.25709 16.5 9.32001Z" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M17 9.32001V7.32001C17 5.99392 16.4732 4.72217 15.5355 3.78448C14.5978 2.8468 13.3261 2.32001 12 2.32001" stroke="green" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                        @elseif ($stage->validation_prof)
                        <a href="{{ route('student.recomandation', $stage->id) }}">
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
                @endforeach
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
@if (session()->has('success'))
<script>
        Swal.fire({
            title: 'Success!',
            text: 'Attendance marked successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/'; // Redirect to a desired page
            }
        });
    </script>
@endif
@if (session()->has('failed'))
<script>
        Swal.fire({
            title: 'failed!',
            text: "Attendance didn't mark correctly.",
            icon: 'error',
            confirmButtonText: 'got it'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/'; // Redirect to a desired page
            }
        });
    </script>
    @endif
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