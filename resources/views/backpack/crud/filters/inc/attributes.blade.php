@php
    $filter->attributes = $filter->attributes ?? [];
    $filter->attributes['class'] = $filter->attributes['class'] ?? $default_class ?? 'form-control';
@endphp

@foreach ($filter->attributes as $attribute => $value)
	@if (is_string($attribute))
    {{ $attribute }}="{{ $value }}"
    @endif
@endforeach
