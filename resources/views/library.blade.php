@extends('master')
@section("app-mid")


<div class="app-main">
    @include('tiles.actions')
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search for names...">
    </div>

    <div class="container" style="margin-top: -15px;">
        @foreach($dossierStages as $dossierStage)
        <!-- Replace 'column_name' with the actual column name you want to display -->

        <a class="box" href="{{ Storage::url($dossierStage->rapport) }}" target="_blank">
            <span class="box__image" style="--bg-image: library.png">
                <img src="library.png" href="">
            </span>
            <span class="box__title">{{$dossierStage->type_dossier}}</span>
        </a>
        @endforeach
    </div>
</div>

<style>
    /*search bar design */
    /* Search container */
    .search-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Search input */
    #searchInput {
        padding: 10px;
        border: 1px solid #ccc;
        width: 300px;
        border-radius: 20px;
        outline: none;
        transition: border-color 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
        background-color: #fff;
        /* Default background color */
    }

    .search-container:hover #searchInput {
        transform: translateY(20px) scale(1.3);
        /* Move the input container and increase its size on hover */

    }

    #searchInput:focus {
        border-color: #2F88FF;
        /* Change to your desired focus color */
        box-shadow: 0 0 5px rgba(47, 136, 255, 0.5);
        /* Change to your desired focus box shadow */
        background-color: #f2faff;
        /* Change to your desired focus background color */
    }

    #searchInput::placeholder {
        color: #999;
        /* Placeholder color */
        transition: color 0.3s ease;
    }

    #searchInput:focus::placeholder {
        animation: shake 0.3s ease forwards;
    }

    /* Additional animation */
    @keyframes shake {
        0% {
            transform: translateX(-2px);
        }

        50% {
            transform: translateX(2px);
        }

        100% {
            transform: translateX(-2px);
        }
    }



    /* lib design*/
    *,
    *::after,
    *::before {
        box-sizing: border-box;
    }

    body,
    html {
        height: 100%;
    }

    .container {
        align-items: center;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(12rem, 1fr));
        justify-content: center;
        min-height: 100vh;
        width: 100%;
        gap: 2rem;
        padding: 2rem;
    }

    .box {
        --in-out-duration: 0.5s;

        color: white;
        text-decoration: none;
        border-radius: 0.5rem;
        display: flex;
        flex-direction: column;
        outline: none;
        gap: 1rem;

        &:is(:hover, :focus) {

            & .box__image {
                scale: 1.05;

                &::after {
                    border-color: white;
                    animation-name: scale-in, pulse;
                    animation-duration: var(--in-out-duration), 2s;
                    animation-iteration-count: 1, infinite;
                    animation-delay: 0s, var(--in-out-duration);
                }

                &::before {
                    opacity: 1;
                }
            }
        }
    }

    .box__title {
        font-weight: bold;
    }

    .box__image {
        aspect-ratio: 264 / 352;
        display: flex;
        position: relative;
        transition: scale var(--in-out-duration);
        /* smooths out transition */
        scale: 1.01;
        width: 100%;

        &::before {
            content: "";
            display: block;
            inset: 0;
            background-image: var(--bg-image);
            position: absolute;
            filter: blur(1rem);
            opacity: 0;
            transition: opacity var(--in-out-duration);
            scale: 1.05;
        }

        &::after {
            content: "";
            display: block;
            inset: -0.5rem;
            border: 3px solid transparent;
            border-radius: 1rem;
            opacity: 0;
            position: absolute;

            animation-name: scale-out;
            animation-duration: var(--in-out-duration);
            animation-iteration-count: 1;
            animation-fill-mode: forwards;

            transition-property: border-color;
            transition-duration: var(--in-out-duration);
        }

        & img {
            box-shadow: 0 0 0.25rem rgba(0 0 0 / 25%);
            border-radius: 0.5rem;
            object-fit: cover;
            object-position: center;
            position: absolute;
            width: 100%;
            height: 100%;
            backdrop-filter: blur(15px) saturate(3);
        }
    }

    @keyframes scale-in {
        from {
            scale: 1.1;
            opacity: 0;
        }

        to {
            scale: 1;
            opacity: 1;
        }
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
        }

        50% {
            opacity: 0;
        }
    }

    @keyframes scale-out {
        from {
            scale: 1;
            opacity: 1;
        }

        to {
            scale: 1.1;
            opacity: 0;
        }
    }
</style>
@endsection