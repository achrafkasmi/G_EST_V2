<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="app-right">
  <button class="close-right">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
      <line x1="18" y1="6" x2="6" y2="18"></line>
      <line x1="6" y1="6" x2="18" y2="18"></line>
    </svg>
  </button>
  <div class="profile-box">
    <div class="profile-photo-wrapper">
      <img alt="{{ auth()->user()->name}}" @if(auth()->user()->image) src="{{ Storage::url(auth()->user()->image) }}" @else src="/profile.PNG" @endif
      class="dense-image dense-loading">
    </div>
    <form id="logout-form" action="{{ route('AUTH-LOGOUT') }}" method="POST" class="d-none">
      @csrf
    </form>

    <a href="#" id="logout-button" onclick="logoutOnClick(event)">
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
    <!--<div class="app-right-section">
      <div class="app-right-section-header">
        <h2>Messages</h2>
        <span class="notification-active">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
          </svg>
        </span>
      </div>
      <div class="message-line">
        <img src="535.JPEG" alt="profile picture 1">
         <div class="message-text-wrapper">
           <p class="message-text">A.Kasmi</p>
           <p class="message-subtext">Les Notes S1-S3-S5 Sont disponibles sur la plateforme</p>
         </div>
      </div>
    </div>-->
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
      <div class="activity-line" onclick="showNotificationPopup('{{ $notification->id }}', '{{ $notification->text_message }}', '{{ $notification->voice_message_url }}')">
        <span class="activity-icon applicant">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
            <polyline points="14 2 14 8 20 8"></polyline>
            <line x1="12" y1="18" x2="12" y2="12"></line>
            <line x1="9" y1="15" x2="15" y2="15"></line>
          </svg>
        </span>
        <div class="activity-text-wrapper">
          <p class="activity-text"><strong>{{ $notification->user->name }}</strong>: {!! $notification->text_message !!}</p>
        </div>
      </div>
      @endforeach
      @endif
    </div>
  </div>
</div>
<!--<div id="notification-popup" class="notification-popup">
  <div class="notification-popup-inner">
    <div id="notification-popup-content" class="notification-popup-content"></div>
  </div>
  <button id="close-popup-btn" class="close-popup-btn">Close</button>
</div>

<script>
  function showNotificationPopup(message) {
    try {
      // Display the message in the popup
      var popupContent = document.getElementById('notification-popup-content');
      popupContent.innerHTML = message;
      document.getElementById('notification-popup').style.display = 'block';
    } catch (error) {
      console.error('Error displaying notification popup:', error);
    }
  }
  // Close the popup when close button is clicked

  document.getElementById('close-popup-btn').addEventListener('click', function() {
    var popup = document.getElementById('notification-popup');
    popup.style.animation = 'popupFadeOut 0.3s ease forwards';
    setTimeout(function() {
      popup.style.display = 'none';
      popup.style.animation = ''; // Reset animation
    }, 300); // Match animation duration
  });
</script>-->
<div id="notification-popup" class="notification-popup">
  <div class="notification-popup-inner">
    <div id="notification-popup-content" class="notification-popup-content"></div>
  </div>
  <button id="close-popup-btn" class="close-popup-btn">Close</button>
</div>
<script>
  function showNotificationPopup(notificationId, message, audioUrl) {
    try {
      // Display the message and audio in the popup
      var popupContent = document.getElementById('notification-popup-content');
      popupContent.innerHTML = '<p>' + message + '</p>';

      if (audioUrl) {
        popupContent.innerHTML += '<audio controls><source src="' + audioUrl + '" type="audio/wav"></audio>';
      }

      // Set the data-notification-id attribute on the close button
      var closeButton = document.getElementById('close-popup-btn');
      closeButton.setAttribute('data-notification-id', notificationId);

      document.getElementById('notification-popup').style.display = 'block';
    } catch (error) {
      console.error('Error displaying notification popup:', error);
    }
  }

  // Close the popup when close button is clicked
  document.getElementById('close-popup-btn').addEventListener('click', function() {
    var notificationId = this.getAttribute('data-notification-id');

    // Update is_seen status
    submitNotificationForm(notificationId);

    var popup = document.getElementById('notification-popup');
    popup.style.animation = 'popupFadeOut 0.3s ease forwards';
    setTimeout(function() {
      popup.style.display = 'none';
      popup.style.animation = ''; // Reset animation
    }, 300); // Match animation duration
  });

  function submitNotificationForm(notificationId) {
    // Create a hidden form element
    var form = document.createElement('form');
    form.method = 'POST';
    form.action = '/mark-notification-as-seen/' + notificationId;
    form.style.display = 'none';

    // Add CSRF token field
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var csrfField = document.createElement('input');
    csrfField.type = 'hidden';
    csrfField.name = '_token';
    csrfField.value = csrfToken;
    form.appendChild(csrfField);

    // Add the form to the document body and submit it
    document.body.appendChild(form);
    form.submit();
  }
</script>








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

<style>
  .notification-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    min-width: 700px;
    max-height: 300px;
    transform: translate(-50%, -50%);
    background-color: rgba(52, 129, 210, 0.2);
    padding: 20px;
    border-radius: 15px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    z-index: 9999;
    animation: popupFadeIn 0.3s ease forwards;
  }


  .notification-popup-inner {
    max-height: 200px;
    /* Adjust as needed */
    min-height: 200px;
    overflow-y: auto;
    border-radius: 10px;
    padding: 10px;
    background-image: url('bgmessage.png');
    background-size: cover;
    /* This ensures the image covers the entire container */
    background-position: center;
    /* This centers the image within the container */
  }

  .notification-popup-content {
    color: darkslategray;
    /* White text color */
    font-size: 18px;
    /* Increased font size */
    padding: 0 20px;
    /* Adjust padding as needed */
  }

  .close-popup-btn {
    cursor: pointer;
    border: none;
    background: none;
    color: #007bff;
    margin-top: 20px;
    /* Increased top margin */
    animation: fadeIn 0.5s ease forwards;
    /* Fade-in animation for close button */
  }

  /* Animation keyframes */
  @keyframes popupFadeIn {
    from {
      opacity: 0;
      transform: translate(-50%, -50%) scale(0.5);
    }

    to {
      opacity: 1;
      transform: translate(-50%, -50%) scale(1);
    }
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }

    to {
      opacity: 1;
    }
  }

  /* Fade out animation for popup */
  @keyframes popupFadeOut {
    from {
      opacity: 1;
    }

    to {
      opacity: 0;
      transform: translate(-50%, -50%) scale(0.5);
    }
  }
</style>


<script>
  var logoutTimeout;

  var logoutInitiated = false;

  function logoutOnClick(event) {
    event.preventDefault();
    if (!logoutInitiated) {
      logoutInitiated = true;
      document.getElementById('logout-form').submit();
    }
  }

  function setLogoutYellow() {
    var logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
      logoutButton.classList.add('logout-yellow');
    }
  }

  function resetLogoutColor() {
    var logoutButton = document.getElementById('logout-button');
    if (logoutButton) {
      logoutButton.classList.remove('logout-yellow');
    }
  }

  // Listen for user interactions
  document.addEventListener('mousemove', function() {
    clearTimeout(logoutTimeout);
    resetLogoutColor();
    logoutTimeout = setTimeout(setLogoutYellow, 60000); // Set the timeout to 1 minute
  });

  // Initialize the timeout on page load
  logoutTimeout = setTimeout(setLogoutYellow, 60000); // Set the timeout to 1 minute
</script>
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

  .logout-yellow .logout-fill {
    fill: orangered;
    /* Change to the desired yellow color */
  }
</style>