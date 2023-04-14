@extends('../layouts/app')

@section('title', 'Nivell recomanat')

@section('content')

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-12">
            <div class="card-body">
                <h3 class="card-title">{{ __('Language level detection test') }}</h3>
                <h4 class="card-subtitle mb-2">{{ __('You have completed the quiz') }}: <strong>{{ $user->email }}</strong></h4>
                <div class="content-center">
                    <div class="circle">
                        <h5>{{ __($val) }}</h5>
                        <H1>{{ $grade }}</H1>
                    </div>
                    <p style="text-align: center;"><strong>{{ __('Recommended level') }}</strong></p>
                </div>
                <div class="botonera">
                    <a type="text/css" class="btn btn-primary rounded-pill basic" href="{{ route('myPDF', encrypt($val)) }}" role="button"
                        style="justify-self: left;">{{ __('Save') }} PDF</a>
                    <a type="text/css" class="btn btn-primary rounded-pill basic" href="{{ route('welcome') }}" role="button"
                        style="justify-self: right;">{{ __('Exit') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/noBackButton.js') }}"></script>

@endsection
