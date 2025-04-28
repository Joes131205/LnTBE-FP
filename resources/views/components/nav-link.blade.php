@props(['active'])

@php
$classes = ($active ?? false)
            ? 'nav-link active border-bottom border-primary fw-medium'
            : 'nav-link text-secondary hover-text-dark';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
