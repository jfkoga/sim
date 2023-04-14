<div>
    <a>{{ __('Choose your language') }}</a>
    @foreach ($available_locales as $locale_name => $available_locale)
        @if ($available_locale === $current_locale)
            <img src="{{ asset('img/flags/' . $available_locale . '.png') }}" alt="{{ $locale_name }}" style="border-radius:50%; filter:grayscale(65%); padding:6px;">
        @else
            <a href="language/{{ $available_locale }}" title="{{ $locale_name }}" style="text-decoration:none;">
                <img src="{{ asset('img/flags/' . $available_locale . '.png') }}" alt="{{ $locale_name }}" style="border-radius:50%; padding:6px;">
            </a>
        @endif
    @endforeach
</div>
