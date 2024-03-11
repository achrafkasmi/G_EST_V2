@extends('master')
@section("app-mid")

<div class="app-main">
    <div class="main-header-line">
        <h1>Ecole supérieure de technologie - Dashboard</h1>
        <div class="action-buttons">
            <button class="open-right-area">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                </svg>
            </button>
            <button class="menu-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>
    <div class="chart-row three">
        <div class="chart-container-wrapper">
            <a href="#" id="toggleCrudContainer">
                <div class="chart-container">
                    <div class="chart-info-wrapper">
                        <h2>Dossiers de Stage</h2>
                        <span></span>
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

    <div class="chart-row two">

        <div class="chart-container-wrapper small">


        </div>
    </div>
    <div class="container crud-container">
        <span class="close-btn" onclick="toggleCrudContainer()">❌</span>
        <h2 class="crud-title">Stage Approvals LP-GC</h2>

        <!-- Search Bar -->
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search...">
            <button id="searchBtn" onclick="searchTable()">Search</button>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Recommandation</th>
                    <th>Etudiant</th>
                    <th>Type de Stage</th>
                    <th>Dossier</th>
                    <th>Rapport</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users  as $user)
                <tr>
                    <td><input type="checkbox" name="recommandation" id="recommandation1"></td>
                    <td>{{$user->name}}</td>
                    <td>Internship</td>
                    <td><a href="{{ Storage::url(auth()->user()->stage_file) }}">click here</a></td>
                    <td><a href="{{ Storage::url(auth()->user()->rapport_file) }}">click here </a></td>
                    <!-- CRUD options (Icons) -->
                    <td class="crud-options">
                        <a href="your_link_here" title="Visualize">
                            <span class="icon visualize-icon"></span>
                            <!-- or use text -->
                            <!-- YourVisualizeIconOrText -->
                        </a>
                        <a href="#" title="Approve" style="color: green;" onclick="approveStage(1)">✔</a>
                        <a href="#" title="Disapprove" style="color: red;" onclick="showDisapprovePopup(1)">✘</a>
                    </td>
                </tr>
                @endforeach
                <!-- Add more rows as needed -->
            </tbody>
        </table>

        <!-- Save Button -->
        <button class="save-button" onclick="saveApprovals()">Save Approvals</button>

        <!-- Disapprove Popup -->
        <div class="disapprove-popup" id="disapprovePopup">
            <div class="popup-content">
                <label for="disapproveNote" style="font-weight: bold;">Disapproval Note:</label>
                <textarea id="disapproveNote" class="popup-input" rows="4"></textarea>
                <div class="popup-buttons">
                    <button onclick="hideDisapprovePopup()">Cancel</button>
                    <button style="background-color: red; color: #fff;" onclick="disapproveStage()">Disapprove</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to toggle the visibility of the .crud-container
    function toggleCrudContainer() {
        var crudContainer = document.querySelector('.crud-container');
        crudContainer.style.display = (crudContainer.style.display === 'none' || crudContainer.style.display === '') ? 'block' : 'none';
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
        // Implement your search logic here
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector(".table");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0]; // Assuming search is based on the first column (Name)
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

    // Function to approve a stage
    function approveStage(rowId) {
        // Implement your approve logic here
        alert("Stage approved for row " + rowId);
    }

    // Function to show the disapprove popup
    function showDisapprovePopup(rowId) {
        var popup = document.getElementById("disapprovePopup");
        popup.style.display = "flex";
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

    // Function to save approvals
    function saveApprovals() {
        // Implement your save logic here
        alert("Approvals saved!");
    }
</script>


@endsection


<style>
    body {
        height: 100vh;
        width: 100%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        font-family: 'Poppins', sans-serif;
        background-color: #050e2d;
        /* Update to your app theme color */
        color: #e5e5e5;
        margin: 0;
    }

    

    .container {
            position: relative;
        }

    .close-btn {
        position: absolute;
        top: 10px;
        left: 10px;
        cursor: pointer;
        font-size: 20px;
    }

    .icon {
        display: inline-block;
        width: 20px;
        /* Adjust the width to your desired size */
        height: 15px;
        /* Adjust the height to your desired size */
        background-size: cover;
    }

    .visualize-icon {
        background-image: url('eye.PNG');
        /* Additional styling for the visualize icon */
    }

    .crud-container {
        max-width: 800px;
        margin: 50px auto;
        background-color: #151c32;
        /* Update to your app theme color */
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        box-sizing: border-box;
        display: none;
    }

    .crud-title {
        font-size: 24px;
        color: #3d7eff;
        /* Update to your app theme color */
        margin-bottom: 20px;
        text-align: center;
    }

    .search-bar {
        margin-bottom: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #searchInput {
        width: 70%;
        padding: 8px;
        border: 1px solid #e5e5e5;
        border-radius: 5px;
        box-sizing: border-box;
    }

    #searchBtn {
        background-color: #5e6a81;
        /* Update to your app theme color */
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        margin-left: 10px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .table th,
    .table td {
        border: 1px solid #e5e5e5;
        padding: 12px;
        text-align: left;
    }

    .table th {
        background-color: #5e6a81;
        /* Update to your app theme color */
        color: #fff;
    }

    .crud-options {
        text-align: center;
    }

    .crud-options a {
        color: #3d7eff;
        /* Update to your app theme color */
        margin: 0 5px;
        text-decoration: none;
        cursor: pointer;
    }

    .crud-options a:hover {
        text-decoration: underline;
    }

    .disapprove-popup {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        text-align: center;
        z-index: 1;
    }

    .popup-content {
        background: #fff;
        padding: 20px;
        border-radius: 5px;
        max-width: 400px;
        margin: 0 auto;
    }

    .popup-input {
        width: 100%;
        margin-bottom: 10px;
        padding: 8px;
        box-sizing: border-box;
    }

    .popup-buttons {
        display: flex;
        justify-content: space-between;
    }

    .save-button {
        background-color: #3d7eff;
        /* Update to your app theme color */
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }
</style>








<style>
    /*this design is for the the mid fo the view*/
</style>