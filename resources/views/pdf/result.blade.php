<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>SIMTEST Result</title>

    <!-- Bootstrap 4.6.2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


    <!-- Style -->
    <style>
        a{
            color:#000000;
        }
        .h5,
        h5 {
            font-weight: 600;
        }

        .container.principal {
            display: grid;
            margin-bottom: 1rem;
        }

        .card.mb-3 {
            margin: 10px auto;
        }

        .card {
            background-color: #DCD6BC;
            border-color: #dcd6bc;
            --bs-card-border-radius: 20px;
        }

        .card-body {
            font-size: 18px;
            /* padding: 40px; */
        }

        .card-title {
            font-weight: 700;
        }

        .card-subtitle {
            font-size: 22px;
        }

        .circle {
            background-color: white;
            border-radius: 150px;
            text-align: center;
            color: #747a29;
            width: 140px;
            height: 140px;
            margin: 20PX auto;
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            align-content: center;
            align-items: stretch;
        }

        .circle H5 {
            margin: 0px;
            font-size: 16px;
            color: #747a29;
        }

        .circle h1 {
            margin: 0;
            color: #747a29;
        }

        .content-center {
            margin: 40px auto;
        }

        .card-text {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        @media (max-width:736px) {
            .circle {
                width: 180px;
                height: 180px;
            }
        }
    </style>
</head>

<body>
    <div class="container principal">
        {{-- <a>{{ $data['user'] }}</a> --}}
        <div class="card text-center">
            <div class="card-header">
                <h2>{{ $data['title'] }}</h2>
            </div>
            <div class="card-body">
                <h3 class="card-title">{{ __('Language level detection test') }}</h3>
                <p class="card-text">{{ __('You have completed the quiz') }}: <strong>Alejandro Escobar</strong></p>
                <div class="circle">
                    <br><br>
                    <h5>SUFICIÈNCIA</h5>
                    <H1>3</H1>
                </div>
                <a><strong>{{ __('Recommended level') }}</strong></a>
            </div>
            <div class="card-footer text-muted">
                <em>{{ $data['timestamp'] }}</em>
            </div>
        </div>
    </div>
</body>

</html>
