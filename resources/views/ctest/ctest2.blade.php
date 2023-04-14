@extends('../layouts/app')

@section('title', 'C-Test 2')

@section('content')
    <form action="{{ route('ctest.progress', [encrypt(2), encrypt($question->id)]) }}" method="POST">
        @csrf
        <div class="container">
            <h4 class="card-title">C-Test (Step 2)</h4>
            <p>{{ $question->answers }}</p>
            <div class="card exer mb-3">
                <div class="row g-0 exercici">
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-subtitle mb-2">ID:{{ $question->id }} \ {{ $question->title }}</h4>
                            <div class="vr" style="height: 0px;border:0;background-color: transparent;"></div>
                            <div class="card-text testempty">
                                {!! $phpDOM !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 breadcrumb">
                        <h4>{{ __('Exercise') }} 2</h4>
                        <div class="bready">
                            <span class="badge bg-primary rounded-pill page">1</span>
                            <span class="badge bg-primary rounded-pill page active">2</span>
                            <span class="badge bg-primary rounded-pill page">3</span>
                            <span class="badge bg-primary rounded-pill page">4</span>
                        </div>
                        <div class="TimeCount">
                            <h5>{{ __('Total Time') }}: <a id="clock"></a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="vr" style="height: 30px;border:0;background-color: transparent;"></div>
        <div class="botons">
            <button type="submit" name="action" value="back" class="btn btn-primary rounded-pill"
                style="justify-self: left;">{{ __('Back') }}</button>
            <button type="submit" name="action" value="next" class="btn btn-primary rounded-pill"
                style="justify-self: right;">{{ __('Next') }}</button>
        </div>
    </form>

    <script>
        const timeLimit = '{{ $timer }}';
        const myPage = '{{ route('welcome') }}';
    </script>
    <script src="{{ asset('js/clock.js') }}"></script>
    <script src="{{ asset('js/noBackButton.js') }}"></script>

@endsection
