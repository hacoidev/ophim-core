<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
@php
$key_attribute = (new $field['model']())->getKeyName();
$field['attribute'] = $field['attribute'] ?? (new $field['model']())->identifiableAttribute();

$selected = $field['model']
    ::whereIn('id', old($field['name'], isset($field['value']) ? $field['value']->pluck('id')->toArray() : []))
    ->pluck($field['attribute'], $key_attribute)
    ->toArray();
@endphp
<label>{!! $field['label'] !!}</label>
<select class="form-control select-tag" name="{{ $field['name'] }}[]" multiple @include('crud::fields.inc.attributes')>
    @foreach ($selected as $option)
        <option value="{{ $option }}" selected>{{ $option }}
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
        <link rel="stylesheet" href="{{ asset('/packages/select2/dist/css/select2.css') }}">
        <link rel="stylesheet" href="{{ asset('/packages/select2-bootstrap-theme/dist/select2-bootstrap.min.css') }}">
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script src="{{ asset('/packages/select2/dist/js/select2.full.min.js') }}"></script>
        <script>
            $(function() {
                $(".select-tag").select2({
                    // theme: 'bootstrap4',
                    tags: true
                });
            })
        </script>
    @endpush
@endif
