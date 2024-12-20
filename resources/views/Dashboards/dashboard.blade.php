@extends('master')
@section("app-mid")
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<title>Acceuil</title>
<div class="app-main">
  @include('tiles.actions')
  @if(auth()->user() && auth()->user()->hasRole('student'))
  <div class="chart-row three" id="chart-row">
    <div class="chart-container-wrapper">
      <div class="chart-container">
        <div class="chart-info-wrapper">
          <h2>taux d'assiduité</h2>
          <span>{{ $totalSessions }} sessions</span>
        </div>
        <div class="chart-svg">
          <svg viewBox="0 0 36 36" class="circular-chart pink">
            <path class="circle-bg" d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <path class="circle" stroke-dasharray="{{ $attendancePercentage }}, 100" d="M18 2.0845
                a 15.9155 15.9155 0 0 1 0 31.831
                a 15.9155 15.9155 0 0 1 0 -31.831"></path>
            <text x="18" y="20.35" class="percentage">{{ $attendancePercentage }}%</text>
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
    <h4 class="header-ds" style="color:grey;"><b>Nouveautés</b></h4>
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
          @foreach ($filieres as $index => $filiere)
          <span class="bar-progress" style="width:{{ $filiere->percentage }}%; background-color:{{ $colors[$index % count($colors)] }}"></span>
          @endforeach
        </div>
        @foreach ($filieres as $index => $filiere)
        <div class="progress-bar-info">
          <span class="progress-color" style="background-color:{{ $colors[$index % count($colors)] }}"></span>
          <span class="progress-type">{{ $filiere->filiere }}</span>
          <span class="progress-amount">{{ number_format($filiere->percentage, 2) }}%</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  <div class="datatabcontainer-updated  mt-6">
    <table class="tab" id="myTable">
      <thead>
        <div class="chart-container-header" style="padding:15px">
          <h2>Etudiants Actifs</h2>
          <span>par année universitaire</span>
        </div>
        <tr>
          <th>Nom Complet</th>
          <th>Cin</th>
          <th>Annee_uni</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($students as $student)
        <tr>

          <td>{{ $student->prenom_fr }} {{ $student->nom_fr }}</td>
          <td>{{ $student->cin }}</td>
          <td>{{ $student->annee_uni }}</td>

          <td>
            @if($student->is_active == 1)
            <a href="{{ route('retrait', ['id_etu' => $student->id]) }}">
              <svg width="28px" height="28px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.5" d="M12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22Z" fill="#1C274C" />
                <path d="M15 12.75C15.4142 12.75 15.75 12.4142 15.75 12C15.75 11.5858 15.4142 11.25 15 11.25H9C8.58579 11.25 8.25 11.5858 8.25 12C8.25 12.4142 8.58579 12.75 9 12.75H15Z" fill="red" />
              </svg>
            </a>
            <a href="{{ route('storelaureat', ['id_etu' => $student->id]) }}"> <!--if a student exist in table t_laureat means he is a laureat so iwant you to make this icon green if he is laureat-->
              <svg width="22px" height="22px" viewBox="0 -3 24 24" id="meteor-icon-kit__solid-graduation-cap" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.522074 5.12131C0.549569 5.10633 0.577846 5.09259 0.606828 5.08019L11.1724 0.27766C11.6982 0.03863 12.3018 0.03863 12.8276 0.27766L23.4138 5.08956C24.1954 5.44483 24.1954 6.555 23.4138 6.9103L12.8276 11.7222C12.3018 11.9612 11.6982 11.9612 11.1724 11.7222L2 7.5529V10.4999C2 11.0522 1.55228 11.4999 1 11.4999C0.447715 11.4999 0 11.0522 0 10.4999V5.99993C0 5.98437 0.000355195 5.9689 0.00105792 5.95352C0.015847 5.6237 0.189526 5.3001 0.522074 5.12131zM20 10.462V12.724C20 13.0995 19.8943 13.4675 19.6949 13.7858C18.1427 16.2633 15.5333 17.4999 12 17.4999C8.46671 17.4999 5.85733 16.2633 4.30518 13.7859C4.10583 13.4677 4.00009 13.0998 4 12.7241V10.462L11.1724 13.7222C11.6982 13.9612 12.3018 13.9612 12.8276 13.7222L20 10.462z" fill="#758CA3" />
              </svg>
            </a>
            @endif
            @if($student->is_active == 0)
            <a href="{{ route('activate', ['id_etu' => $student->id]) }}">
              <svg width="22px" height="22px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <g id="页面-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                  <g id="Arrow" transform="translate(-480.000000, -50.000000)" fill-rule="nonzero">
                    <g id="back_2_fill" transform="translate(480.000000, 50.000000)">
                      <path d="M24,0 L24,24 L0,24 L0,0 L24,0 Z M12.5934901,23.257841 L12.5819402,23.2595131 L12.5108777,23.2950439 L12.4918791,23.2987469 L12.4918791,23.2987469 L12.4767152,23.2950439 L12.4056548,23.2595131 C12.3958229,23.2563662 12.3870493,23.2590235 12.3821421,23.2649074 L12.3780323,23.275831 L12.360941,23.7031097 L12.3658947,23.7234994 L12.3769048,23.7357139 L12.4804777,23.8096931 L12.4953491,23.8136134 L12.4953491,23.8136134 L12.5071152,23.8096931 L12.6106902,23.7357139 L12.6232938,23.7196733 L12.6232938,23.7196733 L12.6266527,23.7031097 L12.609561,23.275831 C12.6075724,23.2657013 12.6010112,23.2592993 12.5934901,23.257841 L12.5934901,23.257841 Z M12.8583906,23.1452862 L12.8445485,23.1473072 L12.6598443,23.2396597 L12.6498822,23.2499052 L12.6498822,23.2499052 L12.6471943,23.2611114 L12.6650943,23.6906389 L12.6699349,23.7034178 L12.6699349,23.7034178 L12.678386,23.7104931 L12.8793402,23.8032389 C12.8914285,23.8068999 12.9022333,23.8029875 12.9078286,23.7952264 L12.9118235,23.7811639 L12.8776777,23.1665331 C12.8752882,23.1545897 12.8674102,23.1470016 12.8583906,23.1452862 L12.8583906,23.1452862 Z M12.1430473,23.1473072 C12.1332178,23.1423925 12.1221763,23.1452606 12.1156365,23.1525954 L12.1099173,23.1665331 L12.0757714,23.7811639 C12.0751323,23.7926639 12.0828099,23.8018602 12.0926481,23.8045676 L12.108256,23.8032389 L12.3092106,23.7104931 L12.3186497,23.7024347 L12.3186497,23.7024347 L12.3225043,23.6906389 L12.340401,23.2611114 L12.337245,23.2485176 L12.337245,23.2485176 L12.3277531,23.2396597 L12.1430473,23.1473072 Z" id="MingCute" fill-rule="nonzero">
                      </path>
                      <path d="M7.16075,10.9724 C8.44534,9.45943 10.3615,8.5 12.5,8.5 C16.366,8.5 19.5,11.634 19.5,15.5 C19.5,16.3284 20.1715,17 21,17 C21.8284,17 22.5,16.3284 22.5,15.5 C22.5,9.97715 18.0228,5.5 12.5,5.5 C9.55608,5.5 6.91086,6.77161 5.08155,8.79452 L4.73527,6.83068 C4.59142,6.01484 3.81343,5.47009 2.99759,5.61394 C2.18175,5.7578 1.637,6.53578 1.78085,7.35163 L2.82274,13.2605 C2.89182,13.6523 3.11371,14.0005 3.43959,14.2287 C3.84283,14.5111 4.37354,14.5736 4.82528,14.4305 L10.4693,13.4353 C11.2851,13.2915 11.8299,12.5135 11.686,11.6976 C11.5422,10.8818 10.7642,10.337 9.94833,10.4809 L7.16075,10.9724 Z" fill="green">
                      </path>
                    </g>
                  </g>
                </g>
              </svg>
            </a>
            @endif
            <a href="{{ route('usercard', ['id_etu' => $student->id]) }}">
              <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.4" d="M12.1207 12.78C12.0507 12.77 11.9607 12.77 11.8807 12.78C10.1207 12.72 8.7207 11.28 8.7207 9.50998C8.7207 7.69998 10.1807 6.22998 12.0007 6.22998C13.8107 6.22998 15.2807 7.69998 15.2807 9.50998C15.2707 11.28 13.8807 12.72 12.1207 12.78Z" stroke="grey" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path opacity="0.34" d="M18.7398 19.3801C16.9598 21.0101 14.5998 22.0001 11.9998 22.0001C9.39977 22.0001 7.03977 21.0101 5.25977 19.3801C5.35977 18.4401 5.95977 17.5201 7.02977 16.8001C9.76977 14.9801 14.2498 14.9801 16.9698 16.8001C18.0398 17.5201 18.6398 18.4401 18.7398 19.3801Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
  var chartElement = document.getElementById('chart');
  if (chartElement) {
    var chartContext = chartElement.getContext('2d');
    var gradient = chartContext.createLinearGradient(0, 0, 0, 450);

    gradient.addColorStop(0, 'rgba(0, 199, 214, 0.32)');
    gradient.addColorStop(0.3, 'rgba(0, 199, 214, 0.1)');
    gradient.addColorStop(1, 'rgba(0, 199, 214, 0)');

    // Function to fetch student data
    function fetchStudentData() {
      fetch('/get-student-count') // Your Laravel route to fetch student data
        .then(response => response.json())
        .then(data => {
          // Extract the labels and counts from the returned data
          var labels = data.map(item => item.annee_uni);
          var counts = data.map(item => item.student_count);

          // Update chart data
          updateChartData(labels, counts);
        })
        .catch(error => console.error('Error fetching student data:', error));
    }

    function updateChartData(labels, counts) {
      var data = {
        labels: labels, // Dynamic labels from the database
        datasets: [{
          label: 'Nombre des Etudiants inscrits',
          backgroundColor: gradient,
          pointBackgroundColor: '#00c7d6',
          borderWidth: 1,
          borderColor: '#0e1a2f',
          data: counts // Dynamic data from the database
        }]
      };

      var options = {
        responsive: true,
        maintainAspectRatio: true,
        animation: {
          easing: 'easeInOutQuad',
          duration: 520
        },
        scales: {
          yAxes: [{
            ticks: {
              fontColor: '#5e6a81'
            },
            gridLines: {
              color: 'rgba(200, 200, 200, 0.08)',
              lineWidth: 1
            }
          }],
          xAxes: [{
            ticks: {
              fontColor: '#5e6a81'
            }
          }]
        },
        elements: {
          line: {
            tension: 0.4
          }
        },
        legend: {
          display: false
        },
        point: {
          backgroundColor: '#00c7d6'
        },
        tooltips: {
          titleFontFamily: 'Poppins',
          backgroundColor: 'rgba(0,0,0,0.4)',
          titleFontColor: 'white',
          caretSize: 5,
          cornerRadius: 2,
          xPadding: 10,
          yPadding: 10
        }
      };

      // Create or update chart
      new Chart(chartContext, {
        type: 'line',
        data: data,
        options: options
      });
    }

    // Fetch student data on page load
    fetchStudentData();
  }
});
</script>
<script>
  ! function(e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
      if (!e.document) throw new Error("jQuery requires a window with a document");
      return t(e)
    } : t(e)
  }("undefined" != typeof window ? window : this, function(C, e) {
    "use strict";
    var t = [],
      r = Object.getPrototypeOf,
      s = t.slice,
      g = t.flat ? function(e) {
        return t.flat.call(e)
      } : function(e) {
        return t.concat.apply([], e)
      },
      u = t.push,
      i = t.indexOf,
      n = {},
      o = n.toString,
      v = n.hasOwnProperty,
      a = v.toString,
      l = a.call(Object),
      y = {},
      m = function(e) {
        return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
      },
      x = function(e) {
        return null != e && e === e.window
      },
      E = C.document,
      c = {
        type: !0,
        src: !0,
        nonce: !0,
        noModule: !0
      };

    function b(e, t, n) {
      var r, i, o = (n = n || E).createElement("script");
      if (o.text = e, t)
        for (r in c)(i = t[r] || t.getAttribute && t.getAttribute(r)) && o.setAttribute(r, i);
      n.head.appendChild(o).parentNode.removeChild(o)
    }

    function w(e) {
      return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? n[o.call(e)] || "object" : typeof e
    }
    var f = "3.6.0",
      S = function(e, t) {
        return new S.fn.init(e, t)
      };

    function p(e) {
      var t = !!e && "length" in e && e.length,
        n = w(e);
      return !m(e) && !x(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }
    S.fn = S.prototype = {
      jquery: f,
      constructor: S,
      length: 0,
      toArray: function() {
        return s.call(this)
      },
      get: function(e) {
        return null == e ? s.call(this) : e < 0 ? this[e + this.length] : this[e]
      },
      pushStack: function(e) {
        var t = S.merge(this.constructor(), e);
        return t.prevObject = this, t
      },
      each: function(e) {
        return S.each(this, e)
      },
      map: function(n) {
        return this.pushStack(S.map(this, function(e, t) {
          return n.call(e, t, e)
        }))
      },
      slice: function() {
        return this.pushStack(s.apply(this, arguments))
      },
      first: function() {
        return this.eq(0)
      },
      last: function() {
        return this.eq(-1)
      },
      even: function() {
        return this.pushStack(S.grep(this, function(e, t) {
          return (t + 1) % 2
        }))
      },
      odd: function() {
        return this.pushStack(S.grep(this, function(e, t) {
          return t % 2
        }))
      },
      eq: function(e) {
        var t = this.length,
          n = +e + (e < 0 ? t : 0);
        return this.pushStack(0 <= n && n < t ? [this[n]] : [])
      },
      end: function() {
        return this.prevObject || this.constructor()
      },
      push: u,
      sort: t.sort,
      splice: t.splice
    }, S.extend = S.fn.extend = function() {
      var e, t, n, r, i, o, a = arguments[0] || {},
        s = 1,
        u = arguments.length,
        l = !1;
      for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || m(a) || (a = {}), s === u && (a = this, s--); s < u; s++)
        if (null != (e = arguments[s]))
          for (t in e) r = e[t], "__proto__" !== t && a !== r && (l && r && (S.isPlainObject(r) || (i = Array.isArray(r))) ? (n = a[t], o = i && !Array.isArray(n) ? [] : i || S.isPlainObject(n) ? n : {}, i = !1, a[t] = S.extend(l, o, r)) : void 0 !== r && (a[t] = r));
      return a
    }, S.extend({
      expando: "jQuery" + (f + Math.random()).replace(/\D/g, ""),
      isReady: !0,
      error: function(e) {
        throw new Error(e)
      },
      noop: function() {},
      isPlainObject: function(e) {
        var t, n;
        return !(!e || "[object Object]" !== o.call(e)) && (!(t = r(e)) || "function" == typeof(n = v.call(t, "constructor") && t.constructor) && a.call(n) === l)
      },
      isEmptyObject: function(e) {
        var t;
        for (t in e) return !1;
        return !0
      },
      globalEval: function(e, t, n) {
        b(e, {
          nonce: t && t.nonce
        }, n)
      },
      each: function(e, t) {
        var n, r = 0;
        if (p(e)) {
          for (n = e.length; r < n; r++)
            if (!1 === t.call(e[r], r, e[r])) break
        } else
          for (r in e)
            if (!1 === t.call(e[r], r, e[r])) break;
        return e
      },
      makeArray: function(e, t) {
        var n = t || [];
        return null != e && (p(Object(e)) ? S.merge(n, "string" == typeof e ? [e] : e) : u.call(n, e)), n
      },
      inArray: function(e, t, n) {
        return null == t ? -1 : i.call(t, e, n)
      },
      merge: function(e, t) {
        for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
        return e.length = i, e
      },
      grep: function(e, t, n) {
        for (var r = [], i = 0, o = e.length, a = !n; i < o; i++) !t(e[i], i) !== a && r.push(e[i]);
        return r
      },
      map: function(e, t, n) {
        var r, i, o = 0,
          a = [];
        if (p(e))
          for (r = e.length; o < r; o++) null != (i = t(e[o], o, n)) && a.push(i);
        else
          for (o in e) null != (i = t(e[o], o, n)) && a.push(i);
        return g(a)
      },
      guid: 1,
      support: y
    }), "function" == typeof Symbol && (S.fn[Symbol.iterator] = t[Symbol.iterator]), S.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
      n["[object " + t + "]"] = t.toLowerCase()
    });
    var d = function(n) {
      var e, d, b, o, i, h, f, g, w, u, l, T, C, a, E, v, s, c, y, S = "sizzle" + 1 * new Date,
        p = n.document,
        k = 0,
        r = 0,
        m = ue(),
        x = ue(),
        A = ue(),
        N = ue(),
        j = function(e, t) {
          return e === t && (l = !0), 0
        },
        D = {}.hasOwnProperty,
        t = [],
        q = t.pop,
        L = t.push,
        H = t.push,
        O = t.slice,
        P = function(e, t) {
          for (var n = 0, r = e.length; n < r; n++)
            if (e[n] === t) return n;
          return -1
        },
        R = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
        M = "[\\x20\\t\\r\\n\\f]",
        I = "(?:\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
        W = "\\[" + M + "*(" + I + ")(?:" + M + "*([*^$|!~]?=)" + M + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + I + "))|)" + M + "*\\]",
        F = ":(" + I + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + W + ")*)|.*)\\)|)",
        B = new RegExp(M + "+", "g"),
        $ = new RegExp("^" + M + "+|((?:^|[^\\\\])(?:\\\\.)*)" + M + "+$", "g"),
        _ = new RegExp("^" + M + "*," + M + "*"),
        z = new RegExp("^" + M + "*([>+~]|" + M + ")" + M + "*"),
        U = new RegExp(M + "|>"),
        X = new RegExp(F),
        V = new RegExp("^" + I + "$"),
        G = {
          ID: new RegExp("^#(" + I + ")"),
          CLASS: new RegExp("^\\.(" + I + ")"),
          TAG: new RegExp("^(" + I + "|[*])"),
          ATTR: new RegExp("^" + W),
          PSEUDO: new RegExp("^" + F),
          CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + M + "*(even|odd|(([+-]|)(\\d*)n|)" + M + "*(?:([+-]|)" + M + "*(\\d+)|))" + M + "*\\)|)", "i"),
          bool: new RegExp("^(?:" + R + ")$", "i"),
          needsContext: new RegExp("^" + M + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + M + "*((?:-\\d)?\\d*)" + M + "*\\)|)(?=[^-]|$)", "i")
        },
        Y = /HTML$/i,
        Q = /^(?:input|select|textarea|button)$/i,
        J = /^h\d$/i,
        K = /^[^{]+\{\s*\[native \w/,
        Z = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
        ee = /[+~]/,
        te = new RegExp("\\\\[\\da-fA-F]{1,6}" + M + "?|\\\\([^\\r\\n\\f])", "g"),
        ne = function(e, t) {
          var n = "0x" + e.slice(1) - 65536;
          return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
        },
        re = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
        ie = function(e, t) {
          return t ? "\0" === e ? "\ufffd" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
        },
        oe = function() {
          T()
        },
        ae = be(function(e) {
          return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
        }, {
          dir: "parentNode",
          next: "legend"
        });
      try {
        H.apply(t = O.call(p.childNodes), p.childNodes), t[p.childNodes.length].nodeType
      } catch (e) {
        H = {
          apply: t.length ? function(e, t) {
            L.apply(e, O.call(t))
          } : function(e, t) {
            var n = e.length,
              r = 0;
            while (e[n++] = t[r++]);
            e.length = n - 1
          }
        }
      }

      function se(t, e, n, r) {
        var i, o, a, s, u, l, c, f = e && e.ownerDocument,
          p = e ? e.nodeType : 9;
        if (n = n || [], "string" != typeof t || !t || 1 !== p && 9 !== p && 11 !== p) return n;
        if (!r && (T(e), e = e || C, E)) {
          if (11 !== p && (u = Z.exec(t)))
            if (i = u[1]) {
              if (9 === p) {
                if (!(a = e.getElementById(i))) return n;
                if (a.id === i) return n.push(a), n
              } else if (f && (a = f.getElementById(i)) && y(e, a) && a.id === i) return n.push(a), n
            } else {
              if (u[2]) return H.apply(n, e.getElementsByTagName(t)), n;
              if ((i = u[3]) && d.getElementsByClassName && e.getElementsByClassName) return H.apply(n, e.getElementsByClassName(i)), n
            } if (d.qsa && !N[t + " "] && (!v || !v.test(t)) && (1 !== p || "object" !== e.nodeName.toLowerCase())) {
            if (c = t, f = e, 1 === p && (U.test(t) || z.test(t))) {
              (f = ee.test(t) && ye(e.parentNode) || e) === e && d.scope || ((s = e.getAttribute("id")) ? s = s.replace(re, ie) : e.setAttribute("id", s = S)), o = (l = h(t)).length;
              while (o--) l[o] = (s ? "#" + s : ":scope") + " " + xe(l[o]);
              c = l.join(",")
            }
            try {
              return H.apply(n, f.querySelectorAll(c)), n
            } catch (e) {
              N(t, !0)
            } finally {
              s === S && e.removeAttribute("id")
            }
          }
        }
        return g(t.replace($, "$1"), e, n, r)
      }

      function ue() {
        var r = [];
        return function e(t, n) {
          return r.push(t + " ") > b.cacheLength && delete e[r.shift()], e[t + " "] = n
        }
      }

      function le(e) {
        return e[S] = !0, e
      }

      function ce(e) {
        var t = C.createElement("fieldset");
        try {
          return !!e(t)
        } catch (e) {
          return !1
        } finally {
          t.parentNode && t.parentNode.removeChild(t), t = null
        }
      }

      function fe(e, t) {
        var n = e.split("|"),
          r = n.length;
        while (r--) b.attrHandle[n[r]] = t
      }

      function pe(e, t) {
        var n = t && e,
          r = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
        if (r) return r;
        if (n)
          while (n = n.nextSibling)
            if (n === t) return -1;
        return e ? 1 : -1
      }

      function de(t) {
        return function(e) {
          return "input" === e.nodeName.toLowerCase() && e.type === t
        }
      }

      function he(n) {
        return function(e) {
          var t = e.nodeName.toLowerCase();
          return ("input" === t || "button" === t) && e.type === n
        }
      }

      function ge(t) {
        return function(e) {
          return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && ae(e) === t : e.disabled === t : "label" in e && e.disabled === t
        }
      }

      function ve(a) {
        return le(function(o) {
          return o = +o, le(function(e, t) {
            var n, r = a([], e.length, o),
              i = r.length;
            while (i--) e[n = r[i]] && (e[n] = !(t[n] = e[n]))
          })
        })
      }

      function ye(e) {
        return e && "undefined" != typeof e.getElementsByTagName && e
      }
      for (e in d = se.support = {}, i = se.isXML = function(e) {
          var t = e && e.namespaceURI,
            n = e && (e.ownerDocument || e).documentElement;
          return !Y.test(t || n && n.nodeName || "HTML")
        }, T = se.setDocument = function(e) {
          var t, n, r = e ? e.ownerDocument || e : p;
          return r != C && 9 === r.nodeType && r.documentElement && (a = (C = r).documentElement, E = !i(C), p != C && (n = C.defaultView) && n.top !== n && (n.addEventListener ? n.addEventListener("unload", oe, !1) : n.attachEvent && n.attachEvent("onunload", oe)), d.scope = ce(function(e) {
            return a.appendChild(e).appendChild(C.createElement("div")), "undefined" != typeof e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
          }), d.attributes = ce(function(e) {
            return e.className = "i", !e.getAttribute("className")
          }), d.getElementsByTagName = ce(function(e) {
            return e.appendChild(C.createComment("")), !e.getElementsByTagName("*").length
          }), d.getElementsByClassName = K.test(C.getElementsByClassName), d.getById = ce(function(e) {
            return a.appendChild(e).id = S, !C.getElementsByName || !C.getElementsByName(S).length
          }), d.getById ? (b.filter.ID = function(e) {
            var t = e.replace(te, ne);
            return function(e) {
              return e.getAttribute("id") === t
            }
          }, b.find.ID = function(e, t) {
            if ("undefined" != typeof t.getElementById && E) {
              var n = t.getElementById(e);
              return n ? [n] : []
            }
          }) : (b.filter.ID = function(e) {
            var n = e.replace(te, ne);
            return function(e) {
              var t = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
              return t && t.value === n
            }
          }, b.find.ID = function(e, t) {
            if ("undefined" != typeof t.getElementById && E) {
              var n, r, i, o = t.getElementById(e);
              if (o) {
                if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
                i = t.getElementsByName(e), r = 0;
                while (o = i[r++])
                  if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
              }
              return []
            }
          }), b.find.TAG = d.getElementsByTagName ? function(e, t) {
            return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : d.qsa ? t.querySelectorAll(e) : void 0
          } : function(e, t) {
            var n, r = [],
              i = 0,
              o = t.getElementsByTagName(e);
            if ("*" === e) {
              while (n = o[i++]) 1 === n.nodeType && r.push(n);
              return r
            }
            return o
          }, b.find.CLASS = d.getElementsByClassName && function(e, t) {
            if ("undefined" != typeof t.getElementsByClassName && E) return t.getElementsByClassName(e)
          }, s = [], v = [], (d.qsa = K.test(C.querySelectorAll)) && (ce(function(e) {
            var t;
            a.appendChild(e).innerHTML = "<a id='" + S + "'></a><select id='" + S + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && v.push("[*^$]=" + M + "*(?:''|\"\")"), e.querySelectorAll("[selected]").length || v.push("\\[" + M + "*(?:value|" + R + ")"), e.querySelectorAll("[id~=" + S + "-]").length || v.push("~="), (t = C.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || v.push("\\[" + M + "*name" + M + "*=" + M + "*(?:''|\"\")"), e.querySelectorAll(":checked").length || v.push(":checked"), e.querySelectorAll("a#" + S + "+*").length || v.push(".#.+[+~]"), e.querySelectorAll("\\\f"), v.push("[\\r\\n\\f]")
          }), ce(function(e) {
            e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
            var t = C.createElement("input");
            t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && v.push("name" + M + "*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && v.push(":enabled", ":disabled"), a.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && v.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), v.push(",.*:")
          })), (d.matchesSelector = K.test(c = a.matches || a.webkitMatchesSelector || a.mozMatchesSelector || a.oMatchesSelector || a.msMatchesSelector)) && ce(function(e) {
            d.disconnectedMatch = c.call(e, "*"), c.call(e, "[s!='']:x"), s.push("!=", F)
          }), v = v.length && new RegExp(v.join("|")), s = s.length && new RegExp(s.join("|")), t = K.test(a.compareDocumentPosition), y = t || K.test(a.contains) ? function(e, t) {
            var n = 9 === e.nodeType ? e.documentElement : e,
              r = t && t.parentNode;
            return e === r || !(!r || 1 !== r.nodeType || !(n.contains ? n.contains(r) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(r)))
          } : function(e, t) {
            if (t)
              while (t = t.parentNode)
                if (t === e) return !0;
            return !1
          }, j = t ? function(e, t) {
            if (e === t) return l = !0, 0;
            var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
            return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !d.sortDetached && t.compareDocumentPosition(e) === n ? e == C || e.ownerDocument == p && y(p, e) ? -1 : t == C || t.ownerDocument == p && y(p, t) ? 1 : u ? P(u, e) - P(u, t) : 0 : 4 & n ? -1 : 1)
          } : function(e, t) {
            if (e === t) return l = !0, 0;
            var n, r = 0,
              i = e.parentNode,
              o = t.parentNode,
              a = [e],
              s = [t];
            if (!i || !o) return e == C ? -1 : t == C ? 1 : i ? -1 : o ? 1 : u ? P(u, e) - P(u, t) : 0;
            if (i === o) return pe(e, t);
            n = e;
            while (n = n.parentNode) a.unshift(n);
            n = t;
            while (n = n.parentNode) s.unshift(n);
            while (a[r] === s[r]) r++;
            return r ? pe(a[r], s[r]) : a[r] == p ? -1 : s[r] == p ? 1 : 0
          }), C
        }, se.matches = function(e, t) {
          return se(e, null, null, t)
        }, se.matchesSelector = function(e, t) {
          if (T(e), d.matchesSelector && E && !N[t + " "] && (!s || !s.test(t)) && (!v || !v.test(t))) try {
            var n = c.call(e, t);
            if (n || d.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
          } catch (e) {
            N(t, !0)
          }
          return 0 < se(t, C, null, [e]).length
        }, se.contains = function(e, t) {
          return (e.ownerDocument || e) != C && T(e), y(e, t)
        }, se.attr = function(e, t) {
          (e.ownerDocument || e) != C && T(e);
          var n = b.attrHandle[t.toLowerCase()],
            r = n && D.call(b.attrHandle, t.toLowerCase()) ? n(e, t, !E) : void 0;
          return void 0 !== r ? r : d.attributes || !E ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
        }, se.escape = function(e) {
          return (e + "").replace(re, ie)
        }, se.error = function(e) {
          throw new Error("Syntax error, unrecognized expression: " + e)
        }, se.uniqueSort = function(e) {
          var t, n = [],
            r = 0,
            i = 0;
          if (l = !d.detectDuplicates, u = !d.sortStable && e.slice(0), e.sort(j), l) {
            while (t = e[i++]) t === e[i] && (r = n.push(i));
            while (r--) e.splice(n[r], 1)
          }
          return u = null, e
        }, o = se.getText = function(e) {
          var t, n = "",
            r = 0,
            i = e.nodeType;
          if (i) {
            if (1 === i || 9 === i || 11 === i) {
              if ("string" == typeof e.textContent) return e.textContent;
              for (e = e.firstChild; e; e = e.nextSibling) n += o(e)
            } else if (3 === i || 4 === i) return e.nodeValue
          } else
            while (t = e[r++]) n += o(t);
          return n
        }, (b = se.selectors = {
          cacheLength: 50,
          createPseudo: le,
          match: G,
          attrHandle: {},
          find: {},
          relative: {
            ">": {
              dir: "parentNode",
              first: !0
            },
            " ": {
              dir: "parentNode"
            },
            "+": {
              dir: "previousSibling",
              first: !0
            },
            "~": {
              dir: "previousSibling"
            }
          },
          preFilter: {
            ATTR: function(e) {
              return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
            },
            CHILD: function(e) {
              return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || se.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && se.error(e[0]), e
            },
            PSEUDO: function(e) {
              var t, n = !e[6] && e[2];
              return G.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = h(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
            }
          },
          filter: {
            TAG: function(e) {
              var t = e.replace(te, ne).toLowerCase();
              return "*" === e ? function() {
                return !0
              } : function(e) {
                return e.nodeName && e.nodeName.toLowerCase() === t
              }
            },
            CLASS: function(e) {
              var t = m[e + " "];
              return t || (t = new RegExp("(^|" + M + ")" + e + "(" + M + "|$)")) && m(e, function(e) {
                return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
              })
            },
            ATTR: function(n, r, i) {
              return function(e) {
                var t = se.attr(e, n);
                return null == t ? "!=" === r : !r || (t += "", "=" === r ? t === i : "!=" === r ? t !== i : "^=" === r ? i && 0 === t.indexOf(i) : "*=" === r ? i && -1 < t.indexOf(i) : "$=" === r ? i && t.slice(-i.length) === i : "~=" === r ? -1 < (" " + t.replace(B, " ") + " ").indexOf(i) : "|=" === r && (t === i || t.slice(0, i.length + 1) === i + "-"))
              }
            },
            CHILD: function(h, e, t, g, v) {
              var y = "nth" !== h.slice(0, 3),
                m = "last" !== h.slice(-4),
                x = "of-type" === e;
              return 1 === g && 0 === v ? function(e) {
                return !!e.parentNode
              } : function(e, t, n) {
                var r, i, o, a, s, u, l = y !== m ? "nextSibling" : "previousSibling",
                  c = e.parentNode,
                  f = x && e.nodeName.toLowerCase(),
                  p = !n && !x,
                  d = !1;
                if (c) {
                  if (y) {
                    while (l) {
                      a = e;
                      while (a = a[l])
                        if (x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) return !1;
                      u = l = "only" === h && !u && "nextSibling"
                    }
                    return !0
                  }
                  if (u = [m ? c.firstChild : c.lastChild], m && p) {
                    d = (s = (r = (i = (o = (a = c)[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === k && r[1]) && r[2], a = s && c.childNodes[s];
                    while (a = ++s && a && a[l] || (d = s = 0) || u.pop())
                      if (1 === a.nodeType && ++d && a === e) {
                        i[h] = [k, s, d];
                        break
                      }
                  } else if (p && (d = s = (r = (i = (o = (a = e)[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] || [])[0] === k && r[1]), !1 === d)
                    while (a = ++s && a && a[l] || (d = s = 0) || u.pop())
                      if ((x ? a.nodeName.toLowerCase() === f : 1 === a.nodeType) && ++d && (p && ((i = (o = a[S] || (a[S] = {}))[a.uniqueID] || (o[a.uniqueID] = {}))[h] = [k, d]), a === e)) break;
                  return (d -= v) === g || d % g == 0 && 0 <= d / g
                }
              }
            },
            PSEUDO: function(e, o) {
              var t, a = b.pseudos[e] || b.setFilters[e.toLowerCase()] || se.error("unsupported pseudo: " + e);
              return a[S] ? a(o) : 1 < a.length ? (t = [e, e, "", o], b.setFilters.hasOwnProperty(e.toLowerCase()) ? le(function(e, t) {
                var n, r = a(e, o),
                  i = r.length;
                while (i--) e[n = P(e, r[i])] = !(t[n] = r[i])
              }) : function(e) {
                return a(e, 0, t)
              }) : a
            }
          },
          pseudos: {
            not: le(function(e) {
              var r = [],
                i = [],
                s = f(e.replace($, "$1"));
              return s[S] ? le(function(e, t, n, r) {
                var i, o = s(e, null, r, []),
                  a = e.length;
                while (a--)(i = o[a]) && (e[a] = !(t[a] = i))
              }) : function(e, t, n) {
                return r[0] = e, s(r, null, n, i), r[0] = null, !i.pop()
              }
            }),
            has: le(function(t) {
              return function(e) {
                return 0 < se(t, e).length
              }
            }),
            contains: le(function(t) {
              return t = t.replace(te, ne),
                function(e) {
                  return -1 < (e.textContent || o(e)).indexOf(t)
                }
            }),
            lang: le(function(n) {
              return V.test(n || "") || se.error("unsupported lang: " + n), n = n.replace(te, ne).toLowerCase(),
                function(e) {
                  var t;
                  do {
                    if (t = E ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-")
                  } while ((e = e.parentNode) && 1 === e.nodeType);
                  return !1
                }
            }),
            target: function(e) {
              var t = n.location && n.location.hash;
              return t && t.slice(1) === e.id
            },
            root: function(e) {
              return e === a
            },
            focus: function(e) {
              return e === C.activeElement && (!C.hasFocus || C.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
            },
            enabled: ge(!1),
            disabled: ge(!0),
            checked: function(e) {
              var t = e.nodeName.toLowerCase();
              return "input" === t && !!e.checked || "option" === t && !!e.selected
            },
            selected: function(e) {
              return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
            },
            empty: function(e) {
              for (e = e.firstChild; e; e = e.nextSibling)
                if (e.nodeType < 6) return !1;
              return !0
            },
            parent: function(e) {
              return !b.pseudos.empty(e)
            },
            header: function(e) {
              return J.test(e.nodeName)
            },
            input: function(e) {
              return Q.test(e.nodeName)
            },
            button: function(e) {
              var t = e.nodeName.toLowerCase();
              return "input" === t && "button" === e.type || "button" === t
            },
            text: function(e) {
              var t;
              return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
            },
            first: ve(function() {
              return [0]
            }),
            last: ve(function(e, t) {
              return [t - 1]
            }),
            eq: ve(function(e, t, n) {
              return [n < 0 ? n + t : n]
            }),
            even: ve(function(e, t) {
              for (var n = 0; n < t; n += 2) e.push(n);
              return e
            }),
            odd: ve(function(e, t) {
              for (var n = 1; n < t; n += 2) e.push(n);
              return e
            }),
            lt: ve(function(e, t, n) {
              for (var r = n < 0 ? n + t : t < n ? t : n; 0 <= --r;) e.push(r);
              return e
            }),
            gt: ve(function(e, t, n) {
              for (var r = n < 0 ? n + t : n; ++r < t;) e.push(r);
              return e
            })
          }
        }).pseudos.nth = b.pseudos.eq, {
          radio: !0,
          checkbox: !0,
          file: !0,
          password: !0,
          image: !0
        }) b.pseudos[e] = de(e);
      for (e in {
          submit: !0,
          reset: !0
        }) b.pseudos[e] = he(e);

      function me() {}

      function xe(e) {
        for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
        return r
      }

      function be(s, e, t) {
        var u = e.dir,
          l = e.next,
          c = l || u,
          f = t && "parentNode" === c,
          p = r++;
        return e.first ? function(e, t, n) {
          while (e = e[u])
            if (1 === e.nodeType || f) return s(e, t, n);
          return !1
        } : function(e, t, n) {
          var r, i, o, a = [k, p];
          if (n) {
            while (e = e[u])
              if ((1 === e.nodeType || f) && s(e, t, n)) return !0
          } else
            while (e = e[u])
              if (1 === e.nodeType || f)
                if (i = (o = e[S] || (e[S] = {}))[e.uniqueID] || (o[e.uniqueID] = {}), l && l === e.nodeName.toLowerCase()) e = e[u] || e;
                else {
                  if ((r = i[c]) && r[0] === k && r[1] === p) return a[2] = r[2];
                  if ((i[c] = a)[2] = s(e, t, n)) return !0
                } return !1
        }
      }

      function we(i) {
        return 1 < i.length ? function(e, t, n) {
          var r = i.length;
          while (r--)
            if (!i[r](e, t, n)) return !1;
          return !0
        } : i[0]
      }

      function Te(e, t, n, r, i) {
        for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++)(o = e[s]) && (n && !n(o, r, i) || (a.push(o), l && t.push(s)));
        return a
      }

      function Ce(d, h, g, v, y, e) {
        return v && !v[S] && (v = Ce(v)), y && !y[S] && (y = Ce(y, e)), le(function(e, t, n, r) {
          var i, o, a, s = [],
            u = [],
            l = t.length,
            c = e || function(e, t, n) {
              for (var r = 0, i = t.length; r < i; r++) se(e, t[r], n);
              return n
            }(h || "*", n.nodeType ? [n] : n, []),
            f = !d || !e && h ? c : Te(c, s, d, n, r),
            p = g ? y || (e ? d : l || v) ? [] : t : f;
          if (g && g(f, p, n, r), v) {
            i = Te(p, u), v(i, [], n, r), o = i.length;
            while (o--)(a = i[o]) && (p[u[o]] = !(f[u[o]] = a))
          }
          if (e) {
            if (y || d) {
              if (y) {
                i = [], o = p.length;
                while (o--)(a = p[o]) && i.push(f[o] = a);
                y(null, p = [], i, r)
              }
              o = p.length;
              while (o--)(a = p[o]) && -1 < (i = y ? P(e, a) : s[o]) && (e[i] = !(t[i] = a))
            }
          } else p = Te(p === t ? p.splice(l, p.length) : p), y ? y(null, t, p, r) : H.apply(t, p)
        })
      }

      function Ee(e) {
        for (var i, t, n, r = e.length, o = b.relative[e[0].type], a = o || b.relative[" "], s = o ? 1 : 0, u = be(function(e) {
            return e === i
          }, a, !0), l = be(function(e) {
            return -1 < P(i, e)
          }, a, !0), c = [function(e, t, n) {
            var r = !o && (n || t !== w) || ((i = t).nodeType ? u(e, t, n) : l(e, t, n));
            return i = null, r
          }]; s < r; s++)
          if (t = b.relative[e[s].type]) c = [be(we(c), t)];
          else {
            if ((t = b.filter[e[s].type].apply(null, e[s].matches))[S]) {
              for (n = ++s; n < r; n++)
                if (b.relative[e[n].type]) break;
              return Ce(1 < s && we(c), 1 < s && xe(e.slice(0, s - 1).concat({
                value: " " === e[s - 2].type ? "*" : ""
              })).replace($, "$1"), t, s < n && Ee(e.slice(s, n)), n < r && Ee(e = e.slice(n)), n < r && xe(e))
            }
            c.push(t)
          } return we(c)
      }
      return me.prototype = b.filters = b.pseudos, b.setFilters = new me, h = se.tokenize = function(e, t) {
        var n, r, i, o, a, s, u, l = x[e + " "];
        if (l) return t ? 0 : l.slice(0);
        a = e, s = [], u = b.preFilter;
        while (a) {
          for (o in n && !(r = _.exec(a)) || (r && (a = a.slice(r[0].length) || a), s.push(i = [])), n = !1, (r = z.exec(a)) && (n = r.shift(), i.push({
              value: n,
              type: r[0].replace($, " ")
            }), a = a.slice(n.length)), b.filter) !(r = G[o].exec(a)) || u[o] && !(r = u[o](r)) || (n = r.shift(), i.push({
            value: n,
            type: o,
            matches: r
          }), a = a.slice(n.length));
          if (!n) break
        }
        return t ? a.length : a ? se.error(e) : x(e, s).slice(0)
      }, f = se.compile = function(e, t) {
        var n, v, y, m, x, r, i = [],
          o = [],
          a = A[e + " "];
        if (!a) {
          t || (t = h(e)), n = t.length;
          while (n--)(a = Ee(t[n]))[S] ? i.push(a) : o.push(a);
          (a = A(e, (v = o, m = 0 < (y = i).length, x = 0 < v.length, r = function(e, t, n, r, i) {
            var o, a, s, u = 0,
              l = "0",
              c = e && [],
              f = [],
              p = w,
              d = e || x && b.find.TAG("*", i),
              h = k += null == p ? 1 : Math.random() || .1,
              g = d.length;
            for (i && (w = t == C || t || i); l !== g && null != (o = d[l]); l++) {
              if (x && o) {
                a = 0, t || o.ownerDocument == C || (T(o), n = !E);
                while (s = v[a++])
                  if (s(o, t || C, n)) {
                    r.push(o);
                    break
                  } i && (k = h)
              }
              m && ((o = !s && o) && u--, e && c.push(o))
            }
            if (u += l, m && l !== u) {
              a = 0;
              while (s = y[a++]) s(c, f, t, n);
              if (e) {
                if (0 < u)
                  while (l--) c[l] || f[l] || (f[l] = q.call(r));
                f = Te(f)
              }
              H.apply(r, f), i && !e && 0 < f.length && 1 < u + y.length && se.uniqueSort(r)
            }
            return i && (k = h, w = p), c
          }, m ? le(r) : r))).selector = e
        }
        return a
      }, g = se.select = function(e, t, n, r) {
        var i, o, a, s, u, l = "function" == typeof e && e,
          c = !r && h(e = l.selector || e);
        if (n = n || [], 1 === c.length) {
          if (2 < (o = c[0] = c[0].slice(0)).length && "ID" === (a = o[0]).type && 9 === t.nodeType && E && b.relative[o[1].type]) {
            if (!(t = (b.find.ID(a.matches[0].replace(te, ne), t) || [])[0])) return n;
            l && (t = t.parentNode), e = e.slice(o.shift().value.length)
          }
          i = G.needsContext.test(e) ? 0 : o.length;
          while (i--) {
            if (a = o[i], b.relative[s = a.type]) break;
            if ((u = b.find[s]) && (r = u(a.matches[0].replace(te, ne), ee.test(o[0].type) && ye(t.parentNode) || t))) {
              if (o.splice(i, 1), !(e = r.length && xe(o))) return H.apply(n, r), n;
              break
            }
          }
        }
        return (l || f(e, c))(r, t, !E, n, !t || ee.test(e) && ye(t.parentNode) || t), n
      }, d.sortStable = S.split("").sort(j).join("") === S, d.detectDuplicates = !!l, T(), d.sortDetached = ce(function(e) {
        return 1 & e.compareDocumentPosition(C.createElement("fieldset"))
      }), ce(function(e) {
        return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
      }) || fe("type|href|height|width", function(e, t, n) {
        if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
      }), d.attributes && ce(function(e) {
        return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
      }) || fe("value", function(e, t, n) {
        if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
      }), ce(function(e) {
        return null == e.getAttribute("disabled")
      }) || fe(R, function(e, t, n) {
        var r;
        if (!n) return !0 === e[t] ? t.toLowerCase() : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
      }), se
    }(C);
    S.find = d, S.expr = d.selectors, S.expr[":"] = S.expr.pseudos, S.uniqueSort = S.unique = d.uniqueSort, S.text = d.getText, S.isXMLDoc = d.isXML, S.contains = d.contains, S.escapeSelector = d.escape;
    var h = function(e, t, n) {
        var r = [],
          i = void 0 !== n;
        while ((e = e[t]) && 9 !== e.nodeType)
          if (1 === e.nodeType) {
            if (i && S(e).is(n)) break;
            r.push(e)
          } return r
      },
      T = function(e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
      },
      k = S.expr.match.needsContext;

    function A(e, t) {
      return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }
    var N = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function j(e, n, r) {
      return m(n) ? S.grep(e, function(e, t) {
        return !!n.call(e, t, e) !== r
      }) : n.nodeType ? S.grep(e, function(e) {
        return e === n !== r
      }) : "string" != typeof n ? S.grep(e, function(e) {
        return -1 < i.call(n, e) !== r
      }) : S.filter(n, e, r)
    }
    S.filter = function(e, t, n) {
      var r = t[0];
      return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? S.find.matchesSelector(r, e) ? [r] : [] : S.find.matches(e, S.grep(t, function(e) {
        return 1 === e.nodeType
      }))
    }, S.fn.extend({
      find: function(e) {
        var t, n, r = this.length,
          i = this;
        if ("string" != typeof e) return this.pushStack(S(e).filter(function() {
          for (t = 0; t < r; t++)
            if (S.contains(i[t], this)) return !0
        }));
        for (n = this.pushStack([]), t = 0; t < r; t++) S.find(e, i[t], n);
        return 1 < r ? S.uniqueSort(n) : n
      },
      filter: function(e) {
        return this.pushStack(j(this, e || [], !1))
      },
      not: function(e) {
        return this.pushStack(j(this, e || [], !0))
      },
      is: function(e) {
        return !!j(this, "string" == typeof e && k.test(e) ? S(e) : e || [], !1).length
      }
    });
    var D, q = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (S.fn.init = function(e, t, n) {
      var r, i;
      if (!e) return this;
      if (n = n || D, "string" == typeof e) {
        if (!(r = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : q.exec(e)) || !r[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
        if (r[1]) {
          if (t = t instanceof S ? t[0] : t, S.merge(this, S.parseHTML(r[1], t && t.nodeType ? t.ownerDocument || t : E, !0)), N.test(r[1]) && S.isPlainObject(t))
            for (r in t) m(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
          return this
        }
        return (i = E.getElementById(r[2])) && (this[0] = i, this.length = 1), this
      }
      return e.nodeType ? (this[0] = e, this.length = 1, this) : m(e) ? void 0 !== n.ready ? n.ready(e) : e(S) : S.makeArray(e, this)
    }).prototype = S.fn, D = S(E);
    var L = /^(?:parents|prev(?:Until|All))/,
      H = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
      };

    function O(e, t) {
      while ((e = e[t]) && 1 !== e.nodeType);
      return e
    }
    S.fn.extend({
      has: function(e) {
        var t = S(e, this),
          n = t.length;
        return this.filter(function() {
          for (var e = 0; e < n; e++)
            if (S.contains(this, t[e])) return !0
        })
      },
      closest: function(e, t) {
        var n, r = 0,
          i = this.length,
          o = [],
          a = "string" != typeof e && S(e);
        if (!k.test(e))
          for (; r < i; r++)
            for (n = this[r]; n && n !== t; n = n.parentNode)
              if (n.nodeType < 11 && (a ? -1 < a.index(n) : 1 === n.nodeType && S.find.matchesSelector(n, e))) {
                o.push(n);
                break
              } return this.pushStack(1 < o.length ? S.uniqueSort(o) : o)
      },
      index: function(e) {
        return e ? "string" == typeof e ? i.call(S(e), this[0]) : i.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
      },
      add: function(e, t) {
        return this.pushStack(S.uniqueSort(S.merge(this.get(), S(e, t))))
      },
      addBack: function(e) {
        return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
      }
    }), S.each({
      parent: function(e) {
        var t = e.parentNode;
        return t && 11 !== t.nodeType ? t : null
      },
      parents: function(e) {
        return h(e, "parentNode")
      },
      parentsUntil: function(e, t, n) {
        return h(e, "parentNode", n)
      },
      next: function(e) {
        return O(e, "nextSibling")
      },
      prev: function(e) {
        return O(e, "previousSibling")
      },
      nextAll: function(e) {
        return h(e, "nextSibling")
      },
      prevAll: function(e) {
        return h(e, "previousSibling")
      },
      nextUntil: function(e, t, n) {
        return h(e, "nextSibling", n)
      },
      prevUntil: function(e, t, n) {
        return h(e, "previousSibling", n)
      },
      siblings: function(e) {
        return T((e.parentNode || {}).firstChild, e)
      },
      children: function(e) {
        return T(e.firstChild)
      },
      contents: function(e) {
        return null != e.contentDocument && r(e.contentDocument) ? e.contentDocument : (A(e, "template") && (e = e.content || e), S.merge([], e.childNodes))
      }
    }, function(r, i) {
      S.fn[r] = function(e, t) {
        var n = S.map(this, i, e);
        return "Until" !== r.slice(-5) && (t = e), t && "string" == typeof t && (n = S.filter(t, n)), 1 < this.length && (H[r] || S.uniqueSort(n), L.test(r) && n.reverse()), this.pushStack(n)
      }
    });
    var P = /[^\x20\t\r\n\f]+/g;

    function R(e) {
      return e
    }

    function M(e) {
      throw e
    }

    function I(e, t, n, r) {
      var i;
      try {
        e && m(i = e.promise) ? i.call(e).done(t).fail(n) : e && m(i = e.then) ? i.call(e, t, n) : t.apply(void 0, [e].slice(r))
      } catch (e) {
        n.apply(void 0, [e])
      }
    }
    S.Callbacks = function(r) {
      var e, n;
      r = "string" == typeof r ? (e = r, n = {}, S.each(e.match(P) || [], function(e, t) {
        n[t] = !0
      }), n) : S.extend({}, r);
      var i, t, o, a, s = [],
        u = [],
        l = -1,
        c = function() {
          for (a = a || r.once, o = i = !0; u.length; l = -1) {
            t = u.shift();
            while (++l < s.length) !1 === s[l].apply(t[0], t[1]) && r.stopOnFalse && (l = s.length, t = !1)
          }
          r.memory || (t = !1), i = !1, a && (s = t ? [] : "")
        },
        f = {
          add: function() {
            return s && (t && !i && (l = s.length - 1, u.push(t)), function n(e) {
              S.each(e, function(e, t) {
                m(t) ? r.unique && f.has(t) || s.push(t) : t && t.length && "string" !== w(t) && n(t)
              })
            }(arguments), t && !i && c()), this
          },
          remove: function() {
            return S.each(arguments, function(e, t) {
              var n;
              while (-1 < (n = S.inArray(t, s, n))) s.splice(n, 1), n <= l && l--
            }), this
          },
          has: function(e) {
            return e ? -1 < S.inArray(e, s) : 0 < s.length
          },
          empty: function() {
            return s && (s = []), this
          },
          disable: function() {
            return a = u = [], s = t = "", this
          },
          disabled: function() {
            return !s
          },
          lock: function() {
            return a = u = [], t || i || (s = t = ""), this
          },
          locked: function() {
            return !!a
          },
          fireWith: function(e, t) {
            return a || (t = [e, (t = t || []).slice ? t.slice() : t], u.push(t), i || c()), this
          },
          fire: function() {
            return f.fireWith(this, arguments), this
          },
          fired: function() {
            return !!o
          }
        };
      return f
    }, S.extend({
      Deferred: function(e) {
        var o = [
            ["notify", "progress", S.Callbacks("memory"), S.Callbacks("memory"), 2],
            ["resolve", "done", S.Callbacks("once memory"), S.Callbacks("once memory"), 0, "resolved"],
            ["reject", "fail", S.Callbacks("once memory"), S.Callbacks("once memory"), 1, "rejected"]
          ],
          i = "pending",
          a = {
            state: function() {
              return i
            },
            always: function() {
              return s.done(arguments).fail(arguments), this
            },
            "catch": function(e) {
              return a.then(null, e)
            },
            pipe: function() {
              var i = arguments;
              return S.Deferred(function(r) {
                S.each(o, function(e, t) {
                  var n = m(i[t[4]]) && i[t[4]];
                  s[t[1]](function() {
                    var e = n && n.apply(this, arguments);
                    e && m(e.promise) ? e.promise().progress(r.notify).done(r.resolve).fail(r.reject) : r[t[0] + "With"](this, n ? [e] : arguments)
                  })
                }), i = null
              }).promise()
            },
            then: function(t, n, r) {
              var u = 0;

              function l(i, o, a, s) {
                return function() {
                  var n = this,
                    r = arguments,
                    e = function() {
                      var e, t;
                      if (!(i < u)) {
                        if ((e = a.apply(n, r)) === o.promise()) throw new TypeError("Thenable self-resolution");
                        t = e && ("object" == typeof e || "function" == typeof e) && e.then, m(t) ? s ? t.call(e, l(u, o, R, s), l(u, o, M, s)) : (u++, t.call(e, l(u, o, R, s), l(u, o, M, s), l(u, o, R, o.notifyWith))) : (a !== R && (n = void 0, r = [e]), (s || o.resolveWith)(n, r))
                      }
                    },
                    t = s ? e : function() {
                      try {
                        e()
                      } catch (e) {
                        S.Deferred.exceptionHook && S.Deferred.exceptionHook(e, t.stackTrace), u <= i + 1 && (a !== M && (n = void 0, r = [e]), o.rejectWith(n, r))
                      }
                    };
                  i ? t() : (S.Deferred.getStackHook && (t.stackTrace = S.Deferred.getStackHook()), C.setTimeout(t))
                }
              }
              return S.Deferred(function(e) {
                o[0][3].add(l(0, e, m(r) ? r : R, e.notifyWith)), o[1][3].add(l(0, e, m(t) ? t : R)), o[2][3].add(l(0, e, m(n) ? n : M))
              }).promise()
            },
            promise: function(e) {
              return null != e ? S.extend(e, a) : a
            }
          },
          s = {};
        return S.each(o, function(e, t) {
          var n = t[2],
            r = t[5];
          a[t[1]] = n.add, r && n.add(function() {
            i = r
          }, o[3 - e][2].disable, o[3 - e][3].disable, o[0][2].lock, o[0][3].lock), n.add(t[3].fire), s[t[0]] = function() {
            return s[t[0] + "With"](this === s ? void 0 : this, arguments), this
          }, s[t[0] + "With"] = n.fireWith
        }), a.promise(s), e && e.call(s, s), s
      },
      when: function(e) {
        var n = arguments.length,
          t = n,
          r = Array(t),
          i = s.call(arguments),
          o = S.Deferred(),
          a = function(t) {
            return function(e) {
              r[t] = this, i[t] = 1 < arguments.length ? s.call(arguments) : e, --n || o.resolveWith(r, i)
            }
          };
        if (n <= 1 && (I(e, o.done(a(t)).resolve, o.reject, !n), "pending" === o.state() || m(i[t] && i[t].then))) return o.then();
        while (t--) I(i[t], a(t), o.reject);
        return o.promise()
      }
    });
    var W = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    S.Deferred.exceptionHook = function(e, t) {
      C.console && C.console.warn && e && W.test(e.name) && C.console.warn("jQuery.Deferred exception: " + e.message, e.stack, t)
    }, S.readyException = function(e) {
      C.setTimeout(function() {
        throw e
      })
    };
    var F = S.Deferred();

    function B() {
      E.removeEventListener("DOMContentLoaded", B), C.removeEventListener("load", B), S.ready()
    }
    S.fn.ready = function(e) {
      return F.then(e)["catch"](function(e) {
        S.readyException(e)
      }), this
    }, S.extend({
      isReady: !1,
      readyWait: 1,
      ready: function(e) {
        (!0 === e ? --S.readyWait : S.isReady) || (S.isReady = !0) !== e && 0 < --S.readyWait || F.resolveWith(E, [S])
      }
    }), S.ready.then = F.then, "complete" === E.readyState || "loading" !== E.readyState && !E.documentElement.doScroll ? C.setTimeout(S.ready) : (E.addEventListener("DOMContentLoaded", B), C.addEventListener("load", B));
    var $ = function(e, t, n, r, i, o, a) {
        var s = 0,
          u = e.length,
          l = null == n;
        if ("object" === w(n))
          for (s in i = !0, n) $(e, t, s, n[s], !0, o, a);
        else if (void 0 !== r && (i = !0, m(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function(e, t, n) {
            return l.call(S(e), n)
          })), t))
          for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
        return i ? e : l ? t.call(e) : u ? t(e[0], n) : o
      },
      _ = /^-ms-/,
      z = /-([a-z])/g;

    function U(e, t) {
      return t.toUpperCase()
    }

    function X(e) {
      return e.replace(_, "ms-").replace(z, U)
    }
    var V = function(e) {
      return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function G() {
      this.expando = S.expando + G.uid++
    }
    G.uid = 1, G.prototype = {
      cache: function(e) {
        var t = e[this.expando];
        return t || (t = {}, V(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
          value: t,
          configurable: !0
        }))), t
      },
      set: function(e, t, n) {
        var r, i = this.cache(e);
        if ("string" == typeof t) i[X(t)] = n;
        else
          for (r in t) i[X(r)] = t[r];
        return i
      },
      get: function(e, t) {
        return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][X(t)]
      },
      access: function(e, t, n) {
        return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
      },
      remove: function(e, t) {
        var n, r = e[this.expando];
        if (void 0 !== r) {
          if (void 0 !== t) {
            n = (t = Array.isArray(t) ? t.map(X) : (t = X(t)) in r ? [t] : t.match(P) || []).length;
            while (n--) delete r[t[n]]
          }(void 0 === t || S.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
        }
      },
      hasData: function(e) {
        var t = e[this.expando];
        return void 0 !== t && !S.isEmptyObject(t)
      }
    };
    var Y = new G,
      Q = new G,
      J = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
      K = /[A-Z]/g;

    function Z(e, t, n) {
      var r, i;
      if (void 0 === n && 1 === e.nodeType)
        if (r = "data-" + t.replace(K, "-$&").toLowerCase(), "string" == typeof(n = e.getAttribute(r))) {
          try {
            n = "true" === (i = n) || "false" !== i && ("null" === i ? null : i === +i + "" ? +i : J.test(i) ? JSON.parse(i) : i)
          } catch (e) {}
          Q.set(e, t, n)
        } else n = void 0;
      return n
    }
    S.extend({
      hasData: function(e) {
        return Q.hasData(e) || Y.hasData(e)
      },
      data: function(e, t, n) {
        return Q.access(e, t, n)
      },
      removeData: function(e, t) {
        Q.remove(e, t)
      },
      _data: function(e, t, n) {
        return Y.access(e, t, n)
      },
      _removeData: function(e, t) {
        Y.remove(e, t)
      }
    }), S.fn.extend({
      data: function(n, e) {
        var t, r, i, o = this[0],
          a = o && o.attributes;
        if (void 0 === n) {
          if (this.length && (i = Q.get(o), 1 === o.nodeType && !Y.get(o, "hasDataAttrs"))) {
            t = a.length;
            while (t--) a[t] && 0 === (r = a[t].name).indexOf("data-") && (r = X(r.slice(5)), Z(o, r, i[r]));
            Y.set(o, "hasDataAttrs", !0)
          }
          return i
        }
        return "object" == typeof n ? this.each(function() {
          Q.set(this, n)
        }) : $(this, function(e) {
          var t;
          if (o && void 0 === e) return void 0 !== (t = Q.get(o, n)) ? t : void 0 !== (t = Z(o, n)) ? t : void 0;
          this.each(function() {
            Q.set(this, n, e)
          })
        }, null, e, 1 < arguments.length, null, !0)
      },
      removeData: function(e) {
        return this.each(function() {
          Q.remove(this, e)
        })
      }
    }), S.extend({
      queue: function(e, t, n) {
        var r;
        if (e) return t = (t || "fx") + "queue", r = Y.get(e, t), n && (!r || Array.isArray(n) ? r = Y.access(e, t, S.makeArray(n)) : r.push(n)), r || []
      },
      dequeue: function(e, t) {
        t = t || "fx";
        var n = S.queue(e, t),
          r = n.length,
          i = n.shift(),
          o = S._queueHooks(e, t);
        "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, function() {
          S.dequeue(e, t)
        }, o)), !r && o && o.empty.fire()
      },
      _queueHooks: function(e, t) {
        var n = t + "queueHooks";
        return Y.get(e, n) || Y.access(e, n, {
          empty: S.Callbacks("once memory").add(function() {
            Y.remove(e, [t + "queue", n])
          })
        })
      }
    }), S.fn.extend({
      queue: function(t, n) {
        var e = 2;
        return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? S.queue(this[0], t) : void 0 === n ? this : this.each(function() {
          var e = S.queue(this, t, n);
          S._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && S.dequeue(this, t)
        })
      },
      dequeue: function(e) {
        return this.each(function() {
          S.dequeue(this, e)
        })
      },
      clearQueue: function(e) {
        return this.queue(e || "fx", [])
      },
      promise: function(e, t) {
        var n, r = 1,
          i = S.Deferred(),
          o = this,
          a = this.length,
          s = function() {
            --r || i.resolveWith(o, [o])
          };
        "string" != typeof e && (t = e, e = void 0), e = e || "fx";
        while (a--)(n = Y.get(o[a], e + "queueHooks")) && n.empty && (r++, n.empty.add(s));
        return s(), i.promise(t)
      }
    });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
      te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
      ne = ["Top", "Right", "Bottom", "Left"],
      re = E.documentElement,
      ie = function(e) {
        return S.contains(e.ownerDocument, e)
      },
      oe = {
        composed: !0
      };
    re.getRootNode && (ie = function(e) {
      return S.contains(e.ownerDocument, e) || e.getRootNode(oe) === e.ownerDocument
    });
    var ae = function(e, t) {
      return "none" === (e = t || e).style.display || "" === e.style.display && ie(e) && "none" === S.css(e, "display")
    };

    function se(e, t, n, r) {
      var i, o, a = 20,
        s = r ? function() {
          return r.cur()
        } : function() {
          return S.css(e, t, "")
        },
        u = s(),
        l = n && n[3] || (S.cssNumber[t] ? "" : "px"),
        c = e.nodeType && (S.cssNumber[t] || "px" !== l && +u) && te.exec(S.css(e, t));
      if (c && c[3] !== l) {
        u /= 2, l = l || c[3], c = +u || 1;
        while (a--) S.style(e, t, c + l), (1 - o) * (1 - (o = s() / u || .5)) <= 0 && (a = 0), c /= o;
        c *= 2, S.style(e, t, c + l), n = n || []
      }
      return n && (c = +c || +u || 0, i = n[1] ? c + (n[1] + 1) * n[2] : +n[2], r && (r.unit = l, r.start = c, r.end = i)), i
    }
    var ue = {};

    function le(e, t) {
      for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++)(r = e[c]).style && (n = r.style.display, t ? ("none" === n && (l[c] = Y.get(r, "display") || null, l[c] || (r.style.display = "")), "" === r.style.display && ae(r) && (l[c] = (u = a = o = void 0, a = (i = r).ownerDocument, s = i.nodeName, (u = ue[s]) || (o = a.body.appendChild(a.createElement(s)), u = S.css(o, "display"), o.parentNode.removeChild(o), "none" === u && (u = "block"), ue[s] = u)))) : "none" !== n && (l[c] = "none", Y.set(r, "display", n)));
      for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
      return e
    }
    S.fn.extend({
      show: function() {
        return le(this, !0)
      },
      hide: function() {
        return le(this)
      },
      toggle: function(e) {
        return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
          ae(this) ? S(this).show() : S(this).hide()
        })
      }
    });
    var ce, fe, pe = /^(?:checkbox|radio)$/i,
      de = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
      he = /^$|^module$|\/(?:java|ecma)script/i;
    ce = E.createDocumentFragment().appendChild(E.createElement("div")), (fe = E.createElement("input")).setAttribute("type", "radio"), fe.setAttribute("checked", "checked"), fe.setAttribute("name", "t"), ce.appendChild(fe), y.checkClone = ce.cloneNode(!0).cloneNode(!0).lastChild.checked, ce.innerHTML = "<textarea>x</textarea>", y.noCloneChecked = !!ce.cloneNode(!0).lastChild.defaultValue, ce.innerHTML = "<option></option>", y.option = !!ce.lastChild;
    var ge = {
      thead: [1, "<table>", "</table>"],
      col: [2, "<table><colgroup>", "</colgroup></table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: [0, "", ""]
    };

    function ve(e, t) {
      var n;
      return n = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && A(e, t) ? S.merge([e], n) : n
    }

    function ye(e, t) {
      for (var n = 0, r = e.length; n < r; n++) Y.set(e[n], "globalEval", !t || Y.get(t[n], "globalEval"))
    }
    ge.tbody = ge.tfoot = ge.colgroup = ge.caption = ge.thead, ge.th = ge.td, y.option || (ge.optgroup = ge.option = [1, "<select multiple='multiple'>", "</select>"]);
    var me = /<|&#?\w+;/;

    function xe(e, t, n, r, i) {
      for (var o, a, s, u, l, c, f = t.createDocumentFragment(), p = [], d = 0, h = e.length; d < h; d++)
        if ((o = e[d]) || 0 === o)
          if ("object" === w(o)) S.merge(p, o.nodeType ? [o] : o);
          else if (me.test(o)) {
        a = a || f.appendChild(t.createElement("div")), s = (de.exec(o) || ["", ""])[1].toLowerCase(), u = ge[s] || ge._default, a.innerHTML = u[1] + S.htmlPrefilter(o) + u[2], c = u[0];
        while (c--) a = a.lastChild;
        S.merge(p, a.childNodes), (a = f.firstChild).textContent = ""
      } else p.push(t.createTextNode(o));
      f.textContent = "", d = 0;
      while (o = p[d++])
        if (r && -1 < S.inArray(o, r)) i && i.push(o);
        else if (l = ie(o), a = ve(f.appendChild(o), "script"), l && ye(a), n) {
        c = 0;
        while (o = a[c++]) he.test(o.type || "") && n.push(o)
      }
      return f
    }
    var be = /^([^.]*)(?:\.(.+)|)/;

    function we() {
      return !0
    }

    function Te() {
      return !1
    }

    function Ce(e, t) {
      return e === function() {
        try {
          return E.activeElement
        } catch (e) {}
      }() == ("focus" === t)
    }

    function Ee(e, t, n, r, i, o) {
      var a, s;
      if ("object" == typeof t) {
        for (s in "string" != typeof n && (r = r || n, n = void 0), t) Ee(e, s, n, r, t[s], o);
        return e
      }
      if (null == r && null == i ? (i = n, r = n = void 0) : null == i && ("string" == typeof n ? (i = r, r = void 0) : (i = r, r = n, n = void 0)), !1 === i) i = Te;
      else if (!i) return e;
      return 1 === o && (a = i, (i = function(e) {
        return S().off(e), a.apply(this, arguments)
      }).guid = a.guid || (a.guid = S.guid++)), e.each(function() {
        S.event.add(this, t, i, r, n)
      })
    }

    function Se(e, i, o) {
      o ? (Y.set(e, i, !1), S.event.add(e, i, {
        namespace: !1,
        handler: function(e) {
          var t, n, r = Y.get(this, i);
          if (1 & e.isTrigger && this[i]) {
            if (r.length)(S.event.special[i] || {}).delegateType && e.stopPropagation();
            else if (r = s.call(arguments), Y.set(this, i, r), t = o(this, i), this[i](), r !== (n = Y.get(this, i)) || t ? Y.set(this, i, !1) : n = {}, r !== n) return e.stopImmediatePropagation(), e.preventDefault(), n && n.value
          } else r.length && (Y.set(this, i, {
            value: S.event.trigger(S.extend(r[0], S.Event.prototype), r.slice(1), this)
          }), e.stopImmediatePropagation())
        }
      })) : void 0 === Y.get(e, i) && S.event.add(e, i, we)
    }
    S.event = {
      global: {},
      add: function(t, e, n, r, i) {
        var o, a, s, u, l, c, f, p, d, h, g, v = Y.get(t);
        if (V(t)) {
          n.handler && (n = (o = n).handler, i = o.selector), i && S.find.matchesSelector(re, i), n.guid || (n.guid = S.guid++), (u = v.events) || (u = v.events = Object.create(null)), (a = v.handle) || (a = v.handle = function(e) {
            return "undefined" != typeof S && S.event.triggered !== e.type ? S.event.dispatch.apply(t, arguments) : void 0
          }), l = (e = (e || "").match(P) || [""]).length;
          while (l--) d = g = (s = be.exec(e[l]) || [])[1], h = (s[2] || "").split(".").sort(), d && (f = S.event.special[d] || {}, d = (i ? f.delegateType : f.bindType) || d, f = S.event.special[d] || {}, c = S.extend({
            type: d,
            origType: g,
            data: r,
            handler: n,
            guid: n.guid,
            selector: i,
            needsContext: i && S.expr.match.needsContext.test(i),
            namespace: h.join(".")
          }, o), (p = u[d]) || ((p = u[d] = []).delegateCount = 0, f.setup && !1 !== f.setup.call(t, r, h, a) || t.addEventListener && t.addEventListener(d, a)), f.add && (f.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, c) : p.push(c), S.event.global[d] = !0)
        }
      },
      remove: function(e, t, n, r, i) {
        var o, a, s, u, l, c, f, p, d, h, g, v = Y.hasData(e) && Y.get(e);
        if (v && (u = v.events)) {
          l = (t = (t || "").match(P) || [""]).length;
          while (l--)
            if (d = g = (s = be.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d) {
              f = S.event.special[d] || {}, p = u[d = (r ? f.delegateType : f.bindType) || d] || [], s = s[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), a = o = p.length;
              while (o--) c = p[o], !i && g !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || r && r !== c.selector && ("**" !== r || !c.selector) || (p.splice(o, 1), c.selector && p.delegateCount--, f.remove && f.remove.call(e, c));
              a && !p.length && (f.teardown && !1 !== f.teardown.call(e, h, v.handle) || S.removeEvent(e, d, v.handle), delete u[d])
            } else
              for (d in u) S.event.remove(e, d + t[l], n, r, !0);
          S.isEmptyObject(u) && Y.remove(e, "handle events")
        }
      },
      dispatch: function(e) {
        var t, n, r, i, o, a, s = new Array(arguments.length),
          u = S.event.fix(e),
          l = (Y.get(this, "events") || Object.create(null))[u.type] || [],
          c = S.event.special[u.type] || {};
        for (s[0] = u, t = 1; t < arguments.length; t++) s[t] = arguments[t];
        if (u.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, u)) {
          a = S.event.handlers.call(this, u, l), t = 0;
          while ((i = a[t++]) && !u.isPropagationStopped()) {
            u.currentTarget = i.elem, n = 0;
            while ((o = i.handlers[n++]) && !u.isImmediatePropagationStopped()) u.rnamespace && !1 !== o.namespace && !u.rnamespace.test(o.namespace) || (u.handleObj = o, u.data = o.data, void 0 !== (r = ((S.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, s)) && !1 === (u.result = r) && (u.preventDefault(), u.stopPropagation()))
          }
          return c.postDispatch && c.postDispatch.call(this, u), u.result
        }
      },
      handlers: function(e, t) {
        var n, r, i, o, a, s = [],
          u = t.delegateCount,
          l = e.target;
        if (u && l.nodeType && !("click" === e.type && 1 <= e.button))
          for (; l !== this; l = l.parentNode || this)
            if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
              for (o = [], a = {}, n = 0; n < u; n++) void 0 === a[i = (r = t[n]).selector + " "] && (a[i] = r.needsContext ? -1 < S(i, this).index(l) : S.find(i, this, null, [l]).length), a[i] && o.push(r);
              o.length && s.push({
                elem: l,
                handlers: o
              })
            } return l = this, u < t.length && s.push({
          elem: l,
          handlers: t.slice(u)
        }), s
      },
      addProp: function(t, e) {
        Object.defineProperty(S.Event.prototype, t, {
          enumerable: !0,
          configurable: !0,
          get: m(e) ? function() {
            if (this.originalEvent) return e(this.originalEvent)
          } : function() {
            if (this.originalEvent) return this.originalEvent[t]
          },
          set: function(e) {
            Object.defineProperty(this, t, {
              enumerable: !0,
              configurable: !0,
              writable: !0,
              value: e
            })
          }
        })
      },
      fix: function(e) {
        return e[S.expando] ? e : new S.Event(e)
      },
      special: {
        load: {
          noBubble: !0
        },
        click: {
          setup: function(e) {
            var t = this || e;
            return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click", we), !1
          },
          trigger: function(e) {
            var t = this || e;
            return pe.test(t.type) && t.click && A(t, "input") && Se(t, "click"), !0
          },
          _default: function(e) {
            var t = e.target;
            return pe.test(t.type) && t.click && A(t, "input") && Y.get(t, "click") || A(t, "a")
          }
        },
        beforeunload: {
          postDispatch: function(e) {
            void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
          }
        }
      }
    }, S.removeEvent = function(e, t, n) {
      e.removeEventListener && e.removeEventListener(t, n)
    }, S.Event = function(e, t) {
      if (!(this instanceof S.Event)) return new S.Event(e, t);
      e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? we : Te, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && S.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[S.expando] = !0
    }, S.Event.prototype = {
      constructor: S.Event,
      isDefaultPrevented: Te,
      isPropagationStopped: Te,
      isImmediatePropagationStopped: Te,
      isSimulated: !1,
      preventDefault: function() {
        var e = this.originalEvent;
        this.isDefaultPrevented = we, e && !this.isSimulated && e.preventDefault()
      },
      stopPropagation: function() {
        var e = this.originalEvent;
        this.isPropagationStopped = we, e && !this.isSimulated && e.stopPropagation()
      },
      stopImmediatePropagation: function() {
        var e = this.originalEvent;
        this.isImmediatePropagationStopped = we, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
      }
    }, S.each({
      altKey: !0,
      bubbles: !0,
      cancelable: !0,
      changedTouches: !0,
      ctrlKey: !0,
      detail: !0,
      eventPhase: !0,
      metaKey: !0,
      pageX: !0,
      pageY: !0,
      shiftKey: !0,
      view: !0,
      "char": !0,
      code: !0,
      charCode: !0,
      key: !0,
      keyCode: !0,
      button: !0,
      buttons: !0,
      clientX: !0,
      clientY: !0,
      offsetX: !0,
      offsetY: !0,
      pointerId: !0,
      pointerType: !0,
      screenX: !0,
      screenY: !0,
      targetTouches: !0,
      toElement: !0,
      touches: !0,
      which: !0
    }, S.event.addProp), S.each({
      focus: "focusin",
      blur: "focusout"
    }, function(e, t) {
      S.event.special[e] = {
        setup: function() {
          return Se(this, e, Ce), !1
        },
        trigger: function() {
          return Se(this, e), !0
        },
        _default: function() {
          return !0
        },
        delegateType: t
      }
    }), S.each({
      mouseenter: "mouseover",
      mouseleave: "mouseout",
      pointerenter: "pointerover",
      pointerleave: "pointerout"
    }, function(e, i) {
      S.event.special[e] = {
        delegateType: i,
        bindType: i,
        handle: function(e) {
          var t, n = e.relatedTarget,
            r = e.handleObj;
          return n && (n === this || S.contains(this, n)) || (e.type = r.origType, t = r.handler.apply(this, arguments), e.type = i), t
        }
      }
    }), S.fn.extend({
      on: function(e, t, n, r) {
        return Ee(this, e, t, n, r)
      },
      one: function(e, t, n, r) {
        return Ee(this, e, t, n, r, 1)
      },
      off: function(e, t, n) {
        var r, i;
        if (e && e.preventDefault && e.handleObj) return r = e.handleObj, S(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
        if ("object" == typeof e) {
          for (i in e) this.off(i, t, e[i]);
          return this
        }
        return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = Te), this.each(function() {
          S.event.remove(this, e, n, t)
        })
      }
    });
    var ke = /<script|<style|<link/i,
      Ae = /checked\s*(?:[^=]|=\s*.checked.)/i,
      Ne = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function je(e, t) {
      return A(e, "table") && A(11 !== t.nodeType ? t : t.firstChild, "tr") && S(e).children("tbody")[0] || e
    }

    function De(e) {
      return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function qe(e) {
      return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Le(e, t) {
      var n, r, i, o, a, s;
      if (1 === t.nodeType) {
        if (Y.hasData(e) && (s = Y.get(e).events))
          for (i in Y.remove(t, "handle events"), s)
            for (n = 0, r = s[i].length; n < r; n++) S.event.add(t, i, s[i][n]);
        Q.hasData(e) && (o = Q.access(e), a = S.extend({}, o), Q.set(t, a))
      }
    }

    function He(n, r, i, o) {
      r = g(r);
      var e, t, a, s, u, l, c = 0,
        f = n.length,
        p = f - 1,
        d = r[0],
        h = m(d);
      if (h || 1 < f && "string" == typeof d && !y.checkClone && Ae.test(d)) return n.each(function(e) {
        var t = n.eq(e);
        h && (r[0] = d.call(this, e, t.html())), He(t, r, i, o)
      });
      if (f && (t = (e = xe(r, n[0].ownerDocument, !1, n, o)).firstChild, 1 === e.childNodes.length && (e = t), t || o)) {
        for (s = (a = S.map(ve(e, "script"), De)).length; c < f; c++) u = e, c !== p && (u = S.clone(u, !0, !0), s && S.merge(a, ve(u, "script"))), i.call(n[c], u, c);
        if (s)
          for (l = a[a.length - 1].ownerDocument, S.map(a, qe), c = 0; c < s; c++) u = a[c], he.test(u.type || "") && !Y.access(u, "globalEval") && S.contains(l, u) && (u.src && "module" !== (u.type || "").toLowerCase() ? S._evalUrl && !u.noModule && S._evalUrl(u.src, {
            nonce: u.nonce || u.getAttribute("nonce")
          }, l) : b(u.textContent.replace(Ne, ""), u, l))
      }
      return n
    }

    function Oe(e, t, n) {
      for (var r, i = t ? S.filter(t, e) : e, o = 0; null != (r = i[o]); o++) n || 1 !== r.nodeType || S.cleanData(ve(r)), r.parentNode && (n && ie(r) && ye(ve(r, "script")), r.parentNode.removeChild(r));
      return e
    }
    S.extend({
      htmlPrefilter: function(e) {
        return e
      },
      clone: function(e, t, n) {
        var r, i, o, a, s, u, l, c = e.cloneNode(!0),
          f = ie(e);
        if (!(y.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || S.isXMLDoc(e)))
          for (a = ve(c), r = 0, i = (o = ve(e)).length; r < i; r++) s = o[r], u = a[r], void 0, "input" === (l = u.nodeName.toLowerCase()) && pe.test(s.type) ? u.checked = s.checked : "input" !== l && "textarea" !== l || (u.defaultValue = s.defaultValue);
        if (t)
          if (n)
            for (o = o || ve(e), a = a || ve(c), r = 0, i = o.length; r < i; r++) Le(o[r], a[r]);
          else Le(e, c);
        return 0 < (a = ve(c, "script")).length && ye(a, !f && ve(e, "script")), c
      },
      cleanData: function(e) {
        for (var t, n, r, i = S.event.special, o = 0; void 0 !== (n = e[o]); o++)
          if (V(n)) {
            if (t = n[Y.expando]) {
              if (t.events)
                for (r in t.events) i[r] ? S.event.remove(n, r) : S.removeEvent(n, r, t.handle);
              n[Y.expando] = void 0
            }
            n[Q.expando] && (n[Q.expando] = void 0)
          }
      }
    }), S.fn.extend({
      detach: function(e) {
        return Oe(this, e, !0)
      },
      remove: function(e) {
        return Oe(this, e)
      },
      text: function(e) {
        return $(this, function(e) {
          return void 0 === e ? S.text(this) : this.empty().each(function() {
            1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
          })
        }, null, e, arguments.length)
      },
      append: function() {
        return He(this, arguments, function(e) {
          1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || je(this, e).appendChild(e)
        })
      },
      prepend: function() {
        return He(this, arguments, function(e) {
          if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
            var t = je(this, e);
            t.insertBefore(e, t.firstChild)
          }
        })
      },
      before: function() {
        return He(this, arguments, function(e) {
          this.parentNode && this.parentNode.insertBefore(e, this)
        })
      },
      after: function() {
        return He(this, arguments, function(e) {
          this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
        })
      },
      empty: function() {
        for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (S.cleanData(ve(e, !1)), e.textContent = "");
        return this
      },
      clone: function(e, t) {
        return e = null != e && e, t = null == t ? e : t, this.map(function() {
          return S.clone(this, e, t)
        })
      },
      html: function(e) {
        return $(this, function(e) {
          var t = this[0] || {},
            n = 0,
            r = this.length;
          if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
          if ("string" == typeof e && !ke.test(e) && !ge[(de.exec(e) || ["", ""])[1].toLowerCase()]) {
            e = S.htmlPrefilter(e);
            try {
              for (; n < r; n++) 1 === (t = this[n] || {}).nodeType && (S.cleanData(ve(t, !1)), t.innerHTML = e);
              t = 0
            } catch (e) {}
          }
          t && this.empty().append(e)
        }, null, e, arguments.length)
      },
      replaceWith: function() {
        var n = [];
        return He(this, arguments, function(e) {
          var t = this.parentNode;
          S.inArray(this, n) < 0 && (S.cleanData(ve(this)), t && t.replaceChild(e, this))
        }, n)
      }
    }), S.each({
      appendTo: "append",
      prependTo: "prepend",
      insertBefore: "before",
      insertAfter: "after",
      replaceAll: "replaceWith"
    }, function(e, a) {
      S.fn[e] = function(e) {
        for (var t, n = [], r = S(e), i = r.length - 1, o = 0; o <= i; o++) t = o === i ? this : this.clone(!0), S(r[o])[a](t), u.apply(n, t.get());
        return this.pushStack(n)
      }
    });
    var Pe = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"),
      Re = function(e) {
        var t = e.ownerDocument.defaultView;
        return t && t.opener || (t = C), t.getComputedStyle(e)
      },
      Me = function(e, t, n) {
        var r, i, o = {};
        for (i in t) o[i] = e.style[i], e.style[i] = t[i];
        for (i in r = n.call(e), t) e.style[i] = o[i];
        return r
      },
      Ie = new RegExp(ne.join("|"), "i");

    function We(e, t, n) {
      var r, i, o, a, s = e.style;
      return (n = n || Re(e)) && ("" !== (a = n.getPropertyValue(t) || n[t]) || ie(e) || (a = S.style(e, t)), !y.pixelBoxStyles() && Pe.test(a) && Ie.test(t) && (r = s.width, i = s.minWidth, o = s.maxWidth, s.minWidth = s.maxWidth = s.width = a, a = n.width, s.width = r, s.minWidth = i, s.maxWidth = o)), void 0 !== a ? a + "" : a
    }

    function Fe(e, t) {
      return {
        get: function() {
          if (!e()) return (this.get = t).apply(this, arguments);
          delete this.get
        }
      }
    }! function() {
      function e() {
        if (l) {
          u.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", l.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", re.appendChild(u).appendChild(l);
          var e = C.getComputedStyle(l);
          n = "1%" !== e.top, s = 12 === t(e.marginLeft), l.style.right = "60%", o = 36 === t(e.right), r = 36 === t(e.width), l.style.position = "absolute", i = 12 === t(l.offsetWidth / 3), re.removeChild(u), l = null
        }
      }

      function t(e) {
        return Math.round(parseFloat(e))
      }
      var n, r, i, o, a, s, u = E.createElement("div"),
        l = E.createElement("div");
      l.style && (l.style.backgroundClip = "content-box", l.cloneNode(!0).style.backgroundClip = "", y.clearCloneStyle = "content-box" === l.style.backgroundClip, S.extend(y, {
        boxSizingReliable: function() {
          return e(), r
        },
        pixelBoxStyles: function() {
          return e(), o
        },
        pixelPosition: function() {
          return e(), n
        },
        reliableMarginLeft: function() {
          return e(), s
        },
        scrollboxSize: function() {
          return e(), i
        },
        reliableTrDimensions: function() {
          var e, t, n, r;
          return null == a && (e = E.createElement("table"), t = E.createElement("tr"), n = E.createElement("div"), e.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", t.style.cssText = "border:1px solid", t.style.height = "1px", n.style.height = "9px", n.style.display = "block", re.appendChild(e).appendChild(t).appendChild(n), r = C.getComputedStyle(t), a = parseInt(r.height, 10) + parseInt(r.borderTopWidth, 10) + parseInt(r.borderBottomWidth, 10) === t.offsetHeight, re.removeChild(e)), a
        }
      }))
    }();
    var Be = ["Webkit", "Moz", "ms"],
      $e = E.createElement("div").style,
      _e = {};

    function ze(e) {
      var t = S.cssProps[e] || _e[e];
      return t || (e in $e ? e : _e[e] = function(e) {
        var t = e[0].toUpperCase() + e.slice(1),
          n = Be.length;
        while (n--)
          if ((e = Be[n] + t) in $e) return e
      }(e) || e)
    }
    var Ue = /^(none|table(?!-c[ea]).+)/,
      Xe = /^--/,
      Ve = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
      },
      Ge = {
        letterSpacing: "0",
        fontWeight: "400"
      };

    function Ye(e, t, n) {
      var r = te.exec(t);
      return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t
    }

    function Qe(e, t, n, r, i, o) {
      var a = "width" === t ? 1 : 0,
        s = 0,
        u = 0;
      if (n === (r ? "border" : "content")) return 0;
      for (; a < 4; a += 2) "margin" === n && (u += S.css(e, n + ne[a], !0, i)), r ? ("content" === n && (u -= S.css(e, "padding" + ne[a], !0, i)), "margin" !== n && (u -= S.css(e, "border" + ne[a] + "Width", !0, i))) : (u += S.css(e, "padding" + ne[a], !0, i), "padding" !== n ? u += S.css(e, "border" + ne[a] + "Width", !0, i) : s += S.css(e, "border" + ne[a] + "Width", !0, i));
      return !r && 0 <= o && (u += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - o - u - s - .5)) || 0), u
    }

    function Je(e, t, n) {
      var r = Re(e),
        i = (!y.boxSizingReliable() || n) && "border-box" === S.css(e, "boxSizing", !1, r),
        o = i,
        a = We(e, t, r),
        s = "offset" + t[0].toUpperCase() + t.slice(1);
      if (Pe.test(a)) {
        if (!n) return a;
        a = "auto"
      }
      return (!y.boxSizingReliable() && i || !y.reliableTrDimensions() && A(e, "tr") || "auto" === a || !parseFloat(a) && "inline" === S.css(e, "display", !1, r)) && e.getClientRects().length && (i = "border-box" === S.css(e, "boxSizing", !1, r), (o = s in e) && (a = e[s])), (a = parseFloat(a) || 0) + Qe(e, t, n || (i ? "border" : "content"), o, r, a) + "px"
    }

    function Ke(e, t, n, r, i) {
      return new Ke.prototype.init(e, t, n, r, i)
    }
    S.extend({
      cssHooks: {
        opacity: {
          get: function(e, t) {
            if (t) {
              var n = We(e, "opacity");
              return "" === n ? "1" : n
            }
          }
        }
      },
      cssNumber: {
        animationIterationCount: !0,
        columnCount: !0,
        fillOpacity: !0,
        flexGrow: !0,
        flexShrink: !0,
        fontWeight: !0,
        gridArea: !0,
        gridColumn: !0,
        gridColumnEnd: !0,
        gridColumnStart: !0,
        gridRow: !0,
        gridRowEnd: !0,
        gridRowStart: !0,
        lineHeight: !0,
        opacity: !0,
        order: !0,
        orphans: !0,
        widows: !0,
        zIndex: !0,
        zoom: !0
      },
      cssProps: {},
      style: function(e, t, n, r) {
        if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
          var i, o, a, s = X(t),
            u = Xe.test(t),
            l = e.style;
          if (u || (t = ze(s)), a = S.cssHooks[t] || S.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
          "string" === (o = typeof n) && (i = te.exec(n)) && i[1] && (n = se(e, t, i), o = "number"), null != n && n == n && ("number" !== o || u || (n += i && i[3] || (S.cssNumber[s] ? "" : "px")), y.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), a && "set" in a && void 0 === (n = a.set(e, n, r)) || (u ? l.setProperty(t, n) : l[t] = n))
        }
      },
      css: function(e, t, n, r) {
        var i, o, a, s = X(t);
        return Xe.test(t) || (t = ze(s)), (a = S.cssHooks[t] || S.cssHooks[s]) && "get" in a && (i = a.get(e, !0, n)), void 0 === i && (i = We(e, t, r)), "normal" === i && t in Ge && (i = Ge[t]), "" === n || n ? (o = parseFloat(i), !0 === n || isFinite(o) ? o || 0 : i) : i
      }
    }), S.each(["height", "width"], function(e, u) {
      S.cssHooks[u] = {
        get: function(e, t, n) {
          if (t) return !Ue.test(S.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? Je(e, u, n) : Me(e, Ve, function() {
            return Je(e, u, n)
          })
        },
        set: function(e, t, n) {
          var r, i = Re(e),
            o = !y.scrollboxSize() && "absolute" === i.position,
            a = (o || n) && "border-box" === S.css(e, "boxSizing", !1, i),
            s = n ? Qe(e, u, n, a, i) : 0;
          return a && o && (s -= Math.ceil(e["offset" + u[0].toUpperCase() + u.slice(1)] - parseFloat(i[u]) - Qe(e, u, "border", !1, i) - .5)), s && (r = te.exec(t)) && "px" !== (r[3] || "px") && (e.style[u] = t, t = S.css(e, u)), Ye(0, t, s)
        }
      }
    }), S.cssHooks.marginLeft = Fe(y.reliableMarginLeft, function(e, t) {
      if (t) return (parseFloat(We(e, "marginLeft")) || e.getBoundingClientRect().left - Me(e, {
        marginLeft: 0
      }, function() {
        return e.getBoundingClientRect().left
      })) + "px"
    }), S.each({
      margin: "",
      padding: "",
      border: "Width"
    }, function(i, o) {
      S.cssHooks[i + o] = {
        expand: function(e) {
          for (var t = 0, n = {}, r = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[i + ne[t] + o] = r[t] || r[t - 2] || r[0];
          return n
        }
      }, "margin" !== i && (S.cssHooks[i + o].set = Ye)
    }), S.fn.extend({
      css: function(e, t) {
        return $(this, function(e, t, n) {
          var r, i, o = {},
            a = 0;
          if (Array.isArray(t)) {
            for (r = Re(e), i = t.length; a < i; a++) o[t[a]] = S.css(e, t[a], !1, r);
            return o
          }
          return void 0 !== n ? S.style(e, t, n) : S.css(e, t)
        }, e, t, 1 < arguments.length)
      }
    }), ((S.Tween = Ke).prototype = {
      constructor: Ke,
      init: function(e, t, n, r, i, o) {
        this.elem = e, this.prop = n, this.easing = i || S.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (S.cssNumber[n] ? "" : "px")
      },
      cur: function() {
        var e = Ke.propHooks[this.prop];
        return e && e.get ? e.get(this) : Ke.propHooks._default.get(this)
      },
      run: function(e) {
        var t, n = Ke.propHooks[this.prop];
        return this.options.duration ? this.pos = t = S.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : Ke.propHooks._default.set(this), this
      }
    }).init.prototype = Ke.prototype, (Ke.propHooks = {
      _default: {
        get: function(e) {
          var t;
          return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = S.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
        },
        set: function(e) {
          S.fx.step[e.prop] ? S.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !S.cssHooks[e.prop] && null == e.elem.style[ze(e.prop)] ? e.elem[e.prop] = e.now : S.style(e.elem, e.prop, e.now + e.unit)
        }
      }
    }).scrollTop = Ke.propHooks.scrollLeft = {
      set: function(e) {
        e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
      }
    }, S.easing = {
      linear: function(e) {
        return e
      },
      swing: function(e) {
        return .5 - Math.cos(e * Math.PI) / 2
      },
      _default: "swing"
    }, S.fx = Ke.prototype.init, S.fx.step = {};
    var Ze, et, tt, nt, rt = /^(?:toggle|show|hide)$/,
      it = /queueHooks$/;

    function ot() {
      et && (!1 === E.hidden && C.requestAnimationFrame ? C.requestAnimationFrame(ot) : C.setTimeout(ot, S.fx.interval), S.fx.tick())
    }

    function at() {
      return C.setTimeout(function() {
        Ze = void 0
      }), Ze = Date.now()
    }

    function st(e, t) {
      var n, r = 0,
        i = {
          height: e
        };
      for (t = t ? 1 : 0; r < 4; r += 2 - t) i["margin" + (n = ne[r])] = i["padding" + n] = e;
      return t && (i.opacity = i.width = e), i
    }

    function ut(e, t, n) {
      for (var r, i = (lt.tweeners[t] || []).concat(lt.tweeners["*"]), o = 0, a = i.length; o < a; o++)
        if (r = i[o].call(n, t, e)) return r
    }

    function lt(o, e, t) {
      var n, a, r = 0,
        i = lt.prefilters.length,
        s = S.Deferred().always(function() {
          delete u.elem
        }),
        u = function() {
          if (a) return !1;
          for (var e = Ze || at(), t = Math.max(0, l.startTime + l.duration - e), n = 1 - (t / l.duration || 0), r = 0, i = l.tweens.length; r < i; r++) l.tweens[r].run(n);
          return s.notifyWith(o, [l, n, t]), n < 1 && i ? t : (i || s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l]), !1)
        },
        l = s.promise({
          elem: o,
          props: S.extend({}, e),
          opts: S.extend(!0, {
            specialEasing: {},
            easing: S.easing._default
          }, t),
          originalProperties: e,
          originalOptions: t,
          startTime: Ze || at(),
          duration: t.duration,
          tweens: [],
          createTween: function(e, t) {
            var n = S.Tween(o, l.opts, e, t, l.opts.specialEasing[e] || l.opts.easing);
            return l.tweens.push(n), n
          },
          stop: function(e) {
            var t = 0,
              n = e ? l.tweens.length : 0;
            if (a) return this;
            for (a = !0; t < n; t++) l.tweens[t].run(1);
            return e ? (s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l, e])) : s.rejectWith(o, [l, e]), this
          }
        }),
        c = l.props;
      for (! function(e, t) {
          var n, r, i, o, a;
          for (n in e)
            if (i = t[r = X(n)], o = e[n], Array.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = S.cssHooks[r]) && "expand" in a)
              for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i);
            else t[r] = i
        }(c, l.opts.specialEasing); r < i; r++)
        if (n = lt.prefilters[r].call(l, o, c, l.opts)) return m(n.stop) && (S._queueHooks(l.elem, l.opts.queue).stop = n.stop.bind(n)), n;
      return S.map(c, ut, l), m(l.opts.start) && l.opts.start.call(o, l), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always), S.fx.timer(S.extend(u, {
        elem: o,
        anim: l,
        queue: l.opts.queue
      })), l
    }
    S.Animation = S.extend(lt, {
      tweeners: {
        "*": [function(e, t) {
          var n = this.createTween(e, t);
          return se(n.elem, e, te.exec(t), n), n
        }]
      },
      tweener: function(e, t) {
        m(e) ? (t = e, e = ["*"]) : e = e.match(P);
        for (var n, r = 0, i = e.length; r < i; r++) n = e[r], lt.tweeners[n] = lt.tweeners[n] || [], lt.tweeners[n].unshift(t)
      },
      prefilters: [function(e, t, n) {
        var r, i, o, a, s, u, l, c, f = "width" in t || "height" in t,
          p = this,
          d = {},
          h = e.style,
          g = e.nodeType && ae(e),
          v = Y.get(e, "fxshow");
        for (r in n.queue || (null == (a = S._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, s = a.empty.fire, a.empty.fire = function() {
            a.unqueued || s()
          }), a.unqueued++, p.always(function() {
            p.always(function() {
              a.unqueued--, S.queue(e, "fx").length || a.empty.fire()
            })
          })), t)
          if (i = t[r], rt.test(i)) {
            if (delete t[r], o = o || "toggle" === i, i === (g ? "hide" : "show")) {
              if ("show" !== i || !v || void 0 === v[r]) continue;
              g = !0
            }
            d[r] = v && v[r] || S.style(e, r)
          } if ((u = !S.isEmptyObject(t)) || !S.isEmptyObject(d))
          for (r in f && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (l = v && v.display) && (l = Y.get(e, "display")), "none" === (c = S.css(e, "display")) && (l ? c = l : (le([e], !0), l = e.style.display || l, c = S.css(e, "display"), le([e]))), ("inline" === c || "inline-block" === c && null != l) && "none" === S.css(e, "float") && (u || (p.done(function() {
              h.display = l
            }), null == l && (c = h.display, l = "none" === c ? "" : c)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", p.always(function() {
              h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
            })), u = !1, d) u || (v ? "hidden" in v && (g = v.hidden) : v = Y.access(e, "fxshow", {
            display: l
          }), o && (v.hidden = !g), g && le([e], !0), p.done(function() {
            for (r in g || le([e]), Y.remove(e, "fxshow"), d) S.style(e, r, d[r])
          })), u = ut(g ? v[r] : 0, r, p), r in v || (v[r] = u.start, g && (u.end = u.start, u.start = 0))
      }],
      prefilter: function(e, t) {
        t ? lt.prefilters.unshift(e) : lt.prefilters.push(e)
      }
    }), S.speed = function(e, t, n) {
      var r = e && "object" == typeof e ? S.extend({}, e) : {
        complete: n || !n && t || m(e) && e,
        duration: e,
        easing: n && t || t && !m(t) && t
      };
      return S.fx.off ? r.duration = 0 : "number" != typeof r.duration && (r.duration in S.fx.speeds ? r.duration = S.fx.speeds[r.duration] : r.duration = S.fx.speeds._default), null != r.queue && !0 !== r.queue || (r.queue = "fx"), r.old = r.complete, r.complete = function() {
        m(r.old) && r.old.call(this), r.queue && S.dequeue(this, r.queue)
      }, r
    }, S.fn.extend({
      fadeTo: function(e, t, n, r) {
        return this.filter(ae).css("opacity", 0).show().end().animate({
          opacity: t
        }, e, n, r)
      },
      animate: function(t, e, n, r) {
        var i = S.isEmptyObject(t),
          o = S.speed(e, n, r),
          a = function() {
            var e = lt(this, S.extend({}, t), o);
            (i || Y.get(this, "finish")) && e.stop(!0)
          };
        return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
      },
      stop: function(i, e, o) {
        var a = function(e) {
          var t = e.stop;
          delete e.stop, t(o)
        };
        return "string" != typeof i && (o = e, e = i, i = void 0), e && this.queue(i || "fx", []), this.each(function() {
          var e = !0,
            t = null != i && i + "queueHooks",
            n = S.timers,
            r = Y.get(this);
          if (t) r[t] && r[t].stop && a(r[t]);
          else
            for (t in r) r[t] && r[t].stop && it.test(t) && a(r[t]);
          for (t = n.length; t--;) n[t].elem !== this || null != i && n[t].queue !== i || (n[t].anim.stop(o), e = !1, n.splice(t, 1));
          !e && o || S.dequeue(this, i)
        })
      },
      finish: function(a) {
        return !1 !== a && (a = a || "fx"), this.each(function() {
          var e, t = Y.get(this),
            n = t[a + "queue"],
            r = t[a + "queueHooks"],
            i = S.timers,
            o = n ? n.length : 0;
          for (t.finish = !0, S.queue(this, a, []), r && r.stop && r.stop.call(this, !0), e = i.length; e--;) i[e].elem === this && i[e].queue === a && (i[e].anim.stop(!0), i.splice(e, 1));
          for (e = 0; e < o; e++) n[e] && n[e].finish && n[e].finish.call(this);
          delete t.finish
        })
      }
    }), S.each(["toggle", "show", "hide"], function(e, r) {
      var i = S.fn[r];
      S.fn[r] = function(e, t, n) {
        return null == e || "boolean" == typeof e ? i.apply(this, arguments) : this.animate(st(r, !0), e, t, n)
      }
    }), S.each({
      slideDown: st("show"),
      slideUp: st("hide"),
      slideToggle: st("toggle"),
      fadeIn: {
        opacity: "show"
      },
      fadeOut: {
        opacity: "hide"
      },
      fadeToggle: {
        opacity: "toggle"
      }
    }, function(e, r) {
      S.fn[e] = function(e, t, n) {
        return this.animate(r, e, t, n)
      }
    }), S.timers = [], S.fx.tick = function() {
      var e, t = 0,
        n = S.timers;
      for (Ze = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
      n.length || S.fx.stop(), Ze = void 0
    }, S.fx.timer = function(e) {
      S.timers.push(e), S.fx.start()
    }, S.fx.interval = 13, S.fx.start = function() {
      et || (et = !0, ot())
    }, S.fx.stop = function() {
      et = null
    }, S.fx.speeds = {
      slow: 600,
      fast: 200,
      _default: 400
    }, S.fn.delay = function(r, e) {
      return r = S.fx && S.fx.speeds[r] || r, e = e || "fx", this.queue(e, function(e, t) {
        var n = C.setTimeout(e, r);
        t.stop = function() {
          C.clearTimeout(n)
        }
      })
    }, tt = E.createElement("input"), nt = E.createElement("select").appendChild(E.createElement("option")), tt.type = "checkbox", y.checkOn = "" !== tt.value, y.optSelected = nt.selected, (tt = E.createElement("input")).value = "t", tt.type = "radio", y.radioValue = "t" === tt.value;
    var ct, ft = S.expr.attrHandle;
    S.fn.extend({
      attr: function(e, t) {
        return $(this, S.attr, e, t, 1 < arguments.length)
      },
      removeAttr: function(e) {
        return this.each(function() {
          S.removeAttr(this, e)
        })
      }
    }), S.extend({
      attr: function(e, t, n) {
        var r, i, o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o) return "undefined" == typeof e.getAttribute ? S.prop(e, t, n) : (1 === o && S.isXMLDoc(e) || (i = S.attrHooks[t.toLowerCase()] || (S.expr.match.bool.test(t) ? ct : void 0)), void 0 !== n ? null === n ? void S.removeAttr(e, t) : i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : (e.setAttribute(t, n + ""), n) : i && "get" in i && null !== (r = i.get(e, t)) ? r : null == (r = S.find.attr(e, t)) ? void 0 : r)
      },
      attrHooks: {
        type: {
          set: function(e, t) {
            if (!y.radioValue && "radio" === t && A(e, "input")) {
              var n = e.value;
              return e.setAttribute("type", t), n && (e.value = n), t
            }
          }
        }
      },
      removeAttr: function(e, t) {
        var n, r = 0,
          i = t && t.match(P);
        if (i && 1 === e.nodeType)
          while (n = i[r++]) e.removeAttribute(n)
      }
    }), ct = {
      set: function(e, t, n) {
        return !1 === t ? S.removeAttr(e, n) : e.setAttribute(n, n), n
      }
    }, S.each(S.expr.match.bool.source.match(/\w+/g), function(e, t) {
      var a = ft[t] || S.find.attr;
      ft[t] = function(e, t, n) {
        var r, i, o = t.toLowerCase();
        return n || (i = ft[o], ft[o] = r, r = null != a(e, t, n) ? o : null, ft[o] = i), r
      }
    });
    var pt = /^(?:input|select|textarea|button)$/i,
      dt = /^(?:a|area)$/i;

    function ht(e) {
      return (e.match(P) || []).join(" ")
    }

    function gt(e) {
      return e.getAttribute && e.getAttribute("class") || ""
    }

    function vt(e) {
      return Array.isArray(e) ? e : "string" == typeof e && e.match(P) || []
    }
    S.fn.extend({
      prop: function(e, t) {
        return $(this, S.prop, e, t, 1 < arguments.length)
      },
      removeProp: function(e) {
        return this.each(function() {
          delete this[S.propFix[e] || e]
        })
      }
    }), S.extend({
      prop: function(e, t, n) {
        var r, i, o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o) return 1 === o && S.isXMLDoc(e) || (t = S.propFix[t] || t, i = S.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
      },
      propHooks: {
        tabIndex: {
          get: function(e) {
            var t = S.find.attr(e, "tabindex");
            return t ? parseInt(t, 10) : pt.test(e.nodeName) || dt.test(e.nodeName) && e.href ? 0 : -1
          }
        }
      },
      propFix: {
        "for": "htmlFor",
        "class": "className"
      }
    }), y.optSelected || (S.propHooks.selected = {
      get: function(e) {
        var t = e.parentNode;
        return t && t.parentNode && t.parentNode.selectedIndex, null
      },
      set: function(e) {
        var t = e.parentNode;
        t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
      }
    }), S.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
      S.propFix[this.toLowerCase()] = this
    }), S.fn.extend({
      addClass: function(t) {
        var e, n, r, i, o, a, s, u = 0;
        if (m(t)) return this.each(function(e) {
          S(this).addClass(t.call(this, e, gt(this)))
        });
        if ((e = vt(t)).length)
          while (n = this[u++])
            if (i = gt(n), r = 1 === n.nodeType && " " + ht(i) + " ") {
              a = 0;
              while (o = e[a++]) r.indexOf(" " + o + " ") < 0 && (r += o + " ");
              i !== (s = ht(r)) && n.setAttribute("class", s)
            } return this
      },
      removeClass: function(t) {
        var e, n, r, i, o, a, s, u = 0;
        if (m(t)) return this.each(function(e) {
          S(this).removeClass(t.call(this, e, gt(this)))
        });
        if (!arguments.length) return this.attr("class", "");
        if ((e = vt(t)).length)
          while (n = this[u++])
            if (i = gt(n), r = 1 === n.nodeType && " " + ht(i) + " ") {
              a = 0;
              while (o = e[a++])
                while (-1 < r.indexOf(" " + o + " ")) r = r.replace(" " + o + " ", " ");
              i !== (s = ht(r)) && n.setAttribute("class", s)
            } return this
      },
      toggleClass: function(i, t) {
        var o = typeof i,
          a = "string" === o || Array.isArray(i);
        return "boolean" == typeof t && a ? t ? this.addClass(i) : this.removeClass(i) : m(i) ? this.each(function(e) {
          S(this).toggleClass(i.call(this, e, gt(this), t), t)
        }) : this.each(function() {
          var e, t, n, r;
          if (a) {
            t = 0, n = S(this), r = vt(i);
            while (e = r[t++]) n.hasClass(e) ? n.removeClass(e) : n.addClass(e)
          } else void 0 !== i && "boolean" !== o || ((e = gt(this)) && Y.set(this, "__className__", e), this.setAttribute && this.setAttribute("class", e || !1 === i ? "" : Y.get(this, "__className__") || ""))
        })
      },
      hasClass: function(e) {
        var t, n, r = 0;
        t = " " + e + " ";
        while (n = this[r++])
          if (1 === n.nodeType && -1 < (" " + ht(gt(n)) + " ").indexOf(t)) return !0;
        return !1
      }
    });
    var yt = /\r/g;
    S.fn.extend({
      val: function(n) {
        var r, e, i, t = this[0];
        return arguments.length ? (i = m(n), this.each(function(e) {
          var t;
          1 === this.nodeType && (null == (t = i ? n.call(this, e, S(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : Array.isArray(t) && (t = S.map(t, function(e) {
            return null == e ? "" : e + ""
          })), (r = S.valHooks[this.type] || S.valHooks[this.nodeName.toLowerCase()]) && "set" in r && void 0 !== r.set(this, t, "value") || (this.value = t))
        })) : t ? (r = S.valHooks[t.type] || S.valHooks[t.nodeName.toLowerCase()]) && "get" in r && void 0 !== (e = r.get(t, "value")) ? e : "string" == typeof(e = t.value) ? e.replace(yt, "") : null == e ? "" : e : void 0
      }
    }), S.extend({
      valHooks: {
        option: {
          get: function(e) {
            var t = S.find.attr(e, "value");
            return null != t ? t : ht(S.text(e))
          }
        },
        select: {
          get: function(e) {
            var t, n, r, i = e.options,
              o = e.selectedIndex,
              a = "select-one" === e.type,
              s = a ? null : [],
              u = a ? o + 1 : i.length;
            for (r = o < 0 ? u : a ? o : 0; r < u; r++)
              if (((n = i[r]).selected || r === o) && !n.disabled && (!n.parentNode.disabled || !A(n.parentNode, "optgroup"))) {
                if (t = S(n).val(), a) return t;
                s.push(t)
              } return s
          },
          set: function(e, t) {
            var n, r, i = e.options,
              o = S.makeArray(t),
              a = i.length;
            while (a--)((r = i[a]).selected = -1 < S.inArray(S.valHooks.option.get(r), o)) && (n = !0);
            return n || (e.selectedIndex = -1), o
          }
        }
      }
    }), S.each(["radio", "checkbox"], function() {
      S.valHooks[this] = {
        set: function(e, t) {
          if (Array.isArray(t)) return e.checked = -1 < S.inArray(S(e).val(), t)
        }
      }, y.checkOn || (S.valHooks[this].get = function(e) {
        return null === e.getAttribute("value") ? "on" : e.value
      })
    }), y.focusin = "onfocusin" in C;
    var mt = /^(?:focusinfocus|focusoutblur)$/,
      xt = function(e) {
        e.stopPropagation()
      };
    S.extend(S.event, {
      trigger: function(e, t, n, r) {
        var i, o, a, s, u, l, c, f, p = [n || E],
          d = v.call(e, "type") ? e.type : e,
          h = v.call(e, "namespace") ? e.namespace.split(".") : [];
        if (o = f = a = n = n || E, 3 !== n.nodeType && 8 !== n.nodeType && !mt.test(d + S.event.triggered) && (-1 < d.indexOf(".") && (d = (h = d.split(".")).shift(), h.sort()), u = d.indexOf(":") < 0 && "on" + d, (e = e[S.expando] ? e : new S.Event(d, "object" == typeof e && e)).isTrigger = r ? 2 : 3, e.namespace = h.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : S.makeArray(t, [e]), c = S.event.special[d] || {}, r || !c.trigger || !1 !== c.trigger.apply(n, t))) {
          if (!r && !c.noBubble && !x(n)) {
            for (s = c.delegateType || d, mt.test(s + d) || (o = o.parentNode); o; o = o.parentNode) p.push(o), a = o;
            a === (n.ownerDocument || E) && p.push(a.defaultView || a.parentWindow || C)
          }
          i = 0;
          while ((o = p[i++]) && !e.isPropagationStopped()) f = o, e.type = 1 < i ? s : c.bindType || d, (l = (Y.get(o, "events") || Object.create(null))[e.type] && Y.get(o, "handle")) && l.apply(o, t), (l = u && o[u]) && l.apply && V(o) && (e.result = l.apply(o, t), !1 === e.result && e.preventDefault());
          return e.type = d, r || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(p.pop(), t) || !V(n) || u && m(n[d]) && !x(n) && ((a = n[u]) && (n[u] = null), S.event.triggered = d, e.isPropagationStopped() && f.addEventListener(d, xt), n[d](), e.isPropagationStopped() && f.removeEventListener(d, xt), S.event.triggered = void 0, a && (n[u] = a)), e.result
        }
      },
      simulate: function(e, t, n) {
        var r = S.extend(new S.Event, n, {
          type: e,
          isSimulated: !0
        });
        S.event.trigger(r, null, t)
      }
    }), S.fn.extend({
      trigger: function(e, t) {
        return this.each(function() {
          S.event.trigger(e, t, this)
        })
      },
      triggerHandler: function(e, t) {
        var n = this[0];
        if (n) return S.event.trigger(e, t, n, !0)
      }
    }), y.focusin || S.each({
      focus: "focusin",
      blur: "focusout"
    }, function(n, r) {
      var i = function(e) {
        S.event.simulate(r, e.target, S.event.fix(e))
      };
      S.event.special[r] = {
        setup: function() {
          var e = this.ownerDocument || this.document || this,
            t = Y.access(e, r);
          t || e.addEventListener(n, i, !0), Y.access(e, r, (t || 0) + 1)
        },
        teardown: function() {
          var e = this.ownerDocument || this.document || this,
            t = Y.access(e, r) - 1;
          t ? Y.access(e, r, t) : (e.removeEventListener(n, i, !0), Y.remove(e, r))
        }
      }
    });
    var bt = C.location,
      wt = {
        guid: Date.now()
      },
      Tt = /\?/;
    S.parseXML = function(e) {
      var t, n;
      if (!e || "string" != typeof e) return null;
      try {
        t = (new C.DOMParser).parseFromString(e, "text/xml")
      } catch (e) {}
      return n = t && t.getElementsByTagName("parsererror")[0], t && !n || S.error("Invalid XML: " + (n ? S.map(n.childNodes, function(e) {
        return e.textContent
      }).join("\n") : e)), t
    };
    var Ct = /\[\]$/,
      Et = /\r?\n/g,
      St = /^(?:submit|button|image|reset|file)$/i,
      kt = /^(?:input|select|textarea|keygen)/i;

    function At(n, e, r, i) {
      var t;
      if (Array.isArray(e)) S.each(e, function(e, t) {
        r || Ct.test(n) ? i(n, t) : At(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, r, i)
      });
      else if (r || "object" !== w(e)) i(n, e);
      else
        for (t in e) At(n + "[" + t + "]", e[t], r, i)
    }
    S.param = function(e, t) {
      var n, r = [],
        i = function(e, t) {
          var n = m(t) ? t() : t;
          r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
        };
      if (null == e) return "";
      if (Array.isArray(e) || e.jquery && !S.isPlainObject(e)) S.each(e, function() {
        i(this.name, this.value)
      });
      else
        for (n in e) At(n, e[n], t, i);
      return r.join("&")
    }, S.fn.extend({
      serialize: function() {
        return S.param(this.serializeArray())
      },
      serializeArray: function() {
        return this.map(function() {
          var e = S.prop(this, "elements");
          return e ? S.makeArray(e) : this
        }).filter(function() {
          var e = this.type;
          return this.name && !S(this).is(":disabled") && kt.test(this.nodeName) && !St.test(e) && (this.checked || !pe.test(e))
        }).map(function(e, t) {
          var n = S(this).val();
          return null == n ? null : Array.isArray(n) ? S.map(n, function(e) {
            return {
              name: t.name,
              value: e.replace(Et, "\r\n")
            }
          }) : {
            name: t.name,
            value: n.replace(Et, "\r\n")
          }
        }).get()
      }
    });
    var Nt = /%20/g,
      jt = /#.*$/,
      Dt = /([?&])_=[^&]*/,
      qt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
      Lt = /^(?:GET|HEAD)$/,
      Ht = /^\/\//,
      Ot = {},
      Pt = {},
      Rt = "*/".concat("*"),
      Mt = E.createElement("a");

    function It(o) {
      return function(e, t) {
        "string" != typeof e && (t = e, e = "*");
        var n, r = 0,
          i = e.toLowerCase().match(P) || [];
        if (m(t))
          while (n = i[r++]) "+" === n[0] ? (n = n.slice(1) || "*", (o[n] = o[n] || []).unshift(t)) : (o[n] = o[n] || []).push(t)
      }
    }

    function Wt(t, i, o, a) {
      var s = {},
        u = t === Pt;

      function l(e) {
        var r;
        return s[e] = !0, S.each(t[e] || [], function(e, t) {
          var n = t(i, o, a);
          return "string" != typeof n || u || s[n] ? u ? !(r = n) : void 0 : (i.dataTypes.unshift(n), l(n), !1)
        }), r
      }
      return l(i.dataTypes[0]) || !s["*"] && l("*")
    }

    function Ft(e, t) {
      var n, r, i = S.ajaxSettings.flatOptions || {};
      for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
      return r && S.extend(!0, e, r), e
    }
    Mt.href = bt.href, S.extend({
      active: 0,
      lastModified: {},
      etag: {},
      ajaxSettings: {
        url: bt.href,
        type: "GET",
        isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(bt.protocol),
        global: !0,
        processData: !0,
        async: !0,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        accepts: {
          "*": Rt,
          text: "text/plain",
          html: "text/html",
          xml: "application/xml, text/xml",
          json: "application/json, text/javascript"
        },
        contents: {
          xml: /\bxml\b/,
          html: /\bhtml/,
          json: /\bjson\b/
        },
        responseFields: {
          xml: "responseXML",
          text: "responseText",
          json: "responseJSON"
        },
        converters: {
          "* text": String,
          "text html": !0,
          "text json": JSON.parse,
          "text xml": S.parseXML
        },
        flatOptions: {
          url: !0,
          context: !0
        }
      },
      ajaxSetup: function(e, t) {
        return t ? Ft(Ft(e, S.ajaxSettings), t) : Ft(S.ajaxSettings, e)
      },
      ajaxPrefilter: It(Ot),
      ajaxTransport: It(Pt),
      ajax: function(e, t) {
        "object" == typeof e && (t = e, e = void 0), t = t || {};
        var c, f, p, n, d, r, h, g, i, o, v = S.ajaxSetup({}, t),
          y = v.context || v,
          m = v.context && (y.nodeType || y.jquery) ? S(y) : S.event,
          x = S.Deferred(),
          b = S.Callbacks("once memory"),
          w = v.statusCode || {},
          a = {},
          s = {},
          u = "canceled",
          T = {
            readyState: 0,
            getResponseHeader: function(e) {
              var t;
              if (h) {
                if (!n) {
                  n = {};
                  while (t = qt.exec(p)) n[t[1].toLowerCase() + " "] = (n[t[1].toLowerCase() + " "] || []).concat(t[2])
                }
                t = n[e.toLowerCase() + " "]
              }
              return null == t ? null : t.join(", ")
            },
            getAllResponseHeaders: function() {
              return h ? p : null
            },
            setRequestHeader: function(e, t) {
              return null == h && (e = s[e.toLowerCase()] = s[e.toLowerCase()] || e, a[e] = t), this
            },
            overrideMimeType: function(e) {
              return null == h && (v.mimeType = e), this
            },
            statusCode: function(e) {
              var t;
              if (e)
                if (h) T.always(e[T.status]);
                else
                  for (t in e) w[t] = [w[t], e[t]];
              return this
            },
            abort: function(e) {
              var t = e || u;
              return c && c.abort(t), l(0, t), this
            }
          };
        if (x.promise(T), v.url = ((e || v.url || bt.href) + "").replace(Ht, bt.protocol + "//"), v.type = t.method || t.type || v.method || v.type, v.dataTypes = (v.dataType || "*").toLowerCase().match(P) || [""], null == v.crossDomain) {
          r = E.createElement("a");
          try {
            r.href = v.url, r.href = r.href, v.crossDomain = Mt.protocol + "//" + Mt.host != r.protocol + "//" + r.host
          } catch (e) {
            v.crossDomain = !0
          }
        }
        if (v.data && v.processData && "string" != typeof v.data && (v.data = S.param(v.data, v.traditional)), Wt(Ot, v, t, T), h) return T;
        for (i in (g = S.event && v.global) && 0 == S.active++ && S.event.trigger("ajaxStart"), v.type = v.type.toUpperCase(), v.hasContent = !Lt.test(v.type), f = v.url.replace(jt, ""), v.hasContent ? v.data && v.processData && 0 === (v.contentType || "").indexOf("application/x-www-form-urlencoded") && (v.data = v.data.replace(Nt, "+")) : (o = v.url.slice(f.length), v.data && (v.processData || "string" == typeof v.data) && (f += (Tt.test(f) ? "&" : "?") + v.data, delete v.data), !1 === v.cache && (f = f.replace(Dt, "$1"), o = (Tt.test(f) ? "&" : "?") + "_=" + wt.guid++ + o), v.url = f + o), v.ifModified && (S.lastModified[f] && T.setRequestHeader("If-Modified-Since", S.lastModified[f]), S.etag[f] && T.setRequestHeader("If-None-Match", S.etag[f])), (v.data && v.hasContent && !1 !== v.contentType || t.contentType) && T.setRequestHeader("Content-Type", v.contentType), T.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]] + ("*" !== v.dataTypes[0] ? ", " + Rt + "; q=0.01" : "") : v.accepts["*"]), v.headers) T.setRequestHeader(i, v.headers[i]);
        if (v.beforeSend && (!1 === v.beforeSend.call(y, T, v) || h)) return T.abort();
        if (u = "abort", b.add(v.complete), T.done(v.success), T.fail(v.error), c = Wt(Pt, v, t, T)) {
          if (T.readyState = 1, g && m.trigger("ajaxSend", [T, v]), h) return T;
          v.async && 0 < v.timeout && (d = C.setTimeout(function() {
            T.abort("timeout")
          }, v.timeout));
          try {
            h = !1, c.send(a, l)
          } catch (e) {
            if (h) throw e;
            l(-1, e)
          }
        } else l(-1, "No Transport");

        function l(e, t, n, r) {
          var i, o, a, s, u, l = t;
          h || (h = !0, d && C.clearTimeout(d), c = void 0, p = r || "", T.readyState = 0 < e ? 4 : 0, i = 200 <= e && e < 300 || 304 === e, n && (s = function(e, t, n) {
            var r, i, o, a, s = e.contents,
              u = e.dataTypes;
            while ("*" === u[0]) u.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
            if (r)
              for (i in s)
                if (s[i] && s[i].test(r)) {
                  u.unshift(i);
                  break
                } if (u[0] in n) o = u[0];
            else {
              for (i in n) {
                if (!u[0] || e.converters[i + " " + u[0]]) {
                  o = i;
                  break
                }
                a || (a = i)
              }
              o = o || a
            }
            if (o) return o !== u[0] && u.unshift(o), n[o]
          }(v, T, n)), !i && -1 < S.inArray("script", v.dataTypes) && S.inArray("json", v.dataTypes) < 0 && (v.converters["text script"] = function() {}), s = function(e, t, n, r) {
            var i, o, a, s, u, l = {},
              c = e.dataTypes.slice();
            if (c[1])
              for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
            o = c.shift();
            while (o)
              if (e.responseFields[o] && (n[e.responseFields[o]] = t), !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), u = o, o = c.shift())
                if ("*" === o) o = u;
                else if ("*" !== u && u !== o) {
              if (!(a = l[u + " " + o] || l["* " + o]))
                for (i in l)
                  if ((s = i.split(" "))[1] === o && (a = l[u + " " + s[0]] || l["* " + s[0]])) {
                    !0 === a ? a = l[i] : !0 !== l[i] && (o = s[0], c.unshift(s[1]));
                    break
                  } if (!0 !== a)
                if (a && e["throws"]) t = a(t);
                else try {
                  t = a(t)
                } catch (e) {
                  return {
                    state: "parsererror",
                    error: a ? e : "No conversion from " + u + " to " + o
                  }
                }
            }
            return {
              state: "success",
              data: t
            }
          }(v, s, T, i), i ? (v.ifModified && ((u = T.getResponseHeader("Last-Modified")) && (S.lastModified[f] = u), (u = T.getResponseHeader("etag")) && (S.etag[f] = u)), 204 === e || "HEAD" === v.type ? l = "nocontent" : 304 === e ? l = "notmodified" : (l = s.state, o = s.data, i = !(a = s.error))) : (a = l, !e && l || (l = "error", e < 0 && (e = 0))), T.status = e, T.statusText = (t || l) + "", i ? x.resolveWith(y, [o, l, T]) : x.rejectWith(y, [T, l, a]), T.statusCode(w), w = void 0, g && m.trigger(i ? "ajaxSuccess" : "ajaxError", [T, v, i ? o : a]), b.fireWith(y, [T, l]), g && (m.trigger("ajaxComplete", [T, v]), --S.active || S.event.trigger("ajaxStop")))
        }
        return T
      },
      getJSON: function(e, t, n) {
        return S.get(e, t, n, "json")
      },
      getScript: function(e, t) {
        return S.get(e, void 0, t, "script")
      }
    }), S.each(["get", "post"], function(e, i) {
      S[i] = function(e, t, n, r) {
        return m(t) && (r = r || n, n = t, t = void 0), S.ajax(S.extend({
          url: e,
          type: i,
          dataType: r,
          data: t,
          success: n
        }, S.isPlainObject(e) && e))
      }
    }), S.ajaxPrefilter(function(e) {
      var t;
      for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    }), S._evalUrl = function(e, t, n) {
      return S.ajax({
        url: e,
        type: "GET",
        dataType: "script",
        cache: !0,
        async: !1,
        global: !1,
        converters: {
          "text script": function() {}
        },
        dataFilter: function(e) {
          S.globalEval(e, t, n)
        }
      })
    }, S.fn.extend({
      wrapAll: function(e) {
        var t;
        return this[0] && (m(e) && (e = e.call(this[0])), t = S(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
          var e = this;
          while (e.firstElementChild) e = e.firstElementChild;
          return e
        }).append(this)), this
      },
      wrapInner: function(n) {
        return m(n) ? this.each(function(e) {
          S(this).wrapInner(n.call(this, e))
        }) : this.each(function() {
          var e = S(this),
            t = e.contents();
          t.length ? t.wrapAll(n) : e.append(n)
        })
      },
      wrap: function(t) {
        var n = m(t);
        return this.each(function(e) {
          S(this).wrapAll(n ? t.call(this, e) : t)
        })
      },
      unwrap: function(e) {
        return this.parent(e).not("body").each(function() {
          S(this).replaceWith(this.childNodes)
        }), this
      }
    }), S.expr.pseudos.hidden = function(e) {
      return !S.expr.pseudos.visible(e)
    }, S.expr.pseudos.visible = function(e) {
      return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, S.ajaxSettings.xhr = function() {
      try {
        return new C.XMLHttpRequest
      } catch (e) {}
    };
    var Bt = {
        0: 200,
        1223: 204
      },
      $t = S.ajaxSettings.xhr();
    y.cors = !!$t && "withCredentials" in $t, y.ajax = $t = !!$t, S.ajaxTransport(function(i) {
      var o, a;
      if (y.cors || $t && !i.crossDomain) return {
        send: function(e, t) {
          var n, r = i.xhr();
          if (r.open(i.type, i.url, i.async, i.username, i.password), i.xhrFields)
            for (n in i.xhrFields) r[n] = i.xhrFields[n];
          for (n in i.mimeType && r.overrideMimeType && r.overrideMimeType(i.mimeType), i.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) r.setRequestHeader(n, e[n]);
          o = function(e) {
            return function() {
              o && (o = a = r.onload = r.onerror = r.onabort = r.ontimeout = r.onreadystatechange = null, "abort" === e ? r.abort() : "error" === e ? "number" != typeof r.status ? t(0, "error") : t(r.status, r.statusText) : t(Bt[r.status] || r.status, r.statusText, "text" !== (r.responseType || "text") || "string" != typeof r.responseText ? {
                binary: r.response
              } : {
                text: r.responseText
              }, r.getAllResponseHeaders()))
            }
          }, r.onload = o(), a = r.onerror = r.ontimeout = o("error"), void 0 !== r.onabort ? r.onabort = a : r.onreadystatechange = function() {
            4 === r.readyState && C.setTimeout(function() {
              o && a()
            })
          }, o = o("abort");
          try {
            r.send(i.hasContent && i.data || null)
          } catch (e) {
            if (o) throw e
          }
        },
        abort: function() {
          o && o()
        }
      }
    }), S.ajaxPrefilter(function(e) {
      e.crossDomain && (e.contents.script = !1)
    }), S.ajaxSetup({
      accepts: {
        script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
      },
      contents: {
        script: /\b(?:java|ecma)script\b/
      },
      converters: {
        "text script": function(e) {
          return S.globalEval(e), e
        }
      }
    }), S.ajaxPrefilter("script", function(e) {
      void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), S.ajaxTransport("script", function(n) {
      var r, i;
      if (n.crossDomain || n.scriptAttrs) return {
        send: function(e, t) {
          r = S("<script>").attr(n.scriptAttrs || {}).prop({
            charset: n.scriptCharset,
            src: n.url
          }).on("load error", i = function(e) {
            r.remove(), i = null, e && t("error" === e.type ? 404 : 200, e.type)
          }), E.head.appendChild(r[0])
        },
        abort: function() {
          i && i()
        }
      }
    });
    var _t, zt = [],
      Ut = /(=)\?(?=&|$)|\?\?/;
    S.ajaxSetup({
      jsonp: "callback",
      jsonpCallback: function() {
        var e = zt.pop() || S.expando + "_" + wt.guid++;
        return this[e] = !0, e
      }
    }), S.ajaxPrefilter("json jsonp", function(e, t, n) {
      var r, i, o, a = !1 !== e.jsonp && (Ut.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Ut.test(e.data) && "data");
      if (a || "jsonp" === e.dataTypes[0]) return r = e.jsonpCallback = m(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Ut, "$1" + r) : !1 !== e.jsonp && (e.url += (Tt.test(e.url) ? "&" : "?") + e.jsonp + "=" + r), e.converters["script json"] = function() {
        return o || S.error(r + " was not called"), o[0]
      }, e.dataTypes[0] = "json", i = C[r], C[r] = function() {
        o = arguments
      }, n.always(function() {
        void 0 === i ? S(C).removeProp(r) : C[r] = i, e[r] && (e.jsonpCallback = t.jsonpCallback, zt.push(r)), o && m(i) && i(o[0]), o = i = void 0
      }), "script"
    }), y.createHTMLDocument = ((_t = E.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === _t.childNodes.length), S.parseHTML = function(e, t, n) {
      return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (y.createHTMLDocument ? ((r = (t = E.implementation.createHTMLDocument("")).createElement("base")).href = E.location.href, t.head.appendChild(r)) : t = E), o = !n && [], (i = N.exec(e)) ? [t.createElement(i[1])] : (i = xe([e], t, o), o && o.length && S(o).remove(), S.merge([], i.childNodes)));
      var r, i, o
    }, S.fn.load = function(e, t, n) {
      var r, i, o, a = this,
        s = e.indexOf(" ");
      return -1 < s && (r = ht(e.slice(s)), e = e.slice(0, s)), m(t) ? (n = t, t = void 0) : t && "object" == typeof t && (i = "POST"), 0 < a.length && S.ajax({
        url: e,
        type: i || "GET",
        dataType: "html",
        data: t
      }).done(function(e) {
        o = arguments, a.html(r ? S("<div>").append(S.parseHTML(e)).find(r) : e)
      }).always(n && function(e, t) {
        a.each(function() {
          n.apply(this, o || [e.responseText, t, e])
        })
      }), this
    }, S.expr.pseudos.animated = function(t) {
      return S.grep(S.timers, function(e) {
        return t === e.elem
      }).length
    }, S.offset = {
      setOffset: function(e, t, n) {
        var r, i, o, a, s, u, l = S.css(e, "position"),
          c = S(e),
          f = {};
        "static" === l && (e.style.position = "relative"), s = c.offset(), o = S.css(e, "top"), u = S.css(e, "left"), ("absolute" === l || "fixed" === l) && -1 < (o + u).indexOf("auto") ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(u) || 0), m(t) && (t = t.call(e, n, S.extend({}, s))), null != t.top && (f.top = t.top - s.top + a), null != t.left && (f.left = t.left - s.left + i), "using" in t ? t.using.call(e, f) : c.css(f)
      }
    }, S.fn.extend({
      offset: function(t) {
        if (arguments.length) return void 0 === t ? this : this.each(function(e) {
          S.offset.setOffset(this, t, e)
        });
        var e, n, r = this[0];
        return r ? r.getClientRects().length ? (e = r.getBoundingClientRect(), n = r.ownerDocument.defaultView, {
          top: e.top + n.pageYOffset,
          left: e.left + n.pageXOffset
        }) : {
          top: 0,
          left: 0
        } : void 0
      },
      position: function() {
        if (this[0]) {
          var e, t, n, r = this[0],
            i = {
              top: 0,
              left: 0
            };
          if ("fixed" === S.css(r, "position")) t = r.getBoundingClientRect();
          else {
            t = this.offset(), n = r.ownerDocument, e = r.offsetParent || n.documentElement;
            while (e && (e === n.body || e === n.documentElement) && "static" === S.css(e, "position")) e = e.parentNode;
            e && e !== r && 1 === e.nodeType && ((i = S(e).offset()).top += S.css(e, "borderTopWidth", !0), i.left += S.css(e, "borderLeftWidth", !0))
          }
          return {
            top: t.top - i.top - S.css(r, "marginTop", !0),
            left: t.left - i.left - S.css(r, "marginLeft", !0)
          }
        }
      },
      offsetParent: function() {
        return this.map(function() {
          var e = this.offsetParent;
          while (e && "static" === S.css(e, "position")) e = e.offsetParent;
          return e || re
        })
      }
    }), S.each({
      scrollLeft: "pageXOffset",
      scrollTop: "pageYOffset"
    }, function(t, i) {
      var o = "pageYOffset" === i;
      S.fn[t] = function(e) {
        return $(this, function(e, t, n) {
          var r;
          if (x(e) ? r = e : 9 === e.nodeType && (r = e.defaultView), void 0 === n) return r ? r[i] : e[t];
          r ? r.scrollTo(o ? r.pageXOffset : n, o ? n : r.pageYOffset) : e[t] = n
        }, t, e, arguments.length)
      }
    }), S.each(["top", "left"], function(e, n) {
      S.cssHooks[n] = Fe(y.pixelPosition, function(e, t) {
        if (t) return t = We(e, n), Pe.test(t) ? S(e).position()[n] + "px" : t
      })
    }), S.each({
      Height: "height",
      Width: "width"
    }, function(a, s) {
      S.each({
        padding: "inner" + a,
        content: s,
        "": "outer" + a
      }, function(r, o) {
        S.fn[o] = function(e, t) {
          var n = arguments.length && (r || "boolean" != typeof e),
            i = r || (!0 === e || !0 === t ? "margin" : "border");
          return $(this, function(e, t, n) {
            var r;
            return x(e) ? 0 === o.indexOf("outer") ? e["inner" + a] : e.document.documentElement["client" + a] : 9 === e.nodeType ? (r = e.documentElement, Math.max(e.body["scroll" + a], r["scroll" + a], e.body["offset" + a], r["offset" + a], r["client" + a])) : void 0 === n ? S.css(e, t, i) : S.style(e, t, n, i)
          }, s, n ? e : void 0, n)
        }
      })
    }), S.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
      S.fn[t] = function(e) {
        return this.on(t, e)
      }
    }), S.fn.extend({
      bind: function(e, t, n) {
        return this.on(e, null, t, n)
      },
      unbind: function(e, t) {
        return this.off(e, null, t)
      },
      delegate: function(e, t, n, r) {
        return this.on(t, e, n, r)
      },
      undelegate: function(e, t, n) {
        return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
      },
      hover: function(e, t) {
        return this.mouseenter(e).mouseleave(t || e)
      }
    }), S.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(e, n) {
      S.fn[n] = function(e, t) {
        return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
      }
    });
    var Xt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    S.proxy = function(e, t) {
      var n, r, i;
      if ("string" == typeof t && (n = e[t], t = e, e = n), m(e)) return r = s.call(arguments, 2), (i = function() {
        return e.apply(t || this, r.concat(s.call(arguments)))
      }).guid = e.guid = e.guid || S.guid++, i
    }, S.holdReady = function(e) {
      e ? S.readyWait++ : S.ready(!0)
    }, S.isArray = Array.isArray, S.parseJSON = JSON.parse, S.nodeName = A, S.isFunction = m, S.isWindow = x, S.camelCase = X, S.type = w, S.now = Date.now, S.isNumeric = function(e) {
      var t = S.type(e);
      return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, S.trim = function(e) {
      return null == e ? "" : (e + "").replace(Xt, "")
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
      return S
    });
    var Vt = C.jQuery,
      Gt = C.$;
    return S.noConflict = function(e) {
      return C.$ === S && (C.$ = Gt), e && C.jQuery === S && (C.jQuery = Vt), S
    }, "undefined" == typeof e && (C.jQuery = C.$ = S), S
  });
</script>
<!--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>-->
<script>
  ! function(e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
      if (!e.document) throw new Error("jQuery requires a window with a document");
      return t(e)
    } : t(e)
  }("undefined" != typeof window ? window : this, function(ie, e) {
    "use strict";
    var oe = [],
      r = Object.getPrototypeOf,
      ae = oe.slice,
      g = oe.flat ? function(e) {
        return oe.flat.call(e)
      } : function(e) {
        return oe.concat.apply([], e)
      },
      s = oe.push,
      se = oe.indexOf,
      n = {},
      i = n.toString,
      ue = n.hasOwnProperty,
      o = ue.toString,
      a = o.call(Object),
      le = {},
      v = function(e) {
        return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
      },
      y = function(e) {
        return null != e && e === e.window
      },
      C = ie.document,
      u = {
        type: !0,
        src: !0,
        nonce: !0,
        noModule: !0
      };

    function m(e, t, n) {
      var r, i, o = (n = n || C).createElement("script");
      if (o.text = e, t)
        for (r in u)(i = t[r] || t.getAttribute && t.getAttribute(r)) && o.setAttribute(r, i);
      n.head.appendChild(o).parentNode.removeChild(o)
    }

    function x(e) {
      return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? n[i.call(e)] || "object" : typeof e
    }
    var t = "3.7.1",
      l = /HTML$/i,
      ce = function(e, t) {
        return new ce.fn.init(e, t)
      };

    function c(e) {
      var t = !!e && "length" in e && e.length,
        n = x(e);
      return !v(e) && !y(e) && ("array" === n || 0 === t || "number" == typeof t && 0 < t && t - 1 in e)
    }

    function fe(e, t) {
      return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }
    ce.fn = ce.prototype = {
      jquery: t,
      constructor: ce,
      length: 0,
      toArray: function() {
        return ae.call(this)
      },
      get: function(e) {
        return null == e ? ae.call(this) : e < 0 ? this[e + this.length] : this[e]
      },
      pushStack: function(e) {
        var t = ce.merge(this.constructor(), e);
        return t.prevObject = this, t
      },
      each: function(e) {
        return ce.each(this, e)
      },
      map: function(n) {
        return this.pushStack(ce.map(this, function(e, t) {
          return n.call(e, t, e)
        }))
      },
      slice: function() {
        return this.pushStack(ae.apply(this, arguments))
      },
      first: function() {
        return this.eq(0)
      },
      last: function() {
        return this.eq(-1)
      },
      even: function() {
        return this.pushStack(ce.grep(this, function(e, t) {
          return (t + 1) % 2
        }))
      },
      odd: function() {
        return this.pushStack(ce.grep(this, function(e, t) {
          return t % 2
        }))
      },
      eq: function(e) {
        var t = this.length,
          n = +e + (e < 0 ? t : 0);
        return this.pushStack(0 <= n && n < t ? [this[n]] : [])
      },
      end: function() {
        return this.prevObject || this.constructor()
      },
      push: s,
      sort: oe.sort,
      splice: oe.splice
    }, ce.extend = ce.fn.extend = function() {
      var e, t, n, r, i, o, a = arguments[0] || {},
        s = 1,
        u = arguments.length,
        l = !1;
      for ("boolean" == typeof a && (l = a, a = arguments[s] || {}, s++), "object" == typeof a || v(a) || (a = {}), s === u && (a = this, s--); s < u; s++)
        if (null != (e = arguments[s]))
          for (t in e) r = e[t], "__proto__" !== t && a !== r && (l && r && (ce.isPlainObject(r) || (i = Array.isArray(r))) ? (n = a[t], o = i && !Array.isArray(n) ? [] : i || ce.isPlainObject(n) ? n : {}, i = !1, a[t] = ce.extend(l, o, r)) : void 0 !== r && (a[t] = r));
      return a
    }, ce.extend({
      expando: "jQuery" + (t + Math.random()).replace(/\D/g, ""),
      isReady: !0,
      error: function(e) {
        throw new Error(e)
      },
      noop: function() {},
      isPlainObject: function(e) {
        var t, n;
        return !(!e || "[object Object]" !== i.call(e)) && (!(t = r(e)) || "function" == typeof(n = ue.call(t, "constructor") && t.constructor) && o.call(n) === a)
      },
      isEmptyObject: function(e) {
        var t;
        for (t in e) return !1;
        return !0
      },
      globalEval: function(e, t, n) {
        m(e, {
          nonce: t && t.nonce
        }, n)
      },
      each: function(e, t) {
        var n, r = 0;
        if (c(e)) {
          for (n = e.length; r < n; r++)
            if (!1 === t.call(e[r], r, e[r])) break
        } else
          for (r in e)
            if (!1 === t.call(e[r], r, e[r])) break;
        return e
      },
      text: function(e) {
        var t, n = "",
          r = 0,
          i = e.nodeType;
        if (!i)
          while (t = e[r++]) n += ce.text(t);
        return 1 === i || 11 === i ? e.textContent : 9 === i ? e.documentElement.textContent : 3 === i || 4 === i ? e.nodeValue : n
      },
      makeArray: function(e, t) {
        var n = t || [];
        return null != e && (c(Object(e)) ? ce.merge(n, "string" == typeof e ? [e] : e) : s.call(n, e)), n
      },
      inArray: function(e, t, n) {
        return null == t ? -1 : se.call(t, e, n)
      },
      isXMLDoc: function(e) {
        var t = e && e.namespaceURI,
          n = e && (e.ownerDocument || e).documentElement;
        return !l.test(t || n && n.nodeName || "HTML")
      },
      merge: function(e, t) {
        for (var n = +t.length, r = 0, i = e.length; r < n; r++) e[i++] = t[r];
        return e.length = i, e
      },
      grep: function(e, t, n) {
        for (var r = [], i = 0, o = e.length, a = !n; i < o; i++) !t(e[i], i) !== a && r.push(e[i]);
        return r
      },
      map: function(e, t, n) {
        var r, i, o = 0,
          a = [];
        if (c(e))
          for (r = e.length; o < r; o++) null != (i = t(e[o], o, n)) && a.push(i);
        else
          for (o in e) null != (i = t(e[o], o, n)) && a.push(i);
        return g(a)
      },
      guid: 1,
      support: le
    }), "function" == typeof Symbol && (ce.fn[Symbol.iterator] = oe[Symbol.iterator]), ce.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function(e, t) {
      n["[object " + t + "]"] = t.toLowerCase()
    });
    var pe = oe.pop,
      de = oe.sort,
      he = oe.splice,
      ge = "[\\x20\\t\\r\\n\\f]",
      ve = new RegExp("^" + ge + "+|((?:^|[^\\\\])(?:\\\\.)*)" + ge + "+$", "g");
    ce.contains = function(e, t) {
      var n = t && t.parentNode;
      return e === n || !(!n || 1 !== n.nodeType || !(e.contains ? e.contains(n) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(n)))
    };
    var f = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\x80-\uFFFF\w-]/g;

    function p(e, t) {
      return t ? "\0" === e ? "\ufffd" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
    }
    ce.escapeSelector = function(e) {
      return (e + "").replace(f, p)
    };
    var ye = C,
      me = s;
    ! function() {
      var e, b, w, o, a, T, r, C, d, i, k = me,
        S = ce.expando,
        E = 0,
        n = 0,
        s = W(),
        c = W(),
        u = W(),
        h = W(),
        l = function(e, t) {
          return e === t && (a = !0), 0
        },
        f = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
        t = "(?:\\\\[\\da-fA-F]{1,6}" + ge + "?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
        p = "\\[" + ge + "*(" + t + ")(?:" + ge + "*([*^$|!~]?=)" + ge + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + t + "))|)" + ge + "*\\]",
        g = ":(" + t + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + p + ")*)|.*)\\)|)",
        v = new RegExp(ge + "+", "g"),
        y = new RegExp("^" + ge + "*," + ge + "*"),
        m = new RegExp("^" + ge + "*([>+~]|" + ge + ")" + ge + "*"),
        x = new RegExp(ge + "|>"),
        j = new RegExp(g),
        A = new RegExp("^" + t + "$"),
        D = {
          ID: new RegExp("^#(" + t + ")"),
          CLASS: new RegExp("^\\.(" + t + ")"),
          TAG: new RegExp("^(" + t + "|[*])"),
          ATTR: new RegExp("^" + p),
          PSEUDO: new RegExp("^" + g),
          CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + ge + "*(even|odd|(([+-]|)(\\d*)n|)" + ge + "*(?:([+-]|)" + ge + "*(\\d+)|))" + ge + "*\\)|)", "i"),
          bool: new RegExp("^(?:" + f + ")$", "i"),
          needsContext: new RegExp("^" + ge + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + ge + "*((?:-\\d)?\\d*)" + ge + "*\\)|)(?=[^-]|$)", "i")
        },
        N = /^(?:input|select|textarea|button)$/i,
        q = /^h\d$/i,
        L = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
        H = /[+~]/,
        O = new RegExp("\\\\[\\da-fA-F]{1,6}" + ge + "?|\\\\([^\\r\\n\\f])", "g"),
        P = function(e, t) {
          var n = "0x" + e.slice(1) - 65536;
          return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
        },
        M = function() {
          V()
        },
        R = J(function(e) {
          return !0 === e.disabled && fe(e, "fieldset")
        }, {
          dir: "parentNode",
          next: "legend"
        });
      try {
        k.apply(oe = ae.call(ye.childNodes), ye.childNodes), oe[ye.childNodes.length].nodeType
      } catch (e) {
        k = {
          apply: function(e, t) {
            me.apply(e, ae.call(t))
          },
          call: function(e) {
            me.apply(e, ae.call(arguments, 1))
          }
        }
      }

      function I(t, e, n, r) {
        var i, o, a, s, u, l, c, f = e && e.ownerDocument,
          p = e ? e.nodeType : 9;
        if (n = n || [], "string" != typeof t || !t || 1 !== p && 9 !== p && 11 !== p) return n;
        if (!r && (V(e), e = e || T, C)) {
          if (11 !== p && (u = L.exec(t)))
            if (i = u[1]) {
              if (9 === p) {
                if (!(a = e.getElementById(i))) return n;
                if (a.id === i) return k.call(n, a), n
              } else if (f && (a = f.getElementById(i)) && I.contains(e, a) && a.id === i) return k.call(n, a), n
            } else {
              if (u[2]) return k.apply(n, e.getElementsByTagName(t)), n;
              if ((i = u[3]) && e.getElementsByClassName) return k.apply(n, e.getElementsByClassName(i)), n
            } if (!(h[t + " "] || d && d.test(t))) {
            if (c = t, f = e, 1 === p && (x.test(t) || m.test(t))) {
              (f = H.test(t) && U(e.parentNode) || e) == e && le.scope || ((s = e.getAttribute("id")) ? s = ce.escapeSelector(s) : e.setAttribute("id", s = S)), o = (l = Y(t)).length;
              while (o--) l[o] = (s ? "#" + s : ":scope") + " " + Q(l[o]);
              c = l.join(",")
            }
            try {
              return k.apply(n, f.querySelectorAll(c)), n
            } catch (e) {
              h(t, !0)
            } finally {
              s === S && e.removeAttribute("id")
            }
          }
        }
        return re(t.replace(ve, "$1"), e, n, r)
      }

      function W() {
        var r = [];
        return function e(t, n) {
          return r.push(t + " ") > b.cacheLength && delete e[r.shift()], e[t + " "] = n
        }
      }

      function F(e) {
        return e[S] = !0, e
      }

      function $(e) {
        var t = T.createElement("fieldset");
        try {
          return !!e(t)
        } catch (e) {
          return !1
        } finally {
          t.parentNode && t.parentNode.removeChild(t), t = null
        }
      }

      function B(t) {
        return function(e) {
          return fe(e, "input") && e.type === t
        }
      }

      function _(t) {
        return function(e) {
          return (fe(e, "input") || fe(e, "button")) && e.type === t
        }
      }

      function z(t) {
        return function(e) {
          return "form" in e ? e.parentNode && !1 === e.disabled ? "label" in e ? "label" in e.parentNode ? e.parentNode.disabled === t : e.disabled === t : e.isDisabled === t || e.isDisabled !== !t && R(e) === t : e.disabled === t : "label" in e && e.disabled === t
        }
      }

      function X(a) {
        return F(function(o) {
          return o = +o, F(function(e, t) {
            var n, r = a([], e.length, o),
              i = r.length;
            while (i--) e[n = r[i]] && (e[n] = !(t[n] = e[n]))
          })
        })
      }

      function U(e) {
        return e && "undefined" != typeof e.getElementsByTagName && e
      }

      function V(e) {
        var t, n = e ? e.ownerDocument || e : ye;
        return n != T && 9 === n.nodeType && n.documentElement && (r = (T = n).documentElement, C = !ce.isXMLDoc(T), i = r.matches || r.webkitMatchesSelector || r.msMatchesSelector, r.msMatchesSelector && ye != T && (t = T.defaultView) && t.top !== t && t.addEventListener("unload", M), le.getById = $(function(e) {
          return r.appendChild(e).id = ce.expando, !T.getElementsByName || !T.getElementsByName(ce.expando).length
        }), le.disconnectedMatch = $(function(e) {
          return i.call(e, "*")
        }), le.scope = $(function() {
          return T.querySelectorAll(":scope")
        }), le.cssHas = $(function() {
          try {
            return T.querySelector(":has(*,:jqfake)"), !1
          } catch (e) {
            return !0
          }
        }), le.getById ? (b.filter.ID = function(e) {
          var t = e.replace(O, P);
          return function(e) {
            return e.getAttribute("id") === t
          }
        }, b.find.ID = function(e, t) {
          if ("undefined" != typeof t.getElementById && C) {
            var n = t.getElementById(e);
            return n ? [n] : []
          }
        }) : (b.filter.ID = function(e) {
          var n = e.replace(O, P);
          return function(e) {
            var t = "undefined" != typeof e.getAttributeNode && e.getAttributeNode("id");
            return t && t.value === n
          }
        }, b.find.ID = function(e, t) {
          if ("undefined" != typeof t.getElementById && C) {
            var n, r, i, o = t.getElementById(e);
            if (o) {
              if ((n = o.getAttributeNode("id")) && n.value === e) return [o];
              i = t.getElementsByName(e), r = 0;
              while (o = i[r++])
                if ((n = o.getAttributeNode("id")) && n.value === e) return [o]
            }
            return []
          }
        }), b.find.TAG = function(e, t) {
          return "undefined" != typeof t.getElementsByTagName ? t.getElementsByTagName(e) : t.querySelectorAll(e)
        }, b.find.CLASS = function(e, t) {
          if ("undefined" != typeof t.getElementsByClassName && C) return t.getElementsByClassName(e)
        }, d = [], $(function(e) {
          var t;
          r.appendChild(e).innerHTML = "<a id='" + S + "' href='' disabled='disabled'></a><select id='" + S + "-\r\\' disabled='disabled'><option selected=''></option></select>", e.querySelectorAll("[selected]").length || d.push("\\[" + ge + "*(?:value|" + f + ")"), e.querySelectorAll("[id~=" + S + "-]").length || d.push("~="), e.querySelectorAll("a#" + S + "+*").length || d.push(".#.+[+~]"), e.querySelectorAll(":checked").length || d.push(":checked"), (t = T.createElement("input")).setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), r.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && d.push(":enabled", ":disabled"), (t = T.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || d.push("\\[" + ge + "*name" + ge + "*=" + ge + "*(?:''|\"\")")
        }), le.cssHas || d.push(":has"), d = d.length && new RegExp(d.join("|")), l = function(e, t) {
          if (e === t) return a = !0, 0;
          var n = !e.compareDocumentPosition - !t.compareDocumentPosition;
          return n || (1 & (n = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !le.sortDetached && t.compareDocumentPosition(e) === n ? e === T || e.ownerDocument == ye && I.contains(ye, e) ? -1 : t === T || t.ownerDocument == ye && I.contains(ye, t) ? 1 : o ? se.call(o, e) - se.call(o, t) : 0 : 4 & n ? -1 : 1)
        }), T
      }
      for (e in I.matches = function(e, t) {
          return I(e, null, null, t)
        }, I.matchesSelector = function(e, t) {
          if (V(e), C && !h[t + " "] && (!d || !d.test(t))) try {
            var n = i.call(e, t);
            if (n || le.disconnectedMatch || e.document && 11 !== e.document.nodeType) return n
          } catch (e) {
            h(t, !0)
          }
          return 0 < I(t, T, null, [e]).length
        }, I.contains = function(e, t) {
          return (e.ownerDocument || e) != T && V(e), ce.contains(e, t)
        }, I.attr = function(e, t) {
          (e.ownerDocument || e) != T && V(e);
          var n = b.attrHandle[t.toLowerCase()],
            r = n && ue.call(b.attrHandle, t.toLowerCase()) ? n(e, t, !C) : void 0;
          return void 0 !== r ? r : e.getAttribute(t)
        }, I.error = function(e) {
          throw new Error("Syntax error, unrecognized expression: " + e)
        }, ce.uniqueSort = function(e) {
          var t, n = [],
            r = 0,
            i = 0;
          if (a = !le.sortStable, o = !le.sortStable && ae.call(e, 0), de.call(e, l), a) {
            while (t = e[i++]) t === e[i] && (r = n.push(i));
            while (r--) he.call(e, n[r], 1)
          }
          return o = null, e
        }, ce.fn.uniqueSort = function() {
          return this.pushStack(ce.uniqueSort(ae.apply(this)))
        }, (b = ce.expr = {
          cacheLength: 50,
          createPseudo: F,
          match: D,
          attrHandle: {},
          find: {},
          relative: {
            ">": {
              dir: "parentNode",
              first: !0
            },
            " ": {
              dir: "parentNode"
            },
            "+": {
              dir: "previousSibling",
              first: !0
            },
            "~": {
              dir: "previousSibling"
            }
          },
          preFilter: {
            ATTR: function(e) {
              return e[1] = e[1].replace(O, P), e[3] = (e[3] || e[4] || e[5] || "").replace(O, P), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
            },
            CHILD: function(e) {
              return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || I.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && I.error(e[0]), e
            },
            PSEUDO: function(e) {
              var t, n = !e[6] && e[2];
              return D.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && j.test(n) && (t = Y(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
            }
          },
          filter: {
            TAG: function(e) {
              var t = e.replace(O, P).toLowerCase();
              return "*" === e ? function() {
                return !0
              } : function(e) {
                return fe(e, t)
              }
            },
            CLASS: function(e) {
              var t = s[e + " "];
              return t || (t = new RegExp("(^|" + ge + ")" + e + "(" + ge + "|$)")) && s(e, function(e) {
                return t.test("string" == typeof e.className && e.className || "undefined" != typeof e.getAttribute && e.getAttribute("class") || "")
              })
            },
            ATTR: function(n, r, i) {
              return function(e) {
                var t = I.attr(e, n);
                return null == t ? "!=" === r : !r || (t += "", "=" === r ? t === i : "!=" === r ? t !== i : "^=" === r ? i && 0 === t.indexOf(i) : "*=" === r ? i && -1 < t.indexOf(i) : "$=" === r ? i && t.slice(-i.length) === i : "~=" === r ? -1 < (" " + t.replace(v, " ") + " ").indexOf(i) : "|=" === r && (t === i || t.slice(0, i.length + 1) === i + "-"))
              }
            },
            CHILD: function(d, e, t, h, g) {
              var v = "nth" !== d.slice(0, 3),
                y = "last" !== d.slice(-4),
                m = "of-type" === e;
              return 1 === h && 0 === g ? function(e) {
                return !!e.parentNode
              } : function(e, t, n) {
                var r, i, o, a, s, u = v !== y ? "nextSibling" : "previousSibling",
                  l = e.parentNode,
                  c = m && e.nodeName.toLowerCase(),
                  f = !n && !m,
                  p = !1;
                if (l) {
                  if (v) {
                    while (u) {
                      o = e;
                      while (o = o[u])
                        if (m ? fe(o, c) : 1 === o.nodeType) return !1;
                      s = u = "only" === d && !s && "nextSibling"
                    }
                    return !0
                  }
                  if (s = [y ? l.firstChild : l.lastChild], y && f) {
                    p = (a = (r = (i = l[S] || (l[S] = {}))[d] || [])[0] === E && r[1]) && r[2], o = a && l.childNodes[a];
                    while (o = ++a && o && o[u] || (p = a = 0) || s.pop())
                      if (1 === o.nodeType && ++p && o === e) {
                        i[d] = [E, a, p];
                        break
                      }
                  } else if (f && (p = a = (r = (i = e[S] || (e[S] = {}))[d] || [])[0] === E && r[1]), !1 === p)
                    while (o = ++a && o && o[u] || (p = a = 0) || s.pop())
                      if ((m ? fe(o, c) : 1 === o.nodeType) && ++p && (f && ((i = o[S] || (o[S] = {}))[d] = [E, p]), o === e)) break;
                  return (p -= g) === h || p % h == 0 && 0 <= p / h
                }
              }
            },
            PSEUDO: function(e, o) {
              var t, a = b.pseudos[e] || b.setFilters[e.toLowerCase()] || I.error("unsupported pseudo: " + e);
              return a[S] ? a(o) : 1 < a.length ? (t = [e, e, "", o], b.setFilters.hasOwnProperty(e.toLowerCase()) ? F(function(e, t) {
                var n, r = a(e, o),
                  i = r.length;
                while (i--) e[n = se.call(e, r[i])] = !(t[n] = r[i])
              }) : function(e) {
                return a(e, 0, t)
              }) : a
            }
          },
          pseudos: {
            not: F(function(e) {
              var r = [],
                i = [],
                s = ne(e.replace(ve, "$1"));
              return s[S] ? F(function(e, t, n, r) {
                var i, o = s(e, null, r, []),
                  a = e.length;
                while (a--)(i = o[a]) && (e[a] = !(t[a] = i))
              }) : function(e, t, n) {
                return r[0] = e, s(r, null, n, i), r[0] = null, !i.pop()
              }
            }),
            has: F(function(t) {
              return function(e) {
                return 0 < I(t, e).length
              }
            }),
            contains: F(function(t) {
              return t = t.replace(O, P),
                function(e) {
                  return -1 < (e.textContent || ce.text(e)).indexOf(t)
                }
            }),
            lang: F(function(n) {
              return A.test(n || "") || I.error("unsupported lang: " + n), n = n.replace(O, P).toLowerCase(),
                function(e) {
                  var t;
                  do {
                    if (t = C ? e.lang : e.getAttribute("xml:lang") || e.getAttribute("lang")) return (t = t.toLowerCase()) === n || 0 === t.indexOf(n + "-")
                  } while ((e = e.parentNode) && 1 === e.nodeType);
                  return !1
                }
            }),
            target: function(e) {
              var t = ie.location && ie.location.hash;
              return t && t.slice(1) === e.id
            },
            root: function(e) {
              return e === r
            },
            focus: function(e) {
              return e === function() {
                try {
                  return T.activeElement
                } catch (e) {}
              }() && T.hasFocus() && !!(e.type || e.href || ~e.tabIndex)
            },
            enabled: z(!1),
            disabled: z(!0),
            checked: function(e) {
              return fe(e, "input") && !!e.checked || fe(e, "option") && !!e.selected
            },
            selected: function(e) {
              return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
            },
            empty: function(e) {
              for (e = e.firstChild; e; e = e.nextSibling)
                if (e.nodeType < 6) return !1;
              return !0
            },
            parent: function(e) {
              return !b.pseudos.empty(e)
            },
            header: function(e) {
              return q.test(e.nodeName)
            },
            input: function(e) {
              return N.test(e.nodeName)
            },
            button: function(e) {
              return fe(e, "input") && "button" === e.type || fe(e, "button")
            },
            text: function(e) {
              var t;
              return fe(e, "input") && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
            },
            first: X(function() {
              return [0]
            }),
            last: X(function(e, t) {
              return [t - 1]
            }),
            eq: X(function(e, t, n) {
              return [n < 0 ? n + t : n]
            }),
            even: X(function(e, t) {
              for (var n = 0; n < t; n += 2) e.push(n);
              return e
            }),
            odd: X(function(e, t) {
              for (var n = 1; n < t; n += 2) e.push(n);
              return e
            }),
            lt: X(function(e, t, n) {
              var r;
              for (r = n < 0 ? n + t : t < n ? t : n; 0 <= --r;) e.push(r);
              return e
            }),
            gt: X(function(e, t, n) {
              for (var r = n < 0 ? n + t : n; ++r < t;) e.push(r);
              return e
            })
          }
        }).pseudos.nth = b.pseudos.eq, {
          radio: !0,
          checkbox: !0,
          file: !0,
          password: !0,
          image: !0
        }) b.pseudos[e] = B(e);
      for (e in {
          submit: !0,
          reset: !0
        }) b.pseudos[e] = _(e);

      function G() {}

      function Y(e, t) {
        var n, r, i, o, a, s, u, l = c[e + " "];
        if (l) return t ? 0 : l.slice(0);
        a = e, s = [], u = b.preFilter;
        while (a) {
          for (o in n && !(r = y.exec(a)) || (r && (a = a.slice(r[0].length) || a), s.push(i = [])), n = !1, (r = m.exec(a)) && (n = r.shift(), i.push({
              value: n,
              type: r[0].replace(ve, " ")
            }), a = a.slice(n.length)), b.filter) !(r = D[o].exec(a)) || u[o] && !(r = u[o](r)) || (n = r.shift(), i.push({
            value: n,
            type: o,
            matches: r
          }), a = a.slice(n.length));
          if (!n) break
        }
        return t ? a.length : a ? I.error(e) : c(e, s).slice(0)
      }

      function Q(e) {
        for (var t = 0, n = e.length, r = ""; t < n; t++) r += e[t].value;
        return r
      }

      function J(a, e, t) {
        var s = e.dir,
          u = e.next,
          l = u || s,
          c = t && "parentNode" === l,
          f = n++;
        return e.first ? function(e, t, n) {
          while (e = e[s])
            if (1 === e.nodeType || c) return a(e, t, n);
          return !1
        } : function(e, t, n) {
          var r, i, o = [E, f];
          if (n) {
            while (e = e[s])
              if ((1 === e.nodeType || c) && a(e, t, n)) return !0
          } else
            while (e = e[s])
              if (1 === e.nodeType || c)
                if (i = e[S] || (e[S] = {}), u && fe(e, u)) e = e[s] || e;
                else {
                  if ((r = i[l]) && r[0] === E && r[1] === f) return o[2] = r[2];
                  if ((i[l] = o)[2] = a(e, t, n)) return !0
                } return !1
        }
      }

      function K(i) {
        return 1 < i.length ? function(e, t, n) {
          var r = i.length;
          while (r--)
            if (!i[r](e, t, n)) return !1;
          return !0
        } : i[0]
      }

      function Z(e, t, n, r, i) {
        for (var o, a = [], s = 0, u = e.length, l = null != t; s < u; s++)(o = e[s]) && (n && !n(o, r, i) || (a.push(o), l && t.push(s)));
        return a
      }

      function ee(d, h, g, v, y, e) {
        return v && !v[S] && (v = ee(v)), y && !y[S] && (y = ee(y, e)), F(function(e, t, n, r) {
          var i, o, a, s, u = [],
            l = [],
            c = t.length,
            f = e || function(e, t, n) {
              for (var r = 0, i = t.length; r < i; r++) I(e, t[r], n);
              return n
            }(h || "*", n.nodeType ? [n] : n, []),
            p = !d || !e && h ? f : Z(f, u, d, n, r);
          if (g ? g(p, s = y || (e ? d : c || v) ? [] : t, n, r) : s = p, v) {
            i = Z(s, l), v(i, [], n, r), o = i.length;
            while (o--)(a = i[o]) && (s[l[o]] = !(p[l[o]] = a))
          }
          if (e) {
            if (y || d) {
              if (y) {
                i = [], o = s.length;
                while (o--)(a = s[o]) && i.push(p[o] = a);
                y(null, s = [], i, r)
              }
              o = s.length;
              while (o--)(a = s[o]) && -1 < (i = y ? se.call(e, a) : u[o]) && (e[i] = !(t[i] = a))
            }
          } else s = Z(s === t ? s.splice(c, s.length) : s), y ? y(null, t, s, r) : k.apply(t, s)
        })
      }

      function te(e) {
        for (var i, t, n, r = e.length, o = b.relative[e[0].type], a = o || b.relative[" "], s = o ? 1 : 0, u = J(function(e) {
            return e === i
          }, a, !0), l = J(function(e) {
            return -1 < se.call(i, e)
          }, a, !0), c = [function(e, t, n) {
            var r = !o && (n || t != w) || ((i = t).nodeType ? u(e, t, n) : l(e, t, n));
            return i = null, r
          }]; s < r; s++)
          if (t = b.relative[e[s].type]) c = [J(K(c), t)];
          else {
            if ((t = b.filter[e[s].type].apply(null, e[s].matches))[S]) {
              for (n = ++s; n < r; n++)
                if (b.relative[e[n].type]) break;
              return ee(1 < s && K(c), 1 < s && Q(e.slice(0, s - 1).concat({
                value: " " === e[s - 2].type ? "*" : ""
              })).replace(ve, "$1"), t, s < n && te(e.slice(s, n)), n < r && te(e = e.slice(n)), n < r && Q(e))
            }
            c.push(t)
          } return K(c)
      }

      function ne(e, t) {
        var n, v, y, m, x, r, i = [],
          o = [],
          a = u[e + " "];
        if (!a) {
          t || (t = Y(e)), n = t.length;
          while (n--)(a = te(t[n]))[S] ? i.push(a) : o.push(a);
          (a = u(e, (v = o, m = 0 < (y = i).length, x = 0 < v.length, r = function(e, t, n, r, i) {
            var o, a, s, u = 0,
              l = "0",
              c = e && [],
              f = [],
              p = w,
              d = e || x && b.find.TAG("*", i),
              h = E += null == p ? 1 : Math.random() || .1,
              g = d.length;
            for (i && (w = t == T || t || i); l !== g && null != (o = d[l]); l++) {
              if (x && o) {
                a = 0, t || o.ownerDocument == T || (V(o), n = !C);
                while (s = v[a++])
                  if (s(o, t || T, n)) {
                    k.call(r, o);
                    break
                  } i && (E = h)
              }
              m && ((o = !s && o) && u--, e && c.push(o))
            }
            if (u += l, m && l !== u) {
              a = 0;
              while (s = y[a++]) s(c, f, t, n);
              if (e) {
                if (0 < u)
                  while (l--) c[l] || f[l] || (f[l] = pe.call(r));
                f = Z(f)
              }
              k.apply(r, f), i && !e && 0 < f.length && 1 < u + y.length && ce.uniqueSort(r)
            }
            return i && (E = h, w = p), c
          }, m ? F(r) : r))).selector = e
        }
        return a
      }

      function re(e, t, n, r) {
        var i, o, a, s, u, l = "function" == typeof e && e,
          c = !r && Y(e = l.selector || e);
        if (n = n || [], 1 === c.length) {
          if (2 < (o = c[0] = c[0].slice(0)).length && "ID" === (a = o[0]).type && 9 === t.nodeType && C && b.relative[o[1].type]) {
            if (!(t = (b.find.ID(a.matches[0].replace(O, P), t) || [])[0])) return n;
            l && (t = t.parentNode), e = e.slice(o.shift().value.length)
          }
          i = D.needsContext.test(e) ? 0 : o.length;
          while (i--) {
            if (a = o[i], b.relative[s = a.type]) break;
            if ((u = b.find[s]) && (r = u(a.matches[0].replace(O, P), H.test(o[0].type) && U(t.parentNode) || t))) {
              if (o.splice(i, 1), !(e = r.length && Q(o))) return k.apply(n, r), n;
              break
            }
          }
        }
        return (l || ne(e, c))(r, t, !C, n, !t || H.test(e) && U(t.parentNode) || t), n
      }
      G.prototype = b.filters = b.pseudos, b.setFilters = new G, le.sortStable = S.split("").sort(l).join("") === S, V(), le.sortDetached = $(function(e) {
        return 1 & e.compareDocumentPosition(T.createElement("fieldset"))
      }), ce.find = I, ce.expr[":"] = ce.expr.pseudos, ce.unique = ce.uniqueSort, I.compile = ne, I.select = re, I.setDocument = V, I.tokenize = Y, I.escape = ce.escapeSelector, I.getText = ce.text, I.isXML = ce.isXMLDoc, I.selectors = ce.expr, I.support = ce.support, I.uniqueSort = ce.uniqueSort
    }();
    var d = function(e, t, n) {
        var r = [],
          i = void 0 !== n;
        while ((e = e[t]) && 9 !== e.nodeType)
          if (1 === e.nodeType) {
            if (i && ce(e).is(n)) break;
            r.push(e)
          } return r
      },
      h = function(e, t) {
        for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
        return n
      },
      b = ce.expr.match.needsContext,
      w = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function T(e, n, r) {
      return v(n) ? ce.grep(e, function(e, t) {
        return !!n.call(e, t, e) !== r
      }) : n.nodeType ? ce.grep(e, function(e) {
        return e === n !== r
      }) : "string" != typeof n ? ce.grep(e, function(e) {
        return -1 < se.call(n, e) !== r
      }) : ce.filter(n, e, r)
    }
    ce.filter = function(e, t, n) {
      var r = t[0];
      return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === r.nodeType ? ce.find.matchesSelector(r, e) ? [r] : [] : ce.find.matches(e, ce.grep(t, function(e) {
        return 1 === e.nodeType
      }))
    }, ce.fn.extend({
      find: function(e) {
        var t, n, r = this.length,
          i = this;
        if ("string" != typeof e) return this.pushStack(ce(e).filter(function() {
          for (t = 0; t < r; t++)
            if (ce.contains(i[t], this)) return !0
        }));
        for (n = this.pushStack([]), t = 0; t < r; t++) ce.find(e, i[t], n);
        return 1 < r ? ce.uniqueSort(n) : n
      },
      filter: function(e) {
        return this.pushStack(T(this, e || [], !1))
      },
      not: function(e) {
        return this.pushStack(T(this, e || [], !0))
      },
      is: function(e) {
        return !!T(this, "string" == typeof e && b.test(e) ? ce(e) : e || [], !1).length
      }
    });
    var k, S = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (ce.fn.init = function(e, t, n) {
      var r, i;
      if (!e) return this;
      if (n = n || k, "string" == typeof e) {
        if (!(r = "<" === e[0] && ">" === e[e.length - 1] && 3 <= e.length ? [null, e, null] : S.exec(e)) || !r[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
        if (r[1]) {
          if (t = t instanceof ce ? t[0] : t, ce.merge(this, ce.parseHTML(r[1], t && t.nodeType ? t.ownerDocument || t : C, !0)), w.test(r[1]) && ce.isPlainObject(t))
            for (r in t) v(this[r]) ? this[r](t[r]) : this.attr(r, t[r]);
          return this
        }
        return (i = C.getElementById(r[2])) && (this[0] = i, this.length = 1), this
      }
      return e.nodeType ? (this[0] = e, this.length = 1, this) : v(e) ? void 0 !== n.ready ? n.ready(e) : e(ce) : ce.makeArray(e, this)
    }).prototype = ce.fn, k = ce(C);
    var E = /^(?:parents|prev(?:Until|All))/,
      j = {
        children: !0,
        contents: !0,
        next: !0,
        prev: !0
      };

    function A(e, t) {
      while ((e = e[t]) && 1 !== e.nodeType);
      return e
    }
    ce.fn.extend({
      has: function(e) {
        var t = ce(e, this),
          n = t.length;
        return this.filter(function() {
          for (var e = 0; e < n; e++)
            if (ce.contains(this, t[e])) return !0
        })
      },
      closest: function(e, t) {
        var n, r = 0,
          i = this.length,
          o = [],
          a = "string" != typeof e && ce(e);
        if (!b.test(e))
          for (; r < i; r++)
            for (n = this[r]; n && n !== t; n = n.parentNode)
              if (n.nodeType < 11 && (a ? -1 < a.index(n) : 1 === n.nodeType && ce.find.matchesSelector(n, e))) {
                o.push(n);
                break
              } return this.pushStack(1 < o.length ? ce.uniqueSort(o) : o)
      },
      index: function(e) {
        return e ? "string" == typeof e ? se.call(ce(e), this[0]) : se.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
      },
      add: function(e, t) {
        return this.pushStack(ce.uniqueSort(ce.merge(this.get(), ce(e, t))))
      },
      addBack: function(e) {
        return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
      }
    }), ce.each({
      parent: function(e) {
        var t = e.parentNode;
        return t && 11 !== t.nodeType ? t : null
      },
      parents: function(e) {
        return d(e, "parentNode")
      },
      parentsUntil: function(e, t, n) {
        return d(e, "parentNode", n)
      },
      next: function(e) {
        return A(e, "nextSibling")
      },
      prev: function(e) {
        return A(e, "previousSibling")
      },
      nextAll: function(e) {
        return d(e, "nextSibling")
      },
      prevAll: function(e) {
        return d(e, "previousSibling")
      },
      nextUntil: function(e, t, n) {
        return d(e, "nextSibling", n)
      },
      prevUntil: function(e, t, n) {
        return d(e, "previousSibling", n)
      },
      siblings: function(e) {
        return h((e.parentNode || {}).firstChild, e)
      },
      children: function(e) {
        return h(e.firstChild)
      },
      contents: function(e) {
        return null != e.contentDocument && r(e.contentDocument) ? e.contentDocument : (fe(e, "template") && (e = e.content || e), ce.merge([], e.childNodes))
      }
    }, function(r, i) {
      ce.fn[r] = function(e, t) {
        var n = ce.map(this, i, e);
        return "Until" !== r.slice(-5) && (t = e), t && "string" == typeof t && (n = ce.filter(t, n)), 1 < this.length && (j[r] || ce.uniqueSort(n), E.test(r) && n.reverse()), this.pushStack(n)
      }
    });
    var D = /[^\x20\t\r\n\f]+/g;

    function N(e) {
      return e
    }

    function q(e) {
      throw e
    }

    function L(e, t, n, r) {
      var i;
      try {
        e && v(i = e.promise) ? i.call(e).done(t).fail(n) : e && v(i = e.then) ? i.call(e, t, n) : t.apply(void 0, [e].slice(r))
      } catch (e) {
        n.apply(void 0, [e])
      }
    }
    ce.Callbacks = function(r) {
      var e, n;
      r = "string" == typeof r ? (e = r, n = {}, ce.each(e.match(D) || [], function(e, t) {
        n[t] = !0
      }), n) : ce.extend({}, r);
      var i, t, o, a, s = [],
        u = [],
        l = -1,
        c = function() {
          for (a = a || r.once, o = i = !0; u.length; l = -1) {
            t = u.shift();
            while (++l < s.length) !1 === s[l].apply(t[0], t[1]) && r.stopOnFalse && (l = s.length, t = !1)
          }
          r.memory || (t = !1), i = !1, a && (s = t ? [] : "")
        },
        f = {
          add: function() {
            return s && (t && !i && (l = s.length - 1, u.push(t)), function n(e) {
              ce.each(e, function(e, t) {
                v(t) ? r.unique && f.has(t) || s.push(t) : t && t.length && "string" !== x(t) && n(t)
              })
            }(arguments), t && !i && c()), this
          },
          remove: function() {
            return ce.each(arguments, function(e, t) {
              var n;
              while (-1 < (n = ce.inArray(t, s, n))) s.splice(n, 1), n <= l && l--
            }), this
          },
          has: function(e) {
            return e ? -1 < ce.inArray(e, s) : 0 < s.length
          },
          empty: function() {
            return s && (s = []), this
          },
          disable: function() {
            return a = u = [], s = t = "", this
          },
          disabled: function() {
            return !s
          },
          lock: function() {
            return a = u = [], t || i || (s = t = ""), this
          },
          locked: function() {
            return !!a
          },
          fireWith: function(e, t) {
            return a || (t = [e, (t = t || []).slice ? t.slice() : t], u.push(t), i || c()), this
          },
          fire: function() {
            return f.fireWith(this, arguments), this
          },
          fired: function() {
            return !!o
          }
        };
      return f
    }, ce.extend({
      Deferred: function(e) {
        var o = [
            ["notify", "progress", ce.Callbacks("memory"), ce.Callbacks("memory"), 2],
            ["resolve", "done", ce.Callbacks("once memory"), ce.Callbacks("once memory"), 0, "resolved"],
            ["reject", "fail", ce.Callbacks("once memory"), ce.Callbacks("once memory"), 1, "rejected"]
          ],
          i = "pending",
          a = {
            state: function() {
              return i
            },
            always: function() {
              return s.done(arguments).fail(arguments), this
            },
            "catch": function(e) {
              return a.then(null, e)
            },
            pipe: function() {
              var i = arguments;
              return ce.Deferred(function(r) {
                ce.each(o, function(e, t) {
                  var n = v(i[t[4]]) && i[t[4]];
                  s[t[1]](function() {
                    var e = n && n.apply(this, arguments);
                    e && v(e.promise) ? e.promise().progress(r.notify).done(r.resolve).fail(r.reject) : r[t[0] + "With"](this, n ? [e] : arguments)
                  })
                }), i = null
              }).promise()
            },
            then: function(t, n, r) {
              var u = 0;

              function l(i, o, a, s) {
                return function() {
                  var n = this,
                    r = arguments,
                    e = function() {
                      var e, t;
                      if (!(i < u)) {
                        if ((e = a.apply(n, r)) === o.promise()) throw new TypeError("Thenable self-resolution");
                        t = e && ("object" == typeof e || "function" == typeof e) && e.then, v(t) ? s ? t.call(e, l(u, o, N, s), l(u, o, q, s)) : (u++, t.call(e, l(u, o, N, s), l(u, o, q, s), l(u, o, N, o.notifyWith))) : (a !== N && (n = void 0, r = [e]), (s || o.resolveWith)(n, r))
                      }
                    },
                    t = s ? e : function() {
                      try {
                        e()
                      } catch (e) {
                        ce.Deferred.exceptionHook && ce.Deferred.exceptionHook(e, t.error), u <= i + 1 && (a !== q && (n = void 0, r = [e]), o.rejectWith(n, r))
                      }
                    };
                  i ? t() : (ce.Deferred.getErrorHook ? t.error = ce.Deferred.getErrorHook() : ce.Deferred.getStackHook && (t.error = ce.Deferred.getStackHook()), ie.setTimeout(t))
                }
              }
              return ce.Deferred(function(e) {
                o[0][3].add(l(0, e, v(r) ? r : N, e.notifyWith)), o[1][3].add(l(0, e, v(t) ? t : N)), o[2][3].add(l(0, e, v(n) ? n : q))
              }).promise()
            },
            promise: function(e) {
              return null != e ? ce.extend(e, a) : a
            }
          },
          s = {};
        return ce.each(o, function(e, t) {
          var n = t[2],
            r = t[5];
          a[t[1]] = n.add, r && n.add(function() {
            i = r
          }, o[3 - e][2].disable, o[3 - e][3].disable, o[0][2].lock, o[0][3].lock), n.add(t[3].fire), s[t[0]] = function() {
            return s[t[0] + "With"](this === s ? void 0 : this, arguments), this
          }, s[t[0] + "With"] = n.fireWith
        }), a.promise(s), e && e.call(s, s), s
      },
      when: function(e) {
        var n = arguments.length,
          t = n,
          r = Array(t),
          i = ae.call(arguments),
          o = ce.Deferred(),
          a = function(t) {
            return function(e) {
              r[t] = this, i[t] = 1 < arguments.length ? ae.call(arguments) : e, --n || o.resolveWith(r, i)
            }
          };
        if (n <= 1 && (L(e, o.done(a(t)).resolve, o.reject, !n), "pending" === o.state() || v(i[t] && i[t].then))) return o.then();
        while (t--) L(i[t], a(t), o.reject);
        return o.promise()
      }
    });
    var H = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    ce.Deferred.exceptionHook = function(e, t) {
      ie.console && ie.console.warn && e && H.test(e.name) && ie.console.warn("jQuery.Deferred exception: " + e.message, e.stack, t)
    }, ce.readyException = function(e) {
      ie.setTimeout(function() {
        throw e
      })
    };
    var O = ce.Deferred();

    function P() {
      C.removeEventListener("DOMContentLoaded", P), ie.removeEventListener("load", P), ce.ready()
    }
    ce.fn.ready = function(e) {
      return O.then(e)["catch"](function(e) {
        ce.readyException(e)
      }), this
    }, ce.extend({
      isReady: !1,
      readyWait: 1,
      ready: function(e) {
        (!0 === e ? --ce.readyWait : ce.isReady) || (ce.isReady = !0) !== e && 0 < --ce.readyWait || O.resolveWith(C, [ce])
      }
    }), ce.ready.then = O.then, "complete" === C.readyState || "loading" !== C.readyState && !C.documentElement.doScroll ? ie.setTimeout(ce.ready) : (C.addEventListener("DOMContentLoaded", P), ie.addEventListener("load", P));
    var M = function(e, t, n, r, i, o, a) {
        var s = 0,
          u = e.length,
          l = null == n;
        if ("object" === x(n))
          for (s in i = !0, n) M(e, t, s, n[s], !0, o, a);
        else if (void 0 !== r && (i = !0, v(r) || (a = !0), l && (a ? (t.call(e, r), t = null) : (l = t, t = function(e, t, n) {
            return l.call(ce(e), n)
          })), t))
          for (; s < u; s++) t(e[s], n, a ? r : r.call(e[s], s, t(e[s], n)));
        return i ? e : l ? t.call(e) : u ? t(e[0], n) : o
      },
      R = /^-ms-/,
      I = /-([a-z])/g;

    function W(e, t) {
      return t.toUpperCase()
    }

    function F(e) {
      return e.replace(R, "ms-").replace(I, W)
    }
    var $ = function(e) {
      return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function B() {
      this.expando = ce.expando + B.uid++
    }
    B.uid = 1, B.prototype = {
      cache: function(e) {
        var t = e[this.expando];
        return t || (t = {}, $(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
          value: t,
          configurable: !0
        }))), t
      },
      set: function(e, t, n) {
        var r, i = this.cache(e);
        if ("string" == typeof t) i[F(t)] = n;
        else
          for (r in t) i[F(r)] = t[r];
        return i
      },
      get: function(e, t) {
        return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][F(t)]
      },
      access: function(e, t, n) {
        return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
      },
      remove: function(e, t) {
        var n, r = e[this.expando];
        if (void 0 !== r) {
          if (void 0 !== t) {
            n = (t = Array.isArray(t) ? t.map(F) : (t = F(t)) in r ? [t] : t.match(D) || []).length;
            while (n--) delete r[t[n]]
          }(void 0 === t || ce.isEmptyObject(r)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
        }
      },
      hasData: function(e) {
        var t = e[this.expando];
        return void 0 !== t && !ce.isEmptyObject(t)
      }
    };
    var _ = new B,
      z = new B,
      X = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
      U = /[A-Z]/g;

    function V(e, t, n) {
      var r, i;
      if (void 0 === n && 1 === e.nodeType)
        if (r = "data-" + t.replace(U, "-$&").toLowerCase(), "string" == typeof(n = e.getAttribute(r))) {
          try {
            n = "true" === (i = n) || "false" !== i && ("null" === i ? null : i === +i + "" ? +i : X.test(i) ? JSON.parse(i) : i)
          } catch (e) {}
          z.set(e, t, n)
        } else n = void 0;
      return n
    }
    ce.extend({
      hasData: function(e) {
        return z.hasData(e) || _.hasData(e)
      },
      data: function(e, t, n) {
        return z.access(e, t, n)
      },
      removeData: function(e, t) {
        z.remove(e, t)
      },
      _data: function(e, t, n) {
        return _.access(e, t, n)
      },
      _removeData: function(e, t) {
        _.remove(e, t)
      }
    }), ce.fn.extend({
      data: function(n, e) {
        var t, r, i, o = this[0],
          a = o && o.attributes;
        if (void 0 === n) {
          if (this.length && (i = z.get(o), 1 === o.nodeType && !_.get(o, "hasDataAttrs"))) {
            t = a.length;
            while (t--) a[t] && 0 === (r = a[t].name).indexOf("data-") && (r = F(r.slice(5)), V(o, r, i[r]));
            _.set(o, "hasDataAttrs", !0)
          }
          return i
        }
        return "object" == typeof n ? this.each(function() {
          z.set(this, n)
        }) : M(this, function(e) {
          var t;
          if (o && void 0 === e) return void 0 !== (t = z.get(o, n)) ? t : void 0 !== (t = V(o, n)) ? t : void 0;
          this.each(function() {
            z.set(this, n, e)
          })
        }, null, e, 1 < arguments.length, null, !0)
      },
      removeData: function(e) {
        return this.each(function() {
          z.remove(this, e)
        })
      }
    }), ce.extend({
      queue: function(e, t, n) {
        var r;
        if (e) return t = (t || "fx") + "queue", r = _.get(e, t), n && (!r || Array.isArray(n) ? r = _.access(e, t, ce.makeArray(n)) : r.push(n)), r || []
      },
      dequeue: function(e, t) {
        t = t || "fx";
        var n = ce.queue(e, t),
          r = n.length,
          i = n.shift(),
          o = ce._queueHooks(e, t);
        "inprogress" === i && (i = n.shift(), r--), i && ("fx" === t && n.unshift("inprogress"), delete o.stop, i.call(e, function() {
          ce.dequeue(e, t)
        }, o)), !r && o && o.empty.fire()
      },
      _queueHooks: function(e, t) {
        var n = t + "queueHooks";
        return _.get(e, n) || _.access(e, n, {
          empty: ce.Callbacks("once memory").add(function() {
            _.remove(e, [t + "queue", n])
          })
        })
      }
    }), ce.fn.extend({
      queue: function(t, n) {
        var e = 2;
        return "string" != typeof t && (n = t, t = "fx", e--), arguments.length < e ? ce.queue(this[0], t) : void 0 === n ? this : this.each(function() {
          var e = ce.queue(this, t, n);
          ce._queueHooks(this, t), "fx" === t && "inprogress" !== e[0] && ce.dequeue(this, t)
        })
      },
      dequeue: function(e) {
        return this.each(function() {
          ce.dequeue(this, e)
        })
      },
      clearQueue: function(e) {
        return this.queue(e || "fx", [])
      },
      promise: function(e, t) {
        var n, r = 1,
          i = ce.Deferred(),
          o = this,
          a = this.length,
          s = function() {
            --r || i.resolveWith(o, [o])
          };
        "string" != typeof e && (t = e, e = void 0), e = e || "fx";
        while (a--)(n = _.get(o[a], e + "queueHooks")) && n.empty && (r++, n.empty.add(s));
        return s(), i.promise(t)
      }
    });
    var G = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
      Y = new RegExp("^(?:([+-])=|)(" + G + ")([a-z%]*)$", "i"),
      Q = ["Top", "Right", "Bottom", "Left"],
      J = C.documentElement,
      K = function(e) {
        return ce.contains(e.ownerDocument, e)
      },
      Z = {
        composed: !0
      };
    J.getRootNode && (K = function(e) {
      return ce.contains(e.ownerDocument, e) || e.getRootNode(Z) === e.ownerDocument
    });
    var ee = function(e, t) {
      return "none" === (e = t || e).style.display || "" === e.style.display && K(e) && "none" === ce.css(e, "display")
    };

    function te(e, t, n, r) {
      var i, o, a = 20,
        s = r ? function() {
          return r.cur()
        } : function() {
          return ce.css(e, t, "")
        },
        u = s(),
        l = n && n[3] || (ce.cssNumber[t] ? "" : "px"),
        c = e.nodeType && (ce.cssNumber[t] || "px" !== l && +u) && Y.exec(ce.css(e, t));
      if (c && c[3] !== l) {
        u /= 2, l = l || c[3], c = +u || 1;
        while (a--) ce.style(e, t, c + l), (1 - o) * (1 - (o = s() / u || .5)) <= 0 && (a = 0), c /= o;
        c *= 2, ce.style(e, t, c + l), n = n || []
      }
      return n && (c = +c || +u || 0, i = n[1] ? c + (n[1] + 1) * n[2] : +n[2], r && (r.unit = l, r.start = c, r.end = i)), i
    }
    var ne = {};

    function re(e, t) {
      for (var n, r, i, o, a, s, u, l = [], c = 0, f = e.length; c < f; c++)(r = e[c]).style && (n = r.style.display, t ? ("none" === n && (l[c] = _.get(r, "display") || null, l[c] || (r.style.display = "")), "" === r.style.display && ee(r) && (l[c] = (u = a = o = void 0, a = (i = r).ownerDocument, s = i.nodeName, (u = ne[s]) || (o = a.body.appendChild(a.createElement(s)), u = ce.css(o, "display"), o.parentNode.removeChild(o), "none" === u && (u = "block"), ne[s] = u)))) : "none" !== n && (l[c] = "none", _.set(r, "display", n)));
      for (c = 0; c < f; c++) null != l[c] && (e[c].style.display = l[c]);
      return e
    }
    ce.fn.extend({
      show: function() {
        return re(this, !0)
      },
      hide: function() {
        return re(this)
      },
      toggle: function(e) {
        return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each(function() {
          ee(this) ? ce(this).show() : ce(this).hide()
        })
      }
    });
    var xe, be, we = /^(?:checkbox|radio)$/i,
      Te = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
      Ce = /^$|^module$|\/(?:java|ecma)script/i;
    xe = C.createDocumentFragment().appendChild(C.createElement("div")), (be = C.createElement("input")).setAttribute("type", "radio"), be.setAttribute("checked", "checked"), be.setAttribute("name", "t"), xe.appendChild(be), le.checkClone = xe.cloneNode(!0).cloneNode(!0).lastChild.checked, xe.innerHTML = "<textarea>x</textarea>", le.noCloneChecked = !!xe.cloneNode(!0).lastChild.defaultValue, xe.innerHTML = "<option></option>", le.option = !!xe.lastChild;
    var ke = {
      thead: [1, "<table>", "</table>"],
      col: [2, "<table><colgroup>", "</colgroup></table>"],
      tr: [2, "<table><tbody>", "</tbody></table>"],
      td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
      _default: [0, "", ""]
    };

    function Se(e, t) {
      var n;
      return n = "undefined" != typeof e.getElementsByTagName ? e.getElementsByTagName(t || "*") : "undefined" != typeof e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && fe(e, t) ? ce.merge([e], n) : n
    }

    function Ee(e, t) {
      for (var n = 0, r = e.length; n < r; n++) _.set(e[n], "globalEval", !t || _.get(t[n], "globalEval"))
    }
    ke.tbody = ke.tfoot = ke.colgroup = ke.caption = ke.thead, ke.th = ke.td, le.option || (ke.optgroup = ke.option = [1, "<select multiple='multiple'>", "</select>"]);
    var je = /<|&#?\w+;/;

    function Ae(e, t, n, r, i) {
      for (var o, a, s, u, l, c, f = t.createDocumentFragment(), p = [], d = 0, h = e.length; d < h; d++)
        if ((o = e[d]) || 0 === o)
          if ("object" === x(o)) ce.merge(p, o.nodeType ? [o] : o);
          else if (je.test(o)) {
        a = a || f.appendChild(t.createElement("div")), s = (Te.exec(o) || ["", ""])[1].toLowerCase(), u = ke[s] || ke._default, a.innerHTML = u[1] + ce.htmlPrefilter(o) + u[2], c = u[0];
        while (c--) a = a.lastChild;
        ce.merge(p, a.childNodes), (a = f.firstChild).textContent = ""
      } else p.push(t.createTextNode(o));
      f.textContent = "", d = 0;
      while (o = p[d++])
        if (r && -1 < ce.inArray(o, r)) i && i.push(o);
        else if (l = K(o), a = Se(f.appendChild(o), "script"), l && Ee(a), n) {
        c = 0;
        while (o = a[c++]) Ce.test(o.type || "") && n.push(o)
      }
      return f
    }
    var De = /^([^.]*)(?:\.(.+)|)/;

    function Ne() {
      return !0
    }

    function qe() {
      return !1
    }

    function Le(e, t, n, r, i, o) {
      var a, s;
      if ("object" == typeof t) {
        for (s in "string" != typeof n && (r = r || n, n = void 0), t) Le(e, s, n, r, t[s], o);
        return e
      }
      if (null == r && null == i ? (i = n, r = n = void 0) : null == i && ("string" == typeof n ? (i = r, r = void 0) : (i = r, r = n, n = void 0)), !1 === i) i = qe;
      else if (!i) return e;
      return 1 === o && (a = i, (i = function(e) {
        return ce().off(e), a.apply(this, arguments)
      }).guid = a.guid || (a.guid = ce.guid++)), e.each(function() {
        ce.event.add(this, t, i, r, n)
      })
    }

    function He(e, r, t) {
      t ? (_.set(e, r, !1), ce.event.add(e, r, {
        namespace: !1,
        handler: function(e) {
          var t, n = _.get(this, r);
          if (1 & e.isTrigger && this[r]) {
            if (n)(ce.event.special[r] || {}).delegateType && e.stopPropagation();
            else if (n = ae.call(arguments), _.set(this, r, n), this[r](), t = _.get(this, r), _.set(this, r, !1), n !== t) return e.stopImmediatePropagation(), e.preventDefault(), t
          } else n && (_.set(this, r, ce.event.trigger(n[0], n.slice(1), this)), e.stopPropagation(), e.isImmediatePropagationStopped = Ne)
        }
      })) : void 0 === _.get(e, r) && ce.event.add(e, r, Ne)
    }
    ce.event = {
      global: {},
      add: function(t, e, n, r, i) {
        var o, a, s, u, l, c, f, p, d, h, g, v = _.get(t);
        if ($(t)) {
          n.handler && (n = (o = n).handler, i = o.selector), i && ce.find.matchesSelector(J, i), n.guid || (n.guid = ce.guid++), (u = v.events) || (u = v.events = Object.create(null)), (a = v.handle) || (a = v.handle = function(e) {
            return "undefined" != typeof ce && ce.event.triggered !== e.type ? ce.event.dispatch.apply(t, arguments) : void 0
          }), l = (e = (e || "").match(D) || [""]).length;
          while (l--) d = g = (s = De.exec(e[l]) || [])[1], h = (s[2] || "").split(".").sort(), d && (f = ce.event.special[d] || {}, d = (i ? f.delegateType : f.bindType) || d, f = ce.event.special[d] || {}, c = ce.extend({
            type: d,
            origType: g,
            data: r,
            handler: n,
            guid: n.guid,
            selector: i,
            needsContext: i && ce.expr.match.needsContext.test(i),
            namespace: h.join(".")
          }, o), (p = u[d]) || ((p = u[d] = []).delegateCount = 0, f.setup && !1 !== f.setup.call(t, r, h, a) || t.addEventListener && t.addEventListener(d, a)), f.add && (f.add.call(t, c), c.handler.guid || (c.handler.guid = n.guid)), i ? p.splice(p.delegateCount++, 0, c) : p.push(c), ce.event.global[d] = !0)
        }
      },
      remove: function(e, t, n, r, i) {
        var o, a, s, u, l, c, f, p, d, h, g, v = _.hasData(e) && _.get(e);
        if (v && (u = v.events)) {
          l = (t = (t || "").match(D) || [""]).length;
          while (l--)
            if (d = g = (s = De.exec(t[l]) || [])[1], h = (s[2] || "").split(".").sort(), d) {
              f = ce.event.special[d] || {}, p = u[d = (r ? f.delegateType : f.bindType) || d] || [], s = s[2] && new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)"), a = o = p.length;
              while (o--) c = p[o], !i && g !== c.origType || n && n.guid !== c.guid || s && !s.test(c.namespace) || r && r !== c.selector && ("**" !== r || !c.selector) || (p.splice(o, 1), c.selector && p.delegateCount--, f.remove && f.remove.call(e, c));
              a && !p.length && (f.teardown && !1 !== f.teardown.call(e, h, v.handle) || ce.removeEvent(e, d, v.handle), delete u[d])
            } else
              for (d in u) ce.event.remove(e, d + t[l], n, r, !0);
          ce.isEmptyObject(u) && _.remove(e, "handle events")
        }
      },
      dispatch: function(e) {
        var t, n, r, i, o, a, s = new Array(arguments.length),
          u = ce.event.fix(e),
          l = (_.get(this, "events") || Object.create(null))[u.type] || [],
          c = ce.event.special[u.type] || {};
        for (s[0] = u, t = 1; t < arguments.length; t++) s[t] = arguments[t];
        if (u.delegateTarget = this, !c.preDispatch || !1 !== c.preDispatch.call(this, u)) {
          a = ce.event.handlers.call(this, u, l), t = 0;
          while ((i = a[t++]) && !u.isPropagationStopped()) {
            u.currentTarget = i.elem, n = 0;
            while ((o = i.handlers[n++]) && !u.isImmediatePropagationStopped()) u.rnamespace && !1 !== o.namespace && !u.rnamespace.test(o.namespace) || (u.handleObj = o, u.data = o.data, void 0 !== (r = ((ce.event.special[o.origType] || {}).handle || o.handler).apply(i.elem, s)) && !1 === (u.result = r) && (u.preventDefault(), u.stopPropagation()))
          }
          return c.postDispatch && c.postDispatch.call(this, u), u.result
        }
      },
      handlers: function(e, t) {
        var n, r, i, o, a, s = [],
          u = t.delegateCount,
          l = e.target;
        if (u && l.nodeType && !("click" === e.type && 1 <= e.button))
          for (; l !== this; l = l.parentNode || this)
            if (1 === l.nodeType && ("click" !== e.type || !0 !== l.disabled)) {
              for (o = [], a = {}, n = 0; n < u; n++) void 0 === a[i = (r = t[n]).selector + " "] && (a[i] = r.needsContext ? -1 < ce(i, this).index(l) : ce.find(i, this, null, [l]).length), a[i] && o.push(r);
              o.length && s.push({
                elem: l,
                handlers: o
              })
            } return l = this, u < t.length && s.push({
          elem: l,
          handlers: t.slice(u)
        }), s
      },
      addProp: function(t, e) {
        Object.defineProperty(ce.Event.prototype, t, {
          enumerable: !0,
          configurable: !0,
          get: v(e) ? function() {
            if (this.originalEvent) return e(this.originalEvent)
          } : function() {
            if (this.originalEvent) return this.originalEvent[t]
          },
          set: function(e) {
            Object.defineProperty(this, t, {
              enumerable: !0,
              configurable: !0,
              writable: !0,
              value: e
            })
          }
        })
      },
      fix: function(e) {
        return e[ce.expando] ? e : new ce.Event(e)
      },
      special: {
        load: {
          noBubble: !0
        },
        click: {
          setup: function(e) {
            var t = this || e;
            return we.test(t.type) && t.click && fe(t, "input") && He(t, "click", !0), !1
          },
          trigger: function(e) {
            var t = this || e;
            return we.test(t.type) && t.click && fe(t, "input") && He(t, "click"), !0
          },
          _default: function(e) {
            var t = e.target;
            return we.test(t.type) && t.click && fe(t, "input") && _.get(t, "click") || fe(t, "a")
          }
        },
        beforeunload: {
          postDispatch: function(e) {
            void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
          }
        }
      }
    }, ce.removeEvent = function(e, t, n) {
      e.removeEventListener && e.removeEventListener(t, n)
    }, ce.Event = function(e, t) {
      if (!(this instanceof ce.Event)) return new ce.Event(e, t);
      e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? Ne : qe, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && ce.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[ce.expando] = !0
    }, ce.Event.prototype = {
      constructor: ce.Event,
      isDefaultPrevented: qe,
      isPropagationStopped: qe,
      isImmediatePropagationStopped: qe,
      isSimulated: !1,
      preventDefault: function() {
        var e = this.originalEvent;
        this.isDefaultPrevented = Ne, e && !this.isSimulated && e.preventDefault()
      },
      stopPropagation: function() {
        var e = this.originalEvent;
        this.isPropagationStopped = Ne, e && !this.isSimulated && e.stopPropagation()
      },
      stopImmediatePropagation: function() {
        var e = this.originalEvent;
        this.isImmediatePropagationStopped = Ne, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
      }
    }, ce.each({
      altKey: !0,
      bubbles: !0,
      cancelable: !0,
      changedTouches: !0,
      ctrlKey: !0,
      detail: !0,
      eventPhase: !0,
      metaKey: !0,
      pageX: !0,
      pageY: !0,
      shiftKey: !0,
      view: !0,
      "char": !0,
      code: !0,
      charCode: !0,
      key: !0,
      keyCode: !0,
      button: !0,
      buttons: !0,
      clientX: !0,
      clientY: !0,
      offsetX: !0,
      offsetY: !0,
      pointerId: !0,
      pointerType: !0,
      screenX: !0,
      screenY: !0,
      targetTouches: !0,
      toElement: !0,
      touches: !0,
      which: !0
    }, ce.event.addProp), ce.each({
      focus: "focusin",
      blur: "focusout"
    }, function(r, i) {
      function o(e) {
        if (C.documentMode) {
          var t = _.get(this, "handle"),
            n = ce.event.fix(e);
          n.type = "focusin" === e.type ? "focus" : "blur", n.isSimulated = !0, t(e), n.target === n.currentTarget && t(n)
        } else ce.event.simulate(i, e.target, ce.event.fix(e))
      }
      ce.event.special[r] = {
        setup: function() {
          var e;
          if (He(this, r, !0), !C.documentMode) return !1;
          (e = _.get(this, i)) || this.addEventListener(i, o), _.set(this, i, (e || 0) + 1)
        },
        trigger: function() {
          return He(this, r), !0
        },
        teardown: function() {
          var e;
          if (!C.documentMode) return !1;
          (e = _.get(this, i) - 1) ? _.set(this, i, e): (this.removeEventListener(i, o), _.remove(this, i))
        },
        _default: function(e) {
          return _.get(e.target, r)
        },
        delegateType: i
      }, ce.event.special[i] = {
        setup: function() {
          var e = this.ownerDocument || this.document || this,
            t = C.documentMode ? this : e,
            n = _.get(t, i);
          n || (C.documentMode ? this.addEventListener(i, o) : e.addEventListener(r, o, !0)), _.set(t, i, (n || 0) + 1)
        },
        teardown: function() {
          var e = this.ownerDocument || this.document || this,
            t = C.documentMode ? this : e,
            n = _.get(t, i) - 1;
          n ? _.set(t, i, n) : (C.documentMode ? this.removeEventListener(i, o) : e.removeEventListener(r, o, !0), _.remove(t, i))
        }
      }
    }), ce.each({
      mouseenter: "mouseover",
      mouseleave: "mouseout",
      pointerenter: "pointerover",
      pointerleave: "pointerout"
    }, function(e, i) {
      ce.event.special[e] = {
        delegateType: i,
        bindType: i,
        handle: function(e) {
          var t, n = e.relatedTarget,
            r = e.handleObj;
          return n && (n === this || ce.contains(this, n)) || (e.type = r.origType, t = r.handler.apply(this, arguments), e.type = i), t
        }
      }
    }), ce.fn.extend({
      on: function(e, t, n, r) {
        return Le(this, e, t, n, r)
      },
      one: function(e, t, n, r) {
        return Le(this, e, t, n, r, 1)
      },
      off: function(e, t, n) {
        var r, i;
        if (e && e.preventDefault && e.handleObj) return r = e.handleObj, ce(e.delegateTarget).off(r.namespace ? r.origType + "." + r.namespace : r.origType, r.selector, r.handler), this;
        if ("object" == typeof e) {
          for (i in e) this.off(i, t, e[i]);
          return this
        }
        return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = qe), this.each(function() {
          ce.event.remove(this, e, n, t)
        })
      }
    });
    var Oe = /<script|<style|<link/i,
      Pe = /checked\s*(?:[^=]|=\s*.checked.)/i,
      Me = /^\s*<!\[CDATA\[|\]\]>\s*$/g;

    function Re(e, t) {
      return fe(e, "table") && fe(11 !== t.nodeType ? t : t.firstChild, "tr") && ce(e).children("tbody")[0] || e
    }

    function Ie(e) {
      return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function We(e) {
      return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Fe(e, t) {
      var n, r, i, o, a, s;
      if (1 === t.nodeType) {
        if (_.hasData(e) && (s = _.get(e).events))
          for (i in _.remove(t, "handle events"), s)
            for (n = 0, r = s[i].length; n < r; n++) ce.event.add(t, i, s[i][n]);
        z.hasData(e) && (o = z.access(e), a = ce.extend({}, o), z.set(t, a))
      }
    }

    function $e(n, r, i, o) {
      r = g(r);
      var e, t, a, s, u, l, c = 0,
        f = n.length,
        p = f - 1,
        d = r[0],
        h = v(d);
      if (h || 1 < f && "string" == typeof d && !le.checkClone && Pe.test(d)) return n.each(function(e) {
        var t = n.eq(e);
        h && (r[0] = d.call(this, e, t.html())), $e(t, r, i, o)
      });
      if (f && (t = (e = Ae(r, n[0].ownerDocument, !1, n, o)).firstChild, 1 === e.childNodes.length && (e = t), t || o)) {
        for (s = (a = ce.map(Se(e, "script"), Ie)).length; c < f; c++) u = e, c !== p && (u = ce.clone(u, !0, !0), s && ce.merge(a, Se(u, "script"))), i.call(n[c], u, c);
        if (s)
          for (l = a[a.length - 1].ownerDocument, ce.map(a, We), c = 0; c < s; c++) u = a[c], Ce.test(u.type || "") && !_.access(u, "globalEval") && ce.contains(l, u) && (u.src && "module" !== (u.type || "").toLowerCase() ? ce._evalUrl && !u.noModule && ce._evalUrl(u.src, {
            nonce: u.nonce || u.getAttribute("nonce")
          }, l) : m(u.textContent.replace(Me, ""), u, l))
      }
      return n
    }

    function Be(e, t, n) {
      for (var r, i = t ? ce.filter(t, e) : e, o = 0; null != (r = i[o]); o++) n || 1 !== r.nodeType || ce.cleanData(Se(r)), r.parentNode && (n && K(r) && Ee(Se(r, "script")), r.parentNode.removeChild(r));
      return e
    }
    ce.extend({
      htmlPrefilter: function(e) {
        return e
      },
      clone: function(e, t, n) {
        var r, i, o, a, s, u, l, c = e.cloneNode(!0),
          f = K(e);
        if (!(le.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || ce.isXMLDoc(e)))
          for (a = Se(c), r = 0, i = (o = Se(e)).length; r < i; r++) s = o[r], u = a[r], void 0, "input" === (l = u.nodeName.toLowerCase()) && we.test(s.type) ? u.checked = s.checked : "input" !== l && "textarea" !== l || (u.defaultValue = s.defaultValue);
        if (t)
          if (n)
            for (o = o || Se(e), a = a || Se(c), r = 0, i = o.length; r < i; r++) Fe(o[r], a[r]);
          else Fe(e, c);
        return 0 < (a = Se(c, "script")).length && Ee(a, !f && Se(e, "script")), c
      },
      cleanData: function(e) {
        for (var t, n, r, i = ce.event.special, o = 0; void 0 !== (n = e[o]); o++)
          if ($(n)) {
            if (t = n[_.expando]) {
              if (t.events)
                for (r in t.events) i[r] ? ce.event.remove(n, r) : ce.removeEvent(n, r, t.handle);
              n[_.expando] = void 0
            }
            n[z.expando] && (n[z.expando] = void 0)
          }
      }
    }), ce.fn.extend({
      detach: function(e) {
        return Be(this, e, !0)
      },
      remove: function(e) {
        return Be(this, e)
      },
      text: function(e) {
        return M(this, function(e) {
          return void 0 === e ? ce.text(this) : this.empty().each(function() {
            1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
          })
        }, null, e, arguments.length)
      },
      append: function() {
        return $e(this, arguments, function(e) {
          1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || Re(this, e).appendChild(e)
        })
      },
      prepend: function() {
        return $e(this, arguments, function(e) {
          if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
            var t = Re(this, e);
            t.insertBefore(e, t.firstChild)
          }
        })
      },
      before: function() {
        return $e(this, arguments, function(e) {
          this.parentNode && this.parentNode.insertBefore(e, this)
        })
      },
      after: function() {
        return $e(this, arguments, function(e) {
          this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
        })
      },
      empty: function() {
        for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (ce.cleanData(Se(e, !1)), e.textContent = "");
        return this
      },
      clone: function(e, t) {
        return e = null != e && e, t = null == t ? e : t, this.map(function() {
          return ce.clone(this, e, t)
        })
      },
      html: function(e) {
        return M(this, function(e) {
          var t = this[0] || {},
            n = 0,
            r = this.length;
          if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
          if ("string" == typeof e && !Oe.test(e) && !ke[(Te.exec(e) || ["", ""])[1].toLowerCase()]) {
            e = ce.htmlPrefilter(e);
            try {
              for (; n < r; n++) 1 === (t = this[n] || {}).nodeType && (ce.cleanData(Se(t, !1)), t.innerHTML = e);
              t = 0
            } catch (e) {}
          }
          t && this.empty().append(e)
        }, null, e, arguments.length)
      },
      replaceWith: function() {
        var n = [];
        return $e(this, arguments, function(e) {
          var t = this.parentNode;
          ce.inArray(this, n) < 0 && (ce.cleanData(Se(this)), t && t.replaceChild(e, this))
        }, n)
      }
    }), ce.each({
      appendTo: "append",
      prependTo: "prepend",
      insertBefore: "before",
      insertAfter: "after",
      replaceAll: "replaceWith"
    }, function(e, a) {
      ce.fn[e] = function(e) {
        for (var t, n = [], r = ce(e), i = r.length - 1, o = 0; o <= i; o++) t = o === i ? this : this.clone(!0), ce(r[o])[a](t), s.apply(n, t.get());
        return this.pushStack(n)
      }
    });
    var _e = new RegExp("^(" + G + ")(?!px)[a-z%]+$", "i"),
      ze = /^--/,
      Xe = function(e) {
        var t = e.ownerDocument.defaultView;
        return t && t.opener || (t = ie), t.getComputedStyle(e)
      },
      Ue = function(e, t, n) {
        var r, i, o = {};
        for (i in t) o[i] = e.style[i], e.style[i] = t[i];
        for (i in r = n.call(e), t) e.style[i] = o[i];
        return r
      },
      Ve = new RegExp(Q.join("|"), "i");

    function Ge(e, t, n) {
      var r, i, o, a, s = ze.test(t),
        u = e.style;
      return (n = n || Xe(e)) && (a = n.getPropertyValue(t) || n[t], s && a && (a = a.replace(ve, "$1") || void 0), "" !== a || K(e) || (a = ce.style(e, t)), !le.pixelBoxStyles() && _e.test(a) && Ve.test(t) && (r = u.width, i = u.minWidth, o = u.maxWidth, u.minWidth = u.maxWidth = u.width = a, a = n.width, u.width = r, u.minWidth = i, u.maxWidth = o)), void 0 !== a ? a + "" : a
    }

    function Ye(e, t) {
      return {
        get: function() {
          if (!e()) return (this.get = t).apply(this, arguments);
          delete this.get
        }
      }
    }! function() {
      function e() {
        if (l) {
          u.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", l.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", J.appendChild(u).appendChild(l);
          var e = ie.getComputedStyle(l);
          n = "1%" !== e.top, s = 12 === t(e.marginLeft), l.style.right = "60%", o = 36 === t(e.right), r = 36 === t(e.width), l.style.position = "absolute", i = 12 === t(l.offsetWidth / 3), J.removeChild(u), l = null
        }
      }

      function t(e) {
        return Math.round(parseFloat(e))
      }
      var n, r, i, o, a, s, u = C.createElement("div"),
        l = C.createElement("div");
      l.style && (l.style.backgroundClip = "content-box", l.cloneNode(!0).style.backgroundClip = "", le.clearCloneStyle = "content-box" === l.style.backgroundClip, ce.extend(le, {
        boxSizingReliable: function() {
          return e(), r
        },
        pixelBoxStyles: function() {
          return e(), o
        },
        pixelPosition: function() {
          return e(), n
        },
        reliableMarginLeft: function() {
          return e(), s
        },
        scrollboxSize: function() {
          return e(), i
        },
        reliableTrDimensions: function() {
          var e, t, n, r;
          return null == a && (e = C.createElement("table"), t = C.createElement("tr"), n = C.createElement("div"), e.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", t.style.cssText = "box-sizing:content-box;border:1px solid", t.style.height = "1px", n.style.height = "9px", n.style.display = "block", J.appendChild(e).appendChild(t).appendChild(n), r = ie.getComputedStyle(t), a = parseInt(r.height, 10) + parseInt(r.borderTopWidth, 10) + parseInt(r.borderBottomWidth, 10) === t.offsetHeight, J.removeChild(e)), a
        }
      }))
    }();
    var Qe = ["Webkit", "Moz", "ms"],
      Je = C.createElement("div").style,
      Ke = {};

    function Ze(e) {
      var t = ce.cssProps[e] || Ke[e];
      return t || (e in Je ? e : Ke[e] = function(e) {
        var t = e[0].toUpperCase() + e.slice(1),
          n = Qe.length;
        while (n--)
          if ((e = Qe[n] + t) in Je) return e
      }(e) || e)
    }
    var et = /^(none|table(?!-c[ea]).+)/,
      tt = {
        position: "absolute",
        visibility: "hidden",
        display: "block"
      },
      nt = {
        letterSpacing: "0",
        fontWeight: "400"
      };

    function rt(e, t, n) {
      var r = Y.exec(t);
      return r ? Math.max(0, r[2] - (n || 0)) + (r[3] || "px") : t
    }

    function it(e, t, n, r, i, o) {
      var a = "width" === t ? 1 : 0,
        s = 0,
        u = 0,
        l = 0;
      if (n === (r ? "border" : "content")) return 0;
      for (; a < 4; a += 2) "margin" === n && (l += ce.css(e, n + Q[a], !0, i)), r ? ("content" === n && (u -= ce.css(e, "padding" + Q[a], !0, i)), "margin" !== n && (u -= ce.css(e, "border" + Q[a] + "Width", !0, i))) : (u += ce.css(e, "padding" + Q[a], !0, i), "padding" !== n ? u += ce.css(e, "border" + Q[a] + "Width", !0, i) : s += ce.css(e, "border" + Q[a] + "Width", !0, i));
      return !r && 0 <= o && (u += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - o - u - s - .5)) || 0), u + l
    }

    function ot(e, t, n) {
      var r = Xe(e),
        i = (!le.boxSizingReliable() || n) && "border-box" === ce.css(e, "boxSizing", !1, r),
        o = i,
        a = Ge(e, t, r),
        s = "offset" + t[0].toUpperCase() + t.slice(1);
      if (_e.test(a)) {
        if (!n) return a;
        a = "auto"
      }
      return (!le.boxSizingReliable() && i || !le.reliableTrDimensions() && fe(e, "tr") || "auto" === a || !parseFloat(a) && "inline" === ce.css(e, "display", !1, r)) && e.getClientRects().length && (i = "border-box" === ce.css(e, "boxSizing", !1, r), (o = s in e) && (a = e[s])), (a = parseFloat(a) || 0) + it(e, t, n || (i ? "border" : "content"), o, r, a) + "px"
    }

    function at(e, t, n, r, i) {
      return new at.prototype.init(e, t, n, r, i)
    }
    ce.extend({
      cssHooks: {
        opacity: {
          get: function(e, t) {
            if (t) {
              var n = Ge(e, "opacity");
              return "" === n ? "1" : n
            }
          }
        }
      },
      cssNumber: {
        animationIterationCount: !0,
        aspectRatio: !0,
        borderImageSlice: !0,
        columnCount: !0,
        flexGrow: !0,
        flexShrink: !0,
        fontWeight: !0,
        gridArea: !0,
        gridColumn: !0,
        gridColumnEnd: !0,
        gridColumnStart: !0,
        gridRow: !0,
        gridRowEnd: !0,
        gridRowStart: !0,
        lineHeight: !0,
        opacity: !0,
        order: !0,
        orphans: !0,
        scale: !0,
        widows: !0,
        zIndex: !0,
        zoom: !0,
        fillOpacity: !0,
        floodOpacity: !0,
        stopOpacity: !0,
        strokeMiterlimit: !0,
        strokeOpacity: !0
      },
      cssProps: {},
      style: function(e, t, n, r) {
        if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
          var i, o, a, s = F(t),
            u = ze.test(t),
            l = e.style;
          if (u || (t = Ze(s)), a = ce.cssHooks[t] || ce.cssHooks[s], void 0 === n) return a && "get" in a && void 0 !== (i = a.get(e, !1, r)) ? i : l[t];
          "string" === (o = typeof n) && (i = Y.exec(n)) && i[1] && (n = te(e, t, i), o = "number"), null != n && n == n && ("number" !== o || u || (n += i && i[3] || (ce.cssNumber[s] ? "" : "px")), le.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (l[t] = "inherit"), a && "set" in a && void 0 === (n = a.set(e, n, r)) || (u ? l.setProperty(t, n) : l[t] = n))
        }
      },
      css: function(e, t, n, r) {
        var i, o, a, s = F(t);
        return ze.test(t) || (t = Ze(s)), (a = ce.cssHooks[t] || ce.cssHooks[s]) && "get" in a && (i = a.get(e, !0, n)), void 0 === i && (i = Ge(e, t, r)), "normal" === i && t in nt && (i = nt[t]), "" === n || n ? (o = parseFloat(i), !0 === n || isFinite(o) ? o || 0 : i) : i
      }
    }), ce.each(["height", "width"], function(e, u) {
      ce.cssHooks[u] = {
        get: function(e, t, n) {
          if (t) return !et.test(ce.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? ot(e, u, n) : Ue(e, tt, function() {
            return ot(e, u, n)
          })
        },
        set: function(e, t, n) {
          var r, i = Xe(e),
            o = !le.scrollboxSize() && "absolute" === i.position,
            a = (o || n) && "border-box" === ce.css(e, "boxSizing", !1, i),
            s = n ? it(e, u, n, a, i) : 0;
          return a && o && (s -= Math.ceil(e["offset" + u[0].toUpperCase() + u.slice(1)] - parseFloat(i[u]) - it(e, u, "border", !1, i) - .5)), s && (r = Y.exec(t)) && "px" !== (r[3] || "px") && (e.style[u] = t, t = ce.css(e, u)), rt(0, t, s)
        }
      }
    }), ce.cssHooks.marginLeft = Ye(le.reliableMarginLeft, function(e, t) {
      if (t) return (parseFloat(Ge(e, "marginLeft")) || e.getBoundingClientRect().left - Ue(e, {
        marginLeft: 0
      }, function() {
        return e.getBoundingClientRect().left
      })) + "px"
    }), ce.each({
      margin: "",
      padding: "",
      border: "Width"
    }, function(i, o) {
      ce.cssHooks[i + o] = {
        expand: function(e) {
          for (var t = 0, n = {}, r = "string" == typeof e ? e.split(" ") : [e]; t < 4; t++) n[i + Q[t] + o] = r[t] || r[t - 2] || r[0];
          return n
        }
      }, "margin" !== i && (ce.cssHooks[i + o].set = rt)
    }), ce.fn.extend({
      css: function(e, t) {
        return M(this, function(e, t, n) {
          var r, i, o = {},
            a = 0;
          if (Array.isArray(t)) {
            for (r = Xe(e), i = t.length; a < i; a++) o[t[a]] = ce.css(e, t[a], !1, r);
            return o
          }
          return void 0 !== n ? ce.style(e, t, n) : ce.css(e, t)
        }, e, t, 1 < arguments.length)
      }
    }), ((ce.Tween = at).prototype = {
      constructor: at,
      init: function(e, t, n, r, i, o) {
        this.elem = e, this.prop = n, this.easing = i || ce.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = r, this.unit = o || (ce.cssNumber[n] ? "" : "px")
      },
      cur: function() {
        var e = at.propHooks[this.prop];
        return e && e.get ? e.get(this) : at.propHooks._default.get(this)
      },
      run: function(e) {
        var t, n = at.propHooks[this.prop];
        return this.options.duration ? this.pos = t = ce.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : at.propHooks._default.set(this), this
      }
    }).init.prototype = at.prototype, (at.propHooks = {
      _default: {
        get: function(e) {
          var t;
          return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = ce.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
        },
        set: function(e) {
          ce.fx.step[e.prop] ? ce.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !ce.cssHooks[e.prop] && null == e.elem.style[Ze(e.prop)] ? e.elem[e.prop] = e.now : ce.style(e.elem, e.prop, e.now + e.unit)
        }
      }
    }).scrollTop = at.propHooks.scrollLeft = {
      set: function(e) {
        e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
      }
    }, ce.easing = {
      linear: function(e) {
        return e
      },
      swing: function(e) {
        return .5 - Math.cos(e * Math.PI) / 2
      },
      _default: "swing"
    }, ce.fx = at.prototype.init, ce.fx.step = {};
    var st, ut, lt, ct, ft = /^(?:toggle|show|hide)$/,
      pt = /queueHooks$/;

    function dt() {
      ut && (!1 === C.hidden && ie.requestAnimationFrame ? ie.requestAnimationFrame(dt) : ie.setTimeout(dt, ce.fx.interval), ce.fx.tick())
    }

    function ht() {
      return ie.setTimeout(function() {
        st = void 0
      }), st = Date.now()
    }

    function gt(e, t) {
      var n, r = 0,
        i = {
          height: e
        };
      for (t = t ? 1 : 0; r < 4; r += 2 - t) i["margin" + (n = Q[r])] = i["padding" + n] = e;
      return t && (i.opacity = i.width = e), i
    }

    function vt(e, t, n) {
      for (var r, i = (yt.tweeners[t] || []).concat(yt.tweeners["*"]), o = 0, a = i.length; o < a; o++)
        if (r = i[o].call(n, t, e)) return r
    }

    function yt(o, e, t) {
      var n, a, r = 0,
        i = yt.prefilters.length,
        s = ce.Deferred().always(function() {
          delete u.elem
        }),
        u = function() {
          if (a) return !1;
          for (var e = st || ht(), t = Math.max(0, l.startTime + l.duration - e), n = 1 - (t / l.duration || 0), r = 0, i = l.tweens.length; r < i; r++) l.tweens[r].run(n);
          return s.notifyWith(o, [l, n, t]), n < 1 && i ? t : (i || s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l]), !1)
        },
        l = s.promise({
          elem: o,
          props: ce.extend({}, e),
          opts: ce.extend(!0, {
            specialEasing: {},
            easing: ce.easing._default
          }, t),
          originalProperties: e,
          originalOptions: t,
          startTime: st || ht(),
          duration: t.duration,
          tweens: [],
          createTween: function(e, t) {
            var n = ce.Tween(o, l.opts, e, t, l.opts.specialEasing[e] || l.opts.easing);
            return l.tweens.push(n), n
          },
          stop: function(e) {
            var t = 0,
              n = e ? l.tweens.length : 0;
            if (a) return this;
            for (a = !0; t < n; t++) l.tweens[t].run(1);
            return e ? (s.notifyWith(o, [l, 1, 0]), s.resolveWith(o, [l, e])) : s.rejectWith(o, [l, e]), this
          }
        }),
        c = l.props;
      for (! function(e, t) {
          var n, r, i, o, a;
          for (n in e)
            if (i = t[r = F(n)], o = e[n], Array.isArray(o) && (i = o[1], o = e[n] = o[0]), n !== r && (e[r] = o, delete e[n]), (a = ce.cssHooks[r]) && "expand" in a)
              for (n in o = a.expand(o), delete e[r], o) n in e || (e[n] = o[n], t[n] = i);
            else t[r] = i
        }(c, l.opts.specialEasing); r < i; r++)
        if (n = yt.prefilters[r].call(l, o, c, l.opts)) return v(n.stop) && (ce._queueHooks(l.elem, l.opts.queue).stop = n.stop.bind(n)), n;
      return ce.map(c, vt, l), v(l.opts.start) && l.opts.start.call(o, l), l.progress(l.opts.progress).done(l.opts.done, l.opts.complete).fail(l.opts.fail).always(l.opts.always), ce.fx.timer(ce.extend(u, {
        elem: o,
        anim: l,
        queue: l.opts.queue
      })), l
    }
    ce.Animation = ce.extend(yt, {
      tweeners: {
        "*": [function(e, t) {
          var n = this.createTween(e, t);
          return te(n.elem, e, Y.exec(t), n), n
        }]
      },
      tweener: function(e, t) {
        v(e) ? (t = e, e = ["*"]) : e = e.match(D);
        for (var n, r = 0, i = e.length; r < i; r++) n = e[r], yt.tweeners[n] = yt.tweeners[n] || [], yt.tweeners[n].unshift(t)
      },
      prefilters: [function(e, t, n) {
        var r, i, o, a, s, u, l, c, f = "width" in t || "height" in t,
          p = this,
          d = {},
          h = e.style,
          g = e.nodeType && ee(e),
          v = _.get(e, "fxshow");
        for (r in n.queue || (null == (a = ce._queueHooks(e, "fx")).unqueued && (a.unqueued = 0, s = a.empty.fire, a.empty.fire = function() {
            a.unqueued || s()
          }), a.unqueued++, p.always(function() {
            p.always(function() {
              a.unqueued--, ce.queue(e, "fx").length || a.empty.fire()
            })
          })), t)
          if (i = t[r], ft.test(i)) {
            if (delete t[r], o = o || "toggle" === i, i === (g ? "hide" : "show")) {
              if ("show" !== i || !v || void 0 === v[r]) continue;
              g = !0
            }
            d[r] = v && v[r] || ce.style(e, r)
          } if ((u = !ce.isEmptyObject(t)) || !ce.isEmptyObject(d))
          for (r in f && 1 === e.nodeType && (n.overflow = [h.overflow, h.overflowX, h.overflowY], null == (l = v && v.display) && (l = _.get(e, "display")), "none" === (c = ce.css(e, "display")) && (l ? c = l : (re([e], !0), l = e.style.display || l, c = ce.css(e, "display"), re([e]))), ("inline" === c || "inline-block" === c && null != l) && "none" === ce.css(e, "float") && (u || (p.done(function() {
              h.display = l
            }), null == l && (c = h.display, l = "none" === c ? "" : c)), h.display = "inline-block")), n.overflow && (h.overflow = "hidden", p.always(function() {
              h.overflow = n.overflow[0], h.overflowX = n.overflow[1], h.overflowY = n.overflow[2]
            })), u = !1, d) u || (v ? "hidden" in v && (g = v.hidden) : v = _.access(e, "fxshow", {
            display: l
          }), o && (v.hidden = !g), g && re([e], !0), p.done(function() {
            for (r in g || re([e]), _.remove(e, "fxshow"), d) ce.style(e, r, d[r])
          })), u = vt(g ? v[r] : 0, r, p), r in v || (v[r] = u.start, g && (u.end = u.start, u.start = 0))
      }],
      prefilter: function(e, t) {
        t ? yt.prefilters.unshift(e) : yt.prefilters.push(e)
      }
    }), ce.speed = function(e, t, n) {
      var r = e && "object" == typeof e ? ce.extend({}, e) : {
        complete: n || !n && t || v(e) && e,
        duration: e,
        easing: n && t || t && !v(t) && t
      };
      return ce.fx.off ? r.duration = 0 : "number" != typeof r.duration && (r.duration in ce.fx.speeds ? r.duration = ce.fx.speeds[r.duration] : r.duration = ce.fx.speeds._default), null != r.queue && !0 !== r.queue || (r.queue = "fx"), r.old = r.complete, r.complete = function() {
        v(r.old) && r.old.call(this), r.queue && ce.dequeue(this, r.queue)
      }, r
    }, ce.fn.extend({
      fadeTo: function(e, t, n, r) {
        return this.filter(ee).css("opacity", 0).show().end().animate({
          opacity: t
        }, e, n, r)
      },
      animate: function(t, e, n, r) {
        var i = ce.isEmptyObject(t),
          o = ce.speed(e, n, r),
          a = function() {
            var e = yt(this, ce.extend({}, t), o);
            (i || _.get(this, "finish")) && e.stop(!0)
          };
        return a.finish = a, i || !1 === o.queue ? this.each(a) : this.queue(o.queue, a)
      },
      stop: function(i, e, o) {
        var a = function(e) {
          var t = e.stop;
          delete e.stop, t(o)
        };
        return "string" != typeof i && (o = e, e = i, i = void 0), e && this.queue(i || "fx", []), this.each(function() {
          var e = !0,
            t = null != i && i + "queueHooks",
            n = ce.timers,
            r = _.get(this);
          if (t) r[t] && r[t].stop && a(r[t]);
          else
            for (t in r) r[t] && r[t].stop && pt.test(t) && a(r[t]);
          for (t = n.length; t--;) n[t].elem !== this || null != i && n[t].queue !== i || (n[t].anim.stop(o), e = !1, n.splice(t, 1));
          !e && o || ce.dequeue(this, i)
        })
      },
      finish: function(a) {
        return !1 !== a && (a = a || "fx"), this.each(function() {
          var e, t = _.get(this),
            n = t[a + "queue"],
            r = t[a + "queueHooks"],
            i = ce.timers,
            o = n ? n.length : 0;
          for (t.finish = !0, ce.queue(this, a, []), r && r.stop && r.stop.call(this, !0), e = i.length; e--;) i[e].elem === this && i[e].queue === a && (i[e].anim.stop(!0), i.splice(e, 1));
          for (e = 0; e < o; e++) n[e] && n[e].finish && n[e].finish.call(this);
          delete t.finish
        })
      }
    }), ce.each(["toggle", "show", "hide"], function(e, r) {
      var i = ce.fn[r];
      ce.fn[r] = function(e, t, n) {
        return null == e || "boolean" == typeof e ? i.apply(this, arguments) : this.animate(gt(r, !0), e, t, n)
      }
    }), ce.each({
      slideDown: gt("show"),
      slideUp: gt("hide"),
      slideToggle: gt("toggle"),
      fadeIn: {
        opacity: "show"
      },
      fadeOut: {
        opacity: "hide"
      },
      fadeToggle: {
        opacity: "toggle"
      }
    }, function(e, r) {
      ce.fn[e] = function(e, t, n) {
        return this.animate(r, e, t, n)
      }
    }), ce.timers = [], ce.fx.tick = function() {
      var e, t = 0,
        n = ce.timers;
      for (st = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
      n.length || ce.fx.stop(), st = void 0
    }, ce.fx.timer = function(e) {
      ce.timers.push(e), ce.fx.start()
    }, ce.fx.interval = 13, ce.fx.start = function() {
      ut || (ut = !0, dt())
    }, ce.fx.stop = function() {
      ut = null
    }, ce.fx.speeds = {
      slow: 600,
      fast: 200,
      _default: 400
    }, ce.fn.delay = function(r, e) {
      return r = ce.fx && ce.fx.speeds[r] || r, e = e || "fx", this.queue(e, function(e, t) {
        var n = ie.setTimeout(e, r);
        t.stop = function() {
          ie.clearTimeout(n)
        }
      })
    }, lt = C.createElement("input"), ct = C.createElement("select").appendChild(C.createElement("option")), lt.type = "checkbox", le.checkOn = "" !== lt.value, le.optSelected = ct.selected, (lt = C.createElement("input")).value = "t", lt.type = "radio", le.radioValue = "t" === lt.value;
    var mt, xt = ce.expr.attrHandle;
    ce.fn.extend({
      attr: function(e, t) {
        return M(this, ce.attr, e, t, 1 < arguments.length)
      },
      removeAttr: function(e) {
        return this.each(function() {
          ce.removeAttr(this, e)
        })
      }
    }), ce.extend({
      attr: function(e, t, n) {
        var r, i, o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o) return "undefined" == typeof e.getAttribute ? ce.prop(e, t, n) : (1 === o && ce.isXMLDoc(e) || (i = ce.attrHooks[t.toLowerCase()] || (ce.expr.match.bool.test(t) ? mt : void 0)), void 0 !== n ? null === n ? void ce.removeAttr(e, t) : i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : (e.setAttribute(t, n + ""), n) : i && "get" in i && null !== (r = i.get(e, t)) ? r : null == (r = ce.find.attr(e, t)) ? void 0 : r)
      },
      attrHooks: {
        type: {
          set: function(e, t) {
            if (!le.radioValue && "radio" === t && fe(e, "input")) {
              var n = e.value;
              return e.setAttribute("type", t), n && (e.value = n), t
            }
          }
        }
      },
      removeAttr: function(e, t) {
        var n, r = 0,
          i = t && t.match(D);
        if (i && 1 === e.nodeType)
          while (n = i[r++]) e.removeAttribute(n)
      }
    }), mt = {
      set: function(e, t, n) {
        return !1 === t ? ce.removeAttr(e, n) : e.setAttribute(n, n), n
      }
    }, ce.each(ce.expr.match.bool.source.match(/\w+/g), function(e, t) {
      var a = xt[t] || ce.find.attr;
      xt[t] = function(e, t, n) {
        var r, i, o = t.toLowerCase();
        return n || (i = xt[o], xt[o] = r, r = null != a(e, t, n) ? o : null, xt[o] = i), r
      }
    });
    var bt = /^(?:input|select|textarea|button)$/i,
      wt = /^(?:a|area)$/i;

    function Tt(e) {
      return (e.match(D) || []).join(" ")
    }

    function Ct(e) {
      return e.getAttribute && e.getAttribute("class") || ""
    }

    function kt(e) {
      return Array.isArray(e) ? e : "string" == typeof e && e.match(D) || []
    }
    ce.fn.extend({
      prop: function(e, t) {
        return M(this, ce.prop, e, t, 1 < arguments.length)
      },
      removeProp: function(e) {
        return this.each(function() {
          delete this[ce.propFix[e] || e]
        })
      }
    }), ce.extend({
      prop: function(e, t, n) {
        var r, i, o = e.nodeType;
        if (3 !== o && 8 !== o && 2 !== o) return 1 === o && ce.isXMLDoc(e) || (t = ce.propFix[t] || t, i = ce.propHooks[t]), void 0 !== n ? i && "set" in i && void 0 !== (r = i.set(e, n, t)) ? r : e[t] = n : i && "get" in i && null !== (r = i.get(e, t)) ? r : e[t]
      },
      propHooks: {
        tabIndex: {
          get: function(e) {
            var t = ce.find.attr(e, "tabindex");
            return t ? parseInt(t, 10) : bt.test(e.nodeName) || wt.test(e.nodeName) && e.href ? 0 : -1
          }
        }
      },
      propFix: {
        "for": "htmlFor",
        "class": "className"
      }
    }), le.optSelected || (ce.propHooks.selected = {
      get: function(e) {
        var t = e.parentNode;
        return t && t.parentNode && t.parentNode.selectedIndex, null
      },
      set: function(e) {
        var t = e.parentNode;
        t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
      }
    }), ce.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function() {
      ce.propFix[this.toLowerCase()] = this
    }), ce.fn.extend({
      addClass: function(t) {
        var e, n, r, i, o, a;
        return v(t) ? this.each(function(e) {
          ce(this).addClass(t.call(this, e, Ct(this)))
        }) : (e = kt(t)).length ? this.each(function() {
          if (r = Ct(this), n = 1 === this.nodeType && " " + Tt(r) + " ") {
            for (o = 0; o < e.length; o++) i = e[o], n.indexOf(" " + i + " ") < 0 && (n += i + " ");
            a = Tt(n), r !== a && this.setAttribute("class", a)
          }
        }) : this
      },
      removeClass: function(t) {
        var e, n, r, i, o, a;
        return v(t) ? this.each(function(e) {
          ce(this).removeClass(t.call(this, e, Ct(this)))
        }) : arguments.length ? (e = kt(t)).length ? this.each(function() {
          if (r = Ct(this), n = 1 === this.nodeType && " " + Tt(r) + " ") {
            for (o = 0; o < e.length; o++) {
              i = e[o];
              while (-1 < n.indexOf(" " + i + " ")) n = n.replace(" " + i + " ", " ")
            }
            a = Tt(n), r !== a && this.setAttribute("class", a)
          }
        }) : this : this.attr("class", "")
      },
      toggleClass: function(t, n) {
        var e, r, i, o, a = typeof t,
          s = "string" === a || Array.isArray(t);
        return v(t) ? this.each(function(e) {
          ce(this).toggleClass(t.call(this, e, Ct(this), n), n)
        }) : "boolean" == typeof n && s ? n ? this.addClass(t) : this.removeClass(t) : (e = kt(t), this.each(function() {
          if (s)
            for (o = ce(this), i = 0; i < e.length; i++) r = e[i], o.hasClass(r) ? o.removeClass(r) : o.addClass(r);
          else void 0 !== t && "boolean" !== a || ((r = Ct(this)) && _.set(this, "__className__", r), this.setAttribute && this.setAttribute("class", r || !1 === t ? "" : _.get(this, "__className__") || ""))
        }))
      },
      hasClass: function(e) {
        var t, n, r = 0;
        t = " " + e + " ";
        while (n = this[r++])
          if (1 === n.nodeType && -1 < (" " + Tt(Ct(n)) + " ").indexOf(t)) return !0;
        return !1
      }
    });
    var St = /\r/g;
    ce.fn.extend({
      val: function(n) {
        var r, e, i, t = this[0];
        return arguments.length ? (i = v(n), this.each(function(e) {
          var t;
          1 === this.nodeType && (null == (t = i ? n.call(this, e, ce(this).val()) : n) ? t = "" : "number" == typeof t ? t += "" : Array.isArray(t) && (t = ce.map(t, function(e) {
            return null == e ? "" : e + ""
          })), (r = ce.valHooks[this.type] || ce.valHooks[this.nodeName.toLowerCase()]) && "set" in r && void 0 !== r.set(this, t, "value") || (this.value = t))
        })) : t ? (r = ce.valHooks[t.type] || ce.valHooks[t.nodeName.toLowerCase()]) && "get" in r && void 0 !== (e = r.get(t, "value")) ? e : "string" == typeof(e = t.value) ? e.replace(St, "") : null == e ? "" : e : void 0
      }
    }), ce.extend({
      valHooks: {
        option: {
          get: function(e) {
            var t = ce.find.attr(e, "value");
            return null != t ? t : Tt(ce.text(e))
          }
        },
        select: {
          get: function(e) {
            var t, n, r, i = e.options,
              o = e.selectedIndex,
              a = "select-one" === e.type,
              s = a ? null : [],
              u = a ? o + 1 : i.length;
            for (r = o < 0 ? u : a ? o : 0; r < u; r++)
              if (((n = i[r]).selected || r === o) && !n.disabled && (!n.parentNode.disabled || !fe(n.parentNode, "optgroup"))) {
                if (t = ce(n).val(), a) return t;
                s.push(t)
              } return s
          },
          set: function(e, t) {
            var n, r, i = e.options,
              o = ce.makeArray(t),
              a = i.length;
            while (a--)((r = i[a]).selected = -1 < ce.inArray(ce.valHooks.option.get(r), o)) && (n = !0);
            return n || (e.selectedIndex = -1), o
          }
        }
      }
    }), ce.each(["radio", "checkbox"], function() {
      ce.valHooks[this] = {
        set: function(e, t) {
          if (Array.isArray(t)) return e.checked = -1 < ce.inArray(ce(e).val(), t)
        }
      }, le.checkOn || (ce.valHooks[this].get = function(e) {
        return null === e.getAttribute("value") ? "on" : e.value
      })
    });
    var Et = ie.location,
      jt = {
        guid: Date.now()
      },
      At = /\?/;
    ce.parseXML = function(e) {
      var t, n;
      if (!e || "string" != typeof e) return null;
      try {
        t = (new ie.DOMParser).parseFromString(e, "text/xml")
      } catch (e) {}
      return n = t && t.getElementsByTagName("parsererror")[0], t && !n || ce.error("Invalid XML: " + (n ? ce.map(n.childNodes, function(e) {
        return e.textContent
      }).join("\n") : e)), t
    };
    var Dt = /^(?:focusinfocus|focusoutblur)$/,
      Nt = function(e) {
        e.stopPropagation()
      };
    ce.extend(ce.event, {
      trigger: function(e, t, n, r) {
        var i, o, a, s, u, l, c, f, p = [n || C],
          d = ue.call(e, "type") ? e.type : e,
          h = ue.call(e, "namespace") ? e.namespace.split(".") : [];
        if (o = f = a = n = n || C, 3 !== n.nodeType && 8 !== n.nodeType && !Dt.test(d + ce.event.triggered) && (-1 < d.indexOf(".") && (d = (h = d.split(".")).shift(), h.sort()), u = d.indexOf(":") < 0 && "on" + d, (e = e[ce.expando] ? e : new ce.Event(d, "object" == typeof e && e)).isTrigger = r ? 2 : 3, e.namespace = h.join("."), e.rnamespace = e.namespace ? new RegExp("(^|\\.)" + h.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, e.result = void 0, e.target || (e.target = n), t = null == t ? [e] : ce.makeArray(t, [e]), c = ce.event.special[d] || {}, r || !c.trigger || !1 !== c.trigger.apply(n, t))) {
          if (!r && !c.noBubble && !y(n)) {
            for (s = c.delegateType || d, Dt.test(s + d) || (o = o.parentNode); o; o = o.parentNode) p.push(o), a = o;
            a === (n.ownerDocument || C) && p.push(a.defaultView || a.parentWindow || ie)
          }
          i = 0;
          while ((o = p[i++]) && !e.isPropagationStopped()) f = o, e.type = 1 < i ? s : c.bindType || d, (l = (_.get(o, "events") || Object.create(null))[e.type] && _.get(o, "handle")) && l.apply(o, t), (l = u && o[u]) && l.apply && $(o) && (e.result = l.apply(o, t), !1 === e.result && e.preventDefault());
          return e.type = d, r || e.isDefaultPrevented() || c._default && !1 !== c._default.apply(p.pop(), t) || !$(n) || u && v(n[d]) && !y(n) && ((a = n[u]) && (n[u] = null), ce.event.triggered = d, e.isPropagationStopped() && f.addEventListener(d, Nt), n[d](), e.isPropagationStopped() && f.removeEventListener(d, Nt), ce.event.triggered = void 0, a && (n[u] = a)), e.result
        }
      },
      simulate: function(e, t, n) {
        var r = ce.extend(new ce.Event, n, {
          type: e,
          isSimulated: !0
        });
        ce.event.trigger(r, null, t)
      }
    }), ce.fn.extend({
      trigger: function(e, t) {
        return this.each(function() {
          ce.event.trigger(e, t, this)
        })
      },
      triggerHandler: function(e, t) {
        var n = this[0];
        if (n) return ce.event.trigger(e, t, n, !0)
      }
    });
    var qt = /\[\]$/,
      Lt = /\r?\n/g,
      Ht = /^(?:submit|button|image|reset|file)$/i,
      Ot = /^(?:input|select|textarea|keygen)/i;

    function Pt(n, e, r, i) {
      var t;
      if (Array.isArray(e)) ce.each(e, function(e, t) {
        r || qt.test(n) ? i(n, t) : Pt(n + "[" + ("object" == typeof t && null != t ? e : "") + "]", t, r, i)
      });
      else if (r || "object" !== x(e)) i(n, e);
      else
        for (t in e) Pt(n + "[" + t + "]", e[t], r, i)
    }
    ce.param = function(e, t) {
      var n, r = [],
        i = function(e, t) {
          var n = v(t) ? t() : t;
          r[r.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
        };
      if (null == e) return "";
      if (Array.isArray(e) || e.jquery && !ce.isPlainObject(e)) ce.each(e, function() {
        i(this.name, this.value)
      });
      else
        for (n in e) Pt(n, e[n], t, i);
      return r.join("&")
    }, ce.fn.extend({
      serialize: function() {
        return ce.param(this.serializeArray())
      },
      serializeArray: function() {
        return this.map(function() {
          var e = ce.prop(this, "elements");
          return e ? ce.makeArray(e) : this
        }).filter(function() {
          var e = this.type;
          return this.name && !ce(this).is(":disabled") && Ot.test(this.nodeName) && !Ht.test(e) && (this.checked || !we.test(e))
        }).map(function(e, t) {
          var n = ce(this).val();
          return null == n ? null : Array.isArray(n) ? ce.map(n, function(e) {
            return {
              name: t.name,
              value: e.replace(Lt, "\r\n")
            }
          }) : {
            name: t.name,
            value: n.replace(Lt, "\r\n")
          }
        }).get()
      }
    });
    var Mt = /%20/g,
      Rt = /#.*$/,
      It = /([?&])_=[^&]*/,
      Wt = /^(.*?):[ \t]*([^\r\n]*)$/gm,
      Ft = /^(?:GET|HEAD)$/,
      $t = /^\/\//,
      Bt = {},
      _t = {},
      zt = "*/".concat("*"),
      Xt = C.createElement("a");

    function Ut(o) {
      return function(e, t) {
        "string" != typeof e && (t = e, e = "*");
        var n, r = 0,
          i = e.toLowerCase().match(D) || [];
        if (v(t))
          while (n = i[r++]) "+" === n[0] ? (n = n.slice(1) || "*", (o[n] = o[n] || []).unshift(t)) : (o[n] = o[n] || []).push(t)
      }
    }

    function Vt(t, i, o, a) {
      var s = {},
        u = t === _t;

      function l(e) {
        var r;
        return s[e] = !0, ce.each(t[e] || [], function(e, t) {
          var n = t(i, o, a);
          return "string" != typeof n || u || s[n] ? u ? !(r = n) : void 0 : (i.dataTypes.unshift(n), l(n), !1)
        }), r
      }
      return l(i.dataTypes[0]) || !s["*"] && l("*")
    }

    function Gt(e, t) {
      var n, r, i = ce.ajaxSettings.flatOptions || {};
      for (n in t) void 0 !== t[n] && ((i[n] ? e : r || (r = {}))[n] = t[n]);
      return r && ce.extend(!0, e, r), e
    }
    Xt.href = Et.href, ce.extend({
      active: 0,
      lastModified: {},
      etag: {},
      ajaxSettings: {
        url: Et.href,
        type: "GET",
        isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(Et.protocol),
        global: !0,
        processData: !0,
        async: !0,
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        accepts: {
          "*": zt,
          text: "text/plain",
          html: "text/html",
          xml: "application/xml, text/xml",
          json: "application/json, text/javascript"
        },
        contents: {
          xml: /\bxml\b/,
          html: /\bhtml/,
          json: /\bjson\b/
        },
        responseFields: {
          xml: "responseXML",
          text: "responseText",
          json: "responseJSON"
        },
        converters: {
          "* text": String,
          "text html": !0,
          "text json": JSON.parse,
          "text xml": ce.parseXML
        },
        flatOptions: {
          url: !0,
          context: !0
        }
      },
      ajaxSetup: function(e, t) {
        return t ? Gt(Gt(e, ce.ajaxSettings), t) : Gt(ce.ajaxSettings, e)
      },
      ajaxPrefilter: Ut(Bt),
      ajaxTransport: Ut(_t),
      ajax: function(e, t) {
        "object" == typeof e && (t = e, e = void 0), t = t || {};
        var c, f, p, n, d, r, h, g, i, o, v = ce.ajaxSetup({}, t),
          y = v.context || v,
          m = v.context && (y.nodeType || y.jquery) ? ce(y) : ce.event,
          x = ce.Deferred(),
          b = ce.Callbacks("once memory"),
          w = v.statusCode || {},
          a = {},
          s = {},
          u = "canceled",
          T = {
            readyState: 0,
            getResponseHeader: function(e) {
              var t;
              if (h) {
                if (!n) {
                  n = {};
                  while (t = Wt.exec(p)) n[t[1].toLowerCase() + " "] = (n[t[1].toLowerCase() + " "] || []).concat(t[2])
                }
                t = n[e.toLowerCase() + " "]
              }
              return null == t ? null : t.join(", ")
            },
            getAllResponseHeaders: function() {
              return h ? p : null
            },
            setRequestHeader: function(e, t) {
              return null == h && (e = s[e.toLowerCase()] = s[e.toLowerCase()] || e, a[e] = t), this
            },
            overrideMimeType: function(e) {
              return null == h && (v.mimeType = e), this
            },
            statusCode: function(e) {
              var t;
              if (e)
                if (h) T.always(e[T.status]);
                else
                  for (t in e) w[t] = [w[t], e[t]];
              return this
            },
            abort: function(e) {
              var t = e || u;
              return c && c.abort(t), l(0, t), this
            }
          };
        if (x.promise(T), v.url = ((e || v.url || Et.href) + "").replace($t, Et.protocol + "//"), v.type = t.method || t.type || v.method || v.type, v.dataTypes = (v.dataType || "*").toLowerCase().match(D) || [""], null == v.crossDomain) {
          r = C.createElement("a");
          try {
            r.href = v.url, r.href = r.href, v.crossDomain = Xt.protocol + "//" + Xt.host != r.protocol + "//" + r.host
          } catch (e) {
            v.crossDomain = !0
          }
        }
        if (v.data && v.processData && "string" != typeof v.data && (v.data = ce.param(v.data, v.traditional)), Vt(Bt, v, t, T), h) return T;
        for (i in (g = ce.event && v.global) && 0 == ce.active++ && ce.event.trigger("ajaxStart"), v.type = v.type.toUpperCase(), v.hasContent = !Ft.test(v.type), f = v.url.replace(Rt, ""), v.hasContent ? v.data && v.processData && 0 === (v.contentType || "").indexOf("application/x-www-form-urlencoded") && (v.data = v.data.replace(Mt, "+")) : (o = v.url.slice(f.length), v.data && (v.processData || "string" == typeof v.data) && (f += (At.test(f) ? "&" : "?") + v.data, delete v.data), !1 === v.cache && (f = f.replace(It, "$1"), o = (At.test(f) ? "&" : "?") + "_=" + jt.guid++ + o), v.url = f + o), v.ifModified && (ce.lastModified[f] && T.setRequestHeader("If-Modified-Since", ce.lastModified[f]), ce.etag[f] && T.setRequestHeader("If-None-Match", ce.etag[f])), (v.data && v.hasContent && !1 !== v.contentType || t.contentType) && T.setRequestHeader("Content-Type", v.contentType), T.setRequestHeader("Accept", v.dataTypes[0] && v.accepts[v.dataTypes[0]] ? v.accepts[v.dataTypes[0]] + ("*" !== v.dataTypes[0] ? ", " + zt + "; q=0.01" : "") : v.accepts["*"]), v.headers) T.setRequestHeader(i, v.headers[i]);
        if (v.beforeSend && (!1 === v.beforeSend.call(y, T, v) || h)) return T.abort();
        if (u = "abort", b.add(v.complete), T.done(v.success), T.fail(v.error), c = Vt(_t, v, t, T)) {
          if (T.readyState = 1, g && m.trigger("ajaxSend", [T, v]), h) return T;
          v.async && 0 < v.timeout && (d = ie.setTimeout(function() {
            T.abort("timeout")
          }, v.timeout));
          try {
            h = !1, c.send(a, l)
          } catch (e) {
            if (h) throw e;
            l(-1, e)
          }
        } else l(-1, "No Transport");

        function l(e, t, n, r) {
          var i, o, a, s, u, l = t;
          h || (h = !0, d && ie.clearTimeout(d), c = void 0, p = r || "", T.readyState = 0 < e ? 4 : 0, i = 200 <= e && e < 300 || 304 === e, n && (s = function(e, t, n) {
            var r, i, o, a, s = e.contents,
              u = e.dataTypes;
            while ("*" === u[0]) u.shift(), void 0 === r && (r = e.mimeType || t.getResponseHeader("Content-Type"));
            if (r)
              for (i in s)
                if (s[i] && s[i].test(r)) {
                  u.unshift(i);
                  break
                } if (u[0] in n) o = u[0];
            else {
              for (i in n) {
                if (!u[0] || e.converters[i + " " + u[0]]) {
                  o = i;
                  break
                }
                a || (a = i)
              }
              o = o || a
            }
            if (o) return o !== u[0] && u.unshift(o), n[o]
          }(v, T, n)), !i && -1 < ce.inArray("script", v.dataTypes) && ce.inArray("json", v.dataTypes) < 0 && (v.converters["text script"] = function() {}), s = function(e, t, n, r) {
            var i, o, a, s, u, l = {},
              c = e.dataTypes.slice();
            if (c[1])
              for (a in e.converters) l[a.toLowerCase()] = e.converters[a];
            o = c.shift();
            while (o)
              if (e.responseFields[o] && (n[e.responseFields[o]] = t), !u && r && e.dataFilter && (t = e.dataFilter(t, e.dataType)), u = o, o = c.shift())
                if ("*" === o) o = u;
                else if ("*" !== u && u !== o) {
              if (!(a = l[u + " " + o] || l["* " + o]))
                for (i in l)
                  if ((s = i.split(" "))[1] === o && (a = l[u + " " + s[0]] || l["* " + s[0]])) {
                    !0 === a ? a = l[i] : !0 !== l[i] && (o = s[0], c.unshift(s[1]));
                    break
                  } if (!0 !== a)
                if (a && e["throws"]) t = a(t);
                else try {
                  t = a(t)
                } catch (e) {
                  return {
                    state: "parsererror",
                    error: a ? e : "No conversion from " + u + " to " + o
                  }
                }
            }
            return {
              state: "success",
              data: t
            }
          }(v, s, T, i), i ? (v.ifModified && ((u = T.getResponseHeader("Last-Modified")) && (ce.lastModified[f] = u), (u = T.getResponseHeader("etag")) && (ce.etag[f] = u)), 204 === e || "HEAD" === v.type ? l = "nocontent" : 304 === e ? l = "notmodified" : (l = s.state, o = s.data, i = !(a = s.error))) : (a = l, !e && l || (l = "error", e < 0 && (e = 0))), T.status = e, T.statusText = (t || l) + "", i ? x.resolveWith(y, [o, l, T]) : x.rejectWith(y, [T, l, a]), T.statusCode(w), w = void 0, g && m.trigger(i ? "ajaxSuccess" : "ajaxError", [T, v, i ? o : a]), b.fireWith(y, [T, l]), g && (m.trigger("ajaxComplete", [T, v]), --ce.active || ce.event.trigger("ajaxStop")))
        }
        return T
      },
      getJSON: function(e, t, n) {
        return ce.get(e, t, n, "json")
      },
      getScript: function(e, t) {
        return ce.get(e, void 0, t, "script")
      }
    }), ce.each(["get", "post"], function(e, i) {
      ce[i] = function(e, t, n, r) {
        return v(t) && (r = r || n, n = t, t = void 0), ce.ajax(ce.extend({
          url: e,
          type: i,
          dataType: r,
          data: t,
          success: n
        }, ce.isPlainObject(e) && e))
      }
    }), ce.ajaxPrefilter(function(e) {
      var t;
      for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    }), ce._evalUrl = function(e, t, n) {
      return ce.ajax({
        url: e,
        type: "GET",
        dataType: "script",
        cache: !0,
        async: !1,
        global: !1,
        converters: {
          "text script": function() {}
        },
        dataFilter: function(e) {
          ce.globalEval(e, t, n)
        }
      })
    }, ce.fn.extend({
      wrapAll: function(e) {
        var t;
        return this[0] && (v(e) && (e = e.call(this[0])), t = ce(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map(function() {
          var e = this;
          while (e.firstElementChild) e = e.firstElementChild;
          return e
        }).append(this)), this
      },
      wrapInner: function(n) {
        return v(n) ? this.each(function(e) {
          ce(this).wrapInner(n.call(this, e))
        }) : this.each(function() {
          var e = ce(this),
            t = e.contents();
          t.length ? t.wrapAll(n) : e.append(n)
        })
      },
      wrap: function(t) {
        var n = v(t);
        return this.each(function(e) {
          ce(this).wrapAll(n ? t.call(this, e) : t)
        })
      },
      unwrap: function(e) {
        return this.parent(e).not("body").each(function() {
          ce(this).replaceWith(this.childNodes)
        }), this
      }
    }), ce.expr.pseudos.hidden = function(e) {
      return !ce.expr.pseudos.visible(e)
    }, ce.expr.pseudos.visible = function(e) {
      return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, ce.ajaxSettings.xhr = function() {
      try {
        return new ie.XMLHttpRequest
      } catch (e) {}
    };
    var Yt = {
        0: 200,
        1223: 204
      },
      Qt = ce.ajaxSettings.xhr();
    le.cors = !!Qt && "withCredentials" in Qt, le.ajax = Qt = !!Qt, ce.ajaxTransport(function(i) {
      var o, a;
      if (le.cors || Qt && !i.crossDomain) return {
        send: function(e, t) {
          var n, r = i.xhr();
          if (r.open(i.type, i.url, i.async, i.username, i.password), i.xhrFields)
            for (n in i.xhrFields) r[n] = i.xhrFields[n];
          for (n in i.mimeType && r.overrideMimeType && r.overrideMimeType(i.mimeType), i.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest"), e) r.setRequestHeader(n, e[n]);
          o = function(e) {
            return function() {
              o && (o = a = r.onload = r.onerror = r.onabort = r.ontimeout = r.onreadystatechange = null, "abort" === e ? r.abort() : "error" === e ? "number" != typeof r.status ? t(0, "error") : t(r.status, r.statusText) : t(Yt[r.status] || r.status, r.statusText, "text" !== (r.responseType || "text") || "string" != typeof r.responseText ? {
                binary: r.response
              } : {
                text: r.responseText
              }, r.getAllResponseHeaders()))
            }
          }, r.onload = o(), a = r.onerror = r.ontimeout = o("error"), void 0 !== r.onabort ? r.onabort = a : r.onreadystatechange = function() {
            4 === r.readyState && ie.setTimeout(function() {
              o && a()
            })
          }, o = o("abort");
          try {
            r.send(i.hasContent && i.data || null)
          } catch (e) {
            if (o) throw e
          }
        },
        abort: function() {
          o && o()
        }
      }
    }), ce.ajaxPrefilter(function(e) {
      e.crossDomain && (e.contents.script = !1)
    }), ce.ajaxSetup({
      accepts: {
        script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
      },
      contents: {
        script: /\b(?:java|ecma)script\b/
      },
      converters: {
        "text script": function(e) {
          return ce.globalEval(e), e
        }
      }
    }), ce.ajaxPrefilter("script", function(e) {
      void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    }), ce.ajaxTransport("script", function(n) {
      var r, i;
      if (n.crossDomain || n.scriptAttrs) return {
        send: function(e, t) {
          r = ce("<script>").attr(n.scriptAttrs || {}).prop({
            charset: n.scriptCharset,
            src: n.url
          }).on("load error", i = function(e) {
            r.remove(), i = null, e && t("error" === e.type ? 404 : 200, e.type)
          }), C.head.appendChild(r[0])
        },
        abort: function() {
          i && i()
        }
      }
    });
    var Jt, Kt = [],
      Zt = /(=)\?(?=&|$)|\?\?/;
    ce.ajaxSetup({
      jsonp: "callback",
      jsonpCallback: function() {
        var e = Kt.pop() || ce.expando + "_" + jt.guid++;
        return this[e] = !0, e
      }
    }), ce.ajaxPrefilter("json jsonp", function(e, t, n) {
      var r, i, o, a = !1 !== e.jsonp && (Zt.test(e.url) ? "url" : "string" == typeof e.data && 0 === (e.contentType || "").indexOf("application/x-www-form-urlencoded") && Zt.test(e.data) && "data");
      if (a || "jsonp" === e.dataTypes[0]) return r = e.jsonpCallback = v(e.jsonpCallback) ? e.jsonpCallback() : e.jsonpCallback, a ? e[a] = e[a].replace(Zt, "$1" + r) : !1 !== e.jsonp && (e.url += (At.test(e.url) ? "&" : "?") + e.jsonp + "=" + r), e.converters["script json"] = function() {
        return o || ce.error(r + " was not called"), o[0]
      }, e.dataTypes[0] = "json", i = ie[r], ie[r] = function() {
        o = arguments
      }, n.always(function() {
        void 0 === i ? ce(ie).removeProp(r) : ie[r] = i, e[r] && (e.jsonpCallback = t.jsonpCallback, Kt.push(r)), o && v(i) && i(o[0]), o = i = void 0
      }), "script"
    }), le.createHTMLDocument = ((Jt = C.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === Jt.childNodes.length), ce.parseHTML = function(e, t, n) {
      return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (le.createHTMLDocument ? ((r = (t = C.implementation.createHTMLDocument("")).createElement("base")).href = C.location.href, t.head.appendChild(r)) : t = C), o = !n && [], (i = w.exec(e)) ? [t.createElement(i[1])] : (i = Ae([e], t, o), o && o.length && ce(o).remove(), ce.merge([], i.childNodes)));
      var r, i, o
    }, ce.fn.load = function(e, t, n) {
      var r, i, o, a = this,
        s = e.indexOf(" ");
      return -1 < s && (r = Tt(e.slice(s)), e = e.slice(0, s)), v(t) ? (n = t, t = void 0) : t && "object" == typeof t && (i = "POST"), 0 < a.length && ce.ajax({
        url: e,
        type: i || "GET",
        dataType: "html",
        data: t
      }).done(function(e) {
        o = arguments, a.html(r ? ce("<div>").append(ce.parseHTML(e)).find(r) : e)
      }).always(n && function(e, t) {
        a.each(function() {
          n.apply(this, o || [e.responseText, t, e])
        })
      }), this
    }, ce.expr.pseudos.animated = function(t) {
      return ce.grep(ce.timers, function(e) {
        return t === e.elem
      }).length
    }, ce.offset = {
      setOffset: function(e, t, n) {
        var r, i, o, a, s, u, l = ce.css(e, "position"),
          c = ce(e),
          f = {};
        "static" === l && (e.style.position = "relative"), s = c.offset(), o = ce.css(e, "top"), u = ce.css(e, "left"), ("absolute" === l || "fixed" === l) && -1 < (o + u).indexOf("auto") ? (a = (r = c.position()).top, i = r.left) : (a = parseFloat(o) || 0, i = parseFloat(u) || 0), v(t) && (t = t.call(e, n, ce.extend({}, s))), null != t.top && (f.top = t.top - s.top + a), null != t.left && (f.left = t.left - s.left + i), "using" in t ? t.using.call(e, f) : c.css(f)
      }
    }, ce.fn.extend({
      offset: function(t) {
        if (arguments.length) return void 0 === t ? this : this.each(function(e) {
          ce.offset.setOffset(this, t, e)
        });
        var e, n, r = this[0];
        return r ? r.getClientRects().length ? (e = r.getBoundingClientRect(), n = r.ownerDocument.defaultView, {
          top: e.top + n.pageYOffset,
          left: e.left + n.pageXOffset
        }) : {
          top: 0,
          left: 0
        } : void 0
      },
      position: function() {
        if (this[0]) {
          var e, t, n, r = this[0],
            i = {
              top: 0,
              left: 0
            };
          if ("fixed" === ce.css(r, "position")) t = r.getBoundingClientRect();
          else {
            t = this.offset(), n = r.ownerDocument, e = r.offsetParent || n.documentElement;
            while (e && (e === n.body || e === n.documentElement) && "static" === ce.css(e, "position")) e = e.parentNode;
            e && e !== r && 1 === e.nodeType && ((i = ce(e).offset()).top += ce.css(e, "borderTopWidth", !0), i.left += ce.css(e, "borderLeftWidth", !0))
          }
          return {
            top: t.top - i.top - ce.css(r, "marginTop", !0),
            left: t.left - i.left - ce.css(r, "marginLeft", !0)
          }
        }
      },
      offsetParent: function() {
        return this.map(function() {
          var e = this.offsetParent;
          while (e && "static" === ce.css(e, "position")) e = e.offsetParent;
          return e || J
        })
      }
    }), ce.each({
      scrollLeft: "pageXOffset",
      scrollTop: "pageYOffset"
    }, function(t, i) {
      var o = "pageYOffset" === i;
      ce.fn[t] = function(e) {
        return M(this, function(e, t, n) {
          var r;
          if (y(e) ? r = e : 9 === e.nodeType && (r = e.defaultView), void 0 === n) return r ? r[i] : e[t];
          r ? r.scrollTo(o ? r.pageXOffset : n, o ? n : r.pageYOffset) : e[t] = n
        }, t, e, arguments.length)
      }
    }), ce.each(["top", "left"], function(e, n) {
      ce.cssHooks[n] = Ye(le.pixelPosition, function(e, t) {
        if (t) return t = Ge(e, n), _e.test(t) ? ce(e).position()[n] + "px" : t
      })
    }), ce.each({
      Height: "height",
      Width: "width"
    }, function(a, s) {
      ce.each({
        padding: "inner" + a,
        content: s,
        "": "outer" + a
      }, function(r, o) {
        ce.fn[o] = function(e, t) {
          var n = arguments.length && (r || "boolean" != typeof e),
            i = r || (!0 === e || !0 === t ? "margin" : "border");
          return M(this, function(e, t, n) {
            var r;
            return y(e) ? 0 === o.indexOf("outer") ? e["inner" + a] : e.document.documentElement["client" + a] : 9 === e.nodeType ? (r = e.documentElement, Math.max(e.body["scroll" + a], r["scroll" + a], e.body["offset" + a], r["offset" + a], r["client" + a])) : void 0 === n ? ce.css(e, t, i) : ce.style(e, t, n, i)
          }, s, n ? e : void 0, n)
        }
      })
    }), ce.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function(e, t) {
      ce.fn[t] = function(e) {
        return this.on(t, e)
      }
    }), ce.fn.extend({
      bind: function(e, t, n) {
        return this.on(e, null, t, n)
      },
      unbind: function(e, t) {
        return this.off(e, null, t)
      },
      delegate: function(e, t, n, r) {
        return this.on(t, e, n, r)
      },
      undelegate: function(e, t, n) {
        return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
      },
      hover: function(e, t) {
        return this.on("mouseenter", e).on("mouseleave", t || e)
      }
    }), ce.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), function(e, n) {
      ce.fn[n] = function(e, t) {
        return 0 < arguments.length ? this.on(n, null, e, t) : this.trigger(n)
      }
    });
    var en = /^[\s\uFEFF\xA0]+|([^\s\uFEFF\xA0])[\s\uFEFF\xA0]+$/g;
    ce.proxy = function(e, t) {
      var n, r, i;
      if ("string" == typeof t && (n = e[t], t = e, e = n), v(e)) return r = ae.call(arguments, 2), (i = function() {
        return e.apply(t || this, r.concat(ae.call(arguments)))
      }).guid = e.guid = e.guid || ce.guid++, i
    }, ce.holdReady = function(e) {
      e ? ce.readyWait++ : ce.ready(!0)
    }, ce.isArray = Array.isArray, ce.parseJSON = JSON.parse, ce.nodeName = fe, ce.isFunction = v, ce.isWindow = y, ce.camelCase = F, ce.type = x, ce.now = Date.now, ce.isNumeric = function(e) {
      var t = ce.type(e);
      return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, ce.trim = function(e) {
      return null == e ? "" : (e + "").replace(en, "$1")
    }, "function" == typeof define && define.amd && define("jquery", [], function() {
      return ce
    });
    var tn = ie.jQuery,
      nn = ie.$;
    return ce.noConflict = function(e) {
      return ie.$ === ce && (ie.$ = nn), e && ie.jQuery === ce && (ie.jQuery = tn), ce
    }, "undefined" == typeof e && (ie.jQuery = ie.$ = ce), ce
  });
</script>
<!--<script src="//cdn.datatables.net/2.0.2/js/dataTables.min.js"> </script>-->
<script>
  ! function(n) {
    "use strict";
    var a;
    "function" == typeof define && define.amd ? define(["jquery"], function(e) {
      return n(e, window, document)
    }) : "object" == typeof exports ? (a = require("jquery"), "undefined" == typeof window ? module.exports = function(e, t) {
      return e = e || window, t = t || a(e), n(t, e, e.document)
    } : module.exports = n(a, window, window.document)) : window.DataTable = n(jQuery, window, document)
  }(function(B, q, _) {
    "use strict";

    function g(e) {
      var t = parseInt(e, 10);
      return !isNaN(t) && isFinite(e) ? t : null
    }

    function o(e, t, n) {
      var a = typeof e,
        r = "string" == a;
      return "number" == a || "bigint" == a || !!y(e) || (t && r && (e = P(e, t)), n && r && (e = e.replace(j, "")), !isNaN(parseFloat(e)) && isFinite(e))
    }

    function l(e, t, n) {
      var a;
      return !!y(e) || ("string" != typeof e || !e.match(/<(input|select)/i)) && (y(a = e) || "string" == typeof a) && !!o(I(e), t, n) || null
    }

    function v(e, t, n, a) {
      var r = [],
        o = 0,
        i = t.length;
      if (void 0 !== a)
        for (; o < i; o++) e[t[o]][n] && r.push(e[t[o]][n][a]);
      else
        for (; o < i; o++) e[t[o]] && r.push(e[t[o]][n]);
      return r
    }

    function h(e, t) {
      var n, a = [];
      void 0 === t ? (t = 0, n = e) : (n = t, t = e);
      for (var r = t; r < n; r++) a.push(r);
      return a
    }

    function b(e) {
      for (var t = [], n = 0, a = e.length; n < a; n++) e[n] && t.push(e[n]);
      return t
    }
    var C, U, t, e, $ = function(e, H) {
        var W, X, V;
        return $.factory(e, H) ? $ : this instanceof $ ? B(e).DataTable(H) : (X = void 0 === (H = e), V = (W = this).length, X && (H = {}), this.api = function() {
          return new U(this)
        }, this.each(function() {
          var n = 1 < V ? Ge({}, H, !0) : H,
            a = 0,
            e = this.getAttribute("id"),
            r = !1,
            t = $.defaults,
            o = B(this);
          if ("table" != this.nodeName.toLowerCase()) Z(null, 0, "Non-table node initialisation (" + this.nodeName + ")", 2);
          else {
            B(this).trigger("options.dt", n), ne(t), ae(t.column), z(t, t, !0), z(t.column, t.column, !0), z(t, B.extend(n, o.data()), !0);
            for (var i = $.settings, a = 0, l = i.length; a < l; a++) {
              var s = i[a];
              if (s.nTable == this || s.nTHead && s.nTHead.parentNode == this || s.nTFoot && s.nTFoot.parentNode == this) {
                var k = (void 0 !== n.bRetrieve ? n : t).bRetrieve,
                  E = (void 0 !== n.bDestroy ? n : t).bDestroy;
                if (X || k) return s.oInstance;
                if (E) {
                  new $.Api(s).destroy();
                  break
                }
                return void Z(s, 0, "Cannot reinitialise DataTable", 3)
              }
              if (s.sTableId == this.id) {
                i.splice(a, 1);
                break
              }
            }
            null !== e && "" !== e || (e = "DataTables_Table_" + $.ext._unique++, this.id = e);
            var u = B.extend(!0, {}, $.models.oSettings, {
                sDestroyWidth: o[0].style.width,
                sInstance: e,
                sTableId: e,
                colgroup: B("<colgroup>").prependTo(this),
                fastData: function(e, t, n) {
                  return G(u, e, t, n)
                }
              }),
              e = (u.nTable = this, u.oInit = n, i.push(u), u.api = new U(u), u.oInstance = 1 === W.length ? W : o.dataTable(), ne(n), n.aLengthMenu && !n.iDisplayLength && (n.iDisplayLength = Array.isArray(n.aLengthMenu[0]) ? n.aLengthMenu[0][0] : B.isPlainObject(n.aLengthMenu[0]) ? n.aLengthMenu[0].value : n.aLengthMenu[0]), n = Ge(B.extend(!0, {}, t), n), Q(u.oFeatures, n, ["bPaginate", "bLengthChange", "bFilter", "bSort", "bSortMulti", "bInfo", "bProcessing", "bAutoWidth", "bSortClasses", "bServerSide", "bDeferRender"]), Q(u, n, ["ajax", "fnFormatNumber", "sServerMethod", "aaSorting", "aaSortingFixed", "aLengthMenu", "sPaginationType", "iStateDuration", "bSortCellsTop", "iTabIndex", "sDom", "fnStateLoadCallback", "fnStateSaveCallback", "renderer", "searchDelay", "rowId", "caption", "layout", ["iCookieDuration", "iStateDuration"],
                ["oSearch", "oPreviousSearch"],
                ["aoSearchCols", "aoPreSearchCols"],
                ["iDisplayLength", "_iDisplayLength"]
              ]), Q(u.oScroll, n, [
                ["sScrollX", "sX"],
                ["sScrollXInner", "sXInner"],
                ["sScrollY", "sY"],
                ["bScrollCollapse", "bCollapse"]
              ]), Q(u.oLanguage, n, "fnInfoCallback"), K(u, "aoDrawCallback", n.fnDrawCallback), K(u, "aoStateSaveParams", n.fnStateSaveParams), K(u, "aoStateLoadParams", n.fnStateLoadParams), K(u, "aoStateLoaded", n.fnStateLoaded), K(u, "aoRowCallback", n.fnRowCallback), K(u, "aoRowCreatedCallback", n.fnCreatedRow), K(u, "aoHeaderCallback", n.fnHeaderCallback), K(u, "aoFooterCallback", n.fnFooterCallback), K(u, "aoInitComplete", n.fnInitComplete), K(u, "aoPreDrawCallback", n.fnPreDrawCallback), u.rowIdFn = J(n.rowId), u),
              c = ($.__browser || (P = {}, $.__browser = P, j = B("<div/>").css({
                position: "fixed",
                top: 0,
                left: -1 * q.pageXOffset,
                height: 1,
                width: 1,
                overflow: "hidden"
              }).append(B("<div/>").css({
                position: "absolute",
                top: 1,
                left: 1,
                width: 100,
                overflow: "scroll"
              }).append(B("<div/>").css({
                width: "100%",
                height: 10
              }))).appendTo("body"), p = j.children(), O = p.children(), P.barWidth = p[0].offsetWidth - p[0].clientWidth, P.bScrollbarLeft = 1 !== Math.round(O.offset().left), j.remove()), B.extend(e.oBrowser, $.__browser), e.oScroll.iBarWidth = $.__browser.barWidth, u.oClasses),
              d = (B.extend(c, $.ext.classes, n.oClasses), o.addClass(c.table), u.oFeatures.bPaginate || (n.iDisplayStart = 0), void 0 === u.iInitDisplayStart && (u.iInitDisplayStart = n.iDisplayStart, u._iDisplayStart = n.iDisplayStart), u.oLanguage),
              f = (B.extend(!0, d, n.oLanguage), d.sUrl ? (B.ajax({
                dataType: "json",
                url: d.sUrl,
                success: function(e) {
                  z(t.oLanguage, e), B.extend(!0, d, e, u.oInit.oLanguage), ee(u, null, "i18n", [u], !0), Oe(u)
                },
                error: function() {
                  Z(u, 0, "i18n file loading error", 21), Oe(u)
                }
              }), r = !0) : ee(u, null, "i18n", [u]), []),
              h = this.getElementsByTagName("thead"),
              p = Ce(u, h[0]);
            if (n.aoColumns) f = n.aoColumns;
            else if (p.length)
              for (l = p[a = 0].length; a < l; a++) f.push(null);
            for (a = 0, l = f.length; a < l; a++) re(u);
            var g, m, v, b, y, D, x, S = u,
              T = n.aoColumnDefs,
              w = f,
              M = p,
              _ = function(e, t) {
                oe(u, e, t)
              },
              C = S.aoColumns;
            if (w)
              for (g = 0, m = w.length; g < m; g++) w[g] && w[g].name && (C[g].sName = w[g].name);
            if (T)
              for (g = T.length - 1; 0 <= g; g--) {
                var I = void 0 !== (x = T[g]).target ? x.target : void 0 !== x.targets ? x.targets : x.aTargets;
                for (Array.isArray(I) || (I = [I]), v = 0, b = I.length; v < b; v++) {
                  var A = I[v];
                  if ("number" == typeof A && 0 <= A) {
                    for (; C.length <= A;) re(S);
                    _(A, x)
                  } else if ("number" == typeof A && A < 0) _(C.length + A, x);
                  else if ("string" == typeof A)
                    for (y = 0, D = C.length; y < D; y++) "_all" === A ? _(y, x) : -1 !== A.indexOf(":name") ? C[y].sName === A.replace(":name", "") && _(y, x) : M.forEach(function(e) {
                      e[y] && (e = B(e[y].cell), A.match(/^[a-z][\w-]*$/i) && (A = "." + A), e.is(A)) && _(y, x)
                    })
                }
              }
            if (w)
              for (g = 0, m = w.length; g < m; g++) _(g, w[g]);
            var F, L, N, j, P = o.children("tbody").find("tr").eq(0),
              R = (P.length && (F = function(e, t) {
                return null !== e.getAttribute("data-" + t) ? t : null
              }, B(P[0]).children("th, td").each(function(e, t) {
                var n, a = u.aoColumns[e];
                a || Z(u, 0, "Incorrect column count", 18), a.mData === e && (n = F(t, "sort") || F(t, "order"), t = F(t, "filter") || F(t, "search"), null === n && null === t || (a.mData = {
                  _: e + ".display",
                  sort: null !== n ? e + ".@data-" + n : void 0,
                  type: null !== n ? e + ".@data-" + n : void 0,
                  filter: null !== t ? e + ".@data-" + t : void 0
                }, a._isArrayHost = !0, oe(u, e)))
              })), u.oFeatures),
              O = function() {
                if (void 0 === n.aaSorting) {
                  var e = u.aaSorting;
                  for (a = 0, l = e.length; a < l; a++) e[a][1] = u.aoColumns[a].asSorting[0]
                }
                $e(u), K(u, "aoDrawCallback", function() {
                  (u.bSorted || "ssp" === te(u) || R.bDeferRender) && $e(u)
                });
                var t = o.children("caption"),
                  t = (u.caption && (t = 0 === t.length ? B("<caption/>").appendTo(o) : t).html(u.caption), t.length && (t[0]._captionSide = t.css("caption-side"), u.captionNode = t[0]), 0 === h.length && (h = B("<thead/>").appendTo(o)), u.nTHead = h[0], B("tr", h).addClass(c.thead.row), o.children("tbody")),
                  t = (0 === t.length && (t = B("<tbody/>").insertAfter(h)), u.nTBody = t[0], o.children("tfoot"));
                if (0 === t.length && (t = B("<tfoot/>").appendTo(o)), u.nTFoot = t[0], B("tr", t).addClass(c.tfoot.row), n.aaData)
                  for (a = 0; a < n.aaData.length; a++) Y(u, n.aaData[a]);
                else "dom" == te(u) && se(u, B(u.nTBody).children("tr"));
                u.aiDisplay = u.aiDisplayMaster.slice(), !(u.bInitialised = !0) === r && Oe(u)
              };
            K(u, "aoDrawCallback", ze), n.bStateSave ? (R.bStateSave = !0, N = O, (L = u).oFeatures.bStateSave ? void 0 !== (j = L.fnStateLoadCallback.call(L.oInstance, L, function(e) {
              Ye(L, e, N)
            })) && Ye(L, j, N) : N()) : O()
          }
        }), W = null, this)
      },
      c = ($.ext = C = {
        buttons: {},
        classes: {},
        builder: "-source-",
        errMode: "alert",
        feature: [],
        features: {},
        search: [],
        selector: {
          cell: [],
          column: [],
          row: []
        },
        legacy: {
          ajax: null
        },
        pager: {},
        renderer: {
          pageButton: {},
          header: {}
        },
        order: {},
        type: {
          className: {},
          detect: [],
          render: {},
          search: {},
          order: {}
        },
        _unique: 0,
        fnVersionCheck: $.fnVersionCheck,
        iApiIndex: 0,
        sVersion: $.version
      }, B.extend(C, {
        afnFiltering: C.search,
        aTypes: C.type.detect,
        ofnSearch: C.type.search,
        oSort: C.type.order,
        afnSortData: C.order,
        aoFeatures: C.feature,
        oStdClasses: C.classes,
        oPagination: C.pager
      }), B.extend($.ext.classes, {
        container: "dt-container",
        empty: {
          row: "dt-empty"
        },
        info: {
          container: "dt-info"
        },
        length: {
          container: "dt-length",
          select: "dt-input"
        },
        order: {
          canAsc: "dt-orderable-asc",
          canDesc: "dt-orderable-desc",
          isAsc: "dt-ordering-asc",
          isDesc: "dt-ordering-desc",
          none: "dt-orderable-none",
          position: "sorting_"
        },
        processing: {
          container: "dt-processing"
        },
        scrolling: {
          body: "dt-scroll-body",
          container: "dt-scroll",
          footer: {
            self: "dt-scroll-foot",
            inner: "dt-scroll-footInner"
          },
          header: {
            self: "dt-scroll-head",
            inner: "dt-scroll-headInner"
          }
        },
        search: {
          container: "dt-search",
          input: "dt-input"
        },
        table: "dataTable",
        tbody: {
          cell: "",
          row: ""
        },
        thead: {
          cell: "",
          row: ""
        },
        tfoot: {
          cell: "",
          row: ""
        },
        paging: {
          active: "current",
          button: "dt-paging-button",
          container: "dt-paging",
          disabled: "disabled"
        }
      }), {}),
      d = /[\r\n\u2028]/g,
      F = /<.*?>/g,
      L = /^\d{2,4}[./-]\d{1,2}[./-]\d{1,2}([T ]{1}\d{1,2}[:.]\d{2}([.:]\d{2})?)?$/,
      N = new RegExp("(\\" + ["/", ".", "*", "+", "?", "|", "(", ")", "[", "]", "{", "}", "\\", "$", "^", "-"].join("|\\") + ")", "g"),
      j = /['\u00A0,$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfkɃΞ]/gi,
      y = function(e) {
        return !e || !0 === e || "-" === e
      },
      P = function(e, t) {
        return c[t] || (c[t] = new RegExp(je(t), "g")), "string" == typeof e && "." !== t ? e.replace(/\./g, "").replace(c[t], ".") : e
      },
      f = function(e, t, n) {
        var a = [],
          r = 0,
          o = e.length;
        if (void 0 !== n)
          for (; r < o; r++) e[r] && e[r][t] && a.push(e[r][t][n]);
        else
          for (; r < o; r++) e[r] && a.push(e[r][t]);
        return a
      },
      I = function(e) {
        return e.replace(F, "").replace(/<script/i, "")
      },
      u = function(e) {
        return "string" == typeof(e = Array.isArray(e) ? e.join(",") : e) ? e.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;") : e
      },
      R = function(e, t) {
        var n;
        return "string" != typeof e ? e : (n = e.normalize("NFD")).length !== e.length ? (!0 === t ? e + " " : "") + n.replace(/[\u0300-\u036f]/g, "") : n
      },
      x = function(e) {
        if (Array.from && Set) return Array.from(new Set(e));
        if (function(e) {
            if (!(e.length < 2))
              for (var t = e.slice().sort(), n = t[0], a = 1, r = t.length; a < r; a++) {
                if (t[a] === n) return !1;
                n = t[a]
              }
            return !0
          }(e)) return e.slice();
        var t, n, a, r = [],
          o = e.length,
          i = 0;
        e: for (n = 0; n < o; n++) {
          for (t = e[n], a = 0; a < i; a++)
            if (r[a] === t) continue e;
          r.push(t), i++
        }
        return r
      },
      O = function(e, t) {
        if (Array.isArray(t))
          for (var n = 0; n < t.length; n++) O(e, t[n]);
        else e.push(t);
        return e
      };

    function D(t, e) {
      e && e.split(" ").forEach(function(e) {
        e && t.classList.add(e)
      })
    }

    function k(t) {
      var n, a, r = {};
      B.each(t, function(e) {
        (n = e.match(/^([^A-Z]+?)([A-Z])/)) && -1 !== "a aa ai ao as b fn i m o s ".indexOf(n[1] + " ") && (a = e.replace(n[0], n[2].toLowerCase()), r[a] = e, "o" === n[1]) && k(t[e])
      }), t._hungarianMap = r
    }

    function z(t, n, a) {
      var r;
      t._hungarianMap || k(t), B.each(n, function(e) {
        void 0 === (r = t._hungarianMap[e]) || !a && void 0 !== n[r] || ("o" === r.charAt(0) ? (n[r] || (n[r] = {}), B.extend(!0, n[r], n[e]), z(t[r], n[r], a)) : n[r] = n[e])
      })
    }
    $.util = {
      diacritics: function(e, t) {
        if ("function" != typeof e) return R(e, t);
        R = e
      },
      debounce: function(n, a) {
        var r;
        return function() {
          var e = this,
            t = arguments;
          clearTimeout(r), r = setTimeout(function() {
            n.apply(e, t)
          }, a || 250)
        }
      },
      throttle: function(a, e) {
        var r, o, i = void 0 !== e ? e : 200;
        return function() {
          var e = this,
            t = +new Date,
            n = arguments;
          r && t < r + i ? (clearTimeout(o), o = setTimeout(function() {
            r = void 0, a.apply(e, n)
          }, i)) : (r = t, a.apply(e, n))
        }
      },
      escapeRegex: function(e) {
        return e.replace(N, "\\$1")
      },
      set: function(a) {
        var f;
        return B.isPlainObject(a) ? $.util.set(a._) : null === a ? function() {} : "function" == typeof a ? function(e, t, n) {
          a(e, "set", t, n)
        } : "string" != typeof a || -1 === a.indexOf(".") && -1 === a.indexOf("[") && -1 === a.indexOf("(") ? function(e, t) {
          e[a] = t
        } : (f = function(e, t, n) {
          for (var a, r, o, i, l = de(n), n = l[l.length - 1], s = 0, u = l.length - 1; s < u; s++) {
            if ("__proto__" === l[s] || "constructor" === l[s]) throw new Error("Cannot set prototype values");
            if (a = l[s].match(ce), r = l[s].match(p), a) {
              if (l[s] = l[s].replace(ce, ""), e[l[s]] = [], (a = l.slice()).splice(0, s + 1), i = a.join("."), Array.isArray(t))
                for (var c = 0, d = t.length; c < d; c++) f(o = {}, t[c], i), e[l[s]].push(o);
              else e[l[s]] = t;
              return
            }
            r && (l[s] = l[s].replace(p, ""), e = e[l[s]](t)), null !== e[l[s]] && void 0 !== e[l[s]] || (e[l[s]] = {}), e = e[l[s]]
          }
          n.match(p) ? e[n.replace(p, "")](t) : e[n.replace(ce, "")] = t
        }, function(e, t) {
          return f(e, t, a)
        })
      },
      get: function(r) {
        var o, f;
        return B.isPlainObject(r) ? (o = {}, B.each(r, function(e, t) {
          t && (o[e] = $.util.get(t))
        }), function(e, t, n, a) {
          var r = o[t] || o._;
          return void 0 !== r ? r(e, t, n, a) : e
        }) : null === r ? function(e) {
          return e
        } : "function" == typeof r ? function(e, t, n, a) {
          return r(e, t, n, a)
        } : "string" != typeof r || -1 === r.indexOf(".") && -1 === r.indexOf("[") && -1 === r.indexOf("(") ? function(e) {
          return e[r]
        } : (f = function(e, t, n) {
          var a, r, o;
          if ("" !== n)
            for (var i = de(n), l = 0, s = i.length; l < s; l++) {
              if (d = i[l].match(ce), a = i[l].match(p), d) {
                if (i[l] = i[l].replace(ce, ""), "" !== i[l] && (e = e[i[l]]), r = [], i.splice(0, l + 1), o = i.join("."), Array.isArray(e))
                  for (var u = 0, c = e.length; u < c; u++) r.push(f(e[u], t, o));
                var d = d[0].substring(1, d[0].length - 1);
                e = "" === d ? r : r.join(d);
                break
              }
              if (a) i[l] = i[l].replace(p, ""), e = e[i[l]]();
              else {
                if (null === e || null === e[i[l]]) return null;
                if (void 0 === e || void 0 === e[i[l]]) return;
                e = e[i[l]]
              }
            }
          return e
        }, function(e, t) {
          return f(e, t, r)
        })
      },
      stripHtml: function(e) {
        var t = typeof e;
        if ("function" != t) return "string" == t ? I(e) : e;
        I = e
      },
      escapeHtml: function(e) {
        var t = typeof e;
        if ("function" != t) return "string" == t || Array.isArray(e) ? u(e) : e;
        u = e
      },
      unique: x
    };
    var r = function(e, t, n) {
      void 0 !== e[t] && (e[n] = e[t])
    };

    function ne(e) {
      r(e, "ordering", "bSort"), r(e, "orderMulti", "bSortMulti"), r(e, "orderClasses", "bSortClasses"), r(e, "orderCellsTop", "bSortCellsTop"), r(e, "order", "aaSorting"), r(e, "orderFixed", "aaSortingFixed"), r(e, "paging", "bPaginate"), r(e, "pagingType", "sPaginationType"), r(e, "pageLength", "iDisplayLength"), r(e, "searching", "bFilter"), "boolean" == typeof e.sScrollX && (e.sScrollX = e.sScrollX ? "100%" : ""), "boolean" == typeof e.scrollX && (e.scrollX = e.scrollX ? "100%" : "");
      var t = e.aoSearchCols;
      if (t)
        for (var n = 0, a = t.length; n < a; n++) t[n] && z($.models.oSearch, t[n]);
      e.serverSide && !e.searchDelay && (e.searchDelay = 400)
    }

    function ae(e) {
      r(e, "orderable", "bSortable"), r(e, "orderData", "aDataSort"), r(e, "orderSequence", "asSorting"), r(e, "orderDataType", "sortDataType");
      var t = e.aDataSort;
      "number" != typeof t || Array.isArray(t) || (e.aDataSort = [t])
    }

    function re(e) {
      var t = $.defaults.column,
        n = e.aoColumns.length,
        t = B.extend({}, $.models.oColumn, t, {
          aDataSort: t.aDataSort || [n],
          mData: t.mData || n,
          idx: n,
          searchFixed: {},
          colEl: B("<col>")
        }),
        t = (e.aoColumns.push(t), e.aoPreSearchCols);
      t[n] = B.extend({}, $.models.oSearch, t[n])
    }

    function oe(e, t, n) {
      function a(e) {
        return "string" == typeof e && -1 !== e.indexOf("@")
      }
      var r = e.aoColumns[t],
        o = (null != n && (ae(n), z($.defaults.column, n, !0), void 0 === n.mDataProp || n.mData || (n.mData = n.mDataProp), n.sType && (r._sManualType = n.sType), n.className && !n.sClass && (n.sClass = n.className), t = r.sClass, B.extend(r, n), Q(r, n, "sWidth", "sWidthOrig"), t !== r.sClass && (r.sClass = t + " " + r.sClass), void 0 !== n.iDataSort && (r.aDataSort = [n.iDataSort]), Q(r, n, "aDataSort")), r.mData),
        i = J(o);
      r.mRender && Array.isArray(r.mRender) && (n = (t = r.mRender.slice()).shift(), r.mRender = $.render[n].apply(q, t)), r._render = r.mRender ? J(r.mRender) : null;
      r._bAttrSrc = B.isPlainObject(o) && (a(o.sort) || a(o.type) || a(o.filter)), r._setter = null, r.fnGetData = function(e, t, n) {
        var a = i(e, t, void 0, n);
        return r._render && t ? r._render(a, t, e, n) : a
      }, r.fnSetData = function(e, t, n) {
        return m(o)(e, t, n)
      }, "number" == typeof o || r._isArrayHost || (e._rowReadObject = !0), e.oFeatures.bSort || (r.bSortable = !1)
    }

    function E(e) {
      var t = e;
      if (t.oFeatures.bAutoWidth) {
        var n, a, r = t.nTable,
          o = t.aoColumns,
          i = t.oScroll,
          l = i.sY,
          s = i.sX,
          i = i.sXInner,
          u = W(t, "bVisible"),
          c = r.getAttribute("width"),
          d = r.parentNode,
          f = r.style.width,
          f = (f && -1 !== f.indexOf("%") && (c = f), ee(t, null, "column-calc", {
            visible: u
          }, !1), B(r.cloneNode()).css("visibility", "hidden").removeAttr("id")),
          h = (f.append("<tbody>"), B("<tr/>").appendTo(f.find("tbody")));
        for (f.append(B(t.nTHead).clone()).append(B(t.nTFoot).clone()), f.find("tfoot th, tfoot td").css("width", ""), f.find("thead th, thead td").each(function() {
            var e = ie(t, this, !0, !1);
            e ? (this.style.width = e, s && B(this).append(B("<div/>").css({
              width: e,
              margin: 0,
              padding: 0,
              border: 0,
              height: 1
            }))) : this.style.width = ""
          }), n = 0; n < u.length; n++) {
          p = u[n], a = o[p];
          var p = function(e, t) {
              var n = e.aoColumns[t];
              if (!n.maxLenString) {
                for (var a, r = "", o = -1, i = 0, l = e.aiDisplayMaster.length; i < l; i++) {
                  var s = e.aiDisplayMaster[i],
                    s = me(e, s)[t],
                    s = s && "object" == typeof s && s.nodeType ? s.innerHTML : s + "";
                  s = s.replace(/id=".*?"/g, "").replace(/name=".*?"/g, ""), (a = I(s).replace(/&nbsp;/g, " ")).length > o && (r = s, o = a.length)
                }
                n.maxLenString = r
              }
              return n.maxLenString
            }(t, p),
            g = C.type.className[a.sType],
            m = p + a.sContentPadding,
            p = -1 === p.indexOf("<") ? _.createTextNode(m) : m;
          B("<td/>").addClass(g).addClass(a.sClass).append(p).appendTo(h)
        }
        B("[name]", f).removeAttr("name");
        var v = B("<div/>").css(s || l ? {
            position: "absolute",
            top: 0,
            left: 0,
            height: 1,
            right: 0,
            overflow: "hidden"
          } : {}).append(f).appendTo(d),
          b = (s && i ? f.width(i) : s ? (f.css("width", "auto"), f.removeAttr("width"), f.width() < d.clientWidth && c && f.width(d.clientWidth)) : l ? f.width(d.clientWidth) : c && f.width(c), 0),
          y = f.find("tbody tr").eq(0).children();
        for (n = 0; n < u.length; n++) {
          var D = y[n].getBoundingClientRect().width;
          b += D, o[u[n]].sWidth = A(D)
        }
        r.style.width = A(b), v.remove(), c && (r.style.width = A(c)), !c && !s || t._reszEvt || (B(q).on("resize.DT-" + t.sInstance, $.util.throttle(function() {
          t.bDestroying || E(t)
        })), t._reszEvt = !0)
      }
      for (var x = e, S = x.aoColumns, T = 0; T < S.length; T++) {
        var w = ie(x, [T], !1, !1);
        S[T].colEl.css("width", w)
      }
      i = e.oScroll;
      "" === i.sY && "" === i.sX || We(e), ee(e, null, "column-sizing", [e])
    }

    function M(e, t) {
      e = W(e, "bVisible");
      return "number" == typeof e[t] ? e[t] : null
    }

    function T(e, t) {
      e = W(e, "bVisible").indexOf(t);
      return -1 !== e ? e : null
    }

    function H(e) {
      var t = e.aoHeader,
        n = e.aoColumns,
        a = 0;
      if (t.length)
        for (var r = 0, o = t[0].length; r < o; r++) n[r].bVisible && "none" !== B(t[0][r].cell).css("display") && a++;
      return a
    }

    function W(e, n) {
      var a = [];
      return e.aoColumns.map(function(e, t) {
        e[n] && a.push(t)
      }), a
    }

    function X(e) {
      for (var t, n, a, r, o, i, l, s = e.aoColumns, u = e.aoData, c = $.ext.type.detect, d = 0, f = s.length; d < f; d++) {
        if (l = [], !(o = s[d]).sType && o._sManualType) o.sType = o._sManualType;
        else if (!o.sType) {
          for (t = 0, n = c.length; t < n; t++) {
            for (a = 0, r = u.length; a < r; a++)
              if (u[a]) {
                if (void 0 === l[a] && (l[a] = G(e, a, d, "type")), !(i = c[t](l[a], e)) && t !== c.length - 2) break;
                if ("html" === i && !y(l[a])) break
              } if (i) {
              o.sType = i;
              break
            }
          }
          o.sType || (o.sType = "string")
        }
        var h = C.type.className[o.sType],
          h = (h && (V(e.aoHeader, d, h), V(e.aoFooter, d, h)), C.type.render[o.sType]);
        if (h && !o._render) {
          o._render = $.util.get(h), p = b = v = m = g = void 0;
          for (var p, g = e, m = d, v = g.aoData, b = 0; b < v.length; b++) v[b].nTr && (p = G(g, b, m, "display"), v[b].displayData[m] = p, ue(v[b].anCells[m], p))
        }
      }
    }

    function V(e, t, n) {
      e.forEach(function(e) {
        e[t] && e[t].unique && D(e[t].cell, n)
      })
    }

    function ie(e, t, n, a) {
      Array.isArray(t) || (t = le(t));
      for (var r, o = 0, i = e.aoColumns, l = 0, s = t.length; l < s; l++) {
        var u = i[t[l]],
          c = n ? u.sWidthOrig : u.sWidth;
        if (a || !1 !== u.bVisible) {
          if (null == c) return null;
          "number" == typeof c ? (r = "px", o += c) : (u = c.match(/([\d\.]+)([^\d]*)/)) && (o += +u[1], r = 3 === u.length ? u[2] : "px")
        }
      }
      return o + r
    }

    function le(e) {
      e = B(e).closest("[data-dt-column]").attr("data-dt-column");
      return e ? e.split(",").map(function(e) {
        return +e
      }) : []
    }

    function Y(e, t, n, a) {
      for (var r = e.aoData.length, o = B.extend(!0, {}, $.models.oRow, {
          src: n ? "dom" : "data",
          idx: r
        }), i = (o._aData = t, e.aoData.push(o), e.aoColumns), l = 0, s = i.length; l < s; l++) i[l].sType = null;
      e.aiDisplayMaster.push(r);
      t = e.rowIdFn(t);
      return void 0 !== t && (e.aIds[t] = o), !n && e.oFeatures.bDeferRender || ve(e, r, n, a), r
    }

    function se(n, e) {
      var a;
      return (e = e instanceof B ? e : B(e)).map(function(e, t) {
        return a = ge(n, t), Y(n, a.data, t, a.cells)
      })
    }

    function G(e, t, n, a) {
      "search" === a ? a = "filter" : "order" === a && (a = "sort");
      var r = e.iDraw,
        o = e.aoColumns[n],
        i = e.aoData[t]._aData,
        l = o.sDefaultContent,
        s = o.fnGetData(i, a, {
          settings: e,
          row: t,
          col: n
        });
      if (void 0 === (s = "display" !== a && s && "object" == typeof s && s.nodeName ? s.innerHTML : s)) return e.iDrawError != r && null === l && (Z(e, 0, "Requested unknown parameter " + ("function" == typeof o.mData ? "{function}" : "'" + o.mData + "'") + " for row " + t + ", column " + n, 4), e.iDrawError = r), l;
      if (s !== i && null !== s || null === l || void 0 === a) {
        if ("function" == typeof s) return s.call(i)
      } else s = l;
      return null === s && "display" === a ? "" : "filter" === a && (t = $.ext.type.search)[o.sType] ? t[o.sType](s) : s
    }

    function ue(e, t) {
      t && "object" == typeof t && t.nodeName ? B(e).empty().append(t) : e.innerHTML = t
    }
    var ce = /\[.*?\]$/,
      p = /\(\)$/;

    function de(e) {
      return (e.match(/(\\.|[^.])+/g) || [""]).map(function(e) {
        return e.replace(/\\\./g, ".")
      })
    }
    var J = $.util.get,
      m = $.util.set;

    function fe(e) {
      return f(e.aoData, "_aData")
    }

    function he(e) {
      e.aoData.length = 0, e.aiDisplayMaster.length = 0, e.aiDisplay.length = 0, e.aIds = {}
    }

    function pe(e, t, n, a) {
      var r, o, i = e.aoData[t];
      if (i._aSortData = null, i._aFilterData = null, i.displayData = null, "dom" !== n && (n && "auto" !== n || "dom" !== i.src)) {
        var l = i.anCells,
          s = me(e, t);
        if (l)
          if (void 0 !== a) ue(l[a], s[a]);
          else
            for (r = 0, o = l.length; r < o; r++) ue(l[r], s[r])
      } else i._aData = ge(e, i, a, void 0 === a ? void 0 : i._aData).data;
      var u = e.aoColumns;
      if (void 0 !== a) u[a].sType = null, u[a].maxLenString = null;
      else {
        for (r = 0, o = u.length; r < o; r++) u[r].sType = null, u[r].maxLenString = null;
        be(e, i)
      }
    }

    function ge(e, t, n, a) {
      function r(e, t) {
        var n;
        "string" == typeof e && -1 !== (n = e.indexOf("@")) && (n = e.substring(n + 1), m(e)(a, t.getAttribute(n)))
      }

      function o(e) {
        void 0 !== n && n !== d || (l = f[d], s = e.innerHTML.trim(), l && l._bAttrSrc ? (m(l.mData._)(a, s), r(l.mData.sort, e), r(l.mData.type, e), r(l.mData.filter, e)) : h ? (l._setter || (l._setter = m(l.mData)), l._setter(a, s)) : a[d] = s), d++
      }
      var i, l, s, u = [],
        c = t.firstChild,
        d = 0,
        f = e.aoColumns,
        h = e._rowReadObject;
      a = void 0 !== a ? a : h ? {} : [];
      if (c)
        for (; c;) "TD" != (i = c.nodeName.toUpperCase()) && "TH" != i || (o(c), u.push(c)), c = c.nextSibling;
      else
        for (var p = 0, g = (u = t.anCells).length; p < g; p++) o(u[p]);
      var t = t.firstChild ? t : t.nTr;
      return t && (t = t.getAttribute("id")) && m(e.rowId)(a, t), {
        data: a,
        cells: u
      }
    }

    function me(e, t) {
      var n = e.aoData[t],
        a = e.aoColumns;
      if (!n.displayData) {
        n.displayData = [];
        for (var r = 0, o = a.length; r < o; r++) n.displayData.push(G(e, t, r, "display"))
      }
      return n.displayData
    }

    function ve(e, t, n, a) {
      var r, o, i, l, s, u, c = e.aoData[t],
        d = c._aData,
        f = [],
        h = e.oClasses.tbody.row;
      if (null === c.nTr) {
        for (r = n || _.createElement("tr"), c.nTr = r, c.anCells = f, D(r, h), r._DT_RowIndex = t, be(e, c), l = 0, s = e.aoColumns.length; l < s; l++) {
          i = e.aoColumns[l], (o = (u = !n || !a[l]) ? _.createElement(i.sCellType) : a[l]) || Z(e, 0, "Incorrect column count", 18), o._DT_CellIndex = {
            row: t,
            column: l
          }, f.push(o);
          var p = me(e, t);
          !u && (!i.mRender && i.mData === l || B.isPlainObject(i.mData) && i.mData._ === l + ".display") || ue(o, p[l]), i.bVisible && u ? r.appendChild(o) : i.bVisible || u || o.parentNode.removeChild(o), i.fnCreatedCell && i.fnCreatedCell.call(e.oInstance, o, G(e, t, l), d, t, l)
        }
        ee(e, "aoRowCreatedCallback", "row-created", [r, d, t, f])
      } else D(c.nTr, h)
    }

    function be(e, t) {
      var n = t.nTr,
        a = t._aData;
      n && ((e = e.rowIdFn(a)) && (n.id = e), a.DT_RowClass && (e = a.DT_RowClass.split(" "), t.__rowc = t.__rowc ? x(t.__rowc.concat(e)) : e, B(n).removeClass(t.__rowc.join(" ")).addClass(a.DT_RowClass)), a.DT_RowAttr && B(n).attr(a.DT_RowAttr), a.DT_RowData) && B(n).data(a.DT_RowData)
    }

    function ye(e, t) {
      var n, a = e.oClasses,
        r = e.aoColumns,
        o = "header" === t ? e.nTHead : e.nTFoot,
        i = "header" === t ? "sTitle" : t;
      if (o) {
        if (("header" === t || f(e.aoColumns, i).join("")) && 1 === (n = (n = B("tr", o)).length ? n : B("<tr/>").appendTo(o)).length)
          for (var l = B("td, th", n).length, s = r.length; l < s; l++) B("<th/>").html(r[l][i] || "").appendTo(n);
        var u = Ce(e, o, !0);
        "header" === t ? e.aoHeader = u : e.aoFooter = u, B(o).children("tr").attr("role", "row"), B(o).children("tr").children("th, td").each(function() {
          Qe(e, t)(e, B(this), a)
        })
      }
    }

    function De(e, t, n) {
      var a, r, o, i, l, s = [],
        u = [],
        c = e.aoColumns,
        e = c.length;
      if (t) {
        for (n = n || h(e).filter(function(e) {
            return c[e].bVisible
          }), a = 0; a < t.length; a++) s[a] = t[a].slice().filter(function(e, t) {
          return n.includes(t)
        }), u.push([]);
        for (a = 0; a < s.length; a++)
          for (r = 0; r < s[a].length; r++)
            if (l = i = 1, void 0 === u[a][r]) {
              for (o = s[a][r].cell; void 0 !== s[a + i] && s[a][r].cell == s[a + i][r].cell;) u[a + i][r] = null, i++;
              for (; void 0 !== s[a][r + l] && s[a][r].cell == s[a][r + l].cell;) {
                for (var d = 0; d < i; d++) u[a + d][r + l] = null;
                l++
              }
              var f = B("span.dt-column-title", o);
              u[a][r] = {
                cell: o,
                colspan: l,
                rowspan: i,
                title: (f.length ? f : B(o)).html()
              }
            } return u
      }
    }

    function xe(e, t) {
      for (var n, a, r = De(e, t), o = 0; o < t.length; o++) {
        if (n = t[o].row)
          for (; a = n.firstChild;) n.removeChild(a);
        for (var i = 0; i < r[o].length; i++) {
          var l = r[o][i];
          l && B(l.cell).appendTo(n).attr("rowspan", l.rowspan).attr("colspan", l.colspan)
        }
      }
    }

    function S(e, t) {
      if (r = "ssp" == te(s = e), void 0 !== (i = s.iInitDisplayStart) && -1 !== i && (s._iDisplayStart = !r && i >= s.fnRecordsDisplay() ? 0 : i, s.iInitDisplayStart = -1), -1 !== ee(e, "aoPreDrawCallback", "preDraw", [e]).indexOf(!1)) w(e, !1);
      else {
        var l, n = [],
          a = 0,
          r = "ssp" == te(e),
          o = e.aiDisplay,
          i = e._iDisplayStart,
          s = e.fnDisplayEnd(),
          u = e.aoColumns,
          c = B(e.nTBody);
        if (e.bDrawing = !0, r) {
          if (!e.bDestroying && !t) return 0 === e.iDraw && c.empty().append(Se(e)), (l = e).iDraw++, w(l, !0), void Ie(l, function(t) {
            function n(e, t) {
              return "function" == typeof a[e][t] ? "function" : a[e][t]
            }
            var a = t.aoColumns,
              e = t.oFeatures,
              r = t.oPreviousSearch,
              o = t.aoPreSearchCols;
            return {
              draw: t.iDraw,
              columns: a.map(function(t, e) {
                return {
                  data: n(e, "mData"),
                  name: t.sName,
                  searchable: t.bSearchable,
                  orderable: t.bSortable,
                  search: {
                    value: o[e].search,
                    regex: o[e].regex,
                    fixed: Object.keys(t.searchFixed).map(function(e) {
                      return {
                        name: e,
                        term: t.searchFixed[e].toString()
                      }
                    })
                  }
                }
              }),
              order: qe(t).map(function(e) {
                return {
                  column: e.col,
                  dir: e.dir,
                  name: n(e.col, "sName")
                }
              }),
              start: t._iDisplayStart,
              length: e.bPaginate ? t._iDisplayLength : -1,
              search: {
                value: r.search,
                regex: r.regex,
                fixed: Object.keys(t.searchFixed).map(function(e) {
                  return {
                    name: e,
                    term: t.searchFixed[e].toString()
                  }
                })
              }
            }
          }(l), function(e) {
            var t = l,
              n = Ae(t, e = e),
              a = Fe(t, "draw", e),
              r = Fe(t, "recordsTotal", e),
              e = Fe(t, "recordsFiltered", e);
            if (void 0 !== a) {
              if (+a < t.iDraw) return;
              t.iDraw = +a
            }
            n = n || [], he(t), t._iRecordsTotal = parseInt(r, 10), t._iRecordsDisplay = parseInt(e, 10);
            for (var o = 0, i = n.length; o < i; o++) Y(t, n[o]);
            t.aiDisplay = t.aiDisplayMaster.slice(), S(t, !0), ke(t), w(t, !1)
          })
        } else e.iDraw++;
        if (0 !== o.length)
          for (var d = r ? e.aoData.length : s, f = r ? 0 : i; f < d; f++) {
            for (var h = o[f], p = e.aoData[h], g = (null === p.nTr && ve(e, h), p.nTr), m = 0; m < u.length; m++) {
              var v = u[m],
                b = p.anCells[m];
              D(b, C.type.className[v.sType]), D(b, v.sClass), D(b, e.oClasses.tbody.cell)
            }
            ee(e, "aoRowCallback", null, [g, p._aData, a, f, h]), n.push(g), a++
          } else n[0] = Se(e);
        ee(e, "aoHeaderCallback", "header", [B(e.nTHead).children("tr")[0], fe(e), i, s, o]), ee(e, "aoFooterCallback", "footer", [B(e.nTFoot).children("tr")[0], fe(e), i, s, o]), c.children().detach(), c.append(B(n)), B(e.nTableWrapper).toggleClass("dt-empty-footer", 0 === B("tr", e.nTFoot).length), ee(e, "aoDrawCallback", "draw", [e], !0), e.bSorted = !1, e.bFiltered = !1, e.bDrawing = !1
      }
    }

    function s(e, t, n) {
      var a = e.oFeatures,
        r = a.bSort,
        a = a.bFilter;
      void 0 !== n && !0 !== n || (r && Ue(e), a ? Le(e, e.oPreviousSearch) : e.aiDisplay = e.aiDisplayMaster.slice()), !0 !== t && (e._iDisplayStart = 0), e._drawHold = t, S(e), e._drawHold = !1
    }

    function Se(e) {
      var t = e.oLanguage,
        n = t.sZeroRecords,
        a = te(e);
      return e.iDraw < 1 && "ssp" === a || e.iDraw <= 1 && "ajax" === a ? n = t.sLoadingRecords : t.sEmptyTable && 0 === e.fnRecordsTotal() && (n = t.sEmptyTable), B("<tr/>").append(B("<td />", {
        colSpan: H(e),
        class: e.oClasses.empty.row
      }).html(n))[0]
    }

    function Te(e, t, n) {
      for (var i = {}, a = (B.each(t, function(e, t) {
          if (null !== t) {
            var e = e.replace(/([A-Z])/g, " $1").split(" "),
              n = (i[e[0]] || (i[e[0]] = {}), 1 === e.length ? "full" : e[1].toLowerCase()),
              a = i[e[0]],
              r = function(t, n) {
                B.isPlainObject(n) ? Object.keys(n).map(function(e) {
                  t.push({
                    feature: e,
                    opts: n[e]
                  })
                }) : t.push(n)
              };
            if (a[n] && a[n].contents || (a[n] = {
                contents: []
              }), Array.isArray(t))
              for (var o = 0; o < t.length; o++) r(a[n].contents, t[o]);
            else r(a[n].contents, t);
            Array.isArray(a[n].contents) || (a[n].contents = [a[n].contents])
          }
        }), Object.keys(i).map(function(e) {
          return 0 !== e.indexOf(n) ? null : {
            name: e,
            val: i[e]
          }
        }).filter(function(e) {
          return null !== e
        })), r = (a.sort(function(e, t) {
          e = +e.name.replace(/[^0-9]/g, "");
          return +t.name.replace(/[^0-9]/g, "") - e
        }), "bottom" === n && a.reverse(), []), o = 0, l = a.length; o < l; o++) a[o].val.full && (r.push({
        full: a[o].val.full
      }), we(e, r[r.length - 1]), delete a[o].val.full), Object.keys(a[o].val).length && (r.push(a[o].val), we(e, r[r.length - 1]));
      return r
    }

    function we(o, i) {
      function l(e, t) {
        return C.features[e] || Z(o, 0, "Unknown feature: " + e), C.features[e].apply(this, [o, t])
      }
      B.each(i, function(e) {
        for (var t, n = i[e].contents, a = 0, r = n.length; a < r; a++) n[a] && ("string" == typeof n[a] ? n[a] = l(n[a], null) : B.isPlainObject(n[a]) ? n[a] = l(n[a].feature, n[a].opts) : "function" == typeof n[a].node ? n[a] = n[a].node(o) : "function" == typeof n[a] && (t = n[a](o), n[a] = "function" == typeof t.node ? t.node() : t))
      })
    }

    function _e(t) {
      var a, e = t.oClasses,
        n = B(t.nTable),
        r = B("<div/>").attr({
          id: t.sTableId + "_wrapper",
          class: e.container
        }).insertBefore(n),
        e = (t.nTableWrapper = r[0], Te(t, t.layout, "top")),
        n = Te(t, t.layout, "bottom"),
        o = Qe(t, "layout");
      if (t.sDom)
        for (var i, l, s, u, c, d, f = t, h = t.sDom, p = r, g = h.match(/(".*?")|('.*?')|./g), m = 0; m < g.length; m++) i = null, "<" == (l = g[m]) ? (s = B("<div/>"), "'" != (u = g[m + 1])[0] && '"' != u[0] || (u = u.replace(/['"]/g, ""), c = "", -1 != u.indexOf(".") ? (d = u.split("."), c = d[0], d = d[1]) : "#" == u[0] ? c = u : d = u, s.attr("id", c.substring(1)).addClass(d), m++), p.append(s), p = s) : ">" == l ? p = p.parent() : "t" == l ? i = He(f) : $.ext.feature.forEach(function(e) {
          l == e.cFeature && (i = e.fnInit(f))
        }), i && p.append(i);
      else e.forEach(function(e) {
        o(t, r, e)
      }), o(t, r, {
        full: {
          table: !0,
          contents: [He(t)]
        }
      }), n.forEach(function(e) {
        o(t, r, e)
      });
      h = t, e = h.nTable;
      h.oFeatures.bProcessing && (a = B("<div/>", {
        id: h.sTableId + "_processing",
        class: h.oClasses.processing.container,
        role: "status"
      }).html(h.oLanguage.sProcessing).append("<div><div></div><div></div><div></div><div></div></div>").insertBefore(e), B(e).on("processing.dt.DT", function(e, t, n) {
        a.css("display", n ? "block" : "none")
      }))
    }

    function Ce(e, t, n) {
      for (var a, r, o, i, l, s, u = e.aoColumns, c = B(t).children("tr"), d = t && "thead" === t.nodeName.toLowerCase(), f = [], h = 0, p = c.length; h < p; h++) f.push([]);
      for (h = 0, p = c.length; h < p; h++)
        for (r = (a = c[h]).firstChild; r;) {
          if ("TD" == r.nodeName.toUpperCase() || "TH" == r.nodeName.toUpperCase()) {
            var g, m, v, b, y, D = [];
            for (b = (b = +r.getAttribute("colspan")) && 0 != b && 1 != b ? b : 1, y = (y = +r.getAttribute("rowspan")) && 0 != y && 1 != y ? y : 1, l = function(e, t, n) {
                for (var a = e[t]; a[n];) n++;
                return n
              }(f, h, 0), s = 1 == b, n && (s && (oe(e, l, B(r).data()), g = u[l], m = r.getAttribute("width") || null, (v = r.style.width.match(/width:\s*(\d+[pxem%]+)/)) && (m = v[1]), g.sWidthOrig = g.sWidth || m, d ? (null === g.sTitle || g.autoTitle || (r.innerHTML = g.sTitle), !g.sTitle && s && (g.sTitle = r.innerHTML.replace(/<.*?>/g, ""), g.autoTitle = !0)) : g.footer && (r.innerHTML = g.footer), g.ariaTitle || (g.ariaTitle = B(r).attr("aria-label") || g.sTitle), g.className) && B(r).addClass(g.className), 0 === B("span.dt-column-title", r).length && B("<span>").addClass("dt-column-title").append(r.childNodes).appendTo(r), d) && 0 === B("span.dt-column-order", r).length && B("<span>").addClass("dt-column-order").appendTo(r), i = 0; i < b; i++) {
              for (o = 0; o < y; o++) f[h + o][l + i] = {
                cell: r,
                unique: s
              }, f[h + o].row = a;
              D.push(l + i)
            }
            r.setAttribute("data-dt-column", x(D).join(","))
          }
          r = r.nextSibling
        }
      return f
    }

    function Ie(n, e, a) {
      function t(e) {
        var t = n.jqXHR ? n.jqXHR.status : null;
        (null === e || "number" == typeof t && 204 == t) && Ae(n, e = {}, []), (t = e.error || e.sError) && Z(n, 0, t), n.json = e, ee(n, null, "xhr", [n, e, n.jqXHR], !0), a(e)
      }
      var r, o = n.ajax,
        i = n.oInstance,
        l = (B.isPlainObject(o) && o.data && (l = "function" == typeof(r = o.data) ? r(e, n) : r, e = "function" == typeof r && l ? l : B.extend(!0, e, l), delete o.data), {
          url: "string" == typeof o ? o : "",
          data: e,
          success: t,
          dataType: "json",
          cache: !1,
          type: n.sServerMethod,
          error: function(e, t) {
            -1 === ee(n, null, "xhr", [n, null, n.jqXHR], !0).indexOf(!0) && ("parsererror" == t ? Z(n, 0, "Invalid JSON response", 1) : 4 === e.readyState && Z(n, 0, "Ajax error", 7)), w(n, !1)
          }
        });
      B.isPlainObject(o) && B.extend(l, o), n.oAjaxData = e, ee(n, null, "preXhr", [n, e, l], !0), "function" == typeof o ? n.jqXHR = o.call(i, e, t, n) : "" === o.url ? (i = {}, $.util.set(o.dataSrc)(i, []), t(i)) : (n.jqXHR = B.ajax(l), r && (o.data = r))
    }

    function Ae(e, t, n) {
      var a = "data";
      if (B.isPlainObject(e.ajax) && void 0 !== e.ajax.dataSrc && ("string" == typeof(e = e.ajax.dataSrc) || "function" == typeof e ? a = e : void 0 !== e.data && (a = e.data)), !n) return "data" === a ? t.aaData || t[a] : "" !== a ? J(a)(t) : t;
      m(a)(t, n)
    }

    function Fe(e, t, n) {
      var e = B.isPlainObject(e.ajax) ? e.ajax.dataSrc : null;
      return e && e[t] ? J(e[t])(n) : (e = "", "draw" === t ? e = "sEcho" : "recordsTotal" === t ? e = "iTotalRecords" : "recordsFiltered" === t && (e = "iTotalDisplayRecords"), void 0 !== n[e] ? n[e] : n[t])
    }

    function Le(n, e) {
      var t = n.aoPreSearchCols;
      if (X(n), "ssp" != te(n)) {
        for (var a, r, o, i, l, s = n, u = s.aoColumns, c = s.aoData, d = 0; d < c.length; d++)
          if (c[d] && !(l = c[d])._aFilterData) {
            for (o = [], a = 0, r = u.length; a < r; a++) u[a].bSearchable ? "string" != typeof(i = null === (i = G(s, d, a, "filter")) ? "" : i) && i.toString && (i = i.toString()) : i = "", i.indexOf && -1 !== i.indexOf("&") && (Pe.innerHTML = i, i = Re ? Pe.textContent : Pe.innerText), i.replace && (i = i.replace(/[\r\n\u2028]/g, "")), o.push(i);
            l._aFilterData = o, l._sFilterRow = o.join("  "), 0
          } n.aiDisplay = n.aiDisplayMaster.slice(), Ne(n.aiDisplay, n, e.search, e), B.each(n.searchFixed, function(e, t) {
          Ne(n.aiDisplay, n, t, {})
        });
        for (var f = 0; f < t.length; f++) {
          var h = t[f];
          Ne(n.aiDisplay, n, h.search, h, f), B.each(n.aoColumns[f].searchFixed, function(e, t) {
            Ne(n.aiDisplay, n, t, {}, f)
          })
        }
        for (var p, g, m = n, v = $.ext.search, b = m.aiDisplay, y = 0, D = v.length; y < D; y++) {
          for (var x = [], S = 0, T = b.length; S < T; S++) g = b[S], p = m.aoData[g], v[y](m, p._aFilterData, g, p._aData, S) && x.push(g);
          b.length = 0, b.push.apply(b, x)
        }
      }
      n.bFiltered = !0, ee(n, null, "search", [n])
    }

    function Ne(e, t, n, a, r) {
      if ("" !== n)
        for (var o = 0, i = "function" == typeof n ? n : null, l = n instanceof RegExp ? n : i ? null : function(e, t) {
            var a = [],
              t = B.extend({}, {
                boundary: !1,
                caseInsensitive: !0,
                exact: !1,
                regex: !1,
                smart: !0
              }, t);
            "string" != typeof e && (e = e.toString());
            if (e = R(e), t.exact) return new RegExp("^" + je(e) + "$", t.caseInsensitive ? "i" : "");
            {
              var n, r, o;
              e = t.regex ? e : je(e), t.smart && (n = (e.match(/!?["\u201C][^"\u201D]+["\u201D]|[^ ]+/g) || [""]).map(function(e) {
                var t, n = !1;
                return "!" === e.charAt(0) && (n = !0, e = e.substring(1)), '"' === e.charAt(0) ? e = (t = e.match(/^"(.*)"$/)) ? t[1] : e : "“" === e.charAt(0) && (e = (t = e.match(/^\u201C(.*)\u201D$/)) ? t[1] : e), n && (1 < e.length && a.push("(?!" + e + ")"), e = ""), e.replace('"', "")
              }), r = a.length ? a.join("") : "", o = t.boundary ? "\\b" : "", e = "^(?=.*?" + o + n.join(")(?=.*?" + o) + ")(" + r + ".)*$")
            }
            return new RegExp(e, t.caseInsensitive ? "i" : "")
          }(n, a); o < e.length;) {
          var s = t.aoData[e[o]],
            u = void 0 === r ? s._sFilterRow : s._aFilterData[r];
          (i && !i(u, s._aData, e[o], r) || l && !l.test(u)) && (e.splice(o, 1), o--), o++
        }
    }
    var je = $.util.escapeRegex,
      Pe = B("<div>")[0],
      Re = void 0 !== Pe.textContent;

    function Oe(n) {
      var a, e, t, r, o, i, l = n.iInitDisplayStart;
      n.bInitialised ? (ye(n, "header"), ye(n, "footer"), xe(n, n.aoHeader), xe(n, n.aoFooter), _e(n), t = (e = n).nTHead, i = t.querySelectorAll("tr"), r = e.bSortCellsTop, o = ':not([data-dt-order="disable"]):not([data-dt-order="icon-only"])', !0 === r ? t = i[0] : !1 === r && (t = i[i.length - 1]), Ve(e, t, t === e.nTHead ? "tr" + o + " th" + o + ", tr" + o + " td" + o : "th" + o + ", td" + o), Be(e, r = [], e.aaSorting), e.aaSorting = r, Xe(n), w(n, !0), ee(n, null, "preInit", [n], !0), s(n), "ssp" != (i = te(n)) && ("ajax" == i ? Ie(n, {}, function(e) {
        var t = Ae(n, e);
        for (a = 0; a < t.length; a++) Y(n, t[a]);
        n.iInitDisplayStart = l, s(n), w(n, !1), ke(n)
      }) : (ke(n), w(n, !1)))) : setTimeout(function() {
        Oe(n)
      }, 200)
    }

    function ke(e) {
      var t;
      e._bInitComplete || (t = [e, e.json], e._bInitComplete = !0, E(e), ee(e, null, "plugin-init", t, !0), ee(e, "aoInitComplete", "init", t, !0))
    }

    function Ee(e, t) {
      t = parseInt(t, 10);
      e._iDisplayLength = t, Ze(e), ee(e, null, "length", [e, t])
    }

    function Me(e, t, n) {
      var a = e._iDisplayStart,
        r = e._iDisplayLength,
        o = e.fnRecordsDisplay();
      if (0 === o || -1 === r) a = 0;
      else if ("number" == typeof t) o < (a = t * r) && (a = 0);
      else if ("first" == t) a = 0;
      else if ("previous" == t)(a = 0 <= r ? a - r : 0) < 0 && (a = 0);
      else if ("next" == t) a + r < o && (a += r);
      else if ("last" == t) a = Math.floor((o - 1) / r) * r;
      else {
        if ("ellipsis" === t) return;
        Z(e, 0, "Unknown paging action: " + t, 5)
      }
      o = e._iDisplayStart !== a;
      e._iDisplayStart = a, ee(e, null, o ? "page" : "page-nc", [e]), o && n && S(e)
    }

    function w(e, t) {
      ee(e, null, "processing", [e, t])
    }

    function He(e) {
      var t, n, a, r, o, i, l, s, u, c, d, f, h, p = B(e.nTable),
        g = e.oScroll;
      return "" === g.sX && "" === g.sY ? e.nTable : (t = g.sX, n = g.sY, a = e.oClasses.scrolling, o = (r = e.captionNode) ? r._captionSide : null, u = B(p[0].cloneNode(!1)), i = B(p[0].cloneNode(!1)), c = function(e) {
        return e ? A(e) : null
      }, (l = p.children("tfoot")).length || (l = null), u = B(s = "<div/>", {
        class: a.container
      }).append(B(s, {
        class: a.header.self
      }).css({
        overflow: "hidden",
        position: "relative",
        border: 0,
        width: t ? c(t) : "100%"
      }).append(B(s, {
        class: a.header.inner
      }).css({
        "box-sizing": "content-box",
        width: g.sXInner || "100%"
      }).append(u.removeAttr("id").css("margin-left", 0).append("top" === o ? r : null).append(p.children("thead"))))).append(B(s, {
        class: a.body
      }).css({
        position: "relative",
        overflow: "auto",
        width: c(t)
      }).append(p)), l && u.append(B(s, {
        class: a.footer.self
      }).css({
        overflow: "hidden",
        border: 0,
        width: t ? c(t) : "100%"
      }).append(B(s, {
        class: a.footer.inner
      }).append(i.removeAttr("id").css("margin-left", 0).append("bottom" === o ? r : null).append(p.children("tfoot"))))), c = u.children(), d = c[0], f = c[1], h = l ? c[2] : null, B(f).on("scroll.DT", function() {
        var e = this.scrollLeft;
        d.scrollLeft = e, l && (h.scrollLeft = e)
      }), B("th, td", d).on("focus", function() {
        var e = d.scrollLeft;
        f.scrollLeft = e, l && (f.scrollLeft = e)
      }), B(f).css("max-height", n), g.bCollapse || B(f).css("height", n), e.nScrollHead = d, e.nScrollBody = f, e.nScrollFoot = h, e.aoDrawCallback.push(We), u[0])
    }

    function We(e) {
      var t, n, a = e.oScroll.iBarWidth,
        r = B(e.nScrollHead).children("div"),
        o = r.children("table"),
        i = e.nScrollBody,
        l = B(i),
        s = B(e.nScrollFoot).children("div"),
        u = s.children("table"),
        c = B(e.nTHead),
        d = B(e.nTable),
        f = e.nTFoot && B("th, td", e.nTFoot).length ? B(e.nTFoot) : null,
        h = e.oBrowser,
        p = i.scrollHeight > i.clientHeight;
      e.scrollBarVis !== p && void 0 !== e.scrollBarVis ? (e.scrollBarVis = p, E(e)) : (e.scrollBarVis = p, d.children("thead, tfoot").remove(), (p = c.clone().prependTo(d)).find("th, td").removeAttr("tabindex"), p.find("[id]").removeAttr("id"), f && (n = f.clone().prependTo(d)).find("[id]").removeAttr("id"), e.aiDisplay.length && (t = d.find("tbody tr").eq(0).find("th, td").map(function() {
        return B(this).outerWidth()
      }), B("col", e.colgroup).each(function(e) {
        this.style.width.replace("px", "") !== t[e] && (this.style.width = t[e] + "px")
      })), o.find("colgroup").remove(), o.append(e.colgroup.clone()), f && (u.find("colgroup").remove(), u.append(e.colgroup.clone())), B("th, td", p).each(function() {
        B(this.childNodes).wrapAll('<div class="dt-scroll-sizing">')
      }), f && B("th, td", n).each(function() {
        B(this.childNodes).wrapAll('<div class="dt-scroll-sizing">')
      }), c = Math.floor(d.height()) > i.clientHeight || "scroll" == l.css("overflow-y"), p = "padding" + (h.bScrollbarLeft ? "Left" : "Right"), n = d.outerWidth(), o.css("width", A(n)), r.css("width", A(n)).css(p, c ? a + "px" : "0px"), f && (u.css("width", A(n)), s.css("width", A(n)).css(p, c ? a + "px" : "0px")), d.children("colgroup").prependTo(d), l.trigger("scroll"), !e.bSorted && !e.bFiltered || e._drawHold || (i.scrollTop = 0))
    }

    function A(e) {
      return null === e ? "0px" : "number" == typeof e ? e < 0 ? "0px" : e + "px" : e.match(/\d$/) ? e + "px" : e
    }

    function Xe(e) {
      var t = e.aoColumns;
      for (e.colgroup.empty(), a = 0; a < t.length; a++) t[a].bVisible && e.colgroup.append(t[a].colEl)
    }

    function Ve(i, e, t, o, l) {
      Je(e, t, function(e) {
        var t = !1,
          n = void 0 === o ? le(e.target) : [o];
        if (n.length) {
          for (var a = 0, r = n.length; a < r; a++)
            if (!1 !== function(e, t, n, a) {
                function r(e, t) {
                  var n = e._idx;
                  return (n = void 0 === n ? s.indexOf(e[1]) : n) + 1 < s.length ? n + 1 : t ? null : 0
                }
                var o, i = e.aoColumns[t],
                  l = e.aaSorting,
                  s = i.asSorting;
                if (!i.bSortable) return !1;
                "number" == typeof l[0] && (l = e.aaSorting = [l]);
                (a || n) && e.oFeatures.bSortMulti ? -1 !== (i = f(l, "0").indexOf(t)) ? null === (o = null === (o = r(l[i], !0)) && 1 === l.length ? 0 : o) ? l.splice(i, 1) : (l[i][1] = s[o], l[i]._idx = o) : (a ? l.push([t, s[0], 0]) : l.push([t, l[0][1], 0]), l[l.length - 1]._idx = 0) : l.length && l[0][0] == t ? (o = r(l[0]), l.length = 1, l[0][1] = s[o], l[0]._idx = o) : (l.length = 0, l.push([t, s[0]]), l[0]._idx = 0)
              }(i, n[a], a, e.shiftKey) && (t = !0), 1 === i.aaSorting.length && "" === i.aaSorting[0][1]) break;
          t && (w(i, !0), setTimeout(function() {
            Ue(i);
            var e, t = i,
              n = t.aiDisplay,
              a = t.aiDisplayMaster,
              r = {},
              o = {};
            for (e = 0; e < a.length; e++) r[a[e]] = e;
            for (e = 0; e < n.length; e++) o[n[e]] = r[n[e]];
            n.sort(function(e, t) {
              return o[e] - o[t]
            }), s(i, !1, !1), w(i, !1), l && l()
          }, 0))
        }
      })
    }

    function Be(n, a, e) {
      function t(e) {
        var t;
        B.isPlainObject(e) ? void 0 !== e.idx ? a.push([e.idx, e.dir]) : e.name && -1 !== (t = f(n.aoColumns, "sName").indexOf(e.name)) && a.push([t, e.dir]) : a.push(e)
      }
      if (B.isPlainObject(e)) t(e);
      else if (e.length && "number" == typeof e[0]) t(e);
      else if (e.length)
        for (var r = 0; r < e.length; r++) t(e[r])
    }

    function qe(e) {
      var t, n, a, r, o, i, l, s = [],
        u = $.ext.type.order,
        c = e.aoColumns,
        d = e.aaSortingFixed,
        f = B.isPlainObject(d),
        h = [];
      if (e.oFeatures.bSort)
        for (Array.isArray(d) && Be(e, h, d), f && d.pre && Be(e, h, d.pre), Be(e, h, e.aaSorting), f && d.post && Be(e, h, d.post), t = 0; t < h.length; t++)
          if (c[l = h[t][0]])
            for (n = 0, a = (r = c[l].aDataSort).length; n < a; n++) i = c[o = r[n]].sType || "string", void 0 === h[t]._idx && (h[t]._idx = c[o].asSorting.indexOf(h[t][1])), h[t][1] && s.push({
              src: l,
              col: o,
              dir: h[t][1],
              index: h[t]._idx,
              type: i,
              formatter: u[i + "-pre"],
              sorter: u[i + "-" + h[t][1]]
            });
      return s
    }

    function Ue(e, t, n) {
      var a, r, o, i, l, c, d = [],
        s = $.ext.type.order,
        f = e.aoData,
        u = e.aiDisplayMaster;
      for (X(e), void 0 !== t ? (l = e.aoColumns[t], c = [{
          src: t,
          col: t,
          dir: n,
          index: 0,
          type: l.sType,
          formatter: s[l.sType + "-pre"],
          sorter: s[l.sType + "-" + n]
        }], u = u.slice()) : c = qe(e), a = 0, r = c.length; a < r; a++) {
        i = c[a], S = x = D = g = p = h = y = b = v = m = void 0;
        var h, p, g, m = e,
          v = i.col,
          b = m.aoColumns[v],
          y = $.ext.order[b.sSortDataType];
        y && (h = y.call(m.oInstance, m, v, T(m, v)));
        for (var D = $.ext.type.order[b.sType + "-pre"], x = m.aoData, S = 0; S < x.length; S++) x[S] && ((p = x[S])._aSortData || (p._aSortData = []), p._aSortData[v] && !y || (g = y ? h[S] : G(m, S, v, "sort"), p._aSortData[v] = D ? D(g, m) : g))
      }
      if ("ssp" != te(e) && 0 !== c.length) {
        for (a = 0, o = u.length; a < o; a++) d[a] = a;
        c.length && "desc" === c[0].dir && d.reverse(), u.sort(function(e, t) {
          for (var n, a, r, o, i = c.length, l = f[e]._aSortData, s = f[t]._aSortData, u = 0; u < i; u++)
            if (n = l[(o = c[u]).col], a = s[o.col], o.sorter) {
              if (0 !== (r = o.sorter(n, a))) return r
            } else if (0 !== (r = n < a ? -1 : a < n ? 1 : 0)) return "asc" === o.dir ? r : -r;
          return (n = d[e]) < (a = d[t]) ? -1 : a < n ? 1 : 0
        })
      } else 0 === c.length && u.sort(function(e, t) {
        return e < t ? -1 : t < e ? 1 : 0
      });
      return void 0 === t && (e.bSorted = !0, ee(e, null, "order", [e, c])), u
    }

    function $e(e) {
      var t, n, a, r = e.aLastSort,
        o = e.oClasses.order.position,
        i = qe(e),
        l = e.oFeatures;
      if (l.bSort && l.bSortClasses) {
        for (t = 0, n = r.length; t < n; t++) a = r[t].src, B(f(e.aoData, "anCells", a)).removeClass(o + (t < 2 ? t + 1 : 3));
        for (t = 0, n = i.length; t < n; t++) a = i[t].src, B(f(e.aoData, "anCells", a)).addClass(o + (t < 2 ? t + 1 : 3))
      }
      e.aLastSort = i
    }

    function ze(n) {
      var e;
      n._bLoadingState || (e = {
        time: +new Date,
        start: n._iDisplayStart,
        length: n._iDisplayLength,
        order: B.extend(!0, [], n.aaSorting),
        search: B.extend({}, n.oPreviousSearch),
        columns: n.aoColumns.map(function(e, t) {
          return {
            visible: e.bVisible,
            search: B.extend({}, n.aoPreSearchCols[t])
          }
        })
      }, n.oSavedState = e, ee(n, "aoStateSaveParams", "stateSaveParams", [n, e]), n.oFeatures.bStateSave && !n.bDestroying && n.fnStateSaveCallback.call(n.oInstance, n, e))
    }

    function Ye(n, e, t) {
      var a, r, o = n.aoColumns,
        i = (n._bLoadingState = !0, n._bInitComplete ? new $.Api(n) : null);
      if (e && e.time) {
        var l = n.iStateDuration;
        if (0 < l && e.time < +new Date - 1e3 * l) n._bLoadingState = !1;
        else if (-1 !== ee(n, "aoStateLoadParams", "stateLoadParams", [n, e]).indexOf(!1)) n._bLoadingState = !1;
        else if (e.columns && o.length !== e.columns.length) n._bLoadingState = !1;
        else {
          if (n.oLoadedState = B.extend(!0, {}, e), ee(n, null, "stateLoadInit", [n, e], !0), void 0 !== e.length && (i ? i.page.len(e.length) : n._iDisplayLength = e.length), void 0 !== e.start && (null === i ? (n._iDisplayStart = e.start, n.iInitDisplayStart = e.start) : Me(n, e.start / n._iDisplayLength)), void 0 !== e.order && (n.aaSorting = [], B.each(e.order, function(e, t) {
              n.aaSorting.push(t[0] >= o.length ? [0, t[1]] : t)
            })), void 0 !== e.search && B.extend(n.oPreviousSearch, e.search), e.columns) {
            for (a = 0, r = e.columns.length; a < r; a++) {
              var s = e.columns[a];
              void 0 !== s.visible && (i ? i.column(a).visible(s.visible, !1) : o[a].bVisible = s.visible), void 0 !== s.search && B.extend(n.aoPreSearchCols[a], s.search)
            }
            i && i.columns.adjust()
          }
          n._bLoadingState = !1, ee(n, "aoStateLoaded", "stateLoaded", [n, e])
        }
      } else n._bLoadingState = !1;
      t()
    }

    function Z(e, t, n, a) {
      if (n = "DataTables warning: " + (e ? "table id=" + e.sTableId + " - " : "") + n, a && (n += ". For more information about this error, please see https://datatables.net/tn/" + a), t) q.console && console.log && console.log(n);
      else {
        t = $.ext, t = t.sErrMode || t.errMode;
        if (e && ee(e, null, "dt-error", [e, a, n], !0), "alert" == t) alert(n);
        else {
          if ("throw" == t) throw new Error(n);
          "function" == typeof t && t(e, a, n)
        }
      }
    }

    function Q(n, a, e, t) {
      Array.isArray(e) ? B.each(e, function(e, t) {
        Array.isArray(t) ? Q(n, a, t[0], t[1]) : Q(n, a, t)
      }) : (void 0 === t && (t = e), void 0 !== a[e] && (n[t] = a[e]))
    }

    function Ge(e, t, n) {
      var a, r;
      for (r in t) Object.prototype.hasOwnProperty.call(t, r) && (a = t[r], B.isPlainObject(a) ? (B.isPlainObject(e[r]) || (e[r] = {}), B.extend(!0, e[r], a)) : n && "data" !== r && "aaData" !== r && Array.isArray(a) ? e[r] = a.slice() : e[r] = a);
      return e
    }

    function Je(e, t, n) {
      B(e).on("click.DT", t, function(e) {
        n(e)
      }).on("keypress.DT", t, function(e) {
        13 === e.which && (e.preventDefault(), n(e))
      }).on("selectstart.DT", t, function() {
        return !1
      })
    }

    function K(e, t, n) {
      n && e[t].push(n)
    }

    function ee(t, e, n, a, r) {
      var o = [];
      return e && (o = t[e].slice().reverse().map(function(e) {
        return e.apply(t.oInstance, a)
      })), null !== n && (e = B.Event(n + ".dt"), n = B(t.nTable), e.dt = t.api, n[r ? "trigger" : "triggerHandler"](e, a), r && 0 === n.parents("body").length && B("body").trigger(e, a), o.push(e.result)), o
    }

    function Ze(e) {
      var t = e._iDisplayStart,
        n = e.fnDisplayEnd(),
        a = e._iDisplayLength;
      n <= t && (t = n - a), t -= t % a, e._iDisplayStart = t = -1 === a || t < 0 ? 0 : t
    }

    function Qe(e, t) {
      var e = e.renderer,
        n = $.ext.renderer[t];
      return B.isPlainObject(e) && e[t] ? n[e[t]] || n._ : "string" == typeof e && n[e] || n._
    }

    function te(e) {
      return e.oFeatures.bServerSide ? "ssp" : e.ajax ? "ajax" : "dom"
    }

    function Ke(e, t, n) {
      var a = e.fnFormatNumber,
        r = e._iDisplayStart + 1,
        o = e._iDisplayLength,
        i = e.fnRecordsDisplay(),
        l = e.fnRecordsTotal(),
        s = -1 === o;
      return t.replace(/_START_/g, a.call(e, r)).replace(/_END_/g, a.call(e, e.fnDisplayEnd())).replace(/_MAX_/g, a.call(e, l)).replace(/_TOTAL_/g, a.call(e, i)).replace(/_PAGE_/g, a.call(e, s ? 1 : Math.ceil(r / o))).replace(/_PAGES_/g, a.call(e, s ? 1 : Math.ceil(i / o))).replace(/_ENTRIES_/g, e.api.i18n("entries", "", n)).replace(/_ENTRIES-MAX_/g, e.api.i18n("entries", "", l)).replace(/_ENTRIES-TOTAL_/g, e.api.i18n("entries", "", i))
    }
    var et = [],
      n = Array.prototype;
    U = function(e, t) {
      if (!(this instanceof U)) return new U(e, t);

      function n(e) {
        e = e, t = $.settings, a = f(t, "nTable");
        var n, t, a, r = e ? e.nTable && e.oFeatures ? [e] : e.nodeName && "table" === e.nodeName.toLowerCase() ? -1 !== (r = a.indexOf(e)) ? [t[r]] : null : e && "function" == typeof e.settings ? e.settings().toArray() : ("string" == typeof e ? n = B(e).get() : e instanceof B && (n = e.get()), n ? t.filter(function(e, t) {
          return n.includes(a[t])
        }) : void 0) : [];
        r && o.push.apply(o, r)
      }
      var o = [];
      if (Array.isArray(e))
        for (var a = 0, r = e.length; a < r; a++) n(e[a]);
      else n(e);
      this.context = 1 < o.length ? x(o) : o, t && this.push.apply(this, t), this.selector = {
        rows: null,
        cols: null,
        opts: null
      }, U.extend(this, this, et)
    }, $.Api = U, B.extend(U.prototype, {
      any: function() {
        return 0 !== this.count()
      },
      context: [],
      count: function() {
        return this.flatten().length
      },
      each: function(e) {
        for (var t = 0, n = this.length; t < n; t++) e.call(this, this[t], t, this);
        return this
      },
      eq: function(e) {
        var t = this.context;
        return t.length > e ? new U(t[e], this[e]) : null
      },
      filter: function(e) {
        e = n.filter.call(this, e, this);
        return new U(this.context, e)
      },
      flatten: function() {
        var e = [];
        return new U(this.context, e.concat.apply(e, this.toArray()))
      },
      get: function(e) {
        return this[e]
      },
      join: n.join,
      includes: function(e) {
        return -1 !== this.indexOf(e)
      },
      indexOf: n.indexOf,
      iterator: function(e, t, n, a) {
        var r, o, i, l, s, u, c, d, f = [],
          h = this.context,
          p = this.selector;
        for ("string" == typeof e && (a = n, n = t, t = e, e = !1), o = 0, i = h.length; o < i; o++) {
          var g = new U(h[o]);
          if ("table" === t) void 0 !== (r = n.call(g, h[o], o)) && f.push(r);
          else if ("columns" === t || "rows" === t) void 0 !== (r = n.call(g, h[o], this[o], o)) && f.push(r);
          else if ("every" === t || "column" === t || "column-rows" === t || "row" === t || "cell" === t)
            for (c = this[o], "column-rows" === t && (u = ct(h[o], p.opts)), l = 0, s = c.length; l < s; l++) d = c[l], void 0 !== (r = "cell" === t ? n.call(g, h[o], d.row, d.column, o, l) : n.call(g, h[o], d, o, l, u)) && f.push(r)
        }
        return f.length || a ? ((e = (a = new U(h, e ? f.concat.apply([], f) : f)).selector).rows = p.rows, e.cols = p.cols, e.opts = p.opts, a) : this
      },
      lastIndexOf: n.lastIndexOf,
      length: 0,
      map: function(e) {
        e = n.map.call(this, e, this);
        return new U(this.context, e)
      },
      pluck: function(e) {
        var t = $.util.get(e);
        return this.map(function(e) {
          return t(e)
        })
      },
      pop: n.pop,
      push: n.push,
      reduce: n.reduce,
      reduceRight: n.reduceRight,
      reverse: n.reverse,
      selector: null,
      shift: n.shift,
      slice: function() {
        return new U(this.context, this)
      },
      sort: n.sort,
      splice: n.splice,
      toArray: function() {
        return n.slice.call(this)
      },
      to$: function() {
        return B(this)
      },
      toJQuery: function() {
        return B(this)
      },
      unique: function() {
        return new U(this.context, x(this.toArray()))
      },
      unshift: n.unshift
    }), q.__apiStruct = et, U.extend = function(e, t, n) {
      if (n.length && t && (t instanceof U || t.__dt_wrapper))
        for (var a, r = 0, o = n.length; r < o; r++) t[(a = n[r]).name] = "function" === a.type ? function(t, n, a) {
          return function() {
            var e = n.apply(t || this, arguments);
            return U.extend(e, e, a.methodExt), e
          }
        }(e, a.val, a) : "object" === a.type ? {} : a.val, t[a.name].__dt_wrapper = !0, U.extend(e, t[a.name], a.propExt)
    }, U.register = t = function(e, t) {
      if (Array.isArray(e))
        for (var n = 0, a = e.length; n < a; n++) U.register(e[n], t);
      else
        for (var r = e.split("."), o = et, i = 0, l = r.length; i < l; i++) {
          var s, u, c = function(e, t) {
            for (var n = 0, a = e.length; n < a; n++)
              if (e[n].name === t) return e[n];
            return null
          }(o, u = (s = -1 !== r[i].indexOf("()")) ? r[i].replace("()", "") : r[i]);
          c || o.push(c = {
            name: u,
            val: {},
            methodExt: [],
            propExt: [],
            type: "object"
          }), i === l - 1 ? (c.val = t, c.type = "function" == typeof t ? "function" : B.isPlainObject(t) ? "object" : "other") : o = s ? c.methodExt : c.propExt
        }
    }, U.registerPlural = e = function(e, t, n) {
      U.register(e, n), U.register(t, function() {
        var e = n.apply(this, arguments);
        return e === this ? this : e instanceof U ? e.length ? Array.isArray(e[0]) ? new U(e.context, e[0]) : e[0] : void 0 : e
      })
    };

    function tt(e, t) {
      var n, a;
      return Array.isArray(e) ? (n = [], e.forEach(function(e) {
        e = tt(e, t);
        n.push.apply(n, e)
      }), n.filter(function(e) {
        return e
      })) : "number" == typeof e ? [t[e]] : (a = t.map(function(e) {
        return e.nTable
      }), B(a).filter(e).map(function() {
        var e = a.indexOf(this);
        return t[e]
      }).toArray())
    }

    function nt(r, o, e) {
      var t, n;
      e && (t = new U(r)).one("draw", function() {
        e(t.ajax.json())
      }), "ssp" == te(r) ? s(r, o) : (w(r, !0), (n = r.jqXHR) && 4 !== n.readyState && n.abort(), Ie(r, {}, function(e) {
        he(r);
        for (var t = Ae(r, e), n = 0, a = t.length; n < a; n++) Y(r, t[n]);
        s(r, o), ke(r), w(r, !1)
      }))
    }

    function at(e, t, n, a, r) {
      for (var o, i, l, s, u = [], c = typeof t, d = 0, f = (t = t && "string" != c && "function" != c && void 0 !== t.length ? t : [t]).length; d < f; d++)
        for (l = 0, s = (i = t[d] && t[d].split && !t[d].match(/[[(:]/) ? t[d].split(",") : [t[d]]).length; l < s; l++)(o = (o = n("string" == typeof i[l] ? i[l].trim() : i[l])).filter(function(e) {
          return null != e
        })) && o.length && (u = u.concat(o));
      var h = C.selector[e];
      if (h.length)
        for (d = 0, f = h.length; d < f; d++) u = h[d](a, r, u);
      return x(u)
    }

    function rt(e) {
      return (e = e || {}).filter && void 0 === e.search && (e.search = e.filter), B.extend({
        search: "none",
        order: "current",
        page: "all"
      }, e)
    }

    function ot(e) {
      var t = new U(e.context[0]);
      return e.length && t.push(e[0]), t.selector = e.selector, t.length && 1 < t[0].length && t[0].splice(1), t
    }
    t("tables()", function(e) {
      return null != e ? new U(tt(e, this.context)) : this
    }), t("table()", function(e) {
      var e = this.tables(e),
        t = e.context;
      return t.length ? new U(t[0]) : e
    }), [
      ["nodes", "node", "nTable"],
      ["body", "body", "nTBody"],
      ["header", "header", "nTHead"],
      ["footer", "footer", "nTFoot"]
    ].forEach(function(t) {
      e("tables()." + t[0] + "()", "table()." + t[1] + "()", function() {
        return this.iterator("table", function(e) {
          return e[t[2]]
        }, 1)
      })
    }), [
      ["header", "aoHeader"],
      ["footer", "aoFooter"]
    ].forEach(function(n) {
      t("table()." + n[0] + ".structure()", function(e) {
        var e = this.columns(e).indexes().flatten(),
          t = this.context[0];
        return De(t, t[n[1]], e)
      })
    }), e("tables().containers()", "table().container()", function() {
      return this.iterator("table", function(e) {
        return e.nTableWrapper
      }, 1)
    }), t("tables().every()", function(n) {
      var a = this;
      return this.iterator("table", function(e, t) {
        n.call(a.table(t), t)
      })
    }), t("caption()", function(r, o) {
      var e, t = this.context;
      return void 0 === r ? (e = t[0].captionNode) && t.length ? e.innerHTML : null : this.iterator("table", function(e) {
        var t = B(e.nTable),
          n = B(e.captionNode),
          a = B(e.nTableWrapper);
        n.length || (n = B("<caption/>").html(r), e.captionNode = n[0], o) || (t.prepend(n), o = n.css("caption-side")), n.html(r), o && (n.css("caption-side", o), n[0]._captionSide = o), (a.find("div.dataTables_scroll").length ? (e = "top" === o ? "Head" : "Foot", a.find("div.dataTables_scroll" + e + " table")) : t).prepend(n)
      }, 1)
    }), t("caption.node()", function() {
      var e = this.context;
      return e.length ? e[0].captionNode : null
    }), t("draw()", function(t) {
      return this.iterator("table", function(e) {
        "page" === t ? S(e) : s(e, !1 === (t = "string" == typeof t ? "full-hold" !== t : t))
      })
    }), t("page()", function(t) {
      return void 0 === t ? this.page.info().page : this.iterator("table", function(e) {
        Me(e, t)
      })
    }), t("page.info()", function() {
      var e, t, n, a, r;
      if (0 !== this.context.length) return t = (e = this.context[0])._iDisplayStart, n = e.oFeatures.bPaginate ? e._iDisplayLength : -1, a = e.fnRecordsDisplay(), {
        page: (r = -1 === n) ? 0 : Math.floor(t / n),
        pages: r ? 1 : Math.ceil(a / n),
        start: t,
        end: e.fnDisplayEnd(),
        length: n,
        recordsTotal: e.fnRecordsTotal(),
        recordsDisplay: a,
        serverSide: "ssp" === te(e)
      }
    }), t("page.len()", function(t) {
      return void 0 === t ? 0 !== this.context.length ? this.context[0]._iDisplayLength : void 0 : this.iterator("table", function(e) {
        Ee(e, t)
      })
    }), t("ajax.json()", function() {
      var e = this.context;
      if (0 < e.length) return e[0].json
    }), t("ajax.params()", function() {
      var e = this.context;
      if (0 < e.length) return e[0].oAjaxData
    }), t("ajax.reload()", function(t, n) {
      return this.iterator("table", function(e) {
        nt(e, !1 === n, t)
      })
    }), t("ajax.url()", function(t) {
      var e = this.context;
      return void 0 === t ? 0 === e.length ? void 0 : (e = e[0], B.isPlainObject(e.ajax) ? e.ajax.url : e.ajax) : this.iterator("table", function(e) {
        B.isPlainObject(e.ajax) ? e.ajax.url = t : e.ajax = t
      })
    }), t("ajax.url().load()", function(t, n) {
      return this.iterator("table", function(e) {
        nt(e, !1 === n, t)
      })
    });

    function it(o, i, e, t) {
      function l(e, t) {
        var n;
        if (Array.isArray(e) || e instanceof B)
          for (var a = 0, r = e.length; a < r; a++) l(e[a], t);
        else e.nodeName && "tr" === e.nodeName.toLowerCase() ? (e.setAttribute("data-dt-row", i.idx), s.push(e)) : (n = B("<tr><td></td></tr>").attr("data-dt-row", i.idx).addClass(t), B("td", n).addClass(t).html(e)[0].colSpan = H(o), s.push(n[0]))
      }
      var s = [];
      l(e, t), i._details && i._details.detach(), i._details = B(s), i._detailsShow && i._details.insertAfter(i.nTr)
    }

    function lt(e, t) {
      var n = e.context;
      if (n.length && e.length) {
        var a = n[0].aoData[e[0]];
        if (a._details) {
          (a._detailsShow = t) ? (a._details.insertAfter(a.nTr), B(a.nTr).addClass("dt-hasChild")) : (a._details.detach(), B(a.nTr).removeClass("dt-hasChild")), ee(n[0], null, "childRow", [t, e.row(e[0])]);
          var i = n[0],
            r = new U(i),
            a = ".dt.DT_details",
            t = "draw" + a,
            e = "column-sizing" + a,
            a = "destroy" + a,
            l = i.aoData;
          if (r.off(t + " " + e + " " + a), f(l, "_details").length > 0) {
            r.on(t, function(e, t) {
              if (i !== t) return;
              r.rows({
                page: "current"
              }).eq(0).each(function(e) {
                var t = l[e];
                if (t._detailsShow) t._details.insertAfter(t.nTr)
              })
            });
            r.on(e, function(e, t) {
              if (i !== t) return;
              var n, a = H(t);
              for (var r = 0, o = l.length; r < o; r++) {
                n = l[r];
                if (n && n._details) n._details.each(function() {
                  var e = B(this).children("td");
                  if (e.length == 1) e.attr("colspan", a)
                })
              }
            });
            r.on(a, function(e, t) {
              if (i !== t) return;
              for (var n = 0, a = l.length; n < a; n++)
                if (l[n] && l[n]._details) ht(r, n)
            })
          }
          ft(n)
        }
      }
    }

    function st(e, t, n, a, r, o) {
      for (var i = [], l = 0, s = r.length; l < s; l++) i.push(G(e, r[l], t, o));
      return i
    }

    function ut(t, n) {
      return function(e) {
        return y(e) || "string" != typeof e || (e = e.replace(d, " "), t && (e = I(e)), n && (e = R(e, !1))), e
      }
    }
    var ct = function(e, t) {
        var n, a = [],
          r = e.aiDisplay,
          o = e.aiDisplayMaster,
          i = t.search,
          l = t.order,
          t = t.page;
        if ("ssp" == te(e)) return "removed" === i ? [] : h(0, o.length);
        if ("current" == t)
          for (u = e._iDisplayStart, c = e.fnDisplayEnd(); u < c; u++) a.push(r[u]);
        else if ("current" == l || "applied" == l) {
          if ("none" == i) a = o.slice();
          else if ("applied" == i) a = r.slice();
          else if ("removed" == i) {
            for (var s = {}, u = 0, c = r.length; u < c; u++) s[r[u]] = null;
            o.forEach(function(e) {
              Object.prototype.hasOwnProperty.call(s, e) || a.push(e)
            })
          }
        } else if ("index" == l || "original" == l)
          for (u = 0, c = e.aoData.length; u < c; u++) e.aoData[u] && ("none" == i || -1 === (n = r.indexOf(u)) && "removed" == i || 0 <= n && "applied" == i) && a.push(u);
        else if ("number" == typeof l) {
          var d = Ue(e, l, "asc");
          if ("none" === i) a = d;
          else
            for (u = 0; u < d.length; u++)(-1 === (n = r.indexOf(d[u])) && "removed" == i || 0 <= n && "applied" == i) && a.push(d[u])
        }
        return a
      },
      dt = (t("rows()", function(a, l) {
        void 0 === a ? a = "" : B.isPlainObject(a) && (l = a, a = ""), l = rt(l);
        var e = this.iterator("table", function(e) {
          return t = at("row", t = a, function(n) {
            var e = g(n),
              a = r.aoData;
            if (null !== e && !o) return [e];
            if (i = i || ct(r, o), null !== e && -1 !== i.indexOf(e)) return [e];
            if (null == n || "" === n) return i;
            if ("function" == typeof n) return i.map(function(e) {
              var t = a[e];
              return n(e, t._aData, t.nTr) ? e : null
            });
            if (n.nodeName) return e = n._DT_RowIndex, t = n._DT_CellIndex, void 0 !== e ? a[e] && a[e].nTr === n ? [e] : [] : t ? a[t.row] && a[t.row].nTr === n.parentNode ? [t.row] : [] : (e = B(n).closest("*[data-dt-row]")).length ? [e.data("dt-row")] : [];
            if ("string" == typeof n && "#" === n.charAt(0)) {
              var t = r.aIds[n.replace(/^#/, "")];
              if (void 0 !== t) return [t.idx]
            }
            e = b(v(r.aoData, i, "nTr"));
            return B(e).filter(n).map(function() {
              return this._DT_RowIndex
            }).toArray()
          }, r = e, o = l), "current" !== o.order && "applied" !== o.order || (n = r.aiDisplayMaster, t.sort(function(e, t) {
            return n.indexOf(e) - n.indexOf(t)
          })), t;
          var r, t, o, i, n
        }, 1);
        return e.selector.rows = a, e.selector.opts = l, e
      }), t("rows().nodes()", function() {
        return this.iterator("row", function(e, t) {
          return e.aoData[t].nTr || void 0
        }, 1)
      }), t("rows().data()", function() {
        return this.iterator(!0, "rows", function(e, t) {
          return v(e.aoData, t, "_aData")
        }, 1)
      }), e("rows().cache()", "row().cache()", function(n) {
        return this.iterator("row", function(e, t) {
          e = e.aoData[t];
          return "search" === n ? e._aFilterData : e._aSortData
        }, 1)
      }), e("rows().invalidate()", "row().invalidate()", function(n) {
        return this.iterator("row", function(e, t) {
          pe(e, t, n)
        })
      }), e("rows().indexes()", "row().index()", function() {
        return this.iterator("row", function(e, t) {
          return t
        }, 1)
      }), e("rows().ids()", "row().id()", function(e) {
        for (var t = [], n = this.context, a = 0, r = n.length; a < r; a++)
          for (var o = 0, i = this[a].length; o < i; o++) {
            var l = n[a].rowIdFn(n[a].aoData[this[a][o]]._aData);
            t.push((!0 === e ? "#" : "") + l)
          }
        return new U(n, t)
      }), e("rows().remove()", "row().remove()", function() {
        return this.iterator("row", function(e, t) {
          var n = e.aoData,
            a = n[t],
            r = e.aiDisplayMaster.indexOf(t),
            r = (-1 !== r && e.aiDisplayMaster.splice(r, 1), -1 !== (r = e.aiDisplay.indexOf(t)) && e.aiDisplay.splice(r, 1), 0 < e._iRecordsDisplay && e._iRecordsDisplay--, Ze(e), e.rowIdFn(a._aData));
          void 0 !== r && delete e.aIds[r], n[t] = null
        }), this
      }), t("rows.add()", function(o) {
        var e = this.iterator("table", function(e) {
            for (var t, n = [], a = 0, r = o.length; a < r; a++)(t = o[a]).nodeName && "TR" === t.nodeName.toUpperCase() ? n.push(se(e, t)[0]) : n.push(Y(e, t));
            return n
          }, 1),
          t = this.rows(-1);
        return t.pop(), t.push.apply(t, e), t
      }), t("row()", function(e, t) {
        return ot(this.rows(e, t))
      }), t("row().data()", function(e) {
        var t, n = this.context;
        return void 0 === e ? n.length && this.length && this[0].length ? n[0].aoData[this[0]]._aData : void 0 : ((t = n[0].aoData[this[0]])._aData = e, Array.isArray(e) && t.nTr && t.nTr.id && m(n[0].rowId)(e, t.nTr.id), pe(n[0], this[0], "data"), this)
      }), t("row().node()", function() {
        var e = this.context;
        return e.length && this.length && this[0].length && e[0].aoData[this[0]].nTr || null
      }), t("row.add()", function(t) {
        t instanceof B && t.length && (t = t[0]);
        var e = this.iterator("table", function(e) {
          return t.nodeName && "TR" === t.nodeName.toUpperCase() ? se(e, t)[0] : Y(e, t)
        });
        return this.row(e[0])
      }), B(_).on("plugin-init.dt", function(e, t) {
        var a = new U(t);
        a.on("stateSaveParams.DT", function(e, t, n) {
          for (var a = t.rowIdFn, r = t.aiDisplayMaster, o = [], i = 0; i < r.length; i++) {
            var l = r[i],
              l = t.aoData[l];
            l._detailsShow && o.push("#" + a(l._aData))
          }
          n.childRows = o
        }), a.on("stateLoaded.DT", function(e, t, n) {
          dt(a, n)
        }), dt(a, a.state.loaded())
      }), function(e, t) {
        t && t.childRows && e.rows(t.childRows.map(function(e) {
          return e.replace(/:/g, "\\:")
        })).every(function() {
          ee(e.settings()[0], null, "requestChild", [this])
        })
      }),
      ft = $.util.throttle(function(e) {
        ze(e[0])
      }, 500),
      ht = function(e, t) {
        var n = e.context;
        n.length && (t = n[0].aoData[void 0 !== t ? t : e[0]]) && t._details && (t._details.remove(), t._detailsShow = void 0, t._details = void 0, B(t.nTr).removeClass("dt-hasChild"), ft(n))
      },
      pt = "row().child",
      gt = pt + "()",
      mt = (t(gt, function(e, t) {
        var n = this.context;
        return void 0 === e ? n.length && this.length && n[0].aoData[this[0]] ? n[0].aoData[this[0]]._details : void 0 : (!0 === e ? this.child.show() : !1 === e ? ht(this) : n.length && this.length && it(n[0], n[0].aoData[this[0]], e, t), this)
      }), t([pt + ".show()", gt + ".show()"], function() {
        return lt(this, !0), this
      }), t([pt + ".hide()", gt + ".hide()"], function() {
        return lt(this, !1), this
      }), t([pt + ".remove()", gt + ".remove()"], function() {
        return ht(this), this
      }), t(pt + ".isShown()", function() {
        var e = this.context;
        return e.length && this.length && e[0].aoData[this[0]]._detailsShow || !1
      }), /^([^:]+):(name|title|visIdx|visible)$/),
      gt = (t("columns()", function(n, a) {
        void 0 === n ? n = "" : B.isPlainObject(n) && (a = n, n = ""), a = rt(a);
        var e = this.iterator("table", function(e) {
          return t = n, l = a, s = (i = e).aoColumns, u = f(s, "sName"), c = f(s, "sTitle"), e = $.util.get("[].[].cell")(i.aoHeader), d = x(O([], e)), at("column", t, function(n) {
            var a, e = g(n);
            if ("" === n) return h(s.length);
            if (null !== e) return [0 <= e ? e : s.length + e];
            if ("function" == typeof n) return a = ct(i, l), s.map(function(e, t) {
              return n(t, st(i, t, 0, 0, a)) ? t : null
            });
            var r = "string" == typeof n ? n.match(mt) : "";
            if (r) switch (r[2]) {
              case "visIdx":
              case "visible":
                var t, o = parseInt(r[1], 10);
                return o < 0 ? [(t = s.map(function(e, t) {
                  return e.bVisible ? t : null
                }))[t.length + o]] : [M(i, o)];
              case "name":
                return u.map(function(e, t) {
                  return e === r[1] ? t : null
                });
              case "title":
                return c.map(function(e, t) {
                  return e === r[1] ? t : null
                });
              default:
                return []
            }
            return n.nodeName && n._DT_CellIndex ? [n._DT_CellIndex.column] : (e = B(d).filter(n).map(function() {
              return le(this)
            }).toArray()).length || !n.nodeName ? e : (e = B(n).closest("*[data-dt-column]")).length ? [e.data("dt-column")] : []
          }, i, l);
          var i, t, l, s, u, c, d
        }, 1);
        return e.selector.cols = n, e.selector.opts = a, e
      }), e("columns().header()", "column().header()", function(a) {
        return this.iterator("column", function(e, t) {
          var n = e.aoHeader;
          return n[void 0 !== a ? a : e.bSortCellsTop ? 0 : n.length - 1][t].cell
        }, 1)
      }), e("columns().footer()", "column().footer()", function(n) {
        return this.iterator("column", function(e, t) {
          return e.aoFooter.length ? e.aoFooter[void 0 !== n ? n : 0][t].cell : null
        }, 1)
      }), e("columns().data()", "column().data()", function() {
        return this.iterator("column-rows", st, 1)
      }), e("columns().render()", "column().render()", function(o) {
        return this.iterator("column-rows", function(e, t, n, a, r) {
          return st(e, t, 0, 0, r, o)
        }, 1)
      }), e("columns().dataSrc()", "column().dataSrc()", function() {
        return this.iterator("column", function(e, t) {
          return e.aoColumns[t].mData
        }, 1)
      }), e("columns().cache()", "column().cache()", function(o) {
        return this.iterator("column-rows", function(e, t, n, a, r) {
          return v(e.aoData, r, "search" === o ? "_aFilterData" : "_aSortData", t)
        }, 1)
      }), e("columns().init()", "column().init()", function() {
        return this.iterator("column", function(e, t) {
          return e.aoColumns[t]
        }, 1)
      }), e("columns().nodes()", "column().nodes()", function() {
        return this.iterator("column-rows", function(e, t, n, a, r) {
          return v(e.aoData, r, "anCells", t)
        }, 1)
      }), e("columns().titles()", "column().title()", function(n, a) {
        return this.iterator("column", function(e, t) {
          "number" == typeof n && (a = n, n = void 0);
          t = B("span.dt-column-title", this.column(t).header(a));
          return void 0 !== n ? (t.html(n), this) : t.html()
        }, 1)
      }), e("columns().types()", "column().type()", function() {
        return this.iterator("column", function(e, t) {
          t = e.aoColumns[t].sType;
          return t || X(e), t
        }, 1)
      }), e("columns().visible()", "column().visible()", function(n, a) {
        var t = this,
          r = [],
          e = this.iterator("column", function(e, t) {
            if (void 0 === n) return e.aoColumns[t].bVisible;
            ! function(e, t, n) {
              var a, r, o = e.aoColumns,
                i = o[t],
                l = e.aoData;
              if (void 0 === n) return i.bVisible;
              if (i.bVisible === n) return !1;
              if (n)
                for (var s = f(o, "bVisible").indexOf(!0, t + 1), u = 0, c = l.length; u < c; u++) l[u] && (r = l[u].nTr, a = l[u].anCells, r) && r.insertBefore(a[t], a[s] || null);
              else B(f(e.aoData, "anCells", t)).detach();
              return i.bVisible = n, Xe(e), !0
            }(e, t, n) || r.push(t)
          });
        return void 0 !== n && this.iterator("table", function(e) {
          xe(e, e.aoHeader), xe(e, e.aoFooter), e.aiDisplay.length || B(e.nTBody).find("td[colspan]").attr("colspan", H(e)), ze(e), t.iterator("column", function(e, t) {
            r.includes(t) && ee(e, null, "column-visibility", [e, t, n, a])
          }), r.length && (void 0 === a || a) && t.columns.adjust()
        }), e
      }), e("columns().widths()", "column().width()", function() {
        var e = this.columns(":visible").count(),
          e = B("<tr>").html("<td>" + Array(e).join("</td><td>") + "</td>"),
          n = (B(this.table().body()).append(e), e.children().map(function() {
            return B(this).outerWidth()
          }));
        return e.remove(), this.iterator("column", function(e, t) {
          e = T(e, t);
          return null !== e ? n[e] : 0
        }, 1)
      }), e("columns().indexes()", "column().index()", function(n) {
        return this.iterator("column", function(e, t) {
          return "visible" === n ? T(e, t) : t
        }, 1)
      }), t("columns.adjust()", function() {
        return this.iterator("table", function(e) {
          E(e)
        }, 1)
      }), t("column.index()", function(e, t) {
        var n;
        if (0 !== this.context.length) return n = this.context[0], "fromVisible" === e || "toData" === e ? M(n, t) : "fromData" === e || "toVisible" === e ? T(n, t) : void 0
      }), t("column()", function(e, t) {
        return ot(this.columns(e, t))
      }), t("cells()", function(g, e, m) {
        var a, r, o, i, l, s, t;
        return B.isPlainObject(g) && (void 0 === g.row ? (m = g, g = null) : (m = e, e = null)), B.isPlainObject(e) && (m = e, e = null), null == e ? this.iterator("table", function(e) {
          return a = e, e = g, t = rt(m), d = a.aoData, f = ct(a, t), n = b(v(d, f, "anCells")), h = B(O([], n)), p = a.aoColumns.length, at("cell", e, function(e) {
            var t, n = "function" == typeof e;
            if (null == e || n) {
              for (o = [], i = 0, l = f.length; i < l; i++)
                for (r = f[i], s = 0; s < p; s++) u = {
                  row: r,
                  column: s
                }, (!n || (c = d[r], e(u, G(a, r, s), c.anCells ? c.anCells[s] : null))) && o.push(u);
              return o
            }
            return B.isPlainObject(e) ? void 0 !== e.column && void 0 !== e.row && -1 !== f.indexOf(e.row) ? [e] : [] : (t = h.filter(e).map(function(e, t) {
              return {
                row: t._DT_CellIndex.row,
                column: t._DT_CellIndex.column
              }
            }).toArray()).length || !e.nodeName ? t : (c = B(e).closest("*[data-dt-row]")).length ? [{
              row: c.data("dt-row"),
              column: c.data("dt-column")
            }] : []
          }, a, t);
          var a, t, r, o, i, l, s, u, c, d, f, n, h, p
        }) : (t = m ? {
          page: m.page,
          order: m.order,
          search: m.search
        } : {}, a = this.columns(e, t), r = this.rows(g, t), t = this.iterator("table", function(e, t) {
          var n = [];
          for (o = 0, i = r[t].length; o < i; o++)
            for (l = 0, s = a[t].length; l < s; l++) n.push({
              row: r[t][o],
              column: a[t][l]
            });
          return n
        }, 1), t = m && m.selected ? this.cells(t, m) : t, B.extend(t.selector, {
          cols: e,
          rows: g,
          opts: m
        }), t)
      }), e("cells().nodes()", "cell().node()", function() {
        return this.iterator("cell", function(e, t, n) {
          e = e.aoData[t];
          return e && e.anCells ? e.anCells[n] : void 0
        }, 1)
      }), t("cells().data()", function() {
        return this.iterator("cell", function(e, t, n) {
          return G(e, t, n)
        }, 1)
      }), e("cells().cache()", "cell().cache()", function(a) {
        return a = "search" === a ? "_aFilterData" : "_aSortData", this.iterator("cell", function(e, t, n) {
          return e.aoData[t][a][n]
        }, 1)
      }), e("cells().render()", "cell().render()", function(a) {
        return this.iterator("cell", function(e, t, n) {
          return G(e, t, n, a)
        }, 1)
      }), e("cells().indexes()", "cell().index()", function() {
        return this.iterator("cell", function(e, t, n) {
          return {
            row: t,
            column: n,
            columnVisible: T(e, n)
          }
        }, 1)
      }), e("cells().invalidate()", "cell().invalidate()", function(a) {
        return this.iterator("cell", function(e, t, n) {
          pe(e, t, a, n)
        })
      }), t("cell()", function(e, t, n) {
        return ot(this.cells(e, t, n))
      }), t("cell().data()", function(e) {
        var t, n, a, r, o, i = this.context,
          l = this[0];
        return void 0 === e ? i.length && l.length ? G(i[0], l[0].row, l[0].column) : void 0 : (t = i[0], n = l[0].row, a = l[0].column, r = t.aoColumns[a], o = t.aoData[n]._aData, r.fnSetData(o, e, {
          settings: t,
          row: n,
          col: a
        }), pe(i[0], l[0].row, "data", l[0].column), this)
      }), t("order()", function(t, e) {
        var n = this.context,
          a = Array.prototype.slice.call(arguments);
        return void 0 === t ? 0 !== n.length ? n[0].aaSorting : void 0 : ("number" == typeof t ? t = [
          [t, e]
        ] : 1 < a.length && (t = a), this.iterator("table", function(e) {
          e.aaSorting = Array.isArray(t) ? t.slice() : t
        }))
      }), t("order.listener()", function(t, n, a) {
        return this.iterator("table", function(e) {
          Ve(e, t, {}, n, a)
        })
      }), t("order.fixed()", function(t) {
        var e;
        return t ? this.iterator("table", function(e) {
          e.aaSortingFixed = B.extend(!0, {}, t)
        }) : (e = (e = this.context).length ? e[0].aaSortingFixed : void 0, Array.isArray(e) ? {
          pre: e
        } : e)
      }), t(["columns().order()", "column().order()"], function(n) {
        var a = this;
        return n ? this.iterator("table", function(e, t) {
          e.aaSorting = a[t].map(function(e) {
            return [e, n]
          })
        }) : this.iterator("column", function(e, t) {
          for (var n = qe(e), a = 0, r = n.length; a < r; a++)
            if (n[a].col === t) return n[a].dir;
          return null
        }, 1)
      }), e("columns().orderable()", "column().orderable()", function(n) {
        return this.iterator("column", function(e, t) {
          e = e.aoColumns[t];
          return n ? e.asSorting : e.bSortable
        }, 1)
      }), t("processing()", function(t) {
        return this.iterator("table", function(e) {
          w(e, t)
        })
      }), t("search()", function(t, n, a, r) {
        var e = this.context;
        return void 0 === t ? 0 !== e.length ? e[0].oPreviousSearch.search : void 0 : this.iterator("table", function(e) {
          e.oFeatures.bFilter && Le(e, "object" == typeof n ? B.extend(e.oPreviousSearch, n, {
            search: t
          }) : B.extend(e.oPreviousSearch, {
            search: t,
            regex: null !== n && n,
            smart: null === a || a,
            caseInsensitive: null === r || r
          }))
        })
      }), t("search.fixed()", function(t, n) {
        var e = this.iterator(!0, "table", function(e) {
          e = e.searchFixed;
          return t ? void 0 === n ? e[t] : (null === n ? delete e[t] : e[t] = n, this) : Object.keys(e)
        });
        return void 0 !== t && void 0 === n ? e[0] : e
      }), e("columns().search()", "column().search()", function(a, r, o, i) {
        return this.iterator("column", function(e, t) {
          var n = e.aoPreSearchCols;
          if (void 0 === a) return n[t].search;
          e.oFeatures.bFilter && ("object" == typeof r ? B.extend(n[t], r, {
            search: a
          }) : B.extend(n[t], {
            search: a,
            regex: null !== r && r,
            smart: null === o || o,
            caseInsensitive: null === i || i
          }), Le(e, e.oPreviousSearch))
        })
      }), t(["columns().search.fixed()", "column().search.fixed()"], function(n, a) {
        var e = this.iterator(!0, "column", function(e, t) {
          e = e.aoColumns[t].searchFixed;
          return n ? void 0 === a ? e[n] : (null === a ? delete e[n] : e[n] = a, this) : Object.keys(e)
        });
        return void 0 !== n && void 0 === a ? e[0] : e
      }), t("state()", function(e, t) {
        var n;
        return e ? (n = B.extend(!0, {}, e), this.iterator("table", function(e) {
          !1 !== t && (n.time = +new Date + 100), Ye(e, n, function() {})
        })) : this.context.length ? this.context[0].oSavedState : null
      }), t("state.clear()", function() {
        return this.iterator("table", function(e) {
          e.fnStateSaveCallback.call(e.oInstance, e, {})
        })
      }), t("state.loaded()", function() {
        return this.context.length ? this.context[0].oLoadedState : null
      }), t("state.save()", function() {
        return this.iterator("table", function(e) {
          ze(e)
        })
      }), $.use = function(e, t) {
        "lib" === t || e.fn ? B = e : "win" == t || e.document ? _ = (q = e).document : "datetime" !== t && "DateTime" !== e.type || ($.DateTime = e)
      }, $.factory = function(e, t) {
        var n = !1;
        return e && e.document && (_ = (q = e).document), t && t.fn && t.fn.jquery && (B = t, n = !0), n
      }, $.versionCheck = function(e, t) {
        for (var n, a, r = (t || $.version).split("."), o = e.split("."), i = 0, l = o.length; i < l; i++)
          if ((n = parseInt(r[i], 10) || 0) !== (a = parseInt(o[i], 10) || 0)) return a < n;
        return !0
      }, $.isDataTable = function(e) {
        var r = B(e).get(0),
          o = !1;
        return e instanceof $.Api || (B.each($.settings, function(e, t) {
          var n = t.nScrollHead ? B("table", t.nScrollHead)[0] : null,
            a = t.nScrollFoot ? B("table", t.nScrollFoot)[0] : null;
          t.nTable !== r && n !== r && a !== r || (o = !0)
        }), o)
      }, $.tables = function(t) {
        var e = !1,
          n = (B.isPlainObject(t) && (e = t.api, t = t.visible), $.settings.filter(function(e) {
            return !(t && !B(e.nTable).is(":visible"))
          }).map(function(e) {
            return e.nTable
          }));
        return e ? new U(n) : n
      }, $.camelToHungarian = z, t("$()", function(e, t) {
        t = this.rows(t).nodes(), t = B(t);
        return B([].concat(t.filter(e).toArray(), t.find(e).toArray()))
      }), B.each(["on", "one", "off"], function(e, n) {
        t(n + "()", function() {
          var e = Array.prototype.slice.call(arguments),
            t = (e[0] = e[0].split(/\s/).map(function(e) {
              return e.match(/\.dt\b/) ? e : e + ".dt"
            }).join(" "), B(this.tables().nodes()));
          return t[n].apply(t, e), this
        })
      }), t("clear()", function() {
        return this.iterator("table", function(e) {
          he(e)
        })
      }), t("error()", function(t) {
        return this.iterator("table", function(e) {
          Z(e, 0, t)
        })
      }), t("settings()", function() {
        return new U(this.context, this.context)
      }), t("init()", function() {
        var e = this.context;
        return e.length ? e[0].oInit : null
      }), t("data()", function() {
        return this.iterator("table", function(e) {
          return f(e.aoData, "_aData")
        }).flatten()
      }), t("trigger()", function(t, n, a) {
        return this.iterator("table", function(e) {
          return ee(e, null, t, n, a)
        }).flatten()
      }), t("ready()", function(e) {
        var t = this.context;
        return e ? this.tables().every(function() {
          this.context[0]._bInitComplete ? e.call(this) : this.on("init", function() {
            e.call(this)
          })
        }) : t.length ? t[0]._bInitComplete || !1 : null
      }), t("destroy()", function(c) {
        return c = c || !1, this.iterator("table", function(e) {
          var t = e.oClasses,
            n = e.nTable,
            a = e.nTBody,
            r = e.nTHead,
            o = e.nTFoot,
            i = B(n),
            a = B(a),
            l = B(e.nTableWrapper),
            s = e.aoData.map(function(e) {
              return e ? e.nTr : null
            }),
            u = t.order,
            o = (e.bDestroying = !0, ee(e, "aoDestroyCallback", "destroy", [e], !0), c || new U(e).columns().visible(!0), l.off(".DT").find(":not(tbody *)").off(".DT"), B(q).off(".DT-" + e.sInstance), n != r.parentNode && (i.children("thead").detach(), i.append(r)), o && n != o.parentNode && (i.children("tfoot").detach(), i.append(o)), e.colgroup.remove(), e.aaSorting = [], e.aaSortingFixed = [], $e(e), B("th, td", r).removeClass(u.canAsc + " " + u.canDesc + " " + u.isAsc + " " + u.isDesc).css("width", ""), a.children().detach(), a.append(s), e.nTableWrapper.parentNode),
            r = e.nTableWrapper.nextSibling,
            u = c ? "remove" : "detach",
            a = (i[u](), l[u](), !c && o && (o.insertBefore(n, r), i.css("width", e.sDestroyWidth).removeClass(t.table)), $.settings.indexOf(e)); - 1 !== a && $.settings.splice(a, 1)
        })
      }), B.each(["column", "row", "cell"], function(e, s) {
        t(s + "s().every()", function(a) {
          var r, o = this.selector.opts,
            i = this,
            l = 0;
          return this.iterator("every", function(e, t, n) {
            r = i[s](t, o), "cell" === s ? a.call(r, r[0][0].row, r[0][0].column, n, l) : a.call(r, t, n, l), l++
          })
        })
      }), t("i18n()", function(e, t, n) {
        var a = this.context[0],
          e = J(e)(a.oLanguage);
        return "string" == typeof(e = B.isPlainObject(e = void 0 === e ? t : e) ? void 0 !== n && void 0 !== e[n] ? e[n] : e._ : e) ? e.replace("%d", n) : e
      }), $.version = "2.0.2", $.settings = [], $.models = {}, $.models.oSearch = {
        caseInsensitive: !0,
        search: "",
        regex: !1,
        smart: !0,
        return: !1
      }, $.models.oRow = {
        nTr: null,
        anCells: null,
        _aData: [],
        _aSortData: null,
        _aFilterData: null,
        _sFilterRow: null,
        src: null,
        idx: -1,
        displayData: null
      }, $.models.oColumn = {
        idx: null,
        aDataSort: null,
        asSorting: null,
        bSearchable: null,
        bSortable: null,
        bVisible: null,
        _sManualType: null,
        _bAttrSrc: !1,
        fnCreatedCell: null,
        fnGetData: null,
        fnSetData: null,
        mData: null,
        mRender: null,
        sClass: null,
        sContentPadding: null,
        sDefaultContent: null,
        sName: null,
        sSortDataType: "std",
        sSortingClass: null,
        sTitle: null,
        sType: null,
        sWidth: null,
        sWidthOrig: null,
        maxLenString: null,
        searchFixed: null
      }, $.defaults = {
        aaData: null,
        aaSorting: [
          [0, "asc"]
        ],
        aaSortingFixed: [],
        ajax: null,
        aLengthMenu: [10, 25, 50, 100],
        aoColumns: null,
        aoColumnDefs: null,
        aoSearchCols: [],
        bAutoWidth: !0,
        bDeferRender: !0,
        bDestroy: !1,
        bFilter: !0,
        bInfo: !0,
        bLengthChange: !0,
        bPaginate: !0,
        bProcessing: !1,
        bRetrieve: !1,
        bScrollCollapse: !1,
        bServerSide: !1,
        bSort: !0,
        bSortMulti: !0,
        bSortCellsTop: null,
        bSortClasses: !0,
        bStateSave: !1,
        fnCreatedRow: null,
        fnDrawCallback: null,
        fnFooterCallback: null,
        fnFormatNumber: function(e) {
          return e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, this.oLanguage.sThousands)
        },
        fnHeaderCallback: null,
        fnInfoCallback: null,
        fnInitComplete: null,
        fnPreDrawCallback: null,
        fnRowCallback: null,
        fnStateLoadCallback: function(e) {
          try {
            return JSON.parse((-1 === e.iStateDuration ? sessionStorage : localStorage).getItem("DataTables_" + e.sInstance + "_" + location.pathname))
          } catch (e) {
            return {}
          }
        },
        fnStateLoadParams: null,
        fnStateLoaded: null,
        fnStateSaveCallback: function(e, t) {
          try {
            (-1 === e.iStateDuration ? sessionStorage : localStorage).setItem("DataTables_" + e.sInstance + "_" + location.pathname, JSON.stringify(t))
          } catch (e) {}
        },
        fnStateSaveParams: null,
        iStateDuration: 7200,
        iDisplayLength: 10,
        iDisplayStart: 0,
        iTabIndex: 0,
        oClasses: {},
        oLanguage: {
          oAria: {
            orderable: ": Activate to sort",
            orderableReverse: ": Activate to invert sorting",
            orderableRemove: ": Activate to remove sorting",
            paginate: {
              first: "First",
              last: "Last",
              next: "Next",
              previous: "Previous"
            }
          },
          oPaginate: {
            sFirst: "«",
            sLast: "»",
            sNext: "›",
            sPrevious: "‹"
          },
          entries: {
            _: "entries",
            1: "entry"
          },
          sEmptyTable: "No data available in table",
          sInfo: "Showing _START_ to _END_ of _TOTAL_ _ENTRIES-TOTAL_",
          sInfoEmpty: "Showing 0 to 0 of 0 _ENTRIES-TOTAL_",
          sInfoFiltered: "(filtered from _MAX_ total _ENTRIES-MAX_)",
          sInfoPostFix: "",
          sDecimal: "",
          sThousands: ",",
          sLengthMenu: "_MENU_ _ENTRIES_ per page",
          sLoadingRecords: "Loading...",
          sProcessing: "",
          sSearch: "Search:",
          sSearchPlaceholder: "",
          sUrl: "",
          sZeroRecords: "No matching records found"
        },
        oSearch: B.extend({}, $.models.oSearch),
        layout: {
          topStart: "pageLength",
          topEnd: "search",
          bottomStart: "info",
          bottomEnd: "paging"
        },
        sDom: null,
        searchDelay: null,
        sPaginationType: "full_numbers",
        sScrollX: "",
        sScrollXInner: "",
        sScrollY: "",
        sServerMethod: "GET",
        renderer: null,
        rowId: "DT_RowId",
        caption: null
      }, k($.defaults), $.defaults.column = {
        aDataSort: null,
        iDataSort: -1,
        ariaTitle: "",
        asSorting: ["asc", "desc", ""],
        bSearchable: !0,
        bSortable: !0,
        bVisible: !0,
        fnCreatedCell: null,
        mData: null,
        mRender: null,
        sCellType: "td",
        sClass: "",
        sContentPadding: "",
        sDefaultContent: null,
        sName: "",
        sSortDataType: "std",
        sTitle: null,
        sType: null,
        sWidth: null
      }, k($.defaults.column), $.models.oSettings = {
        oFeatures: {
          bAutoWidth: null,
          bDeferRender: null,
          bFilter: null,
          bInfo: !0,
          bLengthChange: !0,
          bPaginate: null,
          bProcessing: null,
          bServerSide: null,
          bSort: null,
          bSortMulti: null,
          bSortClasses: null,
          bStateSave: null
        },
        oScroll: {
          bCollapse: null,
          iBarWidth: 0,
          sX: null,
          sXInner: null,
          sY: null
        },
        oLanguage: {
          fnInfoCallback: null
        },
        oBrowser: {
          bScrollbarLeft: !1,
          barWidth: 0
        },
        ajax: null,
        aanFeatures: [],
        aoData: [],
        aiDisplay: [],
        aiDisplayMaster: [],
        aIds: {},
        aoColumns: [],
        aoHeader: [],
        aoFooter: [],
        oPreviousSearch: {},
        searchFixed: {},
        aoPreSearchCols: [],
        aaSorting: null,
        aaSortingFixed: [],
        sDestroyWidth: 0,
        aoRowCallback: [],
        aoHeaderCallback: [],
        aoFooterCallback: [],
        aoDrawCallback: [],
        aoRowCreatedCallback: [],
        aoPreDrawCallback: [],
        aoInitComplete: [],
        aoStateSaveParams: [],
        aoStateLoadParams: [],
        aoStateLoaded: [],
        sTableId: "",
        nTable: null,
        nTHead: null,
        nTFoot: null,
        nTBody: null,
        nTableWrapper: null,
        bInitialised: !1,
        aoOpenRows: [],
        sDom: null,
        searchDelay: null,
        sPaginationType: "two_button",
        pagingControls: 0,
        iStateDuration: 0,
        aoStateSave: [],
        aoStateLoad: [],
        oSavedState: null,
        oLoadedState: null,
        bAjaxDataGet: !0,
        jqXHR: null,
        json: void 0,
        oAjaxData: void 0,
        sServerMethod: null,
        fnFormatNumber: null,
        aLengthMenu: null,
        iDraw: 0,
        bDrawing: !1,
        iDrawError: -1,
        _iDisplayLength: 10,
        _iDisplayStart: 0,
        _iRecordsTotal: 0,
        _iRecordsDisplay: 0,
        oClasses: {},
        bFiltered: !1,
        bSorted: !1,
        bSortCellsTop: null,
        oInit: null,
        aoDestroyCallback: [],
        fnRecordsTotal: function() {
          return "ssp" == te(this) ? +this._iRecordsTotal : this.aiDisplayMaster.length
        },
        fnRecordsDisplay: function() {
          return "ssp" == te(this) ? +this._iRecordsDisplay : this.aiDisplay.length
        },
        fnDisplayEnd: function() {
          var e = this._iDisplayLength,
            t = this._iDisplayStart,
            n = t + e,
            a = this.aiDisplay.length,
            r = this.oFeatures,
            o = r.bPaginate;
          return r.bServerSide ? !1 === o || -1 === e ? t + a : Math.min(t + e, this._iRecordsDisplay) : !o || a < n || -1 === e ? a : n
        },
        oInstance: null,
        sInstance: null,
        iTabIndex: 0,
        nScrollHead: null,
        nScrollFoot: null,
        aLastSort: [],
        oPlugins: {},
        rowIdFn: null,
        rowId: null,
        caption: "",
        captionNode: null,
        colgroup: null
      }, $.ext = C = {
        buttons: {},
        classes: {},
        builder: "-source-",
        errMode: "alert",
        feature: [],
        features: {},
        search: [],
        selector: {
          cell: [],
          column: [],
          row: []
        },
        legacy: {
          ajax: null
        },
        pager: {},
        renderer: {
          pageButton: {},
          header: {}
        },
        order: {},
        type: {
          className: {},
          detect: [],
          render: {},
          search: {},
          order: {}
        },
        _unique: 0,
        fnVersionCheck: $.fnVersionCheck,
        iApiIndex: 0,
        sVersion: $.version
      }, B.extend(C, {
        afnFiltering: C.search,
        aTypes: C.type.detect,
        ofnSearch: C.type.search,
        oSort: C.type.order,
        afnSortData: C.order,
        aoFeatures: C.feature,
        oStdClasses: C.classes,
        oPagination: C.pager
      }), B.extend($.ext.classes, {
        container: "dt-container",
        empty: {
          row: "dt-empty"
        },
        info: {
          container: "dt-info"
        },
        length: {
          container: "dt-length",
          select: "dt-input"
        },
        order: {
          canAsc: "dt-orderable-asc",
          canDesc: "dt-orderable-desc",
          isAsc: "dt-ordering-asc",
          isDesc: "dt-ordering-desc",
          none: "dt-orderable-none",
          position: "sorting_"
        },
        processing: {
          container: "dt-processing"
        },
        scrolling: {
          body: "dt-scroll-body",
          container: "dt-scroll",
          footer: {
            self: "dt-scroll-foot",
            inner: "dt-scroll-footInner"
          },
          header: {
            self: "dt-scroll-head",
            inner: "dt-scroll-headInner"
          }
        },
        search: {
          container: "dt-search",
          input: "dt-input"
        },
        table: "dataTable",
        tbody: {
          cell: "",
          row: ""
        },
        thead: {
          cell: "",
          row: ""
        },
        tfoot: {
          cell: "",
          row: ""
        },
        paging: {
          active: "current",
          button: "dt-paging-button",
          container: "dt-paging",
          disabled: "disabled"
        }
      }), $.ext.pager);
    B.extend(gt, {
      simple: function() {
        return ["previous", "next"]
      },
      full: function() {
        return ["first", "previous", "next", "last"]
      },
      numbers: function() {
        return ["numbers"]
      },
      simple_numbers: function() {
        return ["previous", "numbers", "next"]
      },
      full_numbers: function() {
        return ["first", "previous", "numbers", "next", "last"]
      },
      first_last: function() {
        return ["first", "last"]
      },
      first_last_numbers: function() {
        return ["first", "numbers", "last"]
      },
      _numbers: At,
      numbers_length: 7
    }), B.extend(!0, $.ext.renderer, {
      pagingButton: {
        _: function(e, t, n, a, r) {
          var e = e.oClasses.paging,
            o = [e.button];
          return a && o.push(e.active), r && o.push(e.disabled), {
            display: a = "ellipsis" === t ? B('<span class="ellipsis"></span>').html(n)[0] : B("<button>", {
              class: o.join(" "),
              role: "link",
              type: "button"
            }).html(n),
            clicker: a
          }
        }
      },
      pagingContainer: {
        _: function(e, t) {
          return t
        }
      }
    });

    function vt(e) {
      return e.replace(/[\W]/g, "_")
    }

    function bt(e, t, n, a, r) {
      return q.moment ? e[t](r) : q.luxon ? e[n](r) : a ? e[a](r) : e
    }
    var yt = !1;

    function Dt(e, t, n) {
      var a;
      if (q.moment) {
        if (!(a = q.moment.utc(e, t, n, !0)).isValid()) return null
      } else if (q.luxon) {
        if (!(a = t && "string" == typeof e ? q.luxon.DateTime.fromFormat(e, t) : q.luxon.DateTime.fromISO(e)).isValid) return null;
        a.setLocale(n)
      } else t ? (yt || alert("DataTables warning: Formatted date without Moment.js or Luxon - https://datatables.net/tn/17"), yt = !0) : a = new Date(e);
      return a
    }

    function xt(s) {
      return function(a, r, o, i) {
        0 === arguments.length ? (o = "en", a = r = null) : 1 === arguments.length ? (o = "en", r = a, a = null) : 2 === arguments.length && (o = r, r = a, a = null);
        var l = "datetime" + (r ? "-" + vt(r) : "");
        return $.ext.type.order[l] || $.type(l, {
            detect: function(e) {
              return e === l && l
            },
            order: {
              pre: function(e) {
                return e.valueOf()
              }
            },
            className: "dt-right"
          }),
          function(e, t) {
            var n;
            return null == e && (e = "--now" === i ? (n = new Date, new Date(Date.UTC(n.getFullYear(), n.getMonth(), n.getDate(), n.getHours(), n.getMinutes(), n.getSeconds()))) : ""), "type" === t ? l : "" === e ? "sort" !== t ? "" : Dt("0000-01-01 00:00:00", null, o) : !(null === r || a !== r || "sort" === t || "type" === t || e instanceof Date) || null === (n = Dt(e, a, o)) ? e : "sort" === t ? n : (e = null === r ? bt(n, "toDate", "toJSDate", "")[s]() : bt(n, "format", "toFormat", "toISOString", r), "display" === t ? u(e) : e)
          }
      }
    }
    var St = ",",
      Tt = ".";
    if (void 0 !== q.Intl) try {
      for (var wt = (new Intl.NumberFormat).formatToParts(100000.1), a = 0; a < wt.length; a++) "group" === wt[a].type ? St = wt[a].value : "decimal" === wt[a].type && (Tt = wt[a].value)
    } catch (e) {}
    $.datetime = function(n, a) {
      var r = "datetime-detect-" + vt(n);
      a = a || "en", $.ext.type.order[r] || $.type(r, {
        detect: function(e) {
          var t = Dt(e, n, a);
          return !("" !== e && !t) && r
        },
        order: {
          pre: function(e) {
            return Dt(e, n, a) || 0
          }
        },
        className: "dt-right"
      })
    }, $.render = {
      date: xt("toLocaleDateString"),
      datetime: xt("toLocaleString"),
      time: xt("toLocaleTimeString"),
      number: function(r, o, i, l, s) {
        return null == r && (r = St), null == o && (o = Tt), {
          display: function(e) {
            if ("number" != typeof e && "string" != typeof e) return e;
            if ("" === e || null === e) return e;
            var t = e < 0 ? "-" : "",
              n = parseFloat(e),
              a = Math.abs(n);
            if (1e11 <= a || a < 1e-4 && 0 !== a) return (a = n.toExponential(i).split(/e\+?/))[0] + " x 10<sup>" + a[1] + "</sup>";
            if (isNaN(n)) return u(e);
            n = n.toFixed(i), e = Math.abs(n);
            a = parseInt(e, 10), n = i ? o + (e - a).toFixed(i).substring(2) : "";
            return (t = 0 === a && 0 === parseFloat(n) ? "" : t) + (l || "") + a.toString().replace(/\B(?=(\d{3})+(?!\d))/g, r) + n + (s || "")
          }
        }
      },
      text: function() {
        return {
          display: u,
          filter: u
        }
      }
    };
    var i = $.ext.type,
      _t = ($.type = function(a, e, t) {
        if (!e) return {
          className: i.className[a],
          detect: i.detect.find(function(e) {
            return e.name === a
          }),
          order: {
            pre: i.order[a + "-pre"],
            asc: i.order[a + "-asc"],
            desc: i.order[a + "-desc"]
          },
          render: i.render[a],
          search: i.search[a]
        };

        function n(e, t) {
          i[e][a] = t
        }

        function r(n) {
          function e(e, t) {
            return !0 === (e = n(e, t)) ? a : e
          }
          Object.defineProperty(e, "name", {
            value: a
          });
          var t = i.detect.findIndex(function(e) {
            return e.name === a
          }); - 1 === t ? i.detect.unshift(e) : i.detect.splice(t, 1, e)
        }

        function o(e) {
          i.order[a + "-pre"] = e.pre, i.order[a + "-asc"] = e.asc, i.order[a + "-desc"] = e.desc
        }
        void 0 === t && (t = e, e = null), "className" === e ? n("className", t) : "detect" === e ? r(t) : "order" === e ? o(t) : "render" === e ? n("render", t) : "search" === e ? n("search", t) : e || (t.className && n("className", t.className), void 0 !== t.detect && r(t.detect), t.order && o(t.order), void 0 !== t.render && n("render", t.render), void 0 !== t.search && n("search", t.search))
      }, $.types = function() {
        return i.detect.map(function(e) {
          return e.name
        })
      }, $.type("string", {
        detect: function() {
          return "string"
        },
        order: {
          pre: function(e) {
            return y(e) ? "" : "string" == typeof e ? e.toLowerCase() : e.toString ? e.toString() : ""
          }
        },
        search: ut(!1, !0)
      }), $.type("html", {
        detect: function(e) {
          return y(e) || "string" == typeof e && -1 !== e.indexOf("<") ? "html" : null
        },
        order: {
          pre: function(e) {
            return y(e) ? "" : e.replace ? I(e).trim().toLowerCase() : e + ""
          }
        },
        search: ut(!0, !0)
      }), $.type("date", {
        className: "dt-type-date",
        detect: function(e) {
          var t;
          return (!e || e instanceof Date || L.test(e)) && (null !== (t = Date.parse(e)) && !isNaN(t) || y(e)) ? "date" : null
        },
        order: {
          pre: function(e) {
            e = Date.parse(e);
            return isNaN(e) ? -1 / 0 : e
          }
        }
      }), $.type("html-num-fmt", {
        className: "dt-type-numeric",
        detect: function(e, t) {
          t = t.oLanguage.sDecimal;
          return l(e, t, !0) ? "html-num-fmt" : null
        },
        order: {
          pre: function(e, t) {
            t = t.oLanguage.sDecimal;
            return _t(e, t, F, j)
          }
        },
        search: ut(!0, !0)
      }), $.type("html-num", {
        className: "dt-type-numeric",
        detect: function(e, t) {
          t = t.oLanguage.sDecimal;
          return l(e, t) ? "html-num" : null
        },
        order: {
          pre: function(e, t) {
            t = t.oLanguage.sDecimal;
            return _t(e, t, F)
          }
        },
        search: ut(!0, !0)
      }), $.type("num-fmt", {
        className: "dt-type-numeric",
        detect: function(e, t) {
          t = t.oLanguage.sDecimal;
          return o(e, t, !0) ? "num-fmt" : null
        },
        order: {
          pre: function(e, t) {
            t = t.oLanguage.sDecimal;
            return _t(e, t, j)
          }
        }
      }), $.type("num", {
        className: "dt-type-numeric",
        detect: function(e, t) {
          t = t.oLanguage.sDecimal;
          return o(e, t) ? "num" : null
        },
        order: {
          pre: function(e, t) {
            t = t.oLanguage.sDecimal;
            return _t(e, t)
          }
        }
      }), function(e, t, n, a) {
        var r;
        return 0 === e || e && "-" !== e ? "number" == (r = typeof e) || "bigint" == r ? e : +(e = (e = t ? P(e, t) : e).replace && (n && (e = e.replace(n, "")), a) ? e.replace(a, "") : e) : -1 / 0
      });
    B.extend(!0, $.ext.renderer, {
      footer: {
        _: function(e, t, n) {
          t.addClass(n.tfoot.cell)
        }
      },
      header: {
        _: function(d, f, h) {
          f.addClass(h.thead.cell), d.oFeatures.bSort || f.addClass(h.order.none);
          var e = d.bSortCellsTop,
            t = f.closest("thead").find("tr"),
            n = f.parent().index();
          "disable" === f.attr("data-dt-order") || "disable" === f.parent().attr("data-dt-order") || !0 === e && 0 !== n || !1 === e && n !== t.length - 1 || B(d.nTable).on("order.dt.DT", function(e, t, n) {
            var a, r, o, i, l, s, u, c;
            d === t && (c = h.order, u = t.api.columns(f), a = d.aoColumns[u.flatten()[0]], r = u.orderable().includes(!0), o = "", i = u.indexes(), s = u.orderable(!0).flatten(), l = n.map(function(e) {
              return e.col
            }).join(","), f.removeClass(c.isAsc + " " + c.isDesc).toggleClass(c.none, !r).toggleClass(c.canAsc, r && s.includes("asc")).toggleClass(c.canDesc, r && s.includes("desc")), -1 !== (s = l.indexOf(i.toArray().join(","))) && (u = u.order(), f.addClass(u.includes("asc") ? c.isAsc : "" + u.includes("desc") ? c.isDesc : "")), 0 === s && l.length === i.count() ? (u = n[0], c = a.asSorting, f.attr("aria-sort", "asc" === u.dir ? "ascending" : "descending"), o = c[u.index + 1] ? "Reverse" : "Remove") : f.removeAttr("aria-sort"), f.attr("aria-label", r ? a.ariaTitle + t.api.i18n("oAria.orderable" + o) : a.ariaTitle), r) && (f.find(".dt-column-title").attr("role", "button"), f.attr("tabindex", 0))
          })
        }
      },
      layout: {
        _: function(e, t, n) {
          var a = B("<div/>").addClass("dt-layout-row").appendTo(t);
          B.each(n, function(e, t) {
            e = t.table ? "" : "dt-" + e + " ";
            t.table && a.addClass("dt-layout-table"), B("<div/>").attr({
              id: t.id || null,
              class: "dt-layout-cell " + e + (t.className || "")
            }).append(t.contents).appendTo(a)
          })
        }
      }
    }), $.feature = {}, $.feature.register = function(e, t, n) {
      $.ext.features[e] = t, n && C.feature.push({
        cFeature: n,
        fnInit: t
      })
    }, $.feature.register("info", function(e, s) {
      var t, n, u;
      return e.oFeatures.bInfo ? (t = e.oLanguage, n = e.sTableId, u = B("<div/>", {
        class: e.oClasses.info.container
      }), s = B.extend({
        callback: t.fnInfoCallback,
        empty: t.sInfoEmpty,
        postfix: t.sInfoPostFix,
        search: t.sInfoFiltered,
        text: t.sInfo
      }, s), e.aoDrawCallback.push(function(e) {
        var t = s,
          n = u,
          a = e._iDisplayStart + 1,
          r = e.fnDisplayEnd(),
          o = e.fnRecordsTotal(),
          i = e.fnRecordsDisplay(),
          l = i ? t.text : t.empty;
        i !== o && (l += " " + t.search), l += t.postfix, l = Ke(e, l), t.callback && (l = t.callback.call(e.oInstance, e, a, r, o, i, l)), n.html(l), ee(e, null, "info", [e, n[0], l])
      }), B("#" + n + "_info", e.nWrapper).length || (u.attr({
        "aria-live": "polite",
        id: n + "_info",
        role: "status"
      }), B(e.nTable).attr("aria-describedby", n + "_info")), u) : null
    }, "i");
    var Ct = 0;

    function It(e, t, n, a) {
      var r = e.oLanguage.oPaginate,
        o = {
          display: "",
          active: !1,
          disabled: !1
        };
      switch (t) {
        case "ellipsis":
          o.display = "&#x2026;", o.disabled = !0;
          break;
        case "first":
          o.display = r.sFirst, 0 === n && (o.disabled = !0);
          break;
        case "previous":
          o.display = r.sPrevious, 0 === n && (o.disabled = !0);
          break;
        case "next":
          o.display = r.sNext, 0 !== a && n !== a - 1 || (o.disabled = !0);
          break;
        case "last":
          o.display = r.sLast, 0 !== a && n !== a - 1 || (o.disabled = !0);
          break;
        default:
          "number" == typeof t && (o.display = e.fnFormatNumber(t + 1), n === t) && (o.active = !0)
      }
      return o
    }

    function At(e, t, n) {
      var a = [],
        r = Math.floor(n / 2);
      return t <= n ? a = h(0, t) : 1 === n ? a = [e] : 3 === n ? e <= 1 ? a = [0, 1, "ellipsis"] : t - 2 <= e ? (a = h(t - 2, t)).unshift("ellipsis") : a = ["ellipsis", e, "ellipsis"] : e <= r ? (a = h(0, n - 2)).push("ellipsis", t - 1) : (t - 1 - r <= e ? a = h(t - (n - 2), t) : ((a = h(e - r + 2, e + r - 1)).push("ellipsis", t - 1), a)).unshift(0, "ellipsis"), a
    }
    $.feature.register("search", function(n, e) {
      var t, a, r, o, i, l, s, u, c, d;
      return n.oFeatures.bFilter ? (t = n.oClasses.search, a = n.sTableId, c = n.oLanguage, r = n.oPreviousSearch, o = '<input type="search" class="' + t.input + '"/>', -1 === (e = B.extend({
        placeholder: c.sSearchPlaceholder,
        text: c.sSearch
      }, e)).text.indexOf("_INPUT_") && (e.text += "_INPUT_"), e.text = Ke(n, e.text), c = e.text.match(/_INPUT_$/), s = e.text.match(/^_INPUT_/), i = e.text.replace(/_INPUT_/, ""), l = "<label>" + e.text + "</label>", s ? l = "_INPUT_<label>" + i + "</label>" : c && (l = "<label>" + i + "</label>_INPUT_"), (s = B("<div>").addClass(t.container).append(l.replace(/_INPUT_/, o))).find("label").attr("for", "dt-search-" + Ct), s.find("input").attr("id", "dt-search-" + Ct), Ct++, u = function(e) {
        var t = this.value;
        r.return && "Enter" !== e.key || t != r.search && (r.search = t, Le(n, r), n._iDisplayStart = 0, S(n))
      }, c = null !== n.searchDelay ? n.searchDelay : 0, d = B("input", s).val(r.search).attr("placeholder", e.placeholder).on("keyup.DT search.DT input.DT paste.DT cut.DT", c ? $.util.debounce(u, c) : u).on("mouseup.DT", function(e) {
        setTimeout(function() {
          u.call(d[0], e)
        }, 10)
      }).on("keypress.DT", function(e) {
        if (13 == e.keyCode) return !1
      }).attr("aria-controls", a), B(n.nTable).on("search.dt.DT", function(e, t) {
        n === t && d[0] !== _.activeElement && d.val("function" != typeof r.search ? r.search : "")
      }), s) : null
    }, "f"), $.feature.register("paging", function(e, t) {
      if (!e.oFeatures.bPaginate) return null;
      t = B.extend({
        numbers: $.ext.pager.numbers_length,
        type: e.sPaginationType
      }, t);

      function n() {
        ! function e(t, n, a) {
          if (!t._bInitComplete) return;
          var r = $.ext.pager[a.type],
            o = t.oLanguage.oAria.paginate || {},
            i = t._iDisplayStart,
            l = t._iDisplayLength,
            s = t.fnRecordsDisplay(),
            u = -1 === l,
            c = u ? 0 : Math.ceil(i / l),
            d = u ? 1 : Math.ceil(s / l),
            f = r().map(function(e) {
              return "numbers" === e ? At(c, d, a.numbers) : e
            }).flat();
          var h = [];
          for (var p = 0; p < f.length; p++) {
            var g = f[p],
              m = It(t, g, c, d),
              v = Qe(t, "pagingButton")(t, g, m.display, m.active, m.disabled);
            B(v.clicker).attr({
              "aria-controls": t.sTableId,
              "aria-disabled": m.disabled ? "true" : null,
              "aria-current": m.active ? "page" : null,
              "aria-label": o[g],
              "data-dt-idx": g,
              tabIndex: m.disabled ? -1 : t.iTabIndex
            }), "number" != typeof g && B(v.clicker).addClass(g), Je(v.clicker, {
              action: g
            }, function(e) {
              e.preventDefault(), Me(t, e.data.action, !0)
            }), h.push(v.display)
          }
          i = Qe(t, "pagingContainer")(t, h);
          u = n.find(_.activeElement).data("dt-idx");
          n.empty().append(i);
          void 0 !== u && n.find("[data-dt-idx=" + u + "]").trigger("focus");
          h.length && 1 < a.numbers && B(n).height() >= 2 * B(h[0]).outerHeight() - 10 && e(t, n, B.extend({}, a, {
            numbers: a.numbers - 2
          }))
        }(e, a, t)
      }
      var a = B("<div/>").addClass(e.oClasses.paging.container + " paging_" + t.type);
      return e.aoDrawCallback.push(n), B(e.nTable).on("column-sizing.dt.DT", n), a
    }, "p");
    var Ft = 0;
    return $.feature.register("pageLength", function(a, e) {
      var t = a.oFeatures;
      if (!t.bPaginate || !t.bLengthChange) return null;
      e = B.extend({
        menu: a.aLengthMenu,
        text: a.oLanguage.sLengthMenu
      }, e);
      var t = a.oClasses.length,
        n = a.sTableId,
        r = e.menu,
        o = [],
        i = [];
      if (Array.isArray(r[0])) o = r[0], i = r[1];
      else
        for (p = 0; p < r.length; p++) B.isPlainObject(r[p]) ? (o.push(r[p].value), i.push(r[p].label)) : (o.push(r[p]), i.push(r[p]));
      for (var l = e.text.match(/_MENU_$/), s = e.text.match(/^_MENU_/), u = e.text.replace(/_MENU_/, ""), e = "<label>" + e.text + "</label>", c = (s ? e = "_MENU_<label>" + u + "</label>" : l && (e = "<label>" + u + "</label>_MENU_"), B("<div/>").addClass(t.container).append(e.replace("_MENU_", "<span></span>"))), d = [], f = (c.find("label")[0].childNodes.forEach(function(e) {
          e.nodeType === Node.TEXT_NODE && d.push({
            el: e,
            text: e.textContent
          })
        }), function(t) {
          d.forEach(function(e) {
            e.el.textContent = Ke(a, e.text, t)
          })
        }), h = B("<select/>", {
          name: n + "_length",
          "aria-controls": n,
          class: t.select
        }), p = 0; p < o.length; p++) h[0][p] = new Option("number" == typeof i[p] ? a.fnFormatNumber(i[p]) : i[p], o[p]);
      return c.find("label").attr("for", "dt-length-" + Ft), h.attr("id", "dt-length-" + Ft), Ft++, c.find("span").replaceWith(h), B("select", c).val(a._iDisplayLength).on("change.DT", function() {
        Ee(a, B(this).val()), S(a)
      }), B(a.nTable).on("length.dt.DT", function(e, t, n) {
        a === t && (B("select", c).val(n), f(n))
      }), f(a._iDisplayLength), c
    }, "l"), ((B.fn.dataTable = $).$ = B).fn.dataTableSettings = $.settings, B.fn.dataTableExt = $.ext, B.fn.DataTable = function(e) {
      return B(this).dataTable(e).api()
    }, B.each($, function(e, t) {
      B.fn.DataTable[e] = t
    }), $
  });
</script>
<script>
  $(document).ready(function() {
    if (window.matchMedia("(max-width: 767px)").matches) {
      // Only enable horizontal scrolling for phones (screen width <= 767px)
      $('#myTable').DataTable({
        scrollX: true
      });
    } else {
      $('#myTable').DataTable();
    }
  });
</script>
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
<style>
  tbody {
    color: grey;
  }

  .dt-paging-button.disabled.last {
    color: whitesmoke;
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
  }

  .dt-paging {
    color: grey;
  }

  .datatabcontainer-updated {
    background-color: var(--app-bg-dark);
    color: #fff;
    border-radius: 12px;
    border-collapse: collapse;
    width: 100%;
  }

  .tab th,
  .tab td {
    padding: 8px;
    text-align: left;
  }
</style>
<style>
  .progress-bar-info {
    display: flex;
    align-items: center;
    margin-bottom: 5px;
  }

  .progress-color {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 10px;
  }

  .progress-type,
  .progress-amount {
    display: inline-block;
    vertical-align: middle;
  }

  .progress-type {
    flex: 1;
  }
</style>
@endsection