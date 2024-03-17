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
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr> <!-- Start a new row for each user -->
                    <td>{{$user->name}}</td>
                    <td>{{$user->etudiant->stage->type_dossier}}</td>
                    <td><a href="{{ Storage::url($user->etudiant->stage->dossier_stage)}}" target="_blank">click here</a></td>
                    <td><a href="{{ Storage::url($user->etudiant->stage->rapport) }}" target="_blank">click here </a></td>
                    <td>

                        <a href="#" title="Approve" onclick="approveStage(1)">
                            <svg class="approve" width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                <path class="approve-fill" fill="{{ auth()->check() ? 'black' : 'yellow' }}" d="M26,24c-0.553,0-1,0.448-1,1v4H7V3h10v7c0,0.552,0.447,1,1,1h7v4c0,0.552,0.447,1,1,1s1-0.448,1-1v-4.903    c0.003-0.033,0.02-0.063,0.02-0.097c0-0.337-0.166-0.635-0.421-0.816l-7.892-7.891c-0.086-0.085-0.187-0.147-0.292-0.195    c-0.031-0.015-0.063-0.023-0.097-0.034c-0.082-0.028-0.166-0.045-0.253-0.05C18.043,1.012,18.022,1,18,1H6C5.447,1,5,1.448,5,2v28    c0,0.552,0.447,1,1,1h20c0.553,0,1-0.448,1-1v-5C27,24.448,26.553,24,26,24z M19,9V4.414L23.586,9H19z" />
                                <path class="approve-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M30.73,15.317c-0.379-0.404-1.01-0.424-1.414-0.047l-10.004,9.36l-4.629-4.332c-0.404-0.378-1.036-0.357-1.414,0.047    c-0.377,0.403-0.356,1.036,0.047,1.413l5.313,4.971c0.192,0.18,0.438,0.27,0.684,0.27s0.491-0.09,0.684-0.27l10.688-10    C31.087,16.353,31.107,15.72,30.73,15.317z" />
                            </svg>
                        </a>

                        <a title="Disapprove" onclick="showDisapprovePopup(1)" style="margin-left:5px;">
                            <svg width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill="red" d="M15.198 3.52a1.612 1.612 0 012.223 2.336L6.346 16.421l-2.854.375 1.17-3.272L15.197 3.521zm3.725-1.322a3.612 3.612 0 00-5.102-.128L3.11 12.238a1 1 0 00-.253.388l-1.8 5.037a1 1 0 001.072 1.328l4.8-.63a1 1 0 00.56-.267L18.8 7.304a3.612 3.612 0 00.122-5.106zM12 17a1 1 0 100 2h6a1 1 0 100-2h-6z" />
                            </svg>
                        </a>
                    </td>
                    <td>
                        <input type="checkbox" id="checkbox{{$loop->iteration}}" name="checkbox{{$loop->iteration}}" style="width: 20px; height: 20px; margin-right:5px;">
                        <label for="checkbox{{$loop->iteration}}"> </label><!-- Label for accessibility -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Disapprove Popup -->
        <div class="disapprove-popup" id="disapprovePopup">
            <div class="popup-content">
                <label for="disapproveNote" style="font-weight: bold;">Disapproval Note:</label>
                <textarea id="disapproveNote" class="popup-input" rows="4"></textarea>
                <div class="popup-buttons">
                    <button onclick="hideDisapprovePopup()">Cancel</button>
                    <button style="background-color: red; color: #fff;" onclick="disapproveStage()">send updates</button>
                </div>
            </div>
        </div>
    </div>
    <button class="save-button" onclick="saveApprovals()">Save Approvals</button>
</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>
<script>
    let table = new DataTable('#myTable');
</script>
<script>
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
























    /*hadchi dyal data table*/

    :root {
        --dt-row-selected: 13, 110, 253;
        --dt-row-selected-text: 255, 255, 255;
        --dt-row-selected-link: 9, 10, 11;
        --dt-row-stripe: 0, 0, 0;
        --dt-row-hover: 0, 0, 0;
        --dt-column-ordering: 0, 0, 0;
        --dt-html-background: white
    }

    :root.dark {
        --dt-html-background: rgb(33, 37, 41)
    }

    .datatabcontainer {

        border-radius: 12px;
        background-color: #c0ddff;
        color: #000000;

    }

    .tab {

        max-width: 97%;
        border-radius: 15px;
        color: #000000;
    }

    table.dataTable td.dt-control {
        text-align: center;
        cursor: pointer
    }

    table.dataTable td.dt-control:before {
        display: inline-block;
        box-sizing: border-box;
        content: "";
        border-top: 5px solid transparent;
        border-left: 10px solid rgba(0, 0, 0, 0.5);
        border-bottom: 5px solid transparent;
        border-right: 0px solid transparent
    }

    table.dataTable tr.dt-hasChild td.dt-control:before {
        border-top: 10px solid rgba(0, 0, 0, 0.5);
        border-left: 5px solid transparent;
        border-bottom: 0px solid transparent;
        border-right: 5px solid transparent
    }

    html.dark table.dataTable td.dt-control:before,
    :root[data-bs-theme=dark] table.dataTable td.dt-control:before {
        border-left-color: rgba(255, 255, 255, 0.5)
    }

    html.dark table.dataTable tr.dt-hasChild td.dt-control:before,
    :root[data-bs-theme=dark] table.dataTable tr.dt-hasChild td.dt-control:before {
        border-top-color: rgba(255, 255, 255, 0.5);
        border-left-color: transparent
    }

    div.dt-scroll-body thead tr,
    div.dt-scroll-body tfoot tr {
        height: 0
    }

    div.dt-scroll-body thead tr th,
    div.dt-scroll-body thead tr td,
    div.dt-scroll-body tfoot tr th,
    div.dt-scroll-body tfoot tr td {
        height: 0 !important;
        padding-top: 0px !important;
        padding-bottom: 0px !important;
        border-top-width: 0px !important;
        border-bottom-width: 0px !important
    }

    div.dt-scroll-body thead tr th div.dt-scroll-sizing,
    div.dt-scroll-body thead tr td div.dt-scroll-sizing,
    div.dt-scroll-body tfoot tr th div.dt-scroll-sizing,
    div.dt-scroll-body tfoot tr td div.dt-scroll-sizing {
        height: 0 !important;
        overflow: hidden !important
    }

    table.dataTable thead>tr>th:active,
    table.dataTable thead>tr>td:active {
        outline: none
    }

    table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before {
        position: absolute;
        display: block;
        bottom: 50%;
        content: "▲";
        content: "▲" /""
    }

    table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:after,
    table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
        position: absolute;
        display: block;
        top: 50%;
        content: "▼";
        content: "▼" /""
    }

    table.dataTable thead>tr>th.dt-orderable-asc,
    table.dataTable thead>tr>th.dt-orderable-desc,
    table.dataTable thead>tr>th.dt-ordering-asc,
    table.dataTable thead>tr>th.dt-ordering-desc,
    table.dataTable thead>tr>td.dt-orderable-asc,
    table.dataTable thead>tr>td.dt-orderable-desc,
    table.dataTable thead>tr>td.dt-ordering-asc,
    table.dataTable thead>tr>td.dt-ordering-desc {
        position: relative;
        padding-right: 30px
    }

    table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order,
    table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order,
    table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order,
    table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order,
    table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order,
    table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order,
    table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order,
    table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order {
        position: absolute;
        right: 12px;
        top: 0;
        bottom: 0;
        width: 12px
    }

    table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-orderable-asc span.dt-column-order:after,
    table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-orderable-desc span.dt-column-order:after,
    table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:after,
    table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-orderable-asc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-orderable-desc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
        left: 0;
        opacity: .125;
        line-height: 9px;
        font-size: .8em
    }

    table.dataTable thead>tr>th.dt-orderable-asc,
    table.dataTable thead>tr>th.dt-orderable-desc,
    table.dataTable thead>tr>td.dt-orderable-asc,
    table.dataTable thead>tr>td.dt-orderable-desc {
        cursor: pointer
    }

    table.dataTable thead>tr>th.dt-orderable-asc:hover,
    table.dataTable thead>tr>th.dt-orderable-desc:hover,
    table.dataTable thead>tr>td.dt-orderable-asc:hover,
    table.dataTable thead>tr>td.dt-orderable-desc:hover {
        outline: 2px solid rgba(0, 0, 0, 0.05);
        outline-offset: -2px
    }

    table.dataTable thead>tr>th.dt-ordering-asc span.dt-column-order:before,
    table.dataTable thead>tr>th.dt-ordering-desc span.dt-column-order:after,
    table.dataTable thead>tr>td.dt-ordering-asc span.dt-column-order:before,
    table.dataTable thead>tr>td.dt-ordering-desc span.dt-column-order:after {
        opacity: .6
    }

    table.dataTable thead>tr>th.sorting_desc_disabled span.dt-column-order:after,
    table.dataTable thead>tr>th.sorting_asc_disabled span.dt-column-order:before,
    table.dataTable thead>tr>td.sorting_desc_disabled span.dt-column-order:after,
    table.dataTable thead>tr>td.sorting_asc_disabled span.dt-column-order:before {
        display: none
    }

    table.dataTable thead>tr>th:active,
    table.dataTable thead>tr>td:active {
        outline: none
    }

    div.dt-scroll-body>table.dataTable>thead>tr>th,
    div.dt-scroll-body>table.dataTable>thead>tr>td {
        overflow: hidden
    }

    :root.dark table.dataTable thead>tr>th.dt-orderable-asc:hover,
    :root.dark table.dataTable thead>tr>th.dt-orderable-desc:hover,
    :root.dark table.dataTable thead>tr>td.dt-orderable-asc:hover,
    :root.dark table.dataTable thead>tr>td.dt-orderable-desc:hover,
    :root[data-bs-theme=dark] table.dataTable thead>tr>th.dt-orderable-asc:hover,
    :root[data-bs-theme=dark] table.dataTable thead>tr>th.dt-orderable-desc:hover,
    :root[data-bs-theme=dark] table.dataTable thead>tr>td.dt-orderable-asc:hover,
    :root[data-bs-theme=dark] table.dataTable thead>tr>td.dt-orderable-desc:hover {
        outline: 2px solid rgba(255, 255, 255, 0.05)
    }

    div.dt-processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        margin-left: -100px;
        margin-top: -22px;
        text-align: center;
        padding: 2px;
        z-index: 10
    }

    div.dt-processing>div:last-child {
        position: relative;
        width: 80px;
        height: 15px;
        margin: 1em auto
    }

    div.dt-processing>div:last-child>div {
        position: absolute;
        top: 0;
        width: 13px;
        height: 13px;
        border-radius: 50%;
        background: rgb(13, 110, 253);
        background: rgb(var(--dt-row-selected));
        animation-timing-function: cubic-bezier(0, 1, 1, 0)
    }

    div.dt-processing>div:last-child>div:nth-child(1) {
        left: 8px;
        animation: datatables-loader-1 .6s infinite
    }

    div.dt-processing>div:last-child>div:nth-child(2) {
        left: 8px;
        animation: datatables-loader-2 .6s infinite
    }

    div.dt-processing>div:last-child>div:nth-child(3) {
        left: 32px;
        animation: datatables-loader-2 .6s infinite
    }

    div.dt-processing>div:last-child>div:nth-child(4) {
        left: 56px;
        animation: datatables-loader-3 .6s infinite
    }

    @keyframes datatables-loader-1 {
        0% {
            transform: scale(0)
        }

        100% {
            transform: scale(1)
        }
    }

    @keyframes datatables-loader-3 {
        0% {
            transform: scale(1)
        }

        100% {
            transform: scale(0)
        }
    }

    @keyframes datatables-loader-2 {
        0% {
            transform: translate(0, 0)
        }

        100% {
            transform: translate(24px, 0)
        }
    }

    table.dataTable.nowrap th,
    table.dataTable.nowrap td {
        white-space: nowrap
    }

    table.dataTable th,
    table.dataTable td {
        box-sizing: border-box
    }

    table.dataTable th.dt-left,
    table.dataTable td.dt-left {
        text-align: left
    }

    table.dataTable th.dt-center,
    table.dataTable td.dt-center {
        text-align: center
    }

    table.dataTable th.dt-right,
    table.dataTable td.dt-right {
        text-align: right
    }

    table.dataTable th.dt-justify,
    table.dataTable td.dt-justify {
        text-align: justify
    }

    table.dataTable th.dt-nowrap,
    table.dataTable td.dt-nowrap {
        white-space: nowrap
    }

    table.dataTable th.dt-empty,
    table.dataTable td.dt-empty {
        text-align: center;
        vertical-align: top
    }

    table.dataTable th.dt-type-numeric,
    table.dataTable th.dt-type-date,
    table.dataTable td.dt-type-numeric,
    table.dataTable td.dt-type-date {
        text-align: right
    }

    table.dataTable thead th,
    table.dataTable thead td,
    table.dataTable tfoot th,
    table.dataTable tfoot td {
        text-align: left
    }

    table.dataTable thead th.dt-head-left,
    table.dataTable thead td.dt-head-left,
    table.dataTable tfoot th.dt-head-left,
    table.dataTable tfoot td.dt-head-left {
        text-align: left
    }

    table.dataTable thead th.dt-head-center,
    table.dataTable thead td.dt-head-center,
    table.dataTable tfoot th.dt-head-center,
    table.dataTable tfoot td.dt-head-center {
        text-align: center
    }

    table.dataTable thead th.dt-head-right,
    table.dataTable thead td.dt-head-right,
    table.dataTable tfoot th.dt-head-right,
    table.dataTable tfoot td.dt-head-right {
        text-align: right
    }

    table.dataTable thead th.dt-head-justify,
    table.dataTable thead td.dt-head-justify,
    table.dataTable tfoot th.dt-head-justify,
    table.dataTable tfoot td.dt-head-justify {
        text-align: justify
    }

    table.dataTable thead th.dt-head-nowrap,
    table.dataTable thead td.dt-head-nowrap,
    table.dataTable tfoot th.dt-head-nowrap,
    table.dataTable tfoot td.dt-head-nowrap {
        white-space: nowrap
    }

    table.dataTable tbody th.dt-body-left,
    table.dataTable tbody td.dt-body-left {
        text-align: left
    }

    table.dataTable tbody th.dt-body-center,
    table.dataTable tbody td.dt-body-center {
        text-align: center
    }

    table.dataTable tbody th.dt-body-right,
    table.dataTable tbody td.dt-body-right {
        text-align: right
    }

    table.dataTable tbody th.dt-body-justify,
    table.dataTable tbody td.dt-body-justify {
        text-align: justify
    }

    table.dataTable tbody th.dt-body-nowrap,
    table.dataTable tbody td.dt-body-nowrap {
        white-space: nowrap
    }

    table.dataTable {
        width: 100%;
        margin: 0 auto;
        border-spacing: 0
    }

    table.dataTable thead th,
    table.dataTable tfoot th {
        font-weight: bold
    }

    table.dataTable>thead>tr>th,
    table.dataTable>thead>tr>td {
        padding: 10px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.3)
    }

    table.dataTable>thead>tr>th:active,
    table.dataTable>thead>tr>td:active {
        outline: none
    }

    table.dataTable>tfoot>tr>th,
    table.dataTable>tfoot>tr>td {
        border-top: 1px solid rgba(0, 0, 0, 0.3);
        padding: 10px 10px 6px 10px
    }

    table.dataTable>tbody>tr {
        background-color: transparent
    }

    table.dataTable>tbody>tr:first-child>* {
        border-top: none
    }

    table.dataTable>tbody>tr:last-child>* {
        border-bottom: none
    }

    table.dataTable>tbody>tr.selected>* {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.9);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.9);
        color: rgb(255, 255, 255);
        color: rgb(var(--dt-row-selected-text))
    }

    table.dataTable>tbody>tr.selected a {
        color: rgb(9, 10, 11);
        color: rgb(var(--dt-row-selected-link))
    }

    table.dataTable>tbody>tr>th,
    table.dataTable>tbody>tr>td {
        padding: 8px 10px
    }

    table.dataTable.row-border>tbody>tr>*,
    table.dataTable.display>tbody>tr>* {
        border-top: 1px solid rgba(0, 0, 0, 0.15)
    }

    table.dataTable.row-border>tbody>tr:first-child>*,
    table.dataTable.display>tbody>tr:first-child>* {
        border-top: none
    }

    table.dataTable.row-border>tbody>tr.selected+tr.selected>td,
    table.dataTable.display>tbody>tr.selected+tr.selected>td {
        border-top-color: rgba(13, 110, 253, 0.65);
        border-top-color: rgba(var(--dt-row-selected), 0.65)
    }

    table.dataTable.cell-border>tbody>tr>* {
        border-top: 1px solid rgba(0, 0, 0, 0.15);
        border-right: 1px solid rgba(0, 0, 0, 0.15)
    }

    table.dataTable.cell-border>tbody>tr>*:first-child {
        border-left: 1px solid rgba(0, 0, 0, 0.15)
    }

    table.dataTable.cell-border>tbody>tr:first-child>* {
        border-top: 1px solid rgba(0, 0, 0, 0.3)
    }

    table.dataTable.stripe>tbody>tr:nth-child(odd)>*,
    table.dataTable.display>tbody>tr:nth-child(odd)>* {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.023);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-stripe), 0.023)
    }

    table.dataTable.stripe>tbody>tr:nth-child(odd).selected>*,
    table.dataTable.display>tbody>tr:nth-child(odd).selected>* {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.923);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.923)
    }

    table.dataTable.hover>tbody>tr:hover>*,
    table.dataTable.display>tbody>tr:hover>* {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.035);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.035)
    }

    table.dataTable.hover>tbody>tr.selected:hover>*,
    table.dataTable.display>tbody>tr.selected:hover>* {
        box-shadow: inset 0 0 0 9999px #0d6efd !important;
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 1) !important
    }

    table.dataTable.order-column>tbody tr>.sorting_1,
    table.dataTable.order-column>tbody tr>.sorting_2,
    table.dataTable.order-column>tbody tr>.sorting_3,
    table.dataTable.display>tbody tr>.sorting_1,
    table.dataTable.display>tbody tr>.sorting_2,
    table.dataTable.display>tbody tr>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.019);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.019)
    }

    table.dataTable.order-column>tbody tr.selected>.sorting_1,
    table.dataTable.order-column>tbody tr.selected>.sorting_2,
    table.dataTable.order-column>tbody tr.selected>.sorting_3,
    table.dataTable.display>tbody tr.selected>.sorting_1,
    table.dataTable.display>tbody tr.selected>.sorting_2,
    table.dataTable.display>tbody tr.selected>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.919);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.919)
    }

    table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_1,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.054);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.054)
    }

    table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_2,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.047);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.047)
    }

    table.dataTable.display>tbody>tr:nth-child(odd)>.sorting_3,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd)>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.039);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.039)
    }

    table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_1,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.954);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.954)
    }

    table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_2,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.947);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.947)
    }

    table.dataTable.display>tbody>tr:nth-child(odd).selected>.sorting_3,
    table.dataTable.order-column.stripe>tbody>tr:nth-child(odd).selected>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.939);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.939)
    }

    table.dataTable.display>tbody>tr.even>.sorting_1,
    table.dataTable.order-column.stripe>tbody>tr.even>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.019);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.019)
    }

    table.dataTable.display>tbody>tr.even>.sorting_2,
    table.dataTable.order-column.stripe>tbody>tr.even>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.011);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.011)
    }

    table.dataTable.display>tbody>tr.even>.sorting_3,
    table.dataTable.order-column.stripe>tbody>tr.even>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.003);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-column-ordering), 0.003)
    }

    table.dataTable.display>tbody>tr.even.selected>.sorting_1,
    table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.919);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.919)
    }

    table.dataTable.display>tbody>tr.even.selected>.sorting_2,
    table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.911);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.911)
    }

    table.dataTable.display>tbody>tr.even.selected>.sorting_3,
    table.dataTable.order-column.stripe>tbody>tr.even.selected>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.903);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.903)
    }

    table.dataTable.display tbody tr:hover>.sorting_1,
    table.dataTable.order-column.hover tbody tr:hover>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.082);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.082)
    }

    table.dataTable.display tbody tr:hover>.sorting_2,
    table.dataTable.order-column.hover tbody tr:hover>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.074);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.074)
    }

    table.dataTable.display tbody tr:hover>.sorting_3,
    table.dataTable.order-column.hover tbody tr:hover>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(0, 0, 0, 0.062);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-hover), 0.062)
    }

    table.dataTable.display tbody tr:hover.selected>.sorting_1,
    table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_1 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.982);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.982)
    }

    table.dataTable.display tbody tr:hover.selected>.sorting_2,
    table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_2 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.974);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.974)
    }

    table.dataTable.display tbody tr:hover.selected>.sorting_3,
    table.dataTable.order-column.hover tbody tr:hover.selected>.sorting_3 {
        box-shadow: inset 0 0 0 9999px rgba(13, 110, 253, 0.962);
        box-shadow: inset 0 0 0 9999px rgba(var(--dt-row-selected), 0.962)
    }

    table.dataTable.compact thead th,
    table.dataTable.compact thead td,
    table.dataTable.compact tfoot th,
    table.dataTable.compact tfoot td,
    table.dataTable.compact tbody th,
    table.dataTable.compact tbody td {
        padding: 4px
    }

    div.dt-container {
        position: relative;
        clear: both
    }

    div.dt-container div.dt-layout-row {
        display: table;
        clear: both;
        width: 100%
    }

    div.dt-container div.dt-layout-row.dt-layout-table {
        display: block
    }

    div.dt-container div.dt-layout-row.dt-layout-table div.dt-layout-cell {
        display: block
    }

    div.dt-container div.dt-layout-cell {
        display: table-cell;
        vertical-align: middle;
        padding: 5px 0
    }

    div.dt-container div.dt-layout-cell.dt-full {
        text-align: center
    }

    div.dt-container div.dt-layout-cell.dt-start {
        text-align: left
    }

    div.dt-container div.dt-layout-cell.dt-end {
        text-align: right
    }

    div.dt-container div.dt-layout-cell:empty {
        display: none
    }

    div.dt-container .dt-search input {
        border: 1px solid #aaa;
        border-radius: 10px;
        padding: 5px;
        background-color: transparent;
        color: transparent;

        margin-left: 10px
    }

    div.dt-container .dt-input {
        border: 1px solid #aaa;
        border-radius: 3px;
        padding: 5px;
        background-color: transparent;
        color: inherit
    }

    div.dt-container select.dt-input {
        padding: 4px;

        margin-right: 10px;
        border-radius: 10px;


    }

    div.dt-container .dt-paging .dt-paging-button {
        box-sizing: border-box;
        display: inline-block;
        min-width: 1.5em;
        padding: .5em 1em;
        margin-left: 2px;
        text-align: center;
        text-decoration: none !important;
        cursor: pointer;
        color: inherit !important;
        border: 1px solid transparent;
        border-radius: 10px;
        background: transparent
    }

    div.dt-container .dt-paging .dt-paging-button.current,
    div.dt-container .dt-paging .dt-paging-button.current:hover {
        color: inherit !important;
        border: 1px solid rgba(0, 0, 0, 0.3);
        background-color: rgba(0, 0, 0, 0.05);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, rgba(230, 230, 230, 0.05)), color-stop(100%, rgba(0, 0, 0, 0.05)));
        background: -webkit-linear-gradient(top, rgba(230, 230, 230, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%);
        background: -moz-linear-gradient(top, rgba(230, 230, 230, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%);
        background: -ms-linear-gradient(top, rgba(230, 230, 230, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%);
        background: -o-linear-gradient(top, rgba(230, 230, 230, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%);
        background: linear-gradient(to bottom, rgba(230, 230, 230, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%)
    }

    div.dt-container .dt-paging .dt-paging-button.disabled,
    div.dt-container .dt-paging .dt-paging-button.disabled:hover,
    div.dt-container .dt-paging .dt-paging-button.disabled:active {
        cursor: default;
        color: rgba(0, 0, 0, 0.5) !important;
        border: 1px solid transparent;
        background: transparent;
        box-shadow: none
    }

    div.dt-container .dt-paging .dt-paging-button:hover {
        color: white !important;
        border: 1px solid #111;
        background-color: #111;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #585858), color-stop(100%, #111));
        background: -webkit-linear-gradient(top, #585858 0%, #111 100%);
        background: -moz-linear-gradient(top, #585858 0%, #111 100%);
        background: -ms-linear-gradient(top, #585858 0%, #111 100%);
        background: -o-linear-gradient(top, #585858 0%, #111 100%);
        background: linear-gradient(to bottom, #585858 0%, #111 100%)
    }

    div.dt-container .dt-paging .dt-paging-button:active {
        outline: none;
        background-color: #0c0c0c;
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2b2b2b), color-stop(100%, #0c0c0c));
        background: -webkit-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -moz-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -ms-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: -o-linear-gradient(top, #2b2b2b 0%, #0c0c0c 100%);
        background: linear-gradient(to bottom, #2b2b2b 0%, #0c0c0c 100%);
        box-shadow: inset 0 0 3px #111
    }

    div.dt-container .dt-paging .ellipsis {
        padding: 0 1em
    }

    div.dt-container .dt-length,
    div.dt-container .dt-search,
    div.dt-container .dt-info,
    div.dt-container .dt-processing,
    div.dt-container .dt-paging {
        color: inherit;
        margin-left: 10px;
        margin-right: 10px;
    }

    div.dt-container .dataTables_scroll {
        clear: both
    }

    div.dt-container .dataTables_scroll div.dt-scroll-body {
        -webkit-overflow-scrolling: touch
    }

    div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td {
        vertical-align: middle
    }

    div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>th>div.dataTables_sizing,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>thead>tr>td>div.dataTables_sizing,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>th>div.dataTables_sizing,
    div.dt-container .dataTables_scroll div.dt-scroll-body>table>tbody>tr>td>div.dataTables_sizing {
        height: 0;
        overflow: hidden;
        margin: 0 !important;
        padding: 0 !important
    }

    div.dt-container.dt-empty-footer tbody>tr:last-child>* {
        border-bottom: 1px solid rgba(0, 0, 0, 0.3)
    }

    div.dt-container.dt-empty-footer .dt-scroll-body {
        border-bottom: 1px solid rgba(0, 0, 0, 0.3)
    }

    div.dt-container.dt-empty-footer .dt-scroll-body tbody>tr:last-child>* {
        border-bottom: none
    }

    @media screen and (max-width: 767px) {
        div.dt-container div.dt-layout-row {
            display: block
        }

        div.dt-container div.dt-layout-cell {
            display: block
        }

        div.dt-container div.dt-layout-cell.dt-full,
        div.dt-container div.dt-layout-cell.dt-start,
        div.dt-container div.dt-layout-cell.dt-end {
            text-align: center
        }
    }

    @media screen and (max-width: 640px) {

        .dt-container .dt-length,
        .dt-container .dt-search {
            float: none;
            text-align: center
        }

        .dt-container .dt-search {
            margin-top: .5em
        }
    }

    html.dark {
        --dt-row-hover: 255, 255, 255;
        --dt-row-stripe: 255, 255, 255;
        --dt-column-ordering: 255, 255, 255
    }

    html.dark table.dataTable>thead>tr>th,
    html.dark table.dataTable>thead>tr>td {
        border-bottom: 1px solid rgb(89, 91, 94)
    }

    html.dark table.dataTable>thead>tr>th:active,
    html.dark table.dataTable>thead>tr>td:active {
        outline: none
    }

    html.dark table.dataTable>tfoot>tr>th,
    html.dark table.dataTable>tfoot>tr>td {
        border-top: 1px solid rgb(89, 91, 94)
    }

    html.dark table.dataTable.row-border>tbody>tr>*,
    html.dark table.dataTable.display>tbody>tr>* {
        border-top: 1px solid rgb(64, 67, 70)
    }

    html.dark table.dataTable.row-border>tbody>tr:first-child>*,
    html.dark table.dataTable.display>tbody>tr:first-child>* {
        border-top: none
    }

    html.dark table.dataTable.row-border>tbody>tr.selected+tr.selected>td,
    html.dark table.dataTable.display>tbody>tr.selected+tr.selected>td {
        border-top-color: rgba(13, 110, 253, 0.65);
        border-top-color: rgba(var(--dt-row-selected), 0.65)
    }

    html.dark table.dataTable.cell-border>tbody>tr>th,
    html.dark table.dataTable.cell-border>tbody>tr>td {
        border-top: 1px solid rgb(64, 67, 70);
        border-right: 1px solid rgb(64, 67, 70)
    }

    html.dark table.dataTable.cell-border>tbody>tr>th:first-child,
    html.dark table.dataTable.cell-border>tbody>tr>td:first-child {
        border-left: 1px solid rgb(64, 67, 70)
    }

    html.dark .dt-container.dt-empty-footer table.dataTable {
        border-bottom: 1px solid rgb(89, 91, 94)
    }

    html.dark .dt-container .dt-search input,
    html.dark .dt-container .dt-length select {
        border: 1px solid rgba(255, 255, 255, 0.2);
        background-color: var(--dt-html-background)
    }

    html.dark .dt-container .dt-paging .dt-paging-button.current,
    html.dark .dt-container .dt-paging .dt-paging-button.current:hover {
        border: 1px solid rgb(89, 91, 94);
        background: rgba(255, 255, 255, 0.15)
    }

    html.dark .dt-container .dt-paging .dt-paging-button.disabled,
    html.dark .dt-container .dt-paging .dt-paging-button.disabled:hover,
    html.dark .dt-container .dt-paging .dt-paging-button.disabled:active {
        color: #666 !important
    }

    html.dark .dt-container .dt-paging .dt-paging-button:hover {
        border: 1px solid rgb(53, 53, 53);
        background: rgb(53, 53, 53)
    }

    html.dark .dt-container .dt-paging .dt-paging-button:active {
        background: #3a3a3a
    }

    *[dir=rtl] table.dataTable thead th,
    *[dir=rtl] table.dataTable thead td,
    *[dir=rtl] table.dataTable tfoot th,
    *[dir=rtl] table.dataTable tfoot td {
        text-align: right
    }

    *[dir=rtl] table.dataTable th.dt-type-numeric,
    *[dir=rtl] table.dataTable th.dt-type-date,
    *[dir=rtl] table.dataTable td.dt-type-numeric,
    *[dir=rtl] table.dataTable td.dt-type-date {
        text-align: left
    }

    *[dir=rtl] div.dt-container div.dt-layout-cell.dt-start {
        text-align: right
    }

    *[dir=rtl] div.dt-container div.dt-layout-cell.dt-end {
        text-align: left
    }

    *[dir=rtl] div.dt-container div.dt-search input {
        margin: 0 3px 0 0
    }
</style>



<script src="{{ asset('assets/js/dashboard.js') }}"></script>