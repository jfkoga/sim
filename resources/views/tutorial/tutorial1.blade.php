@extends('../layouts/app')

@section('title', 'Prova de Nivell')

@section('content')

@include('components.language_switcher')

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-md-9">
            <div class="card-body">
                <h3 class="card-title">{{ __('Level Test') }}</h3>
                <h4 class="card-subtitle mb-2">{{ __('The test consists in') }}:</h4>
                <div class="vr" style="height: 0px;border:0;background-color: transparent;"></div>
                <h5>C-Test</h5>
                <p class="card-text">{{ __('CTest explanation') }}</p>
                <div class="vr" style="height: 0px;border:0;background-color: transparent;"></div>
                <h5>{{ __('MCQ') }}</h5>
                <p class="card-text">{{ __('MCQ explanation') }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <img src="{{ asset('img/fons-card.png') }}" class="img-fluid imgdecora" alt="Parla.cat">
        </div>
    </div>
</div>


    <div class="vr" style="height: 30px;border:0;background-color: transparent;"></div>
    <a class="btn btn-primary rounded-pill" href="{{ route('tutorial2', 'user=alejandroTest@gmail.com') }}" role="button" style="justify-self: right;">{{ __('Next') }}</a>
@endsection
