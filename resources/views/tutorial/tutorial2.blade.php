@extends('../layouts/app')

@section('title', 'C-Test')

@section('content')
    <div class="card mb-3">
        <div class="row g-0">
            <div class="card-body">
                <h3 class="card-title">C-Test</h3>
                <p class="card-text">{{ __('CTest explanation') }}</p>
                <p>{{ __('To complete them...') }}</p>
                <p class="card-text">{{ __('See some examples') }}:</p>
                <p class="card-text"><strong>Hi ha seixanta minuts en una hora (en aquest cas dues lletres) tae leo ultricies
                    scelerisque eget quis ligula. Donec efficitur suscipit dictum. Nulla facilisi.<strong></p>
                <div class="card-text">{{ __('Use the buttons') }}:
                    <div class="d-inline-flex">
                        <span class="badge bg-primary rounded-pill page">1</span>
                        <span class="badge bg-primary rounded-pill page">2</span>
                        <span class="badge bg-primary rounded-pill page">3</span>
                        <span class="badge bg-primary rounded-pill page">4</span>
                    </div>
                </div>
                <p class="card-text"><strong>Nulla luctus neque pellentesque lacus porta imperdiet. Nunc tincidunt in ipsum
                    tincidunt
                    sodales. Nulla semper, neque vitae viverra vulputate. Nulla luctus neque pellentesque lacus porta
                    imperdiet.
                    Nunc tincidunt in ipsum tincidunt sodales. Nulla semper, neque vitae viverra vulputate<strong></p>
            </div>
        </div>
    </div>
    <div class="vr" style="height: 30px;border:0;background-color: transparent;"></div>
    <div class="botons">
        <a class="btn btn-primary rounded-pill" href="{{ route('tutorial1', 'user=alejandroTest@gmail.com') }}" role="button"
            style="justify-self: left;">{{ __('Back') }}</a>
        <a class="btn btn-primary rounded-pill"
            href="{{ route('beginSession', $user) }}" role="button"
            style="justify-self: right;">{{ __('Start') }}</a>
    </div>
@endsection
