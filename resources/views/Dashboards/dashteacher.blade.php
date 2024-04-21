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
                    <td><a href="{{ Storage::url($user->etudiant->stage->dossier_stage)}}" target="_blank">click here</a></td>
                    <td><a href="{{ Storage::url($user->etudiant->stage->rapport) }}" target="_blank">click here </a></td>
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

                        <a title="Disapprove" onclick="showDisapprovePopup({{ $user->etudiant->id }})" style="margin-left:5px;">
                            <svg width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill="red" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                            </svg>
                        </a>
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
                @endforeach

            </tbody>
        </table>
    </div>
</div>
<form id="commentForm" method="POST" action="{{ route('ADD-RAPPORT-COMMENT') }}">
    @csrf
    <div class="disapprove-popup" id="disapprovePopup">
        <div class="popup-content">
            <label for="disapproveNote" style="font-weight: bold; color:#000">Notes de l'encadrant:</label>
            <div id="inputContainer">
                <!-- Text Input -->
                <textarea name="notification" id="disapproveNote" class="popup-input" rows="4"></textarea>
            </div>
            <div id="voiceContainer" style="display: none;">
                <div class="voice-controls-container">
                    <button type="button" id="startRecordBtn" onclick="startRecording()" class="record-button">
                        <svg width="50px" height="50px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="black" fill="none">
                            <path d="M47.67,28.43v3.38a15.67,15.67,0,0,1-31.34,0V28.43" stroke-linecap="round" />
                            <rect x="22.51" y="6.45" width="18.44" height="34.22" rx="8.89" stroke-linecap="round" />
                            <line x1="31.73" y1="57.34" x2="31.73" y2="47.71" stroke-linecap="round" />
                            <line x1="37.14" y1="57.55" x2="26.43" y2="57.55" stroke-linecap="round" />
                        </svg>
                    </button>
                    <button type="button" id="stopRecordBtn" style="display: none;" onclick="stopRecording()" class="stop-record-button">
                        <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#00bd6b">
                            <path d="M3 10L3 14M7.5 11V13M12 6V18M16.5 3V21M21 10V14" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <audio id="audioPlayer" controls style="display: none;"></audio>
            </div>

            <!-- Toggle Button -->
            <div>
                <label>Choose input method:</label>
                <label><input type="radio" name="inputMethod" value="text" checked> Text</label>
                <label><input type="radio" name="inputMethod" value="voice"> Voice</label>
                <label><input type="radio" name="inputMethod" value="both"> Both</label>
            </div>
            <div class="popup-buttons">
                <button type="button" class="button-cancel" onclick="hideDisapprovePopup()">Annuler</button>
                <button type="button" class="button-send" onclick="submitForm()">Envoyer les mises à jours</button>
            </div>
        </div>
    </div>
</form>
<script>
    // Function to handle toggle between text and voice input
    document.querySelectorAll('input[name="inputMethod"]').forEach(function(elem) {
        elem.addEventListener('change', function() {
            if (this.value === 'text') {
                document.getElementById('inputContainer').style.display = 'block';
                document.getElementById('voiceContainer').style.display = 'none';
            } else if (this.value === 'voice') {
                document.getElementById('inputContainer').style.display = 'none';
                document.getElementById('voiceContainer').style.display = 'block';
            } else {
                document.getElementById('inputContainer').style.display = 'block';
                document.getElementById('voiceContainer').style.display = 'block';
            }
        });
    });
</script>

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
                };
                recordedChunks = [];
                mediaRecorder.start();
                startRecordBtn.style.display = 'none';
                stopRecordBtn.style.display = 'inline-block';
            })
            .catch(function(err) {
                console.error('Error accessing microphone:', err);
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
                    text: 'Comment added successfully!',
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
                    text: 'Error occurred while adding comment. Please try again.'
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
        alert("Stage approved for row " + rowId);
    }
</script>

@endsection

<style>
.voice-controls-container {
    display: flex;
    align-items: center;
}

.record-button, .stop-record-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 50%;
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-right: 10px; /* Add some space between buttons */
}

.record-button:hover, .stop-record-button:hover {
    background-color: #0056b3;
}

.button-cancel {
    position: absolute;
    bottom: 10px; /* Adjust this value to set the distance from the bottom */
    left: 10px; /* Adjust this value to set the distance from the left */
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #ccc; /* Background color */
    color: #000; /* Text color */
    transition: background-color 0.3s ease; /* Transition effect */
}

/* Hover effect for cancel button */
.button-cancel:hover {
    background-color: #bbb; /* Darken the background color on hover */
}
/* Send button */
.button-send {
    position: absolute;
    bottom: 10px; /* Adjust this value to set the distance from the bottom */
    right: 10px; /* Adjust this value to set the distance from the left */
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    background-color: #ff0000; /* Red background color */
    color: #fff; /* Text color */
    transition: background-color 0.3s ease; /* Transition effect */
}

/* Hover effect for send button */
.button-send:hover {
    background-color: #cc0000; /* Darker red on hover */
}

.popup-content {
    position: relative; /* Add relative positioning */
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
    border-radius: 20px; /* Border radius */
    resize: none;
    background-color: #f2f2f2; /* Light grey background color */
    transition: border-color 0.3s ease; /* Transition effect for border color */
}

/* Hover effect for text input area */
.popup-input:hover {
    border-color: #007bff; /* Change border color on hover */
}

/* Focus effect for text input area */
.popup-input:focus {
    outline: none; /* Remove default focus outline */
    border-color: #007bff; /* Change border color on focus */
}


   
</style>



<script src="{{ asset('assets/js/dashboard.js') }}"></script>