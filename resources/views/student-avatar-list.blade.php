<!DOCTYPE html>
<html>

<head>
    <title>Generated Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            min-height: 100vh;
        }

        .header {
            width: 100%;
            position: relative;
            margin-bottom: 60px;
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
            padding: 20px;
            padding-bottom: 60px;
        }

        .student-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .student-card {
            border: 1px solid #09555c;
            padding: 10px;
            text-align: center;
            overflow: hidden;
            word-break: break-word;
        }

        .student-avatar img {
            max-width: 100%;
            max-height: 150px;
            margin-bottom: 10px;
        }

        h4 {
            text-align: center;
            margin: 20px 0;
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
        <h4>Liste des Etudiants pour: {{ request('annee') }} {{ request('filiere') }}</h4>
        <div class="student-grid">
            @foreach($students as $student)
            <div class="student-card">
                <div class="student-avatar">
                <img src="{{ Storage::url($student->user_image) }}" alt="Student Avatar">
                </div>
                <div class="student-info">
                    <strong>{{ $student->nom_fr }} {{ $student->prenom_fr }}</strong><br>
                    Apogée: {{ $student->apogee }}
                </div>
            </div>
            @endforeach
        </div>
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
