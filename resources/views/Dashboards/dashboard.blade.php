@extends('master')
@section("app-mid")

<div class="app-main">
      <div class="main-header-line">
        <h1>Ecole supérieure de technologie - Dashboard</h1>
        <div class="action-buttons">
          <button class="open-right-area">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-activity">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
            </svg>
          </button>
          <button class="menu-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
              <line x1="3" y1="12" x2="21" y2="12"></line>
              <line x1="3" y1="6" x2="21" y2="6"></line>
              <line x1="3" y1="18" x2="21" y2="18"></line>
            </svg>
          </button>
        </div>
      </div>
      <div class="chart-row three">
        <div class="chart-container-wrapper">
          <div class="chart-container">
            <div class="chart-info-wrapper">
              <h2>taux d'assiduité</h2>
              <span>15 h</span>
            </div>
            <div class="chart-svg">
              <svg viewBox="0 0 36 36" class="circular-chart pink">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <path class="circle" stroke-dasharray="30, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <text x="18" y="20.35" class="percentage">90%</text>
              </svg>
            </div>
          </div>
        </div>
        <div class="chart-container-wrapper">
          <div class="chart-container">
            <div class="chart-info-wrapper">
              <h2>Rank</h2>
              <span>2nd</span>
            </div>
            <div class="chart-svg">
              <svg viewBox="0 0 36 36" class="circular-chart blue">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <path class="circle" stroke-dasharray="60, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <text x="18" y="20.35" class="percentage">60%</text>
              </svg>
            </div>
          </div>
        </div>
        <div class="chart-container-wrapper">
          <div class="chart-container">
            <div class="chart-info-wrapper">
              <h2>cursus</h2>
              <span>24/28 module</span>
            </div>
            <div class="chart-svg">
              <svg viewBox="0 0 36 36" class="circular-chart orange">
                <path class="circle-bg" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <path class="circle" stroke-dasharray="90, 100" d="M18 2.0845
          a 15.9155 15.9155 0 0 1 0 31.831
          a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                <text x="18" y="20.35" class="percentage">90%</text>
              </svg>
            </div>
          </div>
        </div>
      </div>
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
          <div class="chart-container applicants">
            <div class="chart-container-header">
              <h2>Staff</h2>
              <span></span>
            </div>
            <div class="applicant-line">
              <img src="https://images.unsplash.com/photo-1587628604439-3b9a0aa7a163?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MjB8fHdvbWFufGVufDB8fDB8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=900&amp;q=60" alt="profile">
              <div class="applicant-info">
                <span>Emma Ray</span>
                <p>Applied for <strong>Product Designer</strong></p>
              </div>
            </div>
            <div class="applicant-line">
              <img src="https://images.unsplash.com/photo-1583195764036-6dc248ac07d9?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2555&amp;q=80" alt="profile">
              <div class="applicant-info">
                <span>A.Kasmi</span>
                <p>technicien<strong>Developer</strong></p>
              </div>
            </div>
            <div class="applicant-line">
            <img src="https://images.unsplash.com/photo-1543965170-4c01a586684e?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=2232&amp;q=80" alt="profile">

              <div class="applicant-info">
                <span>T.Boughalem</span>
                <p>technicien<strong>Developer</strong></p>
              </div>
            </div>
            <div class="applicant-line">
              <img src="https://images.unsplash.com/photo-1596815064285-45ed8a9c0463?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=1215&amp;q=80" alt="profile">
              <div class="applicant-info">
                <span>A.Rachida</span>
                <p>technicien<strong>Finance</strong></p>
              </div>
            </div>
            <div class="applicant-line">
            <img src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MzV8fHdvbWFufGVufDB8fDB8&amp;ixlib=rb-1.2.1&amp;auto=format&amp;fit=crop&amp;w=900&amp;q=60" alt="profile">

              <div class="applicant-info">
                 <span>O.Boumandi</span>
                 <p>technicien<strong>chargé de communication</strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection