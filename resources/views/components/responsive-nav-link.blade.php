@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active bg-light border-start border-4 border-primary ps-3'
            : 'nav-link text-secondary border-start border-4 border-transparent ps-3 hover-bg-light';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
