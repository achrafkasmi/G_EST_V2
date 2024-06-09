@extends('master')
@section("app-mid")

<div class="app-main">
    @include('tiles.actions')
    <a href="{{ route('dashboard') }}">
        <img src="{{ asset('left-arrow.svg') }}" alt="Left Arrow" width="40px" height="40px" style="fill: grey;">
    </a>
    <div class="profile-wrapper">

        <div class="profile-image">
            <img src="{{ $user->image ? Storage::url($user->image) : asset('profile.PNG') }}" alt="Profile Image">
        </div>

        <h2 class="profile-title">{{ $user->name }} <span>{{ $user->surname }}</span></h2>
        <div class="profile-info">
            <div class="content">
                <h3>About</h3>
                <p><strong>- Email:</strong> {{ $user->email }}</p>
                @if($etudiant)
                <p><strong>- CIN:</strong> {{ $etudiant->cin }}</p>
                <p><strong>- CNE:</strong> {{ $etudiant->cne }}</p>
                <p><strong>- Prénom:</strong> {{ $etudiant->prenom_fr }}</p>
                <p><strong>- Nom:</strong> {{ $etudiant->nom_fr }}</p>
                <p><strong>- Lieu de naissance:</strong> {{ $etudiant->lieu_de_naissance_fr }}</p>
                <p><strong>- Tel:</strong> {{ $etudiant->tel }}</p>
                <p><strong>- BAC:</strong> {{ $etudiant->annee_bac }}</p>
                <p><strong>- Apogee:</strong> {{ $etudiant->apogee }}</p>
                <p><strong>- Statut activité:</strong>
                    <span style="color: {{ $etudiant->is_active ? 'green' : 'red' }}">
                        {{ $etudiant->is_active ? 'Yes' : 'No' }}
                    </span>
                </p>
                @else
                <p>No Etudiant information available.</p>
                @endif

                <p><strong>- Stage Details:</strong></p>
                @if($stages->isNotEmpty())
                <p><strong>Uploaded Initiation:</strong>
                    <span style="color: {{ $is_uploaded_initiation ? 'green' : 'red' }}">
                        {{ $is_uploaded_initiation ? 'Yes' : 'No' }}
                    </span>
                </p>
                <p><strong>Uploaded Technique:</strong>
                    <span style="color: {{ $is_uploaded_technique ? 'green' : 'red' }}">
                        {{ $is_uploaded_technique ? 'Yes' : 'No' }}
                    </span>
                </p>
                <p><strong>Uploaded PFE:</strong>
                    <span style="color: {{ $is_uploaded_pfe ? 'green' : 'red' }}">
                        {{ $is_uploaded_pfe ? 'Yes' : 'No' }}
                    </span>
                </p>
                <p><strong>Uploaded Professionelle:</strong>
                    <span style="color: {{ $is_uploaded_professionelle ? 'green' : 'red' }}">
                        {{ $is_uploaded_professionelle ? 'Yes' : 'No' }}
                    </span>
                </p>
                @else
                <p>No Stage information available.</p>
                @endif


                <p><strong>- Retrait Details:</strong></p>
                @if($latest_retrait)
                <p><strong>Type:</strong> {{ $latest_retrait->type_retrait }}</p>
                <p><strong>Date:</strong> {{ $latest_retrait->created_at->format('Y-m-d H:i:s') }}</p>

                <p><strong>Retrait Document:</strong> <a href="{{ Storage::url($latest_retrait->dossier_retrait) }}" target="_blank">View Document</a></p>
                @if($retrait->count() > 1)
                <p style="color: green; cursor: pointer;" onclick="toggleMoreRetraits()">More...</p>
                <div id="moreRetraits" style="display: none;">
                    @foreach($retrait->slice(1) as $retrait)
                    <p><strong>Type:</strong> {{ $retrait->type_retrait }}</p>
                    <p><strong>Date:</strong> {{ $latest_retrait->created_at->format('Y-m-d H:i:s') }}</p>

                    <p><strong>Retrait Document:</strong> <a href="{{ Storage::url($retrait->dossier_retrait) }}" target="_blank">View Document</a></p>
                    @endforeach
                </div>
                @endif
                @else
                <p>No Retrait information available.</p>
                @endif

                <p><strong>- Laureat Details:</strong></p>
                @if($laureat)
                <p><strong>Laureat Document:</strong> <a href="{{ Storage::url($laureat->path_dossier_lautreat) }}" target="_blank">View Document</a></p>
                @else
                <p>Not a Laureat.</p>
                @endif
            </div>
        </div>
    </div>




</div>
<style>
    .profile-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 90%;
        max-width: 800px;
        margin: 3em auto 0;
        padding: .5em;
        box-shadow: 0px 15px 50px -13px rgba(0, 0, 0, 0.34);
        border-radius: 1em;
        background: #FFF;
        overflow-y: scroll;
    }

    .profile-image {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: crimson;
        overflow: hidden;
        box-shadow: 1px 24px 55px -19px rgba(220, 20, 60, 1);
        margin-bottom: 1em;
    }

    .profile-image img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .profile-title {
        color: #333;
        font-weight: 700;
        font-size: 1.5em;
        line-height: 1.2em;
        letter-spacing: -0.02em;
        margin: 0.5em 0;
        text-align: center;
    }

    .profile-title span {
        display: block;
        font-size: 0.8em;
    }

    .profile-info {
        width: 100%;
    }

    .profile-info .content {
        width: 100%;
        padding: 7em;
    }

    .profile-info .content h3 {
        text-transform: uppercase;
        color: crimson;
        letter-spacing: 0.2em;
    }

    .profile-info .content p {
        font-weight: 400;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        line-height: 1.5em;
        color: rgba(0, 0, 0, 0.8);
        margin: 0.5em 0;
    }

    .profile-info .content p.link {
        font-size: 0.9em;
    }

    .profile-info .content p.link i {
        color: crimson;
        font-family: "FontAwesome";
        line-height: inherit;
        margin-right: 4%;
    }

    .profile-info .content p.link a:link,
    .profile-info .content p.link a:visited {
        text-decoration: none;
        color: inherit;
        transition: color 0.25s;
    }

    .profile-info .content p.link a:hover {
        color: crimson;
        transition: color 0.25s;
    }

    .profile-info .content p.link.one {
        margin-top: 3em;
    }

    .profile-title {
        font-size: 1.5em;
        font-style: italic;
    }

    /* larger screens */
    @media (min-width: 992px) {
        .profile-wrapper {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 800px;
            height: 680px;
            margin-bottom: 0;
            margin: 3em 0 0;
            background-color: transparent;
        }

        .profile-image {
            width: 45%;
            height: 75%;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 1em;
            background-color: crimson;
            z-index: 1;
            overflow: hidden;
            box-shadow: 1px 24px 55px -19px rgba(220, 20, 60, 1);
        }

        .profile-image img {
            border-radius: 50%;
            width: 50%;
            height: auto;
            object-fit: cover;
        }

        .profile-title {
            display: block;
            position: absolute;
            top: 8%;
            left: 34%;
            color: #333;
            z-index: 2;
            font-weight: 700;
            font-size: 3.5em;
            line-height: 1em;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .profile-title span {
            display: block;
            margin-left: 28%;
        }

        .profile-info {
            display: block;
            position: absolute;
            top: 25%;
            right: 10;
            border-radius: 1em;
            width: 90%;
            height: auto;
            background: #FFF;
            box-shadow: 0px 15px 50px -13px rgba(0, 0, 0, 0.34);
        }

        .profile-info .content {
            display: inline-block;
            float: right;
            width: 60%;
            margin-top: -30px;
            padding: 7%;
        }

        .profile-info .content p {
            font-weight: 400;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            line-height: .9em;
            color: rgba(0, 0, 0, 0.8);
        }
    }
</style>

<script>
    function toggleMoreRetraits() {
        var moreRetraits = document.getElementById("moreRetraits");
        if (moreRetraits.style.display === "none") {
            moreRetraits.style.display = "block";
        } else {
            moreRetraits.style.display = "none";
        }
    }
</script>
@endsection