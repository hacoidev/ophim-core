<!-- field_type_name -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
<div class="input-group">
    <input type="text" name="{{ $field['name'] }}"
        value="{{ old($field['name']) ? old($field['name']) : (isset($field['value']) ? $field['value'] : (isset($field['default']) ? $field['default'] : '')) }}"
        @include('crud::fields.inc.attributes') id="ckfinder-{{ strtolower($field['name']) }}">
    <span class="input-group-append">
        <button type="button" class="btn btn-info"
            onclick="selectFileWithCKFinder('{{ strtolower($field['name']) }}')">Browse</button>
    </span>
</div>
<img class="mw-100 mt-2 rounded" src="{{ old($field['name'], isset($entry) ? $entry->{$field['name']} : '') }}"
    id="preview-{{ strtolower($field['name']) }}">


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
        @include('ckfinder::setup')
        <script>
            function selectFileWithCKFinder(elementId) {
                CKFinder.modal({
                    chooseFiles: true,
                    width: 800,
                    height: 600,
                    onInit: function(finder) {
                        finder.on('files:choose', function(evt) {
                            var file = evt.data.files.first();
                            var output = document.getElementById('ckfinder-' + elementId);
                            var preview = document.getElementById('preview-' + elementId);
                            if (output) {
                                output.value = file.getUrl();
                            }
                            if (preview) {
                                preview.src = file.getUrl();
                            }
                        });

                        finder.on('file:choose:resizedImage', function(evt) {
                            var output = document.getElementById(elementId);
                            output.value = evt.data.resizedUrl;
                        });
                    }
                });
            }
        </script>
    @endpush
@endif
