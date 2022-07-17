@php
    $column['value'] = $column['value'] ?? data_get($entry, $column['name']);
    $column['escaped'] = $column['escaped'] ?? true;
    $column['text'] = $column['default'] ?? '-';

    if ($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

    if (!empty($column['value'])) {
        $column['text'] = isset($column['value']->name) ? $column['value']->name : $column['value']->pluck('name')->implode(', ');
    }
@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
    @if ($column['escaped'])
        {{ $column['text'] }}
    @else
        {!! $column['text'] !!}
    @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
