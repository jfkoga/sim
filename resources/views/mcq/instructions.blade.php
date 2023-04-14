@extends('../layouts/app')

@section('title', 'MCQ tutorial')

@section('content')
    <div class="alert alert-success">
        <a> Detected difficulty to begin MCQ: <strong>Level {{ $level }}</strong></a>
    </div>
    <hr>
    <div class="container principal">
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-md-9">
                    <div class="card-body">
                        <h3 class="card-title">{{ __('MCQ') }}</h3>
                        <p class="card-text">{{ __('This part consists of answering multiple choice questions...') }}</p>
                        <p class="card-text">
                            {{ __('To mark the answer, you must click on the option that is considered correct...') }}:</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <img src="{{ asset('img/fons-card.png') }}" class="img-fluid imgdecora" alt="Parla.cat">
                </div>
            </div>
        </div>
        <div class="vr" style="height: 30px;border:0;background-color: transparent;"></div>
        <a class="btn btn-primary rounded-pill" href="{{ route('mcq.step', encrypt($level)) }}" role="button"
            style="justify-self: right;">{{ __('Start') }} MCQ</a>
    </div>
@endsection

<script src="{{ asset('js/noBackButton.js') }}"></script>
