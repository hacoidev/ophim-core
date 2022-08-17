@php
$field['value'] = old_empty_or_null($field['name'], '') ?? ($field['value'] ?? ($field['default'] ?? ''));
$field['multiple'] = $field['allows_multiple'] ?? ($field['multiple'] ?? false);
$options = config('themes', []);
@endphp
<!-- select from array -->
@include('crud::fields.inc.wrapper_start')
<label>{!! $field['label'] !!}</label>
@include('crud::fields.inc.translatable_icon')
@if ($field['multiple'])
    <input type="hidden" name="{{ $field['name'] }}" value="" @if (in_array('disabled', $field['attributes'] ?? [])) disabled @endif />
@endif


@foreach ($options as $key => $value)
    <div class="col-12 col-md-6 col-lg-4 bordered">
        <div class="thumbnail">
            <div class="img-thumbnail-wrap" style="background-image: url('{{ $value['preview_image'] ?? '' }}')"></div>
            <div class="caption">
                <div class="col-12" style="background: #eee; padding: 15px;">
                    <div style="word-break: break-all">
                        <h4>{{ $value['name'] ?? 'Unknown' }}</h4>
                        <p>Author: {{ $value['author'] ?? 'Unknown' }}</p>
                        <p>Version: {{ $value['version'] ?? 'Unknown' }}</p>
                        <p>Description: {{ $value['description'] ?? 'Unknown' }}</p>
                    </div>
                    <div class="clearfix"></div>
                    <div>
                        <div class="form-check form-check-inline mr-1">
                            <input class="form-check-input" type="radio" name="{{ $field['name'] }}"
                                value="{{ $key }}" id="theme-{{ $loop->index }}"
                                @if ($key == $entry->value) checked @endif>
                            <label class="form-check-label" for="theme-{{ $loop->index }}">Kích hoạt</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

{{-- HINT --}}
@if (isset($field['hint']))
    <p class="help-block">{!! $field['hint'] !!}</p>
@endif
@include('crud::fields.inc.wrapper_end')
