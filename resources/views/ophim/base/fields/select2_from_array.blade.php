<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
@php
$field['allows_multiple'] = $field['allows_multiple'] ?? false;
$field['options'] = $field['options'] ?? [];
$field['value'] = $field['value'] ?? [];

@endphp
<label>{!! $field['label'] !!}</label>
<select class="form-control select2-from-array" name="{{ $field['name'] }}[]" @if ($field['allows_multiple']) multiple @endif
    @include('crud::fields.inc.attributes')>
    @foreach ($field['options'] as $key => $option)
        <option value="{{ $key }}" @if (($field['allows_multiple'] && in_array($key, $field['value'])) || $key == $field['value']) selected @endif>{{ $option }}
        </option>
    @endforeach
</select>

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')

@if ($crud->fieldTypeNotLoaded($field))
    @php
        $crud->markFieldTypeAsLoaded($field);
    @endphp

    {{-- FIELD EXTRA CSS --}}
    {{-- push things in the after_styles section --}}
    @push('crud_fields_styles')
        <!-- no styles -->
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            $(function() {
                $(".select2-from-array").select2({});
            })
        </script>
    @endpush
@endif
