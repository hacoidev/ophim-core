<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')

@php
$selected = $field['value'] ?? [];
@endphp

<label>{!! $field['label'] !!}</label>
<select class="form-control select2-tags" name="{{ $field['name'] }}[]" multiple @include('crud::fields.inc.attributes')>
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
    @endpush

    {{-- FIELD EXTRA JS --}}
    {{-- push things in the after_scripts section --}}
    @push('crud_fields_scripts')
        <script>
            $(function() {
                $(".select2-tags").select2({
                    tags: true
                });
            })
        </script>
    @endpush
@endif
