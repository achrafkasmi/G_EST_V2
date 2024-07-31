<!DOCTYPE html>
<html>

<head>
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: auto;
            height: 80%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .header {
            width: 100%;
            position: relative;
            margin-bottom: 20px;
        }

        .logo1 {
            position: absolute;
            top: -10;
            left: 0;
        }

        .logo2 {
            position: absolute;
            top: -10;
            right: 0;
        }

        .mid-text {
            text-align: center;
            font-size: 10px;
            /* Reduced font size */
            margin-top: -10px;
            /* Moved up slightly */
        }

        .logo1 img,
        .logo2 img {
            height: 80px;
            /* Increased logo size */
        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
            text-align: center;
            font-size: 10px;
            margin-bottom: -15;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo1"><img src="{{ public_path('UniLogo.png') }}" alt="Left Logo"></div>
        <div class="logo2"><img src="{{ public_path('LogoEST.PNG') }}" alt="Right Logo"></div>
        <div class="mid-text">
            <span>
                Royaume du Maroc<br>
                Ministère de l'Enseignement Supérieur,<br>
                de la Recherche Scientifique et de l’Innovation<br>
                Université Sultan Moulay Slimane<br>
                L'Ecole Supérieure de Technologie -- Fkih Ben Salah<br>
            </span>
        </div>
    </div>

    <div class="footer">
        <span class="footer-text">Ecole Supérieure de Technologie - Fkih Ben Salah <br>
            Hay Tighnari, Route Nationale N° 11, 23200 Fkih Ben Salah<br>
            Tel. : 06.64.29.59.98/06.64.32.85.65 , Email : estfbs@usms.ma , Site Web : http:// estfbs.usms.ac.ma/<br>
        </span>
    </div>

    <h4 style="align-items:center;">Liste Etudiants Pour: {{ request('annee') }} {{ request('filiere') }}</h4>
    <table>
        <thead>
            <tr>
                <th>Apogée</th>
                <th>Nom et Prénom</th>
                @foreach($columns as $column)
                <th>{{ $column }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{$student->apogee}}</td>
                <td>{{ $student->nom_fr }} {{ $student->prenom_fr }}</td>
                @foreach($columns as $column)
                <td></td> <!-- Empty content for custom columns -->
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>