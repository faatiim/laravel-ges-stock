@php
    $segments = Request::segments();
    $segmentCount = count($segments);
@endphp

<ol class="breadcrumb d-lg-flex d-none">
    <li class="breadcrumb-item">
        <i class="bi bi-house"></i>
        <a href="{{ route('dashboard') }}">Home</a>
    </li>

    @foreach ($segments as $index => $segment)
        @php
            // Format le segment (ex: outils -> Outils)
            $title = ucwords(str_replace('-', ' ', $segment));
            $url = url(implode('/', array_slice($segments, 0, $index + 1)));
        @endphp

        @if ($index + 1 < $segmentCount)
            <li class="breadcrumb-item">
                <a href="{{ $url }}">{{ $title }}</a>
            </li>
        @else
            <li class="breadcrumb-item breadcrumb-active" aria-current="page">
                {{ $title }}
            </li>
        @endif
    @endforeach
</ol>
