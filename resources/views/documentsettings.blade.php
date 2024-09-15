@extends('master')
@section("app-mid")
<title>Document Settings</title>
<div class="app-main">
  @include('tiles.actions')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <a href="{{ route('documents.index') }}">
    <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
  </a>

  <!-- Active Documents Table -->
  <div class="datatabcontainerr mt-4">
    <table class="tab" id="documentsTable">
      <thead>
        <tr>
          <th>Intitule</th>
          <th>Destination</th>
          <th>Document</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($documents as $document)
        <tr>
          <td>{{ $document->intitule_document }}</td>
          <td>{{ $document->type_document }}</td>
          <td>
            <a href="{{ Storage::url($document->document) }}" target="_blank">View PDF</a>
          </td>
          <td>{{ $document->created_at->format('Y-m-d') }}</td>

          <td>
            <a href="javascript:void(0)" class="archive-document" data-id="{{ $document->id }}">
              <img src="{{ asset($document->is_archived ? 'offline.svg' : 'online.svg') }}" alt="Archive" width="12px" height="12px">
            </a>

           <!-- <a href="javascript:void(0)" class="delete-document " data-id="{{ $document->id }}">
              <img src="{{ asset('recyclebin.svg') }}" alt="Delete" width="20px" height="20px">
            </a>-->

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</div>

<!-- Include jQuery and DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>

<script>
  $(document).ready(function() {
    $('#documentsTable').DataTable();
  });

  // Archive/Unarchive document
  $(document).on('click', '.archive-document', function() {
    let documentId = $(this).data('id');
    let token = $('meta[name="csrf-token"]').attr('content');
    let $icon = $(this).find('img');

    Swal.fire({
      title: 'Are you sure?',
      text: "You are about to archive/unarchive this document.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, proceed!',
      cancelButtonText: 'No, cancel!',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/documents/archive/' + documentId,
          type: 'POST',
          data: {
            _token: token,
          },
          success: function(response) {
            if (response.success) {
              if (response.is_archived) {
                $icon.attr('src', "{{ asset('offline.svg') }}");
              } else {
                $icon.attr('src', "{{ asset('online.svg') }}");
              }

              Swal.fire({
                title: 'Success!',
                text: 'Document status has been updated.',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false,
              });
            }
          },
          error: function() {
            Swal.fire('Error!', 'Unable to update the document status.', 'error');
          }
        });
      }
    });
  });

  // Delete document
  $(document).on('click', '.delete-document', function() {
    let documentId = $(this).data('id');
    let token = $('meta[name="csrf-token"]').attr('content');

    Swal.fire({
      title: 'Are you sure?',
      text: "This action will permanently delete the document.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: '/documents/delete/' + documentId,
          type: 'DELETE',
          data: {
            _token: token,
          },
          success: function(response) {
            if (response.success) {
              Swal.fire('Deleted!', 'The document has been deleted.', 'success');
              location.reload(); // Reload page to update view
            }
          },
          error: function() {
            Swal.fire('Error!', 'Unable to delete the document.', 'error');
          }
        });
      }
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
    margin-top: 1%;
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