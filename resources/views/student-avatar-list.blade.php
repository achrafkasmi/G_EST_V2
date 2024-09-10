<!DOCTYPE html>
<html>

<head>
    <title>Student University Card</title>
    <style>
        @page {
            size: 153.089pt 243.307pt; 
            margin: 0;
        }

        @font-face {
            font-family: 'Amiri';
            src: url('{{ public_path("fonts/Amiri-Regular.ttf") }}') format('truetype');
        }

        body {
            font-family: 'Amiri', sans-serif;
            margin: 0;
            padding: 0;
            width: 153.089pt;
            height: 243.307pt;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            height: 25pt;
            padding: 0 5pt;
        }

        .logo1,
        .logo2 {
            width: 25pt;
            height: 25pt;
        }

        .logo1 img,
        .logo2 img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .mid-text {
            font-size: 6pt;
            line-height: 1.1;
            color: #1484CD;
            text-align: center;
            flex-grow: 1;
        }

        .yellow-line {
            width: 100%;
            height: 2pt;
            background-color: #FFAE42;
            margin: 2pt 0;
        }

        .card-title {
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            margin: 2pt 0;
            position: relative;
        }

        .annee-uni {
            display: inline;
            font-size: 6pt;
        }

        .content {
            display: flex;
            padding: 5pt;
        }

        .student-avatar {
            width: 50pt;
            height: 62.5pt;
            margin-right: 5pt;
            border: .5px solid black;
        }

        .student-avatar img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .mid-informations {
            font-size: 7pt;
            line-height: 1.1;
            display: flex;
            flex-direction: column;
        }

        .french,
        .arabe {
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        .french {
            text-align: left;
        }

        .arabe {
            text-align: right;
            direction: rtl;
            font-family: 'DejaVu Sans', sans-serif;
        }

        .apogee {
            text-align: center;
            margin-top: 5pt;
        }

        .barcode {
            text-align: center;
            margin-top: 5pt;
        }
    </style>
</head>

<body>
    @foreach($students as $student)
    <div class="header">
        <div class="logo1"><img src="{{ public_path('UniLogo.png') }}" alt="Left Logo"></div>
        <div class="mid-text">
            Université Sultan Moulay Slimane<br>
            L'Ecole Supérieure de Technologie<br>
            Fkih Ben Salah
        </div>
        <div class="logo2"><img src="{{ public_path('LogoEST.PNG') }}" alt="Right Logo"></div>
    </div>

    <div class="yellow-line"></div>

    <div class="card-title">
        Carte d'étudiant
        <span class="annee-uni">{{ $student->annee_uni }}</span>
    </div>

    <div class="content">
        <div class="student-avatar">
            @if($student->user->image)
            <img src="{{ public_path(str_replace('public/', 'storage/', $student->user->image)) }}" alt="Student Avatar">
            @else
            <img src="{{ public_path('profile.PNG') }}" alt="Default Avatar">
            @endif
        </div>
        <div class="mid-informations">
            <div class="french">
                <strong>Filière:</strong> {{ $student->FILIERE }}<br>
                <strong>Nom:</strong> {{ $student->nom_fr }}<br>
                <strong>Prénom:</strong> {{ $student->prenom_fr }}<br>
                <strong>CNE/Massar:</strong> {{ $student->cne }}<br>
                <strong>CIN:</strong> {{ $student->cin }}
            </div>
            <div class="arabe">
                {{ $student->nom_ar }} <strong>: النسب</strong><br>
                {{ $student->prenom_ar }} <strong>: الاسم</strong>
            </div>
        </div>
    </div>

    <div class="apogee">
        {{ $student->apogee }}
    </div>

    <div class="barcode">
        {!! DNS1D::getBarcodeHTML($student->apogee, 'C128') !!}
    </div>

    @if(!$loop->last)
    <div style="page-break-after: always;"></div>
    @endif
    @endforeach
</body>

</html>
