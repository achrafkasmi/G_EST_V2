 <div class="app-right">
   <button class="close-right">
     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
       <line x1="18" y1="6" x2="6" y2="18"></line>
       <line x1="6" y1="6" x2="18" y2="18"></line>
     </svg>
   </button>
   <div class="profile-box">
     <div class="profile-photo-wrapper">
       <img alt="{{ auth()->user()->name}}" @if(auth()->user()->image) src="{{ Storage::url(auth()->user()->image) }}" @else src="profile.PNG" @endif
       class="dense-image dense-loading">
     </div>
     <form id="logout-form" action="{{ route('AUTH-LOGOUT') }}" method="POST" class="d-none">
       @csrf
     </form>

     <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
       <svg class="logout-icon" width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
         <path class="logout-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M29,18c0,7.2-5.8,13-13,13S3,25.2,3,18c0-5.5,3.5-10.4,8.7-12.3c0.5-0.2,1.1,0.1,1.3,0.6 c0.2,0.5-0.1,1.1-0.6,1.3C8,9.2,5,13.3,5,18c0,6.1,4.9,11,11,11s11-4.9,11-11c0-4.7-3-8.8-7.3-10.4c-0.5-0.2-0.8-0.8-0.6-1.3 c0.2-0.5,0.8-0.8,1.3-0.6C25.5,7.6,29,12.5,29,18z" />
         <path class="logout-fill" fill="{{ auth()->check() ? 'green' : 'yellow' }}" d="M17,2v10c0,0.5-0.5,1-1,1s-1-0.5-1-1V2c0-0.5,0.5-1,1-1S17,1.5,17,2z" />
       </svg>
     </a>
     <p class="profile-text">{{ auth()->user()->name ?? 'Connecter Vous!' }}</p>
     <p class="profile-subtext">
       @foreach(auth()->user()->roles as $role)
       {{ $role->name }}
       @endforeach
     </p>
   </div>
   <div class="app-right-content">
     <div class="app-right-section">
       <div class="app-right-section-header">
         <h2>Messages</h2>
         <span class="notification-active">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
             <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
           </svg>
         </span>
       </div>
       <div class="message-line">
         <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2250&amp;q=80" alt="profile">
         <div class="message-text-wrapper">
           <p class="message-text">A.Rachida</p>
           <p class="message-subtext">LP-GC Une séance a été programmé le 23 Mars a 08:30.</p>
         </div>
       </div>
       <div class="message-line">
         <img src="535.JPEG" alt="profile picture 1">
         <div class="message-text-wrapper">
           <p class="message-text">A.Kasmi</p>
           <p class="message-subtext">Les Notes S1-S3-S5 Sont disponibles sur la plateforme</p>
         </div>
       </div>
       <div class="message-line">
         <img src="taha.PNG" alt="profile picture 2">
         <div class="message-text-wrapper">
           <p class="message-text">T.Boughalem</p>
           <p class="message-subtext">les cartes sim INWI CAMPUS CONNECTE sont disponible auprès du service de scolarité</p>
         </div>
       </div>
     </div>
     <div class="app-right-section">
       <div class="app-right-section-header">
         <h2>Notifications</h2>
         <span class="notification-active">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
             <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
             <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
           </svg>
         </span>
       </div>

       @if(auth()->user()->hasRole('student') && auth()->user()->etudiant)
       @foreach(auth()->user()->etudiant->notifications as $notification)
       <div class="activity-line">
         <span class="activity-icon applicant">
           <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus">
             <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
             <polyline points="14 2 14 8 20 8"></polyline>
             <line x1="12" y1="18" x2="12" y2="12"></line>
             <line x1="9" y1="15" x2="15" y2="15"></line>
           </svg>
         </span>
         <div class="activity-text-wrapper">
           <p class="activity-text">L'encadrant <strong>{{ $notification->user->name }}</strong>: {{ $notification->text_message }}</p>
         </div>
       </div>
       @endforeach
       @endif
     </div>
   </div>
 </div>
 <style>
   .logout-icon {
     position: relative;
     bottom: 100px;
     left: 35px;
     /* Adjust as needed */
   }

   .logout-icon:hover .logout-fill {
     fill: red;
     /* Change to the desired red color */
   }
 </style>