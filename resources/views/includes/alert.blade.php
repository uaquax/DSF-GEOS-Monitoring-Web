@php
    $alert = session()->pull('alert');
    $alertLevel = session()->pull('alert-level');
@endphp

@if ($alert && $alertLevel)
    <div class="alert
                text-center
        @if ($alertLevel === 'success')
            alert-success
        @elseif ($alertLevel === 'danger')
            alert-danger
        @elseif ($alertLevel === 'warning')
            alert-warning
        @else
            alert-info
        @endif" role="alert">
        {{ $alert }}
    </div>
@endif
