

  var openRightArea = document.querySelector('.open-right-area');
  if (openRightArea) {
    openRightArea.addEventListener('click', function() {
      document.querySelector('.app-right').classList.add('show');
    });
  }

  var closeRight = document.querySelector('.close-right');
  if (closeRight) {
    closeRight.addEventListener('click', function() {
      document.querySelector('.app-right').classList.remove('show');
    });
  }

  var menuButton = document.querySelector('.menu-button');
  if (menuButton) {
    menuButton.addEventListener('click', function() {
      document.querySelector('.app-left').classList.add('show');
    });
  }

  var closeMenu = document.querySelector('.close-menu');
  if (closeMenu) {
    closeMenu.addEventListener('click', function() {
      document.querySelector('.app-left').classList.remove('show');
    });
  }


