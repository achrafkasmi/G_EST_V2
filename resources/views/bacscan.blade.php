@extends('master')
@section("app-mid")

<!-- Include Dropify CSS from CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/dropify/dist/css/dropify.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<!-- Include jQuery from CDN (required for Dropify) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include Dropify JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/dropify/dist/js/dropify.min.js"></script>
<!-- Include jQuery and DataTables -->

<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>

<div class="app-main">
    @include('tiles.actions')

    <!-- Tabs Navigation -->
    <div class="tabs">
        <a href="{{ route('documents.index') }}">
            <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
        </a>
        <button class="tablinks" onclick="openTab(event, 'NewConceptTab1')">Aperçu</button>
        <button class="tablinks" onclick="openTab(event, 'NewConceptTab2')">Upload</button>
        <button class="tablinks" onclick="openTab(event, 'NewConceptTab3')">Management</button>
    </div>

    <!-- Tab Content -->

    <!-- Tab 1 -->
    <div class="datatabcontainerr tabcontent" id="NewConceptTab1" class="tabcontent">
        <table class="tab" id="bacTable">
            <thead>
                <tr>
                    <th>Document</th>
                    <th>Created At</th>
                    
                </tr>
            </thead>
            <tbody>

                <tr>
                    <td>click to view pdf</td>
                    <td>Created At</td>
                   
                </tr>

            </tbody>
        </table>
    </div>




    <!-- Tab 2 -->
    <div id="NewConceptTab2" class="tabcontent container form-container" style="display: none;">
        <div class="form-title">Upload Baccalaureates</div>
        <form action="{{ route('baccalaureates.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="year" class="form-label">year</label>
                <input type="number" id="year" name="year" required placeholder="Enter Year" class="form-control year-input" min="1900" max="2100">
            </div>
            <div class="form-group">
                <label for="pdf_file">Select Baccalaureate PDF:</label>
                <input class="form-control dropify" type="file" id="pdf_file" name="pdf_file" accept=".pdf" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn submit-btn">Upload Baccalaureates PDF</button>
            </div>
        </form>
    </div>

    <!-- Tab 3 -->
    <div id="NewConceptTab3" class="tabcontent" style="display: none;">
        <h2>Tab 3</h2>

    </div>
</div>

<script>
    // Function to handle tab switching
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none"; // Hide all tab content
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", ""); // Remove active class
        }
        document.getElementById(tabName).style.display = "block"; // Show the selected tab
        evt.currentTarget.className += " active"; // Add active class to the clicked tab

        // Store the active tab name in localStorage
        localStorage.setItem('activeTab', tabName);
    }

    $(document).ready(function() {
        // Check if there is an active tab stored in localStorage
        var activeTab = localStorage.getItem('activeTab') || 'NewConceptTab1';
        openTab(null, activeTab); // Open the stored tab or default to Tab 1
    });

    $(document).ready(function() {
        $('#bacTable').DataTable();
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize Dropify on file inputs with customized height
        $('#pdf_file').dropify({
            messages: {
                'default': 'Drag and drop a file here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Oops, something wrong happened.'
            }
        });
    });
</script>
<style>
    .dt-layout-row {
        color: #808080;
    }

    .dt-layout-cell.dt-end {
        color: grey;
    }

    .dt-column-order {
        color: rgba(0, 207, 222, 1);
    }

    .dt-column-title {
        color: #686D76;
    }

    .dt-paging {
        color: grey;
    }

    .datatabcontainer {
        background-color: var(--app-bg-dark);
        color: #fff;
        border-collapse: collapse;
        width: 100%;
    }

    .tab th,
    .tab td {
        padding: 8px;
        text-align: left;
    }

    /* Tabs styles */
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 50px;

    }

    .tablinks {
        padding: 10px;
        cursor: pointer;
        background-color: #f1f1f1;
        border: none;
        border-radius: 20px;
    }

    .tablinks.active {
        background-color: #d1d1d1;
        font-weight: bold;
    }

    .tabcontent {
        display: none;
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

    .form-label {
        color: #b8c2d3;
        font-size: 16px;
        margin-bottom: 5px;
        display: block;
    }

    .year-input {
        background-color: #394a6e;
        border: 1px solid #4d6396;
        border-radius: 8px;
        color: #b8c2d3;
        padding: 10px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .year-input:focus {
        background-color: #2f3c57;
        border-color: #007bff;
        outline: none;
    }

    .year-input::placeholder {
        color: #b8c2d3;
        opacity: 0.7;
    }
    tbody {
        
    color: grey;
  }

  .dt-layout-row {
    color: #808080;
  }

  .dt-layout-cell.dt-end {
    color: grey;
  }

  .dt-column-order {
    color: rgba(0, 207, 222, 1);
  }

  .dt-column-title {
    color: #686D76;
    white-space: nowrap;
  }

  .dt-paging {
    color: grey;
  }

  .datatabcontainerr {
    background-color: var(--app-bg-dark);
    color: #fff;
    margin-top: 1%;
    border-collapse: collapse;
    width: 100%;
    overflow-x: auto;
    border-radius: 15px;
  }

  .tab th,
  .tab td {
    padding: 8px;
    text-align: left;
    word-break: break-word;
  }

  .tab th {
    white-space: nowrap;
  }
</style>
@endsection