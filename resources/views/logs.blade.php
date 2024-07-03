@extends('master')
@section("app-mid")
<title>Log</title>
<div class="app-main">
    @include('tiles.actions')
    <h1>Logs</h1>
    <div class="datatabcontainer mt-4">
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
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->user->name }}</td>
                        <td>{{ $log->operation }}</td>
                        <td>{{ class_basename($log->model) }}</td>
                        <td>{{ $log->formatted_details }}</td>
                        <td>{{ $log->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
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

  .datatabcontainer {
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
