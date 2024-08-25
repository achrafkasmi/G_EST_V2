<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DENIED ACCESS</title>
    <style>
       body {
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                rgba(0, 0, 0) 100%;
            color: grey;
            flex-direction: column;
            text-align: center;
        }
        .bubble {
            --_float-distance: -20px;
            --_float-speed: 3000ms;
            --_size: 200px;

            width: var(--_size);
            aspect-ratio: 1 / 1;
            border-radius: 50%;
            position: relative;
            backdrop-filter: blur(5px);
            box-shadow:
                inset 0 0.13vmin blue,
                inset 0 0.18vmin orange,
                inset 0.1vmin 0.1vmin orange;
            animation: floating var(--_float-speed) ease-in-out infinite;
        }

        .bubble::before,
        .bubble::after {
            content: "";
            position: absolute;
            border-radius: inherit;
        }

        .bubble::before {
            inset: 0;
            backdrop-filter: blur(12px);
            background-image: conic-gradient(from -25deg at 80% 20%,
                    transparent 85%,
                    rgba(255, 255, 255, 0.7) 94%,
                    transparent 94%);
            filter: blur(4px);
        }

        .bubble::after {
            inset: -3px;
            background: rgba(5, 19, 64, 0.2); /* Slightly darkened overlay */
            backdrop-filter: blur(3px);
            z-index: -1;
        }

        @keyframes floating {
            0%,
            100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(var(--_float-distance, -10px));
            }
        }
    </style>
</head>
<body>
    <span class="bubble"></span>
    <h4 style="color:grey">FORBIDDEN ...</h4>
</body>
</html>
