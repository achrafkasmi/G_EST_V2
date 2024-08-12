<!DOCTYPE html>
<html>

<head>
    <title>enerated Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
            /* Ensure body covers at least the viewport height */
        }

        table {
            width: 100%;
            /* Adjust to fill the width */
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #09555c;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            overflow: hidden;
            /* Prevent text overflow */
            word-break: break-word;
            /* Break long words */
        }

        .header {
            width: 100%;
            position: relative;
            margin-bottom: 60px;
            /* Space for footer */
            padding: 0 20px;
            box-sizing: border-box;
        }

        .logo1 {
            position: absolute;
            top: 10px;
            left: 0;
        }

        .logo2 {
            position: absolute;
            top: 10px;
            right: 0;
        }

        .mid-text {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }

        .logo1 img,
        .logo2 img {
            height: 80px;
        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
            text-align: center;
            font-size: 10px;
            padding: 10px;
            box-sizing: border-box;
            border-top: 1px solid black;
        }

        .content {
            padding-bottom: 20px;
            /* Space for footer */
        }

        h4 {
            text-align: center;
            margin: 20px 0;
            /* Space above and below the heading */
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

    <div class="content">
        <h4>Liste Etudiants Pour: {{ request('annee') }} {{ request('filiere') }}</h4>
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
                    <td>{{ $student->$column }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <span class="footer-text">
            Ecole Supérieure de Technologie - Fkih Ben Salah<br>
            Hay Tighnari, Route Nationale N° 11, 23200 Fkih Ben Salah<br>
            Tel. : 06.64.29.59.98/06.64.32.85.65 , Email : estfbs@usms.ma , Site Web : http://estfbs.usms.ac.ma/
        </span>
    </div>
</body>

</html>