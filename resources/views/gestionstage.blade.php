<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


@extends('master')

@section("app-mid")



<div class="app-main">
   @include('tiles.actions')
   <div class="datatabcontainer mt-4">
      <table class="tab" id="myTable">

         <thead>
            <tr>
               <th>Nom complet</th>
               <th>Type de stage</th>
               <th>Dossier de stage</th>
               <th>Rapport</th>
               <th>Statut encadrant</th>
               <th>Actions</th>
            </tr>
         </thead>
         <tbody>
            @if(session('success'))
            <script>
               Swal.fire({
                  icon: 'success',
                  title: 'Success!',
                  text: '{{ session('
                  success ') }}',
               });
            </script>
            @endif
            @foreach($dossierStages as $dossierStage)
            <tr>
               <td>{{ $dossierStage->etudiant->nom_fr. " " .$dossierStage->etudiant->prenom_fr}}</td>
               <td>{{ $dossierStage->type_dossier }}</td>
               <td><a href="{{ Storage::url($dossierStage->dossier_stage)}}" target="_blank">click here</a></td>
               <td><a href="{{ Storage::url($dossierStage->rapport) }}" target="_blank">click here </a></td>

               @if($dossierStage->validation_prof)

               <td>
                  <svg width="24px" height="24px" viewBox="0 0 48 48" version="1" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 48 48">
                     <circle fill="#4CAF50" cx="24" cy="24" r="21" />
                     <polygon fill="#CCFF90" points="34.6,14.6 21,28.2 15.4,22.6 12.6,25.4 21,33.8 37.4,17.4" />
                  </svg>

               </td>
               @else

               <td>
                  <svg height="24px" width="24px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
                     <style type="text/css">
                        .st0 {
                           fill: #FF0000;
                        }
                     </style>
                     <g>
                        <path class="st0" d="M387.187,68.12c-4.226,0-8.328,0.524-12.249,1.511V55.44c0-27.622-22.472-50.094-50.094-50.094
		c-10.293,0-19.865,3.123-27.834,8.461C288.017,5.252,275.869,0,262.508,0c-22.84,0-42.156,15.365-48.16,36.302
		c-5.268-1.887-10.935-2.912-16.844-2.912c-27.622,0-50.094,22.472-50.094,50.094v82.984c-5.996-2.332-12.508-3.616-19.318-3.616
		c-29.43,0-53.373,23.936-53.373,53.366v99.695c0,63.299,38.525,185.645,184.315,195.649c4.274,0.289,8.586,0.438,12.813,0.438
		c91.218,0,165.435-72.378,165.435-161.35V118.214C437.281,90.592,414.81,68.12,387.187,68.12z M271.846,483.947
		c-3.585,0-7.209-0.126-10.896-0.376c-134.659-9.237-158.179-126.668-158.179-167.659v-99.695c0-13.979,11.341-25.313,25.32-25.313
		c13.98,0,25.321,11.334,25.321,25.313v76.997h22.05V83.485c0-12.172,9.87-22.042,22.041-22.042c12.172,0,22.042,9.87,22.042,22.042
		v152.959h20.922V50.094c0-12.172,9.87-22.041,22.041-22.041c12.172,0,22.042,9.87,22.042,22.041v186.35h18.253V55.44
		c0-12.172,9.87-22.041,22.042-22.041c12.171,0,22.041,9.87,22.041,22.041v181.004h18.261v-118.23
		c0-12.172,9.87-22.042,22.041-22.042c12.172,0,22.042,9.87,22.042,22.042V350.65C409.229,419.748,353.445,483.947,271.846,483.947z
		" />
                     </g>
                  </svg>
               </td>
               @endif

               <td>
                  @if($dossierStage->validation_prof && $dossierStage->validation_admin)
                  <a href="{{ route('approve-dossier', $dossierStage->id)}}">
                     <svg width="24px" height="24px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="48" height="48" fill="white" fill-opacity="0.01" />
                        <path d="M44 24C44 35.0457 35.0457 44 24 44C18.0265 44 4 44 4 44C4 44 4 29.0722 4 24C4 12.9543 12.9543 4 24 4C35.0457 4 44 12.9543 44 24Z" fill="#2F88FF" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14 26L20.0001 32L33.0001 19" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                     </svg>
                  </a>
                  @elseif($dossierStage->validation_prof)
                  <a href="{{ route('approve-dossier', $dossierStage->id)}}" title="Approve" onclick="approveStage(1)">
                     <svg class="approve" width="24" height="24" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <path class="approve-fill" fill="{{ auth()->check() ? 'black' : 'yellow' }}" d="M26,24c-0.553,0-1,0.448-1,1v4H7V3h10v7c0,0.552,0.447,1,1,1h7v4c0,0.552,0.447,1,1,1s1-0.448,1-1v-4.903    c0.003-0.033,0.02-0.063,0.02-0.097c0-0.337-0.166-0.635-0.421-0.816l-7.892-7.891c-0.086-0.085-0.187-0.147-0.292-0.195    c-0.031-0.015-0.063-0.023-0.097-0.034c-0.082-0.028-0.166-0.045-0.253-0.05C18.043,1.012,18.022,1,18,1H6C5.447,1,5,1.448,5,2v28    c0,0.552,0.447,1,1,1h20c0.553,0,1-0.448,1-1v-5C27,24.448,26.553,24,26,24z M19,9V4.414L23.586,9H19z" />
                        <path class="approve-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M30.73,15.317c-0.379-0.404-1.01-0.424-1.414-0.047l-10.004,9.36l-4.629-4.332c-0.404-0.378-1.036-0.357-1.414,0.047    c-0.377,0.403-0.356,1.036,0.047,1.413l5.313,4.971c0.192,0.18,0.438,0.27,0.684,0.27s0.491-0.09,0.684-0.27l10.688-10    C31.087,16.353,31.107,15.72,30.73,15.317z" />
                     </svg>
                  </a>
                  @endif
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>

</div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>


<script>
   let table = new DataTable('#myTable');

   // Function to approve a stage
   function approveStage(rowId) {
      // Implement your approve logic here
      alert("Stage approved for row " + rowId);
   }
</script>


@endsection