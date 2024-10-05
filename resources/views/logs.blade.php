@extends('master')
@section("app-mid")
<title>Log</title>
<div class="app-main">
    @include('tiles.actions')
    <h1>Logs</h1>
    <div class="datatabcontainerr mt-4">
        <table class="tab" id="logsTable">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Operation</th>
                    <th>Model</th>
                    <th>Details</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>

<script>
    $(document).ready(function() {
        $('#logsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('logs.data') }}",
            columns: [
                { data: 'user_name', name: 'user_name' },
                { data: 'operation', name: 'operation' },
                { data: 'model', name: 'model' },
                { data: 'formatted_details', name: 'formatted_details' },
                { data: 'created_at', name: 'created_at' }
            ],
            scrollX: true // Enable horizontal scrolling
        });
    });
</script>

<style>
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
    border-collapse: collapse;
    width: 100%;
    overflow-x: auto; 
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