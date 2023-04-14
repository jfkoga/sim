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
        .navbar,
        .card-header {
            background-color: #e44b30;
        }

        .navbar-brand,
        div#greenHeader>a {
            color: #FFFFFF;
        }

        a {
            color: #000000;
        }

        #greenHeader{
            background-color: #c3bc98;
        }
        #greenBody{
            background-color: #dad5bc;
        }
    </style>
</head>

<body>

    <nav class="navbar red">
        <div class="container">
            <h1 class="navbar-brand">PARLA . CAT</h1>
        </div>
    </nav>

    <hr>

    <div class="container">

        <div class="card text-center">
            <div class="card-header" id="greenHeader">
                <a><strong>{{ strtoupper(__('Level Test Results')) }}</strong></a>
            </div>
            <div class="card-body" id="greenBody">
                <div class="card">
                    <div class="card text-center">
                        <div class="card-header">
                            <a><strong>{{ $data['user']->email }}</strong></a>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">{{ __('Recommended level') }}</li>
                                    <li class="list-group-item"><a>{{ __($data['qualification']) }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a>{{ $data['timestamp'] }}</a>
            </div>
        </div>
    </div>
</body>

</html>
