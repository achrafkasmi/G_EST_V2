<div class="app-left">
  <button class="close-menu">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  </button>
  <div class="app-logo">
    <img src="logoESTwhite.png" alt="Your Logo" width="60" height="60">
    <span>EST-FBS</span>
  </div>
  <ul class="nav-list">
    <li class="nav-list-item  @if($active_tab === 'dash') active @endif">
      <a class="nav-list-link" href="http://127.0.0.1:8000/dash">
        <img src="dashboard.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Dashboard
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'library') active @endif" >
      <a class="pop-cont nav-list-link" href="http://127.0.0.1:8000/library">
        <img src="bibliotheque.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Bibliotheque
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
    @if(auth()->user() && auth()->user()->hasRole('teacher')|| auth()->user()->hasRole('student'))
    <li class="nav-list-item @if($active_tab == 'documents') active @endif" >
      <a class=" nav-list-link" href="http://127.0.0.1:8000/documents">
        <img src="e-doc.PNG" alt="e-documentys" width="28" height="28" style="margin-right: 10px;" />
        E-documents
      </a>
    </li>
    @endif
    @if(auth()->user() && auth()->user()->hasRole('student'))
    <li class="nav-list-item @if($active_tab == 'messtages') active @endif" >
      <a class="nav-list-link" href="http://127.0.0.1:8000/messtages">
        <img src="documentsdestage.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Dossier de Stage
      </a>
    </li>
    @endif
    <li class="nav-list-item">
      <a class="pop-cont nav-list-link @if($active_tab == 'planning') active @endif" href="#" >
        <img src="calendar.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Plannings examens
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
   
    <!--haaadi nfakrek fiha❌-->
    @if(auth()->user() && auth()->user()->hasRole('admin'))
    <li class="nav-list-item @if($active_tab == 'team') active @endif" >
      <a class="pop-cont nav-list-link" href="#">
        <img src="team.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Team
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'historisation') active @endif" >
      <a class="pop-cont nav-list-link" href="#">
        <img src="reports.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Rapports
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'checkstage') active @endif"  >
      <a class="pop-cont nav-list-link" href="#" >
        <img src="historisation.PNG" alt="checkstage" width="28" height="28" style="margin-right: 10px;" />
        Historisation
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'gestionstage') active @endif"  >
      <a class="nav-list-link" href="http://127.0.0.1:8000/stages">
        <img src="checkstage.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Gestion Des Stages
        
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'addusers') active @endif"  >
      <a class="nav-list-link" href="http://127.0.0.1:8000/addUser">
        <img src="adduser.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Add Users
      </a>
    </li>
    <li class="nav-list-item "  >
      <a class="pop-cont nav-list-link" href="#">
        <img src="notice.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Add Notice.
        <span class="pop-up">Ce Service est en cours de développement...</span>
      </a>
    </li>
    <li class="nav-list-item @if($active_tab == 'addedoc') active @endif"  >
      <a class="nav-list-link" href="http://127.0.0.1:8000/managedocuments">
        <img src="addEdoc.PNG" alt="historisation" width="28" height="28" style="margin-right: 10px;" />
        Add E-document.
      </a>
    </li>
    @endif
  </ul>

</div>

<style>
  .app-left {
    flex-basis: 240px;
    background-color: var(--app-bg-dark);
    height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 24px 0;
    transition: all 0.4s ease-in;

    &.show {
      right: 0;
      opacity: 1;
    }
  }

  /*pop up message from here*/
  * {
    margin: 0;
    border: 0;
    padding: 0;
    font-family: sans-serif;
  }

  .container {
    width: 100%;
    text-align: center;
    margin-top: 100px
  }

  .pop-cont {
    position: relative;

    cursor: pointer;
    user-select: none;
  }

  .pop-cont:hover {
    color: #129fea;
    transition: .6s
  }

  .pop-up {
    background-color: #888;
    padding: 4px 8px;
    /* Adjust the padding for a smaller popup */
    color: white;
    font-weight: lighter;
    border-radius: 8px;
    position: absolute;
    width: 180px;
    /* Adjust the width */
    font-size: 14px;
    /* Adjust the font size */
    right: 50%;
    left: 10%;
    margin-right: -90px;
    /* Adjust the margin-right to center the popup */
    /* Adjust the top position */
    display: none;
  }

  /*.display-js{
      display: block;
  }*/
  .pop-up:after {
    content: "";
    position: absolute;
    border-top: 15px solid #888;
    border-right: 10px solid rgba(0, 0, 0, 0);
    border-left: 10px solid rgba(0, 0, 0, 0);
    bottom: -15px;
    right: 46%
  }

  .pop-up {
    animation-fill-mode: forwards;
    animation-name: move;
    animation-duration: .2s;
    animation-timing-function: ease-out
  }

  @keyframes move {
    from {
      transform: scale(0);
      top: 15px;
      opacity: .3
    }

    to {
      transform: scale(1);
      top: -65px;
      opacity: 1
    }
  }
</style>


<script>
  // Get all elements with class 'pop-cont'
  var popupContainers = document.querySelectorAll('.pop-cont');

  // Variable to keep track of the currently displayed popup
  var currentPopup = null;

  // Iterate through each 'pop-cont' element
  popupContainers.forEach(function(popupContainer) {
    // Get the corresponding '.pop-up' element within the current 'pop-cont'
    var popupBox = popupContainer.querySelector('.pop-up');

    // Add a click event listener to each 'pop-cont'
    popupContainer.onclick = function() {
      // Check if there is a currently displayed popup
      if (currentPopup !== null) {
        // Hide the currently displayed popup
        currentPopup.style.display = 'none';
      }

      // Toggle the display of the associated '.pop-up' element
      popupBox.style.display = (popupBox.style.display === 'none' || popupBox.style.display === '') ? 'block' : 'none';

      // Update the currently displayed popup
      currentPopup = popupBox;
    };
  });

  // Close the popup when clicking outside of it
  window.onclick = function(event) {
    // Check if the clicked element is neither a '.pop-cont' nor a '.pop-up'
    if (!event.target.matches('.pop-cont') && !event.target.matches('.pop-up')) {
      // Hide all '.pop-up' elements
      popupContainers.forEach(function(popupContainer) {
        var popupBox = popupContainer.querySelector('.pop-up');
        popupBox.style.display = 'none';
      });

      // Reset the currently displayed popup
      currentPopup = null;
    }
  };
</script>