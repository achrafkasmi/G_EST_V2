@extends('master')
@section("app-mid")

<div class="app-main">
  @include('tiles.actions')
  @if(auth()->user() && auth()->user()->hasRole('student'))
  <div class="chart-row three" id="chart-row">
    <div class="chart-container-wrapper">
      <div class="chart-container">
        <div class="chart-info-wrapper">
          <h2>taux d'assiduité</h2>
          <span>--h</span>
        </div>
        <div class="chart-svg">
          <svg viewBox="0 0 36 36" class="circular-chart pink">
            <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="100, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage">--%</text>
          </svg>
        </div>
      </div>
    </div>
    <div class="chart-container-wrapper">
      <div class="chart-container">
        <div class="chart-info-wrapper">
          <h2>Rank</h2>
          <span>--</span>
        </div>
        <div class="chart-svg">
          <svg viewBox="0 0 36 36" class="circular-chart blue">
            <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="100, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage">--%</text>
          </svg>
        </div>
      </div>
    </div>
    <div class="chart-container-wrapper">
      <div class="chart-container">
        <div class="chart-info-wrapper">
          <h2>cursus</h2>
          <span>--/--</span>
        </div>
        <div class="chart-svg">
          <svg viewBox="0 0 36 36" class="circular-chart orange">
            <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="100, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage">--%</text>
          </svg>
        </div>
      </div>
    </div>
  </div>

  <div class="program-container" id="program-container">
    <h4 class="header-ds"style="color:grey;"><b>Nouveautés</b></h4>
  </div>

  @else

  <div class="chart-row two">
    <div class="chart-container-wrapper big">
      <div class="chart-container">
        <div class="chart-container-header">
          <h2>Nombre des Etudiants inscrits</h2>
          <span>par année universitaire</span>
        </div>
        <div class="line-chart">
          <div class="chartjs-size-monitor">
            <div class="chartjs-size-monitor-expand">
              <div class=""></div>
            </div>
            <div class="chartjs-size-monitor-shrink">
              <div class=""></div>
            </div>
          </div>
          <canvas id="chart" width="932" height="466" style="display: block; height: 233px; width: 466px;" class="chartjs-render-monitor"></canvas>
        </div>
        <div class="chart-data-details">
          <div class="chart-details-header"></div>
        </div>
      </div>
    </div>
    <div class="chart-container-wrapper small">
      <div class="chart-container">
        <div class="chart-container-header">
          <h2>Acquisitions</h2>
          <span href="#">Cette année</span>
        </div>
        <div class="acquisitions-bar">
          <span class="bar-progress rejected" style="width:8%;"></span>
          <span class="bar-progress on-hold" style="width:10%;"></span>
          <span class="bar-progress shortlisted" style="width:18%;"></span>
          <span class="bar-progress applications" style="width:64%;"></span>
        </div>
        <div class="progress-bar-info">
          <span class="progress-color applications"></span>
          <span class="progress-type">Applications</span>
          <span class="progress-amount">64%</span>
        </div>
        <div class="progress-bar-info">
          <span class="progress-color shortlisted"></span>
          <span class="progress-type">Shortlisted</span>
          <span class="progress-amount">18%</span>
        </div>
        <div class="progress-bar-info">
          <span class="progress-color on-hold"></span>
          <span class="progress-type">On-hold</span>
          <span class="progress-amount">10%</span>
        </div>
        <div class="progress-bar-info">
          <span class="progress-color rejected"></span>
          <span class="progress-type">Rejected</span>
          <span class="progress-amount">8%</span>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#program-container').click(function() {
      $('.chart-container-wrapper').fadeOut(600);
      $('#chart-row').slideUp(600);
    });

    // Revert action when clicking outside the program-container
    $(document).click(function(e) {
      if (!$(e.target).closest('#program-container').length) {
        $('.chart-container-wrapper').fadeIn(600);
        $('#chart-row').slideDown(600);
      }
    });
  });
</script>
@endsection
