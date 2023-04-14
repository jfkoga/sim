@extends('../layouts/app')

@section('title', 'MCQ tutorial')

@section('content')
    <form action="{{ route('mcq.progress', encrypt($myMCQ->id)) }}" method="POST">
        @csrf
        <div class="container">
            <h4 class="card-title">{{ __('MCQ') }}</h4>
            <div class="card exer mb-3">
                <div class="row g-0 exercici">
                    <div class="col-md-12">
                        <div class="card-body">
                            <h5>{{ '[ID: ' . $myMCQ->id . ' / LEVEL: ' . $myMCQ->level . '] (Answer is: ' . $myMCQ->SOL . ')'}}</h5>
                            <h4 class="card-subtitle mb-2">{!! $myMCQ->phrase !!}</h4>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q" id="a1" value="A">
                                <label class="form-check-label" for="a1">{{ $myMCQ->A }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q" id="a2" value="B">
                                <label class="form-check-label" for="a2">{{ $myMCQ->B }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q" id="a3" value="C">
                                <label class="form-check-label" for="a3">{{ $myMCQ->C }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q" id="a4" value="D">
                                <label class="form-check-label" for="a4">{{ $myMCQ->D }}</label>
                            </div>
                            {{-- <div class="form-check">
                                <input class="form-check-input" type="radio" name="q4" id="a4">
                                <label class="form-check-label" for="a4">wasd</label>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

            @error('q')
                <span class="alert alert-danger">
                    <strong>{{ __('You must mark an answer') }}</strong>
                </span>
            @enderror

        </div>
        <div class="vr" style="height: 30px;border:0;background-color: transparent;"></div>
        <div style="text-align: right;">
            <button type="submit" name="action" value="next" class="btn btn-primary rounded-pill"
                style="justify-self: right;">{{ __('Next') }}</button>
        </div>
    </form>
@endsection
