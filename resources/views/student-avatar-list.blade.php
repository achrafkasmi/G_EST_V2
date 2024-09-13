<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Carte d'étudiant</title>
    <!--<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">-->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .card {
            width: 100%;
        }

        .logo-left {
            float: left;
            width: 12%;
            margin-left: 2%;
        }

        .university-name {
            float: left;
            width: 90%;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
            color: #0080bf;
        }

        .logo-right {
            float: right;
            width: 12%;
            height: 14%;
        }

        .yellow-line {
            clear: both;
            width: 90%;
            height: 2px;
            background-color: orange;
            margin: 5px auto 0;
            border-radius: 1px;
        }

        .subtitle {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            font-size: 6.5px;
            font-weight: bold;
            padding: 0 10px;
        }

        .annee-uni {
            font-size: 6px;
            text-align: left;
        }

        .carte-text {
            width: 100%;
            text-align: center;
            margin-top: -3%;
        }

        .photo {
            float: left;
            width: 22%;
            height: 40%;
            margin-left: 5px;
            background-color: #ccc;
        }

        .info {
            float: right;
            width: 70%;
            margin-right:14px;
            font-size: 10px;
        }

        .footer {
            clear: both;
            width: 22%;
            text-align: center;
            font-size: 8px;
            margin-left: 5px;
        }

        .img {
            width: 100%;
            height: 116%;
        }

        .barcode {
            width: 27%;
            height: 22%;
            margin-left: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
           margin-top: 15px;
        }


        .arabic {
            margin-top: -24%;
            margin-right: 1%;
            direction: rtl;
            unicode-bidi: bidi-override;
            font-family: 'Noto Naskh Arabic', 'Arabic Font', Arial, sans-serif;
        }
    </style>
</head>

<body>
    <div class="card">
        <img class="logo-left" src="{{ public_path('UniLogo.png') }}" alt="University Logo">

        <div class="university-name">
            Université Sultan Moulay Slimane<br>
            École Supérieure de Technologie<br>
            Fkih Ben Salah
        </div>

        <img class="logo-right" src="{{ public_path('LogoEST.PNG') }}" alt="EST Logo">

        <div class="yellow-line"></div>

        <div class="subtitle">
            <span class="annee-uni">{{ $student->annee_uni }}</span>
            <h3 class="carte-text">Carte d'étudiant</h3>
        </div>

        <div class="content">
            <div class="photo">
                @if($student->user && $student->user->image)
                <img class="img" src="{{ public_path(str_replace('public/', 'storage/', $student->user->image)) }}" alt="Student Photo">
                @else
                <img class="img" src="{{ public_path('profile.PNG') }}" alt="Default Photo">
                @endif
            </div>

            <div class="info">
                <div class="info-row"><strong>Filière:</strong> {{ $student->FILIERE }}</div>
                <div class="info-row"><strong>Nom:</strong> {{ $student->nom_fr }}</div>
                <div class="info-row"><strong>Prénom:</strong> {{ $student->prenom_fr }}</div>
                <div class="info-row"><strong>CNE/Massar:</strong> {{ $student->cne }}</div>
                <div class="info-row"><strong>CIN:</strong> {{ $student->cin }} </div>
                <div class="arabic">
                    <strong>النسب :</strong> {{ $student->nom_ar }} <br>
                    <strong>الاسم :</strong> {{ $student->prenom_ar }} <br>
                    <strong>ر.و.ط / مسار:</strong> <br>
                    <strong>ب.و.ت :</strong>
                </div>
            </div>
        </div>

        <div class="footer">
            {{ $student->apogee }}
        </div>
    </div>
   <div class="barcode">
    <img src="data:image/png;base64,{{ $barcode }}" alt="Barcode" style="object-fit: contain;">
</div>

</body>

</html>